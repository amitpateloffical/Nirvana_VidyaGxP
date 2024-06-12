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
    function calculateRiskAnalysis(selectElement) {
        // Get the row containing the changed select element
        let row = selectElement.closest('tr');

        // Get values from select elements within the row
        let R = parseFloat(document.getElementById('analysisR').value) || 0;
        let P = parseFloat(document.getElementById('analysisP').value) || 0;
        let N = parseFloat(document.getElementById('analysisN').value) || 0;

        // Perform the calculation
        let result = R * P * N;

        // Update the result field within the row
        document.getElementById('analysisRPN').value = result;
    }
</script>

<div class="form-field-head">

    <div class="division-bar">
        <strong>Site Division/Project</strong> : {{ Helpers::getDivisionName(session()->get('division')) }}/Observation
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
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Compliance In-Progress</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Compliance Verification</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Activity log</button>
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button> -->
        </div>

        <form action="{{ route('observationstore') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="step-form">

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="sub-head">Parent record Information</div>
                            </div>
                           
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">(Parent) Date Opened</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="parent_date_opened"  placeholder="DD-MM-YYYY" />
                                        <input type="date" id="start_date_checkdate" name="parent_date_opened" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'parent_date_opened');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">(Parent) Observation</label>
                                    <textarea name="parent_observation"></textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Description">(Parent) Classification</label>
                                    <select name="parent_classification">
                                        <option value="">Enter Your Selection Here</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">(Parent) CAPA Taken/Proposed</label>
                                    <textarea name="parent_capa_taken_proposed"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">(Parent) TCD for Closure of Audit Task</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="parent_tcd_for_closure_of_audit_task" readonly placeholder="DD-MM-YYYY" />
                                        <input type="date" id="start_date_checkdate" name="parent_tcd_for_closure_of_audit_task" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'parent_tcd_for_closure_of_audit_task');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">General Information</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Division Code</b></label>
                                    <input readonly type="text" name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    {{-- <div class="static">QMS-North America</div> --}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="originator">Initiator</label>
                                    <input disabled type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_opened">Date of Initiation</label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Assignee</b></label>
                                    <input type="text" name="assignee">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Short Description</b></label>
                                    <input type="text" name="short_description">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Follow-up Task Description</label>
                                    <textarea name="follow_up_task_description"></textarea>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="file_attchment_if_any">File Attachment</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="file_attchment_if_any"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="file_attchment_if_any[]" {{-- ignore --}} oninput="addMultipleFiles(this, 'file_attchment_if_any')" multiple>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Follow-up Task Submit By</b></label>
                                    <input type="text" name="assignee">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Follow-up Task Submit On</b></label>
                                    <input type="text" name="assignee">
                                </div>
                            </div> -->

                        </div>
                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                            <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                            <button type="button"> <a class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="sub-head">Compliance Execution</div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Compliance Execution Details</label>
                                    <textarea name="compliance_execution_details"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">Date of Completion</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="date_of_completion" readonly placeholder="DD-MM-YYYY" />
                                        <input type="date" id="start_date_checkdate" name="date_of_completion" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'date_of_completion');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="file_attchment_if_any">Execution Attachment</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="file_attchment_if_any"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="execution_attachment" {{-- ignore --}} oninput="addMultipleFiles(this, 'file_attchment_if_any')" multiple>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Delay Justification</label>
                                    <textarea name="delay_justification"></textarea>
                                </div>
                            </div>
