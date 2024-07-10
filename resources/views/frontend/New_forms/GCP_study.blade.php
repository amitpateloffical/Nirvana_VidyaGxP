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
        / GCP Study
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">GCP Study</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">GCP Details</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Important Dates</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signatures</button>

        </div>

        <form action="{{ route('GCP_study.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="Initiator"> Record Number </label>
                                    <input disabled type="text" name="record"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/GCP_Study/{{ date('Y') }}/{{ $record_number }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input readonly type="text" name="division_code"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    {{-- <div class="static">QMS-North America</div> --}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Initiator</b></label>
                                     <input type="text" disabled name="initiator_id" value="{{ auth()->user()->name }}">
                                </div>
                            </div>
                            {{--<div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Devision</b></label>
                                    <select id="select-state" placeholder="Select..." name="division_id">
                                        <option value="">Select a value</option>
                                        @if($users->isNotEmpty())
                                            @foreach($qmsDevisions as $qmsDevision)
                                            <option value='{{ $qmsDevision->id }}'>{{ $qmsDevision->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>--}}
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date of Initiation"><b>Date of Initiation</b></label>
                                    <div><span class="text-primary">When was this record opened?</span>
                                    </div>
                                    <input readonly type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description <span class="text-danger">*</span></label>
                                    <p class="text-primary">Short Description to be presented on dekstop</p>
                                    <input id="docname" type="text" name="short_description_gi" maxlength="255" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <p class="text-primary">Person responsible</p>
                                    <select id="select-state" placeholder="Select..." name="assign_to_gi">
                                        <option value="">Select a value</option>
                                        @if($users->isNotEmpty())
                                            @foreach($users as $user)
                                            <option value='{{ $user->id }}'>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due <span class="text-danger"></span></label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input  type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}">
                                        {{--<input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="department_gi"><b>Department(s)</b></label>
                                    <p class="text-primary">Add all the related departments</p>
                                    <select name="department_gi" id="initiator_group">
                                        <option value="">-- Select --</option>
                                        <option value="CQA" @if (old('department_gi') == 'CQA') selected @endif>
                                            Corporate Quality Assurance</option>
                                        <option value="QAB" @if (old('department_gi') == 'QAB') selected @endif>Quality
                                            Assurance Biopharma</option>
                                        <option value="CQC" @if (old('department_gi') == 'CQC') selected @endif>Central
                                            Quality Control</option>
                                        <option value="MANU" @if (old('department_gi') == 'MANU') selected @endif>
                                            Manufacturing</option>
                                        <option value="PSG" @if (old('department_gi') == 'PSG') selected @endif>Plasma
                                            Sourcing Group</option>
                                        <option value="CS" @if (old('department_gi') == 'CS') selected @endif>Central
                                            Stores</option>
                                        <option value="ITG" @if (old('department_gi') == 'ITG') selected @endif>
                                            Information Technology Group</option>
                                        <option value="MM" @if (old('department_gi') == 'MM') selected @endif>
                                            Molecular Medicine</option>
                                        <option value="CL" @if (old('department_gi') == 'CL') selected @endif>Central
                                            Laboratory</option>

                                        <option value="TT" @if (old('department_gi') == 'TT') selected @endif>Tech
                                            team</option>
                                        <option value="QA" @if (old('department_gi') == 'QA') selected @endif>
                                            Quality Assurance</option>
                                        <option value="QM" @if (old('department_gi') == 'QM') selected @endif>
                                            Quality Management</option>
                                        <option value="IA" @if (old('department_gi') == 'IA') selected @endif>IT
                                            Administration</option>
                                        <option value="ACC" @if (old('department_gi') == 'ACC') selected @endif>
                                            Accounting</option>
                                        <option value="LOG" @if (old('department_gi') == 'LOG') selected @endif>
                                            Logistics</option>
                                        <option value="SM" @if (old('department_gi') == 'SM') selected @endif>
                                            Senior Management</option>
                                        <option value="BA" @if (old('department_gi') == 'BA') selected @endif>
                                            Business Administration</option>
                                    </select>
                                </div>
                            </div>
                            {{--<div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Department(s)<span class="text-danger"></span>
                                    </label>
                                    <p class="text-primary">Add all the related departments</p>
                                    <select id="select-state" placeholder="Select..." name="department_gi">
                                        <option value="">Select a value</option>

                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>--}}

                            <div class="sub-head">
                                Study Details
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Study Number</label>
                                    <input type="number" name="study_number_sd">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Name of Product</label>
                                    <input type="text" name="name_of_product_sd">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Study Title</label>
                                    <input type="text" name="study_title_sd">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Study type</label>
                                    <select name="study_type_sd">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="interventional-studies">Interventional Studies</option>
                                        <option value="observational-Studies">Observational Studies</option>
                                        <option value="preclinical-studies">Preclinical Studies</option>
                                        <option value="regulatory-studies">Regulatory Studies</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Study Protocol Number</label>
                                    <input id="docname" type="number" name="study_protocol_number_sd">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <p class="text-primary">Detailed Description</p>
                                    <label for="Responsible Department">Description</label>
                                    <textarea name="description_sd"></textarea>
                                    {{--<input type="text" name="description_sd">--}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label class="mb-4" for="Responsible Department">Comments</label>
                                    <textarea name="comments_sd"></textarea>
                                    {{--<input type="text" name="comments_sd">--}}
                                </div>
                            </div>
                            <div class="sub-head">
                                Additional Information
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Related studies</label>
                                    <p class="text-primary">Link between study records related to the same study type or topic</p>
                                    <select name="related_studies_ai">
                                        <option value="toxicology">Toxicology</option>
                                        <option value="microbiome">Microbiome</option>
                                        <option value="formulation-and-stability">Formulation and Stability </option>
                                        <option value="adaptive-clinical">Adaptive Clinical</option>
                                        <option value="Translational">Translational</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label class="mb-4" for="Responsible Department">Document Link</label>
                                    <input type="text" name="document_link_ai">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Appendiceis</label>
                                    <select name="appendiceis_ai">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="statistical-analysis-plan">Statistical Analysis Plan (SAP)</option>
                                        <option value="patient-information-sheet">Patient Information Sheet (PIS)</option>
                                        <option value="data-management-plan">Data Management Plan (DMP)</option>
                                        <option value="quality-assurance-plan">Quality Assurance (QA) Plan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Related Audits</label>
                                    <select name="related_audits_ai">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="quality-assurance-audits">Quality Assurance Audits</option>
                                        <option value="regulatory-compliance-audits">Regulatory Compliance Audits</option>
                                        <option value="clinical-trial-audits">Clinical Trial Audits</option>
                                        <option value="data-integrity-audits">Data Integrity Audits</option>
                                        <option value="process-and-documentation-audits">Process and Documentation Audits</option>
                                    </select>
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
            <div id="CCForm2" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="sub-head col-12">GCP Details</div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="start_date">Generic Product Name</label>
                                <div class="calenderauditee">
                                    <input type="text" id="start_date" name="generic_product_name_gcpd">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="start_date">Indication Name</label>
                                <div class="calenderauditee">
                                    <input type="text" id="start_date" name="indication_name_gcpd">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="start_date">Clinical Study Manager</label>
                                <div class="calenderauditee">
                                    <input type="text" id="start_date" name="clinical_study_manager_gcpd">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="start_date">Clinical Expert</label>
                                <div class="calenderauditee">
                                    <input type="text" id="start_date" name="clinical_expert_gcpd">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Responsible Department">Phase Level</label>
                                <select name="phase_level_gcpd">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="phase-I">Phase I</option>
                                    <option value="phase-II">Phase II</option>
                                    <option value="phase-advanced-trials">Phase-Advanced Trials</option>
                                    <option value="phase-transition-trials">Phase Transition Trials</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Responsible Department">Therapeutic Area</label>
                                <select name="therapeutic_area_gcpd">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="cardiology">Cardiology</option>
                                    <option value="oncology">Oncology</option>
                                    <option value="neurology">Neurology</option>
                                    <option value="endocrinology">Endocrinology</option>
                                    <option value="pulmonology">Pulmonology</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="start_date">IND No.</label>
                                <div class="calenderauditee">
                                    <input type="number" id="start_date" name="ind_no_gcpd">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="start_date">Number of Centers</label>
                                <div class="calenderauditee">
                                    <input type="number" id="start_date" name="number_of_centers_gcpd">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="start_date">#of Subjects</label>
                                <div class="calenderauditee">
                                    <input type="text" id="start_date" name="of_subjects_gcpd">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            Audit Site Information
                            <button type="button" name="audit_site_information" id="AuditSiteInformation">+</button>
                            <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                (Launch Instruction)
                            </span>
                        </label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="AuditSiteInformation_details" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 4%">Row#</th>
                                        <th style="width: 10%">Number</th>
                                        <th style="width: 16%">Audit Frequency</th>
                                        <th style="width: 16%"> Current</th>
                                        <th style="width: 16%"> CRO</th>
                                        <th style="width: 16%">Remark</th>
                                        <th style="width: 12%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td><input disabled type="text" name="audit_site_information[0][serial]" value="1"></td>
                                    <td><input type="number" name="audit_site_information[0][Number]"></td>
                                    <td><input type="text" name="audit_site_information[0][AuditFrequency]"></td>
                                    <td><input type="text" name="audit_site_information[0][Current]"></td>
                                    <td><input type="text" name="audit_site_information[0][CRO]"></td>
                                    <td><input type="text" name="audit_site_information[0][Remark]"></td>
                                    <td><button readonly type="text" class="removeRowBtn">Remove</button></td>
                                </tbody>

                            </table>

                        </div>
                    </div>
                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            Study Site Information
                            <button type="button" name="study_site_information" id="StudySiteInformation">+</button>
                            <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                (Launch Instruction)
                            </span>
                        </label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="StudySiteInformation_details" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 4%">Row#</th>
                                        <th style="width: 12%">Audit Site</th>
                                        <th style="width: 10%">Site No.</th>
                                        <th style="width: 16%">Investigator</th>
                                        <th style="width: 16%">First Patient in Date</th>
                                        <th style="width: 10%">Enrolled No.</th>
                                        <th style="width: 16%">Current</th>
                                        <th style="width: 16%">Remark</th>
                                        <th style="width: 12%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td><input disabled type="text" name="study_site_information[0][serial]" value="1"></td>
                                    <td><input type="text" name="study_site_information[0][AuditSite]"></td>
                                    <td><input type="number" name="study_site_information[0][SiteNo]"></td>
                                    <td><input type="text" name="study_site_information[0][Investigator]"></td>
                                    <td><input type="date" name="study_site_information[0][FirstPatientInDate]"></td>
                                    <td><input type="number" name="study_site_information[0][EnrolledNo]"></td>
                                    <td><input type="text" name="study_site_information[0][Current]"></td>
                                    <td><input type="text" name="study_site_information[0][Remark]"></td>
                                    <td><button readonly type="text" class="removeRowBtn">Remove</button></td>
                                    {{--<td><input readonly type="text"></td>--}}
                                </tbody>

                            </table>
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

            <!-- =========================================================================================================== -->

            <div id="CCForm3" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="sub-head">Important Date</div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Date">Initiation Date</label>
                                <input type="date" name="initiation_date_i">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Date">Study Start Date</label>
                                <input type="date" name="study_start_date">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Date">Study End Date</label>
                                <input type="date" name="study_end_date">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Date">Study Protocol</label>
                                <input type="text" name="study_protocol">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Date">First Subject in(FSI)</label>
                                <input type="date" name="first_subject_in">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Date">Last Subject Out</label>
                                <input type="date" name="last_subject_out">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Date">Data Base Lock(DBL)</label>
                                <input type="text" name="databse_lock">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Date">Integrated CTR</label>
                                <input type="text" name="integrated_ctr">
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

            <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Initiate</div>
                            <div class="col-4">
                                <div class="group-input">
                                    <label for="Victim"><b>Initiated By :</b></label>
                                    <div class=""></div>

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="group-input">

                                    <label for="Division Code"><b>Initiated On : </b></label>
                                    <div class="date"></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="group-input">

                                    <label for="Division Code"><b>Submit Comments : </b></label>
                                    <div class="date"></div>
                                </div>
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
                                '<td><input type="number" name="audit_site_information[' + serialNumber + '][Number]"></td>' +
                                '<td><input type="text" name="audit_site_information[' + serialNumber + '][AuditFrequency]"></td>' +
                                '<td><input type="text" name="audit_site_information[' + serialNumber + '][Current]"></td>' +
                                '<td><input type="text" name="audit_site_information[' + serialNumber + '][CRO]"></td>' +
                                '<td><input type="text" name="audit_site_information[' + serialNumber + '][Remark]"></td>' +
                                '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +
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
                                '<td><input type="text" name="study_site_information[' + serialNumber + '][AuditSite]"></td>' +
                                '<td><input type="number" name="study_site_information[' + serialNumber + '][SiteNo]"></td>' +
                                '<td><input type="text" name="study_site_information[' + serialNumber + '][Investigator]"></td>' +
                                '<td><input type="date" name="study_site_information[' + serialNumber + '][FirstPatientInDate]"></td>' +
                                '<td><input type="number" name="study_site_information[' + serialNumber + '][EnrolledNo]"></td>' +
                                '<td><input type="text" name="study_site_information[' + serialNumber + '][Current]"></td>' +
                                '<td><input type="text" name="study_site_information[' + serialNumber + '][Remark]"></td>' +
                                '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +
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
                $(document).on('click', '.removeRowBtn', function() {
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
