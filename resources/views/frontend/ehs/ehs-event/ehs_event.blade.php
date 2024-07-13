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
        <strong>Site Division/Project</strong> :{{ Helpers::getDivisionName(session()->get('division')) }}
        / EHS_Event
    </div>
</div>



@php
        $users = DB::table('users')->select('id','name')->get();
        
    @endphp
{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}


<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Detailed Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Damage Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Investigation Summary</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Root casue and Risk Analysis</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
        </div>
        

        <form action="{{ route('ehs_store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                <!-- Tab content -->
                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">
                            General Information
                        </div> <!-- RECORD NUMBER -->
                        <div class="row">
                        <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/EHS/{{ date('Y') }}/{{ $record_number }}">
                                    </div>
                                </div>
       
        
                                    
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input readonly type="text" name="division_code"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    </div>
                                </div>
     
                                <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator_id" value="{{ Auth::user()->name }}" >

                                </div>
                            </div>
                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date Of Initiation</b></label>
                                    <input disabled type="date" name="date_Of_initiation" value="">
                                    <input type="hidden" name="date_Of_initiation" value="">
                                </div>
                            </div> -->
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Opened">Date of Initiation</label>
                                        @if (isset($ehsevent) && $ehsevent->intiation_date)
                                            <input disabled type="text"
                                                value="{{ \Carbon\Carbon::parse($ehsevent->intiation_date)->format('d-M-Y') }}"
                                                name="intiation_date_display">
                                            <input type="hidden" value="{{ $ehsevent->intiation_date }}"
                                                name="intiation_date">
                                        @else
                                            <input disabled type="text" value="{{ date('d-M-Y') }}"
                                                name="intiation_date_display">
                                            <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                        @endif
                                    </div>
                                </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="assigned_to">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select name="assigned_to" id="assigned_to">
                                        <option value="">Select a value</option>
                                        @if ($users->isNotEmpty())
                                            @foreach ($users as $value)
                                                <option value="{{ $value->name }}">{{ $value->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date"> Due Date<span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MM-YYYY" />
                                        <input type="date" name="date_due"  min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="sub-head">
                                EHS Event Details
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Event type</label>
                                    <select name="event_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="event_type_1">Event-Type-1</option>
                                        <option value="event_type_2">Event-Type-2</option>
                                        <option value="event_type_3">Event-Type-3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Incident Sub-Type</label>
                                    <select name="incident_sub_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="sub_type_1">Sub-Type-1</option>
                                        <option value="sub_type_2">Sub-Type-2</option>
                                        <option value="sub_type_3">Sub-Type-3</option>
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Date Occurred</b></label>
                                    <input type="date" name="date_occurred" value="">
                                </div>
                            </div> -->

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Occurred <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input type="text" id="date_occurred"  placeholder="DD-MM-YYYY" />
                                        <input type="date" name="date_occurred" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'date_occurred')" />
                                    </div>
                                </div>
                            </div>
                            

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Time Occurred</label>
                                    <select name="time_occurred">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Date of Reporting</b></label>
                                    <input type="date" name="date_of_reporting" value="">
                                </div>
                            </div> -->

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date of Reporting <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input type="text" id="date_of_reporting"  placeholder="DD-MM-YYYY" />
                                        <input type="date" name="date_of_reporting" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'date_of_reporting')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Reporter</b></label>
                                    <input type="text" name="reporter" value="">

                                </div>
                            </div>