<!-- 
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Country">Execution Complete By</label>
                                    <input type="text" name="country">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Country">Execution Complete On</label>
                                    <input type="text" name="country">
                                </div>
                            </div> -->

                            <!-- {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="date_Response_due">Date Response Due</label>
                                        <input type="date" name="date_Response_due2" />
                                    </div>
                                </div> --}}
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date ">
                                    <label for="date_Response_due1">Date Response Due</label>
                                    <div class="calenderauditee">
                                        <input type="text" name="date_response_due1" id="date_Response_due" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="date_Response_due_checkdate" class="hide-input" oninput="handleDateInput(this, 'date_Response_due');checkDate('date_Response_due_checkdate','date_due_checkdate')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date ">
                                    <label for="date_due"> Due Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" name="capa_date_due" id="date_due" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="date_due_checkdate" class="hide-input" oninput="handleDateInput(this, 'date_due');checkDate('date_Response_due_checkdate','date_due_checkdate')" />
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="date_due">Date Due</label>
                                        <input type="date" name="capa_date_due">
                                    </div>
                                </div> --}}
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="assign_to2">Assigned To</label>
                                    <select name="assign_to2">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="cro_vendor">CRO/Vendor</label>
                                        <select name="cro_vendor">
                                            <option value="">-- Select --</option>
                                            <option title="Amit Guru" value="1">
                                                Amit Guru
                                            </option>
                                            <option title="Shaleen Mishra" value="2">
                                                Shaleen Mishra
                                            </option>
                                            <option title="Vikas Prajapati" value="3">
                                                Vikas Prajapati
                                            </option>
                                            <option title="Anshul Patel" value="4">
                                                Anshul Patel
                                            </option>
                                            <option title="Amit Patel" value="5">
                                                Amit Patel
                                            </option>
                                            <option title="Madhulika Mishra" value="6">
                                                Madhulika Mishra
                                            </option>
                                            <option title="Jim Kim" value="7">
                                                Jim Kim
                                            </option>
                                            <option title="Akash Asthana" value="8">
                                                Akash Asthana
                                            </option>
                                            <option title="Not Applicable" value="9">
                                                Not Applicable
                                            </option>
                                            {{-- @foreach ($users as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach --}}
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-12">
                        <div class="group-input">
                            <label for="action-plan-grid">
                                Action Plan<button type="button" name="action-plan-grid" id="observation_table">+</button>
                            </label>
                            <table class="table table-bordered" id="observation">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Action</th>
                                        <th>Responsible</th>
                                        <th>Deadline</th>
                                        <th>Item Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                    <td><input type="text" name="action[]"></td>
                                    {{-- <td><input type="text" name="responsible[]"></td> --}}
                                    <td> <select id="select-state" placeholder="Select..." name="responsible[]">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}
                                            </option>
                                            @endforeach
                                        </select></td>
                                    {{-- <td><input type="text" name="deadline[]"></td> --}}
                                    <td>
                                        <div class="group-input new-date-data-field mb-0">
                                            <div class="input-date ">
                                                <div class="calenderauditee">
                                                    <input type="text" id="deadline' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" />
                                                    <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" name="deadline[]" class="hide-input" oninput="handleDateInput(this, `deadline' + serialNumber +'`)" />
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" name="item_status[]"></td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="comments">Comments</label>
                            <textarea name="comments"></textarea>
                        </div>
                    </div> -->
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <!-- <div class="col-12">
                    <div class="sub-head"></div>
                </div>
                <div class="col-12">
                    <div class="group-input">
                        <label for="impact">Impact</label>
                        <select name="impact">
                            <option value="">-- Select --</option>
                            <option value="1">High</option>
                            <option value="2">Medium</option>
                            <option value="3">Low</option>
                            <option value="4">None</option>
                        </select>
                    </div>
                </div> -->

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Verification Comments</label>
                                    <textarea name="verification_commentss"></textarea>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="file_attchment_if_any">Verification Attachment</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="file_attchment_if_any"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="verification_attachment" {{-- ignore --}} oninput="addMultipleFiles(this, 'file_attchment_if_any')" multiple>
                                    </div>
                                </div>
                            </div>

                           


                            <div class="sub-head">Cancellation</div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Cancellation Remarks</label>
                                    <textarea name="cancellation_remarks"></textarea>
                                </div>
                            </div>

                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Country">Cancellation Done By</label>
                                    <input type="text" name="country">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Country">Cancellation Done On</label>
                                    <input type="text" name="country">
                                </div>
                            </div> -->


                            <!-- 
                <div class="col-12">
                    <div class="group-input">
                        <label for="impact_analysis">Impact Analysis</label>
                        <textarea name="impact_analysis"></textarea>
                    </div>
                </div> -->
                            <!-- <div class="col-12">
                    <div class="sub-head">Risk Analysis</div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Severity Rate">Severity Rate</label>
                        <select name="severity_rate" id="analysisR" onchange='calculateRiskAnalysis(this)'>
                            <option value="">Enter Your Selection Here</option>
                            <option value="1">Negligible</option>
                            <option value="2">Moderate</option>
                            <option value="3">Major</option>
                            <option value="4">Fatal</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Occurrence">Occurrence</label>
                        <select name="occurrence" id="analysisP" onchange='calculateRiskAnalysis(this)'>
                            <option value="">Enter Your Selection Here</option>
                            <option value="5">Extremely Unlikely</option>
                            <option value="4">Rare</option>
                            <option value="3">Unlikely</option>
                            <option value="2">Likely</option>
                            <option value="1">Very Likely</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Detection">Detection</label>
                        <select name="detection" id="analysisN" onchange='calculateRiskAnalysis(this)'>
                            <option value="">Enter Your Selection Here</option>
                            <option value="5">Impossible</option>
                            <option value="4">Rare</option>
                            <option value="3">Unlikely</option>
                            <option value="2">Likely</option>
                            <option value="1">Very Likely</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="RPN">RPN</label>
                        <input type="text" name="analysisRPN" id="analysisRPN" readonly>
                    </div>
                </div> -->
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="sub-head">General Information</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Follow-up Task Submit By</label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Follow-up Task Submit On</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="sub-head">Compliance Execution</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Execution Complete By</label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Execution Complete On</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="sub-head">Compliance Verification</div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Verification Completed By</label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Verification Completed On</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Cancellation Done By</label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Cancellation Done On</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>







                            <!-- {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="actual_start_date">Actual Start Date</label>
                                        <input type="date" name="actual_start_date">
                                    </div>
                                </div> --}}
                <div class="col-lg-6 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="actual_start_date">Actual Start Date</label>
                        <div class="calenderauditee">
                            <input type="text" id="actual_start_date" readonly placeholder="DD-MMM-YYYY" />
                            <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="actual_start_date_checkdate" name="actual_start_date" class="hide-input" oninput="handleDateInput(this, 'actual_start_date');checkDate('actual_start_date_checkdate','actual_end_date_checkdate')" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6  new-date-data-field">
                    <div class="group-input input-date">
                        <label for="actual_end_date">Actual End Date</lable>
                            <div class="calenderauditee">
                                <input type="text" id="actual_end_date" placeholder="DD-MMM-YYYY" />
                                <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="actual_end_date_checkdate" name="actual_end_date" class="hide-input" oninput="handleDateInput(this, 'actual_end_date');checkDate('actual_start_date_checkdate','actual_end_date_checkdate')" />
                            </div>


                    </div>
                </div>
                <div class="col-12">
                    <div class="group-input">
                        <label for="action_taken">Action Taken</label>
                        <textarea name="action_taken"></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="sub-head">Response Summary</div>
                </div>
                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="date_response_due">Date Response Due</label>
                                        <input type="date" name="date_response_due1">
                                    </div>
                                </div> --}}
                {{-- <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date ">
                                        <label for="date_response_due">Date Response Due</label>
                                        <div class="calenderauditee">
                                            <input type="text" name="date_response_due1" id="date_response_due1" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                oninput="handleDateInput(this, 'date_response_due1')" />
            </div>
        </div>
    </div> --}}
    {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="response_date">Date of Response</label>
                                        <input type="date" name="response_date">
                                    </div>
                                </div> --}}
    {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="attach_files">Attached Files</label>
                                        <input type="file" name="attach_files2">
                                    </div>
                                </div> --}}
    <div class="col-12">
        <div class="group-input">
            <label for="attach_files">Attached Files</label>
            <div><small class="text-primary">Please Attach all relevant or supporting
                    documents</small></div>
            <div class="file-attachment-field">
                <div class="file-attachment-list" id="attach_files2"></div>
                <div class="add-btn">
                    <div>Add</div>
                    <input type="file" id="myfile" name="attach_files2[]" oninput="addMultipleFiles(this, 'attach_files2')" multiple>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="group-input">
            <label for="related_url">Related URL</label>
            <input type="url" name="related_url">
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="response_summary">Response Summary</label>
            <textarea name="response_summary"></textarea>
        </div>
    </div> -->
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Completed_By">Completed By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Completed_On">Completed On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA_Approved_By">QA Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA_Approved_On">QA Approved On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_By">Final Approval By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_On">Final Approval On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="submit">Submit</button>
                            <button type="button"> <a class="text-white" href="{{ url('dashboard') }}"> Exit </a>
                            </button>
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
        ele: '#Facility, #Group, #Audit, #Auditee'
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
    $(document).ready(function() {
        $('#observation_table').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);
                console.log(users);
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="action[]"></td>' +
                    '<td><select name="responsible[]">' +
                    '<option value="">Select a value</option>';

                for (var i = 0; i < users.length; i++) {
                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }

                html += '</select></td>' +
                    // '<td><input type="date" name="deadline[]"></td>' +
                    '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="deadline' + serialNumber + '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="deadline[]" class="hide-input" oninput="handleDateInput(this, `deadline' + serialNumber + '`)" /></div></div></div></td>' +

                    '<td><input type="text" name="item_status[]"></td>' +
                    '</tr>';



                return html;
            }

            var tableBody = $('#observation tbody');
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