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
        / Study
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Study</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Protocol Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Treament Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Logistics and Reports</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Important Dates and Persons</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Signatures</button>
        </div>

        <form action="{{ route('study_update',$study->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            @method('PUT')
            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Originator"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator_id" value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date of Initiation</b></label>
                                    <input disabled type="date" name="intiation_date" value="">
                                    <input type="hidden" name="intiation_date" value="">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description"  value="{{ $study->short_description }}" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input  disabled type="text" name="record"
                                        value="">
                                </div>

                            </div>


                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assigned_to">
                                        <option value="">Select a value</option>
                                        @if ($users->isNotEmpty())
                                            @foreach ($users as $user)
                                                <option value='{{ $user->id }}'>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
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
                                    <label for="Study_num"><b>Study Num</b></label>
                                    <input type="text" name="study_num" value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Sponsor"><b>Sponsor</b></label>
                                    <input type="text" name="sponsor" value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="type1">Type</label>
                                    <select name="type1">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Version">Version No.</label>
                                    <input type="text" name="Version">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="file_attach">File Attachments</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_attach[]" oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                        </div>
                                    </div>
                                    {{-- <input type="file" name="file_attach[]" multiple> --}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Trade_name">(Parent) Trade Name</label>
                                    <input type="text" name="parent_name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Trade_name">Related URLs</label>
                                    <select name="related_urls">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Source_Documents">Source Documents</label>
                                    <select name="Source_Documents">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Comments">Comments</label>
                                    <textarea name="comments" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="sub-head">
                                Finace
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Budget">Budget</label>
                                    <input type="text" name="budget">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Currency">Currency</label>
                                    <select name="currency">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Total_study">Total Study Cost</label>
                                    <select name="Total_study">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Financial Transations(0)
                                    <button type="button" name="audit-agenda-grid" id="Financial_Transation">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Financial-field-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Transations</th>
                                                <th style="width: 16%">Transations Type</th>
                                                <th style="width: 16%">Date</th>
                                                <th style="width: 16%">Amount</th>
                                                <th style="width: 15%">Currency Used</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name="IDnumber[]"></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="date" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name="Remarks[]"></td>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Projected">Projected # of Sites</label>
                                    <input type="text" name="Projected">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Total_study">Number of sites in study</label>
                                    <select name="Total_sites">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Projected">Projected # of Subjects</label>
                                    <input type="text" name="subjects">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Total_study">Number of Subjects in study</label>
                                    <select name="Total_subjects">
                                        <option value="">Enter Your Selection Here</option>
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
                            <div class="sub-head col-12">General Information</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Phase of Study</label>
                                    <select name="departments">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Protocol">Protocol Type</label>
                                    <select name="Protocol">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Protocol_Activities">Protocol Activities</label>
                                    <select name="Protocol_Activities">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Counties">Counties</label>
                                    <input type="text" name="counties">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Agency">Agency Reference Number</label>
                                    <input type="text" name="agency">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="EudraCT">EudraCT Number</label>
                                    <input type="text" name="eudraCT">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Regulatory">Regulatory Status</label>
                                    <select name="regulatory">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for=" Global_Regulatory">Global Regulatory Status</label>
                                    <select name="global_regulatory">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for=" Protocol">Protocol Long Name</label>
                                    <textarea name="protocol_name" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for=" Comments">Comments</label>
                                    <textarea name="comment1" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for=" Case_Report">Case Report From Status</label>
                                    <select name="case_report">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for=" Case_Number">Case Number</label>
                                    <input type="text" name="case_number">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Background">Background</label>
                                    <textarea name="background" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Objectives">Objectives</label>
                                    <textarea name="objectives" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Pediatric">Pediatric</label>
                                    <select name="pediatric">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">Yes</option>
                                        <option value="">No</option>
                                        <option value="">NA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Partner">Partner</label>
                                    <select name="partner">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Study_Hypothesis">Study Hypothesis</label>
                                    <input type="text" name="study_hypothesis">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Biomarker">Biomarker</label>
                                    <input type="text" name="biomarker">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="blinding">Blinding</label>
                                    <select name="Blinding">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Consent_form">Consent Form</label>
                                    <select name="consent_form">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="CTX">CTX?</label>
                                    <select name="ctx">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Crossover_Trial">Crossover Trial?</label>
                                    <select name="crossover_trial">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Comperative">Comperative?</label>
                                    <select name="comperative">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Comperator">Comperator</label>
                                    <input type="text" name="comperator">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Version">Version No.</label>
                                    <select name="version_no">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Study_Manual">Study Manual Version</label>
                                    <input type="text" name="study_manual">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Study_Manual">Global Version Approved</label>
                                    <input type="text" name="global_version">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Version_Approved">Version Approved</label>
                                    <input type="text" name="version_approved">
                                </div>
                            </div>

                            <div class="sub-head col-12">Logistics</div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Hospitals">Hospitals</label>
                                    <input type="text" name="hospitals">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Venders">Venders</label>
                                    <input type="text" name="venders">
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Equipment(0)
                                    <button type="button" name="audit-agenda-grid1" id="Equipment">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Equipment-field-instruction-modal">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Product Name</th>
                                                <th style="width: 16%">Batch Number</th>
                                                <th style="width: 16%">Expiry Date</th>
                                                <th style="width: 16%">ManuFactured Date</th>
                                                <th style="width: 15%">Number of items Needed</th>
                                                <th style="width: 15%">Exits</th>
                                                <th style="width: 15%">Comment</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name="IDnumber[]"></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="date" name=""></td>
                                            <td><input type="date" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Interim_Study_Report">Interim Study Report</label>
                                    <select name="interim_study_report">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Result_Synopsis">Result Synopsis</label>
                                    <textarea name="result_synopsis" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Study_Final_Report">Study Final Report</label>
                                    <select name="study_final_report">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
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

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Surrogate">Surrogate Marker/Variable</label>
                                    <input type="text" name="surrogate" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Special_Handling">Special Handling</label>
                                    <select name="special_handling">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Minimum_Time">Minimum Time Between Subjects</label>
                                    <input type="text" name="minimum_time" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Washout_Period">Washout Period</label>
                                    <input type="text" name="washout_period" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Admission_Criteria">Admission Criteria</label>
                                    <textarea name="admission_criteria" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Clinical_Significance">Clinical Significance</label>
                                    <textarea name="clinical_significance" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Dosing Schedule
                                    <button type="button" name="audit-agenda-grid2" id="DosingSchedule">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="DosingSchedule-field-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Product Name</th>
                                                <th style="width: 16%">Batch Number</th>
                                                <th style="width: 16%">Expiry Date</th>
                                                <th style="width: 16%">ManuFactured Date</th>
                                                <th style="width: 15%">Strength</th>
                                                <th style="width: 15%">Form</th>
                                                <th style="width: 15%">Dosing Schedule</th>
                                                <th style="width: 15%">Dose</th>
                                                <th style="width: 15%">Date Start</th>
                                                <th style="width: 15%">Comments</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name="IDnumber[]"></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="date" name=""></td>
                                            <td><input type="date" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="date" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Tests(0)
                                    <button type="button" name="audit-agenda-grid3" id="Tests">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Tests-field-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Type Of Test</th>
                                                <th style="width: 16%">Manner of Execution</th>
                                                <th style="width: 16%">Monitoring Frequency</th>
                                                <th style="width: 16%">Results</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name="IDnumber[]"></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                        </tbody>

                                    </table>
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

                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">

                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Risk Factors</div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="start_Inclusion">Start of Inclusion(FPFV)Date</label>
                                    <input type="date" name="start_Inclusion">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="End_Inclusion">End of Inclusion(LPLV)Date</label>
                                    <input type="date" name="end_Inclusion">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Scheduled_Start_Date">Scheduled Start Date</label>
                                    <input type="date" name="scheduled_start_date">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Scheduled_End_Date">Scheduled End Date</label>
                                    <input type="date" name="scheduled_end_date">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Actual_start">Actual Start Date</label>
                                    <input type="date" name="actual_start">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Actual_END">Actual End Date</label>
                                    <input type="date" name="actual_end">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Date_Trial_Active">Date Trial Active</label>
                                    <input type="date" name="date_trial_ctive">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="End_Date_Trial_Active">End of Trial Date</label>
                                    <input type="date" name="end_date_trial_active">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Protocol_Date">Protocol Date</label>
                                    <input type="date" name="protocol_date">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="dateofcurrent">Date of current IB</label>
                                    <input type="date" name="dateofcurrent">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="IRBApproval">IRB Approval Date</label>
                                    <input type="date" name="irb_approval">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="InternationalBirth">International Birth Date</label>
                                    <input type="date" name="international_birth">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Ethics">Ethics Committee Approval</label>
                                    <input type="date" name="ethics">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Study">Study Manual Versions</label>
                                    <input type="date" name="manual_version">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Subject">First Subject</label>
                                    <input type="date" name="first_subject">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="lastSubject">Last Subject</label>
                                    <input type="date" name="last_subject">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Signatures">CROM Contract Signatures Date</label>
                                    <input type="date" name="signatures">
                                </div>
                            </div>


                            <div class="col-12 sub-head">
                                Personal Involved </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="lead">Lead Investigator</label>
                                    <input type="text" name="lead">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Project_Manager">Project Manager</label>
                                    <input type="text" name="project_manager">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="CROM">CROM</label>
                                    <input type="text" name="crom">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Sponsor">Sponsor</label>
                                    <input type="text" name="sponsors">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Additional_Investigators">Additional Investigators</label>
                                    <textarea name="additional_investigators" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Manager">Manager(s)</label>
                                    <textarea name="manager" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Clinical_Research">Clinical Research Team</label>
                                    <textarea name="clinical_research" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Data_Safety">Data Safety Mointeoring Board</label>
                                    <textarea name="data_safety" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Clinical_Event">Clinical Event Committee</label>
                                    <textarea name="clinical_event" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="IRB">IRB</label>
                                    <textarea name="irb" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Statisticlans">Statisticlans</label>
                                    <textarea name="statisticlans" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Biostatisticlans">Biostatisticlans</label>
                                    <textarea name="biostatisticlans" id="" cols="30" rows="3"></textarea>
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

                <div id="CCForm6" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">
                                Signatures
                            </div>
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
                                    <label for="Closed by">Closed By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Closed on">Closed On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closer by">Early Closure By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closer on">Early Closure On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Finalized_by">Report Finalized By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Finalized_on">Report Finalized On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Approved_By">Report Approved By</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Approved_on">Report Approved On</label>
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
        $('#Financial_Transation').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="date" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#Financial-field-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#DosingSchedule').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="date" name="[]"></td>' +
                    '<td><input type="date" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="date" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#DosingSchedule-field-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#Tests').click(function(e) {
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

            var tableBody = $('#Tests-field-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#Equipment').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="date" name="[]"></td>' +
                    '<td><input type="date" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#Equipment-field-instruction-modal tbody');
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