<!-- 
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="file_attach">File Attachments</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_attachment" oninput="addMultipleFiles(this, 'file_attachment')" multiple>
                                        </div>
                                    </div>
                                    {{-- <input type="file" name="file_attach[]" multiple> --}}
                                </div>
                            </div> -->

                            <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">File Attachments</label>
                                        <div>
                                            <small class="text-primary">
                                                Please Attach all relevant or supporting documents
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_attachment[]"
                                                    oninput="addMultipleFiles(this, 'file_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Responsible Department">Similar Incidents(s)</label>
                                    <select name="similar_incidents">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Short Description"> Description<span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Immediate Actions<span class="text-danger"></span></label>
                                    <textarea name="immediate_actions"></textarea>
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
                            <div class="sub-head col-12">Detailed Information</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Accident Type</label>
                                    <select name="accident_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">OSHA Reportable?</label>
                                    <select name="osha_reportable">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">First Lost Work Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date" readonly placeholder="DD-MM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="first_lost_work_date" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6  new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="end_date">Last Lost Work Date</lable>
                                        <div class="calenderauditee">
                                            <input type="text" id="end_date" placeholder="DD-MM-YYYY" />
                                            <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="end_date_checkdate" name="last_lost_work_date" class="hide-input" oninput="handleDateInput(this, 'end_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                        </div>
                                </div>
                            </div>
                            <div class="col-lg-6  new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="end_date">First Restricted Work Date</lable>
                                        <div class="calenderauditee">
                                            <input type="text" id="end_date2" placeholder="DD-MM-YYYY" />
                                            <input type="date" min="" id="end_date_checkdate" name="first_restricted_work_date" class="hide-input" oninput="handleDateInput(this, 'end_date2');checkDate('start_date_checkdate','end_date_checkdate')" />
                                        </div>
                                </div>
                            </div>
                            <div class="col-lg-6  new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="end_date">Last Restricted Work Date</lable>
                                        <div class="calenderauditee">
                                            <input type="text" id="end_date3" placeholder="DD-MM-YYYY" />
                                            <input type="date" min="" id="end_date_checkdate" name="last_restricted_work_date" class="hide-input" oninput="handleDateInput(this, 'end_date3');checkDate('start_date_checkdate','end_date_checkdate')" />
                                        </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Vehicle Type</label>
                                    <select name="vehicle_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Vehicle Number</label>
                                    <div class="calenderauditee">
                                        <input name="vehicle_number" type="text" id="start_date"  />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Litigation</label>
                                    <select name="litigation">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Department(s)</label>
                                    <div class="calenderauditee">
                                        <input name="department" type="text" id="start_date"  />
                                    </div>
                                </div>
                            </div>
                            <div class="sub-head col-12">Involved Persons</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Employee(s) Involved<span class="text-danger"></span></label>
                                    <textarea name="employee_involved"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Involved(s) Contractor(s)<span class="text-danger"></span></label>
                                    <textarea name="involved_contractor"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Attorneys (s) Involved(s)<span class="text-danger"></span></label>
                                    <textarea name="attorneys_involved"></textarea>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Witness(es) Information(0)
                                    <button type="button" name="audit-agenda-grid" id="Witness_details">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Witness_details_details">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Witness Name</th>
                                                <th style="width: 16%">Witness Type</th>
                                                <th style="width: 16%">Item Descriptions</th>
                                                <th style="width: 16%">Comments</th>
                                                <th style="width: 15%">Remarks</th>
                                                <th style="width: 15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="Witness_details_details[0][serial]" value="1"></td>
                                            <td><input type="text" name="Witness_details_details[0][witness_name]"></td>
                                            <td><input type="text" name="Witness_details_details[0][witness_type]"></td>
                                            <td><input type="text" name="Witness_details_details[0][item_descriptions]"></td>
                                            <td><input type="text" name="Witness_details_details[0][comments]"></td>
                                            <td><input type="text" name="Witness_details_details[0][remarks]"></td> 
                                            <td><button type="text" class="removeBtn">remove</button>
                                            </td>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Comments">Lead Investigator </label>
                                    <Input name="lead_investigator" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Comments">Line Operator </label>
                                    <Input name="line_operator" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Comments">Reporter </label>
                                    <Input name="detail_info_reporter" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Comments">Supervisor </label>
                                    <Input name="supervisor" />
                                </div>
                            </div>

                            <div class="sub-head col-12">Near Miss and Measures</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Unsafe Situation</label>
                                    <select name="unsafe_situation">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Safeguarding Measure Taken</label>
                                    <select name="safeguarding_measure_taken">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sub-head col-12">Enviromental Information</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Enviromental Category</label>
                                    <select name="enviromental_category">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Special Weather Conditions">Special Weather Conditions</label>
                                    <select name="Special_Weather_Conditions">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Source Department">Source Of Release or Spill</label>
                                    <select name="source_Of_release_or_spill">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Special Weather Conditions">Special Weather Conditions</label>
                                    <select name="Special_Weather_Conditions">
                                        <option value="">Cause Of Release or Spill</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Environment Evacuation Ordered">Environment Evacuation Ordered</label>
                                    <select name="environment_evacuation_ordered">
                                        <option value="">Environment Evacuation Ordered</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date">Date Simples Taken</label>
                                    <input type="date" name="date_simples_taken">
                                </div>
                            </div> --}}

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Date Simples Taken</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date9" readonly placeholder="DD-MM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="date_simples_taken" class="hide-input" oninput="handleDateInput(this, 'start_date9');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Agency">Agency(s) Notified</label>
                                    <select name="agency_notified">
                                        <option value="">Environment Evacuation Ordered</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="audit-agenda-grid">
                                        Materials Released(0)
                                        <button type="button" name="audit-agenda-grid" id="MaterialsReleased">+</button>
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="MaterialsReleased-field-table" name="materials_released">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">Row#</th>
                                                    <th style="width: 12%">Type of Material(s) Released</th>
                                                    <th style="width: 16%">Quantity Of Materials Released</th>
                                                    <th style="width: 16%"> Medium Affected By Released</th>
                                                    <th style="width: 16%"> Health Risk?</th>
                                                    <th style="width: 15%">Remarks</th>
                                                    <th style="width: 15%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><input disabled type="text" name="serial[]" value="1"></td>
                                                <td><input type="text" name="materials_released[0][type_of_material_released]"></td>
                                                <td><input type="text" name="materials_released[0][quantity_Of_materials_released]"></td>
                                                <td><input type="text" name="materials_released[0][medium_affected_by_released]"></td>
                                                <td><input type="text" name="materials_released[0][health_risk]"></td>
                                                <td><input type="text" name="materials_released[0][remarks]"></td>
                                                <td>
                                                    <button type="button"
                                                             class="removeBtn2">remove</button>
                                                     </td>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sub-head col-12">Fire Incident</div>
                        <!-- <div class="col-lg-12"> -->
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Agency">Fire Category</label>
                                <select name="fire_category">
                                    <option value="">--select--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Agency">Fire Evacuation Ordered?</label>
                                <select name="fire_evacuation_ordered">
                                    <option value="">--select--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                        <!-- </div> -->
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Agency">Combat By</label>
                                <select name="combat_by">
                                    <option value="">--select--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Agency">Fire Fighting Equipment Used</label>
                                <input type="text" name="fire_fighting_equipment_used">
                            </div>
                        </div>

                        {{-- <div class="col-md-6">
                            <div class="group-input">
                                <label for="zone">Zone</label>
                                <select name="zone">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="Asia">Asia</option>
                                    <option value="Europe">Europe</option>
                                    <option value="Africa">Africa</option>
                                    <option value="Central America">Central America</option>
                                    <option value="South America">South America</option>
                                    <option value="Oceania">Oceania</option>
                                    <option value="North America">North America</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="country">Country</label>
                                <select name="country" class="form-select country"
                                    aria-label="Default select example" onchange="loadStates()">
                                    <option>Select Country</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="state">State</label>
                                <select name="state" class="form-select state"
                                    aria-label="Default select example" onchange="loadCities()">
                                    <option>Select State</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="city">City</label>
                                <select name="city" class="form-select city"
                                    aria-label="Default select example">
                                    <option>Select City</option>
                                </select>
                            </div>
                        </div> --}}






                        <div class="sub-head col-12">Event Location</div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Agency">Zone</label>
                                <select name="zone">
                                     <option value="">Enter Your Selection Here</option>
                                    <option value="Asia">Asia</option>
                                    <option value="Europe">Europe</option>
                                    <option value="Africa">Africa</option>
                                    <option value="Central America">Central America</option>
                                    <option value="South America">South America</option>
                                    <option value="Oceania">Oceania</option>
                                    <option value="North America">North America</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Agency">Country</label>
                                <select name="country" class="form-select country"
                                    aria-label="Default select example" onchange="loadStates()">
                                    <option>Select Country</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="State">State/District</label>
                                <select name="state" class="form-select state"
                                aria-label="Default select example" onchange="loadCities()">
                                <option>Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="group-input">
                            <label for="Agency">City</label>
                            <select name="city" class="form-select city"
                                aria-label="Default select example">
                                <option >Select City</option>
                            </select>
                        </div>
                    </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Site">Site Name</label>
                                <select name="site_name">
                                    <option value="">--select--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Building">Building</label>
                                <select name="building">
                                    <option value="">--select--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Floor">Floor</label>
                                <select name="floor">
                                    <option value="">--select--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Room">Room</label>
                                <select name="room">
                                    <option value="">--select--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Location">Location</label>
                                <input type="text" name="location">
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

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Victim Information</div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Victim">Victim</label>
                                    <input type="text" name="victim" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Medical">Medical Treatment?(Y/N)</label>
                                    <select name="medical_treatment">
                                        <option value="">--select--</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Victim_Position">Victim Position</label>
                                    <select name="victim_position">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Victim_Realation">Victim Realation To Company</label>
                                    <select name="victim_realation">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Hospitalization">Hospitalization</label>
                                    <select name="hospitalization">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Hospital_name">Hospital Name</label>
                                    <input type="text" name="hospital_name" />
                                </div>
                            </div>
                          
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Date of Treatment</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date7" readonly placeholder="DD-MM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="date_of_treatment" class="hide-input" oninput="handleDateInput(this, 'start_date7');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Victim_Treated">Victim Treated By</label>
                                    <input type="text" name="victim_treated_by" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Victim_Treated">Medical Treatment Discription</label>
                                    <textarea name="medical_treatment_discription" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-12 sub-head">
                                Physical Damage
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Injury">Injury Type</label>
                                    <select name="injury_type">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Injury">Number of Injuries</label>
                                    <input type="text" name="number_of_injuries">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Injury">Type of Illness</label>
                                    <select name="type_of_illness">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Injury">Permanent Disability?</label>
                                    <select name="permanent_disability">
                                        <option value="">--select--</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="sub-head">
                                Damage Information
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Permanent">Damage Category</label>
                                    <select name="damage_category">
                                        <option value="">--select--</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Related_Equipment">Related Equipment</label>
                                    <input type="text" name="related_equipment">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Estimated_Amount">Estimated Amount of Damage Equipment</label>
                                    <input type="text" name="estimated_amount">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Permanent">Currency</label>
                                    <select name="currency">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Involved">Insurance Company Involved?</label>
                                    <select name="insurance_company_involved">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Denied_By_Insurance">Denied By Insurance Company?</label>
                                    <select name="denied_by_insurance">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Damage_Details">Damage Details</label>
                                    <textarea name="damage_details" id="" cols="30" rows="3"></textarea>
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
                        <div class="row">
                            <div class="sub-head">Investigation summary</div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Actual_Amount ">Actual Amount of Damage</label>
                                    <input type="text" name="actual_amount" />
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Currency">Currency</label>
                                    <select name="currency">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="investigation_summary">Investigation summary</label>
                                    <textarea name="investigation_summary" id="" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Conclusion">Conclusion</label>
                                    <textarea name="conclusion" id="" cols="30" rows="5"></textarea>
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

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Risk Factors</div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Safety_Impact_Probability">Safety Impact Probability</label>
                                    <select name="safety_impact_probability">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Safety_Impact_Severity">Safety Impact Severity</label>
                                    <select name="safety_impact_severity">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Legal_Impact_Probability">Legal Impact Probability</label>
                                    <select name="legal_impact_probability">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Legal_Impact_Severity">Legal Impact Severity</label>
                                    <select name="legal_impact_severity">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Business_Impact_Probability">Business Impact Probability</label>
                                    <select name="business_impact_probability">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Business_Impact_Severity">Business Impact Severity</label>
                                    <select name="business_impact_severity">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Revenue_Impact_Probability">Revenue Impact Probability</label>
                                    <select name="revenue_impact_probability">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Revenue_Impact_Severity">Revenue Impact Severity</label>
                                    <select name="revenue_impact_severity">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Brand_Impact_Probability">Brand Impact Probability</label>
                                    <select name="brand_impact_probability">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Brand_Impact_Severity">Brand Impact Severity</label>
                                    <select name="brand_impact_severity">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 sub-head">
                                Calculated Risk and Further Actions
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Safety_Impact_Risk">Safety Impact Risk</label>
                                    <select name="safety_impact_risk">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Legal_Impact_Risk">Legal Impact Risk</label>
                                    <select name="legal_impact_risk">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Business_Impact_Risk">Business Impact Risk</label>
                                    <select name="business_impact_risk">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Revenue_Impact_Risk">Revenue Impact Risk</label>
                                    <select name="revenue_impact_risk">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Brand_Impact_Risk">Brand Impact Risk</label>
                                    <select name="brand_impact_risk">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sub-head">
                                General Risk Information
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Impact">Impact</label>
                                    <select name="impact">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Impact_Analysis">Impact Analysis</label>
                                    <textarea name="impact_analysis" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Recommended_Action">Recommended Action</label>
                                    <textarea name="recommended_action" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Comments">Comments</label>
                                    <textarea name="comments" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Direct_Cause">Direct Cause</label>
                                    <select name="direct_cause">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Safeguarding">Safeguarding Measure Taken</label>
                                    <select name="root_cause_safeguarding_measure_taken">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sub-head">
                                Root Cause Analysis
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Permanent">Root cause Methodlogy</label>
                                    <select name="root_cause_methodlogy">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Root Cause(0)
                                    <button type="button" name="audit-agenda-grid" id="RootCause">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#RootCause-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="RootCause-field-instruction-modal" name="root_cause">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Root Cause Category</th>
                                                <th style="width: 16%"> Root Cause Sub Category</th>
                                                <th style="width: 16%"> Probability</th>
                                                <th style="width: 16%"> Comments</th>
                                                <th style="width: 15%">Remarks</th>
                                                <th style="width: 15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name="root_cause[0][root_cause_category]"></td>
                                            <td> <input type="text" name="root_cause[0][root_cause_sub_category]"></td>
                                            <td> <input type="text" name="root_cause[0][probability]"></td>
                                            <td> <input type="text" name="root_cause[0][comments]"></td>
                                            <td><input type="text" name="root_cause[0][remarks]"></td>
                                            <td>
                                                <button type="button"
                                                         class="removeBtn3">remove</button>
                                                 </td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Root_cause_Description">Root cause Description</label>
                                    <textarea name="root_cause_description" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="sub-head">
                                Risk Analysis
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Severity_Rate">Severity Rate</label>
                                    <select name="severity_rate">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Occurrence">Occurrence</label>
                                    <select name="occurrence">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Detection">Detection</label>
                                    <select name="detection">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="RPN">RPN</label>
                                    <select name="rpn">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Risk_Analysis">Risk Analysis</label>
                                    <textarea name="risk_analysis" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Criticality">Criticality</label>
                                    <select name="criticality">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Inform_Local_Authority">Inform Local Authority?</label>
                                    <select name="inform_local_authority">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Authority_Type">Authority Type</label>
                                    <select name="authority_type">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Authority(s)_Notified">Authority(s) Notified</label>
                                    <select name="authority_notified">
                                        <option value="">--select--</option>
                                         <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Other_Authority">Other Authority</label>
                                <input type="text" name="other_authority">
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
                        <div class="sub-head">Submit</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Submitted By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Submitted On</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Submitted Comment</label>
                                <div class="static"></div>
                            </div>
                        </div>

                        <div class="sub-head">Cancel</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Cancel By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Cancel On</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Cancel Comment</label>
                                <div class="static"></div>
                            </div>
                        </div>

                        <div class="sub-head">Review Complete</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Review Complete By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Review Complete On</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Review Complete Comment</label>
                                <div class="static"></div>
                            </div>
                        </div>

                        <div class="sub-head">More Information Required</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">More Information Required By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">More Information Required On</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">More Information Required Comment</label>
                                <div class="static"></div>
                            </div>
                        </div>

                        <div class="sub-head">Complete Investigation</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Complete Investigation By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Complete Investigation On</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Complete Investigation Comment</label>
                                <div class="static"></div>
                            </div>
                        </div>

                        <div class="sub-head">Analysis Complete</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Analysis Complete By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Analysis Complete On</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Analysis Complete Comment</label>
                                <div class="static"></div>
                            </div>
                        </div>

                        <div class="sub-head">More Investigation Required</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">More Investigation Required By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">More Investigation Required On</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">More Investigation Required Comment</label>
                                <div class="static"></div>
                            </div>
                        </div>

                        <div class="sub-head">Propose Plan
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Propose Plan By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Propose Plan On</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Propose Plan Comment</label>
                                <div class="static"></div>
                            </div>
                        </div>

                        <div class="sub-head">Approve Plan</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Approve Plan By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Approve Plan On</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Approve Plan Comment</label>
                                <div class="static"></div>
                            </div>
                        </div>

                        <div class="sub-head">Reject </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Reject By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Reject On</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Reject Comment</label>
                                <div class="static"></div>
                            </div>
                        </div>

                        <div class="sub-head">All CAPA Closed</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">All CAPA Closed By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">All CAPA Closed On</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">All CAPA Closed Comment</label>
                                <div class="static"></div>
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
    var config = {
        cUrl: 'https://api.countrystatecity.in/v1',
        ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
    };

    var countrySelect = document.querySelector('.country'),
        stateSelect = document.querySelector('.state'),
        citySelect = document.querySelector('.city');

    function loadCountries() {
        let apiEndPoint = `${config.cUrl}/countries`;

        $.ajax({
            url: apiEndPoint,
            headers: {
                "X-CSCAPI-KEY": config.ckey
            },
            success: function(data) {
                data.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.iso2;
                    option.textContent = country.name;
                    countrySelect.appendChild(option);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading countries:', error);
            }
        });
    }

    function loadStates() {
        stateSelect.disabled = false;
        stateSelect.innerHTML = '<option value="">Select State</option>';

        const selectedCountryCode = countrySelect.value;

        $.ajax({
            url: `${config.cUrl}/countries/${selectedCountryCode}/states`,
            headers: {
                "X-CSCAPI-KEY": config.ckey
            },
            success: function(data) {
                data.forEach(state => {
                    const option = document.createElement('option');
                    option.value = state.iso2;
                    option.textContent = state.name;
                    stateSelect.appendChild(option);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading states:', error);
            }
        });
    }

    function loadCities() {
        citySelect.disabled = false;
        citySelect.innerHTML = '<option value="">Select City</option>';

        const selectedCountryCode = countrySelect.value;
        const selectedStateCode = stateSelect.value;

        $.ajax({
            url: `${config.cUrl}/countries/${selectedCountryCode}/states/${selectedStateCode}/cities`,
            headers: {
                "X-CSCAPI-KEY": config.ckey
            },
            success: function(data) {
                data.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.id;
                    option.textContent = city.name;
                    citySelect.appendChild(option);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading cities:', error);
            }
        });
    }
    $(document).ready(function() {
        loadCountries();
    });
</script>
<script>
    $(document).ready(function() {
        $('#Witness_details').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="Witness_details_details[' + serialNumber + ']serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="Witness_details_details[' + serialNumber + '][witness_name]"></td>' +
                    '<td><input type="text" name="Witness_details_details[' + serialNumber + '][witness_type]"></td>' +
                    '<td><input type="text" name="Witness_details_details[' + serialNumber + '][item_descriptions]"></td>' +
                    '<td><input type="text" name="Witness_details_details[' + serialNumber + '][comments]"></td>' +
                    '<td><input type="text" name="Witness_details_details[' + serialNumber + '][remarks]"></td>' +
                    '<td><button type="text" class="removeBtn">remove</button></td>' +
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
    $(document).on('click', '.removeBtn', function() {
        $(this).closest('tr').remove();
    })
</script>
<script>
    $(document).ready(function() {
        $('#MaterialsReleased').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="materials_released[' + serialNumber + '][type_of_material_released]"></td>' +
                    '<td><input type="text" name="materials_released[' + serialNumber + '][quantity_Of_materials_released]"></td>' +
                    '<td><input type="text" name="materials_released[' + serialNumber + '][medium_affected_by_released]"></td>' +
                    '<td><input type="text" name="materials_released[' + serialNumber + '][health_risk]"></td>' +
                    '<td><input type="text" name="materials_released[' + serialNumber + '][remarks]"></td>' +
                    '<td><button type="text" class="removeBtn2">remove</button></td>' +
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
    $(document).on('click', '.removeBtn2', function() {
        $(this).closest('tr').remove();
    })
</script>
<script>
    $(document).ready(function() {
        $('#RootCause').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="root_cause[' + serialNumber + '][root_cause_category]"></td>' +
                    '<td><input type="text" name="root_cause[' + serialNumber + '][root_cause_sub_category]"></td>' +
                    '<td><input type="text" name="root_cause[' + serialNumber + '][probability]"></td>' +
                    '<td><input type="text" name="root_cause[' + serialNumber + '][comments]"></td>' +
                    '<td><input type="text" name="root_cause[' + serialNumber + '][remarks]"></td>' +
                    '<td><button type="text" class="removeBtn3">remove</button></td>' +
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
    $(document).on('click', '.removeBtn3', function() {
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