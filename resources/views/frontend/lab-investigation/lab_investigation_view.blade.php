@extends('frontend.layout.main')
@section('container')

@php
        $users = DB::table('users')->get();
       // dd(Auth::user());
        
@endphp
<style>
    textarea.note-codable {
        display: none !important;
    }

    header {
        display: none;
    }
</style>
  <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
    </style>

    <style>
        .progress-bars div {
            flex: 1 1 auto;
            border: 1px solid grey;
            padding: 5px;
            text-align: center;
            position: relative;
            /* border-right: none; */
            background: white;
        }

        .state-block {
            padding: 20px;
            margin-bottom: 20px;
        }

        .progress-bars div.active {
            background: green;
            font-weight: bold;
        }

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(1) {
            border-radius: 20px 0px 0px 20px;
        }


        #change-control-fields>div.container-fluid>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(7) {
            border-radius: 0px 20px 20px 0px;

        }
    </style>

<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / Lab Investigation
    </div>
</div>

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

                // Update the result field within the row
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
        <script>
            function calculateRiskAnalysis2(selectElement) {
                // Get the row containing the changed select element
                let row = selectElement.closest('tr');

                // Get values from select elements within the row
                let R = parseFloat(document.getElementById('analysisR2').value) || 0;
                let P = parseFloat(document.getElementById('analysisP2').value) || 0;
                let N = parseFloat(document.getElementById('analysisN2').value) || 0;

                // Perform the calculation
                let result = R * P * N;

                // Update the result field within the row
                document.getElementById('analysisRPN2').value = result;
            }
        </script>  <script>
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

                // Update the result field within the row
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
        <script>
            function calculateRiskAnalysis2(selectElement) {
                // Get the row containing the changed select element
                let row = selectElement.closest('tr');

                // Get values from select elements within the row
                let R = parseFloat(document.getElementById('analysisR2').value) || 0;
                let P = parseFloat(document.getElementById('analysisP2').value) || 0;
                let N = parseFloat(document.getElementById('analysisN2').value) || 0;

                // Perform the calculation
                let result = R * P * N;

                // Update the result field within the row
                document.getElementById('analysisRPN2').value = result;
            }
        </script>


<script>
    $(document).ready(function() {
        $('#root_couse').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="root_couse_category[]"></td>' +
                    '<td><input type="text" name="root_couse_sub_category[]"></td>' +
                    '<td><input type="text" name="probability[]"></td>' +
                    '<td><input type="text" name="Comment[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +
                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' + 

                //     '</tr>';

                return html;
            }

            var tableBody = $('#root_couse-first-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<div class="form-field-head">

        <!-- <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / CAPA
        </div> -->
    </div>


{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">
        <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow </div>
                     <div class="d-flex" style="gap:20px;">
                      @php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                       @endphp
                        <button class="button_theme1"> <a class="text-white" href="{{ url('CapaAuditTrial', $data->id) }}">
                                Audit Trail </a> </button>
                                @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">Submit</button>
                                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal"> Cancel </button>
                     
                                  @elseif($data->stage == 2 && (in_array(15, $userRoleIds) || in_array(18, $userRoleIds)))
                                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">Report Results</button>
                                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal"> Sample Received </button>
                     
                                  @elseif($data->stage == 3 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">Reject</button>
                                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">Evaluation Completed</button>
                     
                                @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>



                </div>   

        </div>   

         <div class="status">
                    <div class="head">Current Status</div>
                     @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else

                     <div class="progress-bars d-flex">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active">Lab Investigation in Progress</div>
                            @else
                                <div class="">Lab Investigation in Progress</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">Lab Investigation Evaluation</div>
                            @else
                                <div class="">Lab Investigation Evaluation</div>
                            @endif 
                             @if ($data->stage >=4)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif

                              @endif


                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>    

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Risk Assessment</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Investigation & Root Couse </button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signature</button>

        </div>

        <form action="{{ route('lab_invest_update',$data->id) }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="originator">Record Number</label>
                                            {{--  <input disabled type="text" name="record"  
                                     value="{{ Helpers::getDivisionName(session()->get('division')) }}/CAPA/{{ date('Y') }}/{{ $record_number }}">  --}}
                               <input disabled type="text" name="record "
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}/LI/{{ Helpers::year($data->created_at) }}/{{ $data->record }}">
                                    
                               
                                </div>
                            </div>



                         <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code">Site/Location Code</label>
                                        <input readonly type="text" name="division_id"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                             
                                    </div>
                                </div>

                                  <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="originator">Initiator</label>
                                    <input readonly  type="text" name="initiator_id" value="{{Auth::user()->name}}"  />
                                </div> 
                            </div>

                         <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Date of Initiation</label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>
                          
   <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Initiator Group Code">Short Description</label>
                                    <input type="text" name="short_description" id="initiator_group_code" value="{{ $data->short_description }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">Assigned To <span class="text-danger"></span></label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="">Select a value</option>
                                        @foreach ($users as $value)
                                            <option value="{{ $value->id }}" {{ $value->id == $data->assigned_to ? 'selected' : '' }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assign_to')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                             <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Due Date">Date Due</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" value="{{ $data->due_date ? \Carbon\Carbon::parse($data->due_date)->format('d-M-Y') : '' }}" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" value="{{ $data->due_date }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="If Others">Trainer</label>
                                    <select id="select-state" placeholder="Select..." name="trainer">
                                        <option value="">Select a value</option>
                                        @foreach ($users as $value)
                                            <option value="{{ $value->id }}" {{ $value->id == $data->trainer ? 'selected' : '' }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('trainer')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="expiry_date">Expiry Date</label>
                                            <div class="calenderauditee">
                                                <input type="text" id="expiration_date" readonly placeholder="DD-MMM-YYYY" value="{{ \Carbon\Carbon::parse($data->expiry_date)->format('d-M-Y') }}" />
                                                <input type="date" name="expiry_date" id="expiry_date" value="{{ \Carbon\Carbon::parse($data->expiry_date)->format('Y-m-d') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" onchange="handleDateInputdata(this, 'expiration_date')" />
                                            </div>
                                        </div>
                                    </div>


                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Type">Type</label>
                                <select name="type">
                                    <option value="">-- Select --</option>
                                    <option value="Facillties" {{ $data->type == 'Facillties' ? 'selected' : '' }}>Facillties</option>
                                    <option value="Other" {{ $data->type == 'Other' ? 'selected' : '' }}>Other</option>
                                    <option value="Stabillity" {{ $data->type == 'Stabillity' ? 'selected' : '' }}>Stabillity</option>
                                    <option value="Raw Material" {{ $data->type == 'Raw Material' ? 'selected' : '' }}>Raw Material</option>
                                    <option value="Clinical Production" {{ $data->type == 'Clinical Production' ? 'selected' : '' }}>Clinical Production</option>
                                    <option value="Commercial Production" {{ $data->type == 'Commercial Production' ? 'selected' : '' }}>Commercial Production</option>
                                    <option value="Labellling" {{ $data->type == 'Labellling' ? 'selected' : '' }}>Labellling</option>
                                    <option value="laboratory" {{ $data->type == 'laboratory' ? 'selected' : '' }}>laboratory</option>
                                    <option value="Utillities" {{ $data->type == 'Utillities' ? 'selected' : '' }}>Utillities</option>
                                    <option value="Validation" {{ $data->type == 'Validation' ? 'selected' : '' }}>Validation</option>
                                </select>
                            </div>
                        </div>


                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Priority Level">Priority Level</label>
                            <select name="priority_level">
                                <option value="">-- Select --</option>
                                <option value="low" {{ $data->priority_level == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $data->priority_level == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $data->priority_level == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                    </div>




                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="External Tests">External Tests</label>
                            <select name="external_tests">
                                <option value="">-- select --</option>
                                <option value="test1" {{ $data->external_tests == 'test1' ? 'selected' : '' }}>test 1</option>
                                <option value="test2" {{ $data->external_tests == 'test2' ? 'selected' : '' }}>test 2</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Test Lab">Test Lab</label>
                            <select name="test_lab">
                                <option value="0">-- select --</option>
                                <option value="test1" {{ $data->test_lab == 'test1' ? 'selected' : '' }}>test 1</option>
                                <option value="test2" {{ $data->test_lab == 'test2' ? 'selected' : '' }}>test 2</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Original Test Results">Original Test Results</label>
                            <select name="original_test_result">
                                <option value="">-- select --</option>
                                <option value="result1" {{ $data->original_test_result == 'result1' ? 'selected' : '' }}>Result 1</option>
                                <option value="result2" {{ $data->original_test_result == 'result2' ? 'selected' : '' }}>Result 2</option>
                            </select>
                        </div>
                    </div>


                       <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Limits / Specifications">Limits / Specifications</label>
                            <select name="limit_specifications">
                                <option value="">-- select --</option>
                                <option value="limit1" {{ $data->limit_specifications == 'limit1' ? 'selected' : '' }}>limit 1</option>
                                <option value="limit2" {{ $data->limit_specifications == 'limit2' ? 'selected' : '' }}>limit 2</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Additional Investigators">Additional Investigators</label>
                            <select id="select-state" placeholder="Select..." name="additional_investigator">
                                <option value="">Select a value</option>
                                @foreach ($users as $value)
                                    <option value="{{ $value->id }}" {{ $value->id == $data->additional_investigator ? 'selected' : '' }}>
                                        {{ $value->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('additional_investigator')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                       <div class="col-lg-6">
                        <div class="group-input">
                        {{--  {{  dd($data->departments)}}  --}}
                            <label for="department">Department(s)</label>
                        <select multiple name="departments[]" placeholder="Select Department(s)" data-search="false" data-silent-initial-value-set="true" id="department">
                        <option value="1" {{ (!empty($data->departments) && in_array('1', $data->departments)) ? 'selected' : '' }}>Work Instruction</option>
                        <option value="2" {{ (!empty($data->departments) && in_array('2', $data->departments)) ? 'selected' : '' }}>Quality Assurance</option>
                        <option value="3" {{ (!empty($data->departments) && in_array('3', $data->departments)) ? 'selected' : '' }}>Specifications</option>
                        <option value="4" {{ (!empty($data->departments) && in_array('4', $data->departments)) ? 'selected' : '' }}>Production</option>
                        </select>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Description">Description</label>
                            <textarea class="" name="description" id="">{{ old('description', $data->description) }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="group-input">
                            <label for="Comments">Comments</label>
                            <textarea class="" name="comments" id="">{{ old('comments', $data->comments) }}</textarea>
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
                                                <div disabled class="file-attachment-list" id="root_cause_initial_attachment">
                                                    @if ($data->attached_test)
                                                    @foreach(json_decode($data->attached_test) as $file)
                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                               @endforeach
                                                    @endif
                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>

                                                    <input type="file" id="myfile" name="attached_test[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                        oninput="addMultipleFiles(this, 'root_cause_initial_attachment')"
                                                        multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Related URLs">Related URLs</label>
                                  
                    <input type="text" name="related_urls" value="{{ old('related_urls', $data->related_urls) }}">

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
                            <div class="sub-head col-12">Risk assessment</div>

                           <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Severity Rate">Severity Rate</label>
                                <select name="severity_rate" id="analysisR2" onchange='calculateRiskAnalysis2(this)'>
                                    <option value="0">Enter Your Selection Here</option>
                                    <option value="1" {{ $data->severity_rate == 1 ? 'selected' : '' }}>High</option>
                                    <option value="2" {{ $data->severity_rate == 2 ? 'selected' : '' }}>Low</option>
                                    <option value="3" {{ $data->severity_rate == 3 ? 'selected' : '' }}>Medium</option>
                                    <option value="4" {{ $data->severity_rate == 4 ? 'selected' : '' }}>None</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Occurrence">Occurrence</label>
                                <select name="occurrence" id="analysisP2" onchange='calculateRiskAnalysis2(this)'>
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="1" {{ $data->occurrence == 1 ? 'selected' : '' }}>High</option>
                                    <option value="2" {{ $data->occurrence == 2 ? 'selected' : '' }}>Medium</option>
                                    <option value="3" {{ $data->occurrence == 3 ? 'selected' : '' }}>Low</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Detection">Detection</label>
                                <select name="detection" id="analysisN2" onchange='calculateRiskAnalysis2(this)'>
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="5" {{ $data->detection == 5 ? 'selected' : '' }}>Impossible</option>
                                    <option value="4" {{ $data->detection == 4 ? 'selected' : '' }}>Rare</option>
                                    <option value="3" {{ $data->detection == 3 ? 'selected' : '' }}>Unlikely</option>
                                    <option value="2" {{ $data->detection == 2 ? 'selected' : '' }}>Likely</option>
                                    <option value="1" {{ $data->detection == 1 ? 'selected' : '' }}>Very Likely</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="RPN">RPN</label>
                                <input type="text" name="RPN" id="analysisRPN2" value="{{ $data->RPN }}" readonly>
                            </div>
                        </div>



                         <div class="col-md-12">
    <div class="group-input">
        <label for="Risk Analysis">Risk Analysis</label>
        <textarea name="risk_analysis" id="">{{ $data->risk_analysis }}</textarea>
    </div>
</div>

<div class="sub-head">Geogrephic Information</div>

<div class="col-lg-6">
    <div class="group-input">
        <label for="Zone">Zone</label>
        <select name="zone" id="zone">
            <option value="">Enter Your Selection Here</option>
            @foreach($zones as $zone)
                <option value="{{ $zone }}" {{ $data->zone == $zone ? 'selected' : '' }}>{{ $zone }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-lg-6">
    <div class="group-input">
        <label for="Country">Country</label>
        <select name="country" class="countries" id="country">
            <option value="">Select Country</option>
            @foreach($countries as $country)
                <option value="{{ $country }}" {{ $data->country == $country ? 'selected' : '' }}>{{ $country }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-lg-6">
    <div class="group-input">
        <label for="City">City</label>
        <select name="city" class="cities" id="city">
            <option value="">Select City</option>
            @foreach($cities as $city)
                <option value="{{ $city }}" {{ $data->city == $city ? 'selected' : '' }}>{{ $city }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-lg-6">
    <div class="group-input">
        <label for="State/District">State/District</label>
        <select name="state_district" class="states" id="stateId">
            <option value="">Select State</option>
            @foreach($states as $state)
                <option value="{{ $state }}" {{ $data->state_district == $state ? 'selected' : '' }}>{{ $state }}</option>
            @endforeach
        </select>
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

              
               <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                                <div class="row">
                                   
                              <div class="col-12">
                                <div class="group-input">
                                    <label for="root-cause-methodology">Root Cause Methodology</label>
                                    @php
                                        $selectedMethodologies = explode(',', $data->root_cause_methodology);
                                    @endphp
                                    <select name="root_cause_methodology[]" multiple {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} id="root-cause-methodology">
                                        <option value="Why-Why Chart" @if(in_array('Why-Why Chart', $selectedMethodologies)) selected @endif>Why-Why Chart</option>
                                        <option value="Failure Mode and Effect Analysis" @if(in_array('Failure Mode and Effect Analysis', $selectedMethodologies)) selected @endif>Failure Mode and Effect Analysis</option>
                                        <option value="Fishbone or Ishikawa Diagram" @if(in_array('Fishbone or Ishikawa Diagram', $selectedMethodologies)) selected @endif>Fishbone or Ishikawa Diagram</option>
                                        <option value="Is/Is Not Analysis" @if(in_array('Is/Is Not Analysis', $selectedMethodologies)) selected @endif>Is/Is Not Analysis</option>
                                    </select>
                                </div>
                            </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="root_cause">
                                                Root Cause
                                                <button type="button" onclick="add4Input_case('root-cause-first-table')"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>+</button>
                                            </label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="root-cause-first-table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:5%">Row #</th>
                                                            <th>Root Cause Category</th>
                                                            <th>Root Cause Sub-Category</th>
                                                            <th>Probability</th>
                                                            <th>Remarks</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!empty($data->Root_Cause_Category))
                                                        @foreach (unserialize($data->Root_Cause_Category) as $key => $Root_Cause_Category)
                                                            <tr>
                                                                <td><input disabled type="text" name="serial_number[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $key + 1 }}">
                                                                </td>
                                                                <td><input type="text" name="Root_Cause_Category[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->Root_Cause_Category)[$key] ? unserialize($data->Root_Cause_Category)[$key] : '' }}"></td>
                                                                <td><input type="text" name="Root_Cause_Sub_Category[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->Root_Cause_Sub_Category)[$key] ? unserialize($data->Root_Cause_Sub_Category)[$key] : '' }}"></td>
                                                                <td><input type="text" name="Probability[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->Probability)[$key] ? unserialize($data->Probability)[$key] : '' }}"></td>
                                                                <td><input type="text" name="Remarks[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->Remarks)[$key] ?? null }}"></td>
                                                              <td><button type="text" class="removeRowBtn" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Remove</button></td>
                                                            </tr>
                                                            @endforeach
                                                            @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{--  <div class="col-12 sub-head"></div>  --}}
                                  <div class="col-12 mb-4" id="fmea-section" style="display:none;">
                              
                                        <div class="group-input">
                                            <label for="agenda">
                                                Failure Mode and Effect Analysis<button type="button" name="agenda"
                                                    onclick="addRootCauseAnalysisRiskAssessment1('risk-assessment-risk-management')"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>+</button>
                                            </label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" style="width: 200%"
                                                    id="risk-assessment-risk-management">
                                                   <thead>
    <tr>
        <th>Row #</th>
        <th>Risk Factor</th>
        <th>Risk element</th>
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
        <th>Mitigation proposal (Mention either CAPA reference number, IQ, OQ or PQ)</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @if (!empty($riskEffectAnalysis->risk_factor))
        @foreach (unserialize($riskEffectAnalysis->risk_factor) as $key => $riskFactor)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td><input name="risk_factor[]" type="text" value="{{ $riskFactor }}" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}></td>
                <td><input name="risk_element[]" type="text" value="{{ unserialize($riskEffectAnalysis->risk_element)[$key] ?? '' }}" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}></td>
                <td><input name="problem_cause[]" type="text" value="{{ unserialize($riskEffectAnalysis->problem_cause)[$key] ?? '' }}" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}></td>
                <td><input name="existing_risk_control[]" type="text" value="{{ unserialize($riskEffectAnalysis->existing_risk_control)[$key] ?? '' }}" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}></td>
                <td>
                    <select onchange="calculateInitialResult(this)" class="fieldR" name="initial_severity[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                        <option value="">-- Select --</option>
                        <option value="1" {{ (unserialize($riskEffectAnalysis->initial_severity)[$key] ?? '') == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ (unserialize($riskEffectAnalysis->initial_severity)[$key] ?? '') == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ (unserialize($riskEffectAnalysis->initial_severity)[$key] ?? '') == 3 ? 'selected' : '' }}>3</option>
                    </select>
                </td>
                <td>
                    <select onchange="calculateInitialResult(this)" class="fieldP" name="initial_detectability[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                        <option value="">-- Select --</option>
                        <option value="1" {{ (unserialize($riskEffectAnalysis->initial_detectability)[$key] ?? '') == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ (unserialize($riskEffectAnalysis->initial_detectability)[$key] ?? '') == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ (unserialize($riskEffectAnalysis->initial_detectability)[$key] ?? '') == 3 ? 'selected' : '' }}>3</option>
                    </select>
                </td>
                <td>
                    <select onchange="calculateInitialResult(this)" class="fieldN" name="initial_probability[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                        <option value="">-- Select --</option>
                        <option value="1" {{ (unserialize($riskEffectAnalysis->initial_probability)[$key] ?? '') == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ (unserialize($riskEffectAnalysis->initial_probability)[$key] ?? '') == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ (unserialize($riskEffectAnalysis->initial_probability)[$key] ?? '') == 3 ? 'selected' : '' }}>3</option>
                    </select>
                </td>
                <td>
                    <input name="initial_rpn[]" class='initial-rpn' type="text" value="{{ unserialize($data->initial_rpn)[$key] ?? '' }}" disabled>
                </td>
                <td>
                    <select onchange="calculateInitialResult(this)" class="fieldR" name="risk_acceptance[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                        <option value="">-- Select --</option>
                        <option value="Y" {{ (unserialize($riskEffectAnalysis->risk_acceptance)[$key] ?? '') == 'Y' ? 'selected' : '' }}>Y</option>
                        <option value="N" {{ (unserialize($riskEffectAnalysis->risk_acceptance)[$key] ?? '') == 'N' ? 'selected' : '' }}>N</option>
                    </select>
                </td>
                <td>
                    <input name="risk_control_measure[]" type="text" value="{{ unserialize($data->risk_control_measure)[$key] ?? '' }}" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                </td>
                <td>
                    <select onchange="calculateResidualResult(this)" class="residual-fieldR" name="residual_severity[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                        <option value="">-- Select --</option>
                        <option value="1" {{ (unserialize($riskEffectAnalysis->residual_severity)[$key] ?? '') == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ (unserialize($riskEffectAnalysis->residual_severity)[$key] ?? '') == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ (unserialize($riskEffectAnalysis->residual_severity)[$key] ?? '') == 3 ? 'selected' : '' }}>3</option>
                    </select>
                </td>
                <td>
                    <select onchange="calculateResidualResult(this)" class="residual-fieldP" name="residual_probability[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                        <option value="">-- Select --</option>
                        <option value="1" {{ (unserialize($riskEffectAnalysis->residual_probability)[$key] ?? '') == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ (unserialize($riskEffectAnalysis->residual_probability)[$key] ?? '') == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ (unserialize($riskEffectAnalysis->residual_probability)[$key] ?? '') == 3 ? 'selected' : '' }}>3</option>
                    </select>
                </td>
                <td>
                    <select onchange="calculateResidualResult(this)" class="residual-fieldN" name="residual_detectability[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                        <option value="">-- Select --</option>
                        <option value="1" {{ (unserialize($riskEffectAnalysis->residual_detectability)[$key] ?? '') == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ (unserialize($riskEffectAnalysis->residual_detectability)[$key] ?? '') == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ (unserialize($riskEffectAnalysis->residual_detectability)[$key] ?? '') == 3 ? 'selected' : '' }}>3</option>
                    </select>
                </td>
                <td>
                    <input name="residual_rpn[]" class='residual-rpn' type="text" value="{{ unserialize($data->residual_rpn)[$key] ?? '' }}" disabled>
                </td>
                <td>
                    <select onchange="calculateInitialResult(this)" class="fieldR" name="risk_acceptance2[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                        <option value="">-- Select --</option>
                        <option value="Y" {{ (unserialize($riskEffectAnalysis->risk_acceptance2)[$key] ?? '') == 'Y' ? 'selected' : '' }}>Y</option>
                        <option value="N" {{ (unserialize($riskEffectAnalysis->risk_acceptance2)[$key] ?? '') == 'N' ? 'selected' : '' }}>N</option>
                    </select>
                </td>
                <td>
                    <input name="mitigation_proposal[]" type="text" value="{{ unserialize($riskEffectAnalysis->mitigation_proposal)[$key] ?? '' }}" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                </td>
                <td><button type="button" class="removeRowBtn" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Remove</button></td>
            </tr>
        @endforeach
    @endif
</tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {{--  <div class="col-12 sub-head"></div>  --}}
                                <div class="col-12" id="fishbone-section" style="display:none;">
                                        <div class="group-input">
                                            <label for="fishbone">
                                                Fishbone or Ishikawa Diagram
                                                <button type="button" name="agenda"
                                                    onclick="addFishBone('.top-field-group', '.bottom-field-group')"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>+</button>
                                                <button type="button" name="agenda" class="fishbone-del-btn"
                                                    onclick="deleteFishBone('.top-field-group', '.bottom-field-group')">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                                <span class="text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#fishbone-instruction-modal"
                                                    style="font-size: 0.8rem; font-weight: 400;">
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
                                                            @if (!empty($data->measurement))
                                                                @foreach (unserialize($data->measurement) as $key => $measure)
                                                                    <div><input type="text"
                                                                            value="{{ $measure }}"
                                                                            name="measurement[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}></div>
                                                                    <div><input type="text"
                                                                            value="{{ unserialize($data->materials)[$key] ? unserialize($data->materials)[$key] : '' }}"
                                                                            name="materials[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}></div>
                                                                    <div><input type="text"
                                                                            value="{{ unserialize($data->methods)[$key] ?? null }}"
                                                                            name="methods[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}></div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="mid"></div>
                                                    <div class="bottom-field-group">
                                                        <div class="grid-field fields bottom-field">
                                                            @if (!empty($data->environment))
                                                                @foreach (unserialize($data->environment) as $key => $measure)
                                                                    <div><input type="text"
                                                                            value="{{ $measure }}"
                                                                            name="environment[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}></div>
                                                                    <div><input type="text"
                                                                            value="{{ unserialize($data->manpower)[$key] ? unserialize($data->manpower)[$key] : '' }}"
                                                                            name="manpower[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}></div>
                                                                    <div><input type="text"
                                                                            value="{{ unserialize($data->machine)[$key] ? unserialize($data->machine)[$key] : '' }}"
                                                                            name="machine[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}></div>
                                                                @endforeach
                                                            @endif

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
                                                          <textarea name="problem_statement"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->problem_statement }}</textarea>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--  <div class="col-12 sub-head"></div>  --}}
                                     <div class="col-12" id="why-why-chart-section" style="display:none;">
                                   <div class="group-input">
                                            <label for="why-why-chart">
                                                Why-Why Chart
                                                <span class="text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#why_chart-instruction-modal"
                                                    style="font-size: 0.8rem; font-weight: 400;">
                                                    (Launch Instruction)
                                                </span>
                                            </label>
                                            <div class="why-why-chart">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr style="background: #f4bb22">
                                                            <th style="width:150px;">Problem Statement</th>
                                                              <td>
                                                            <textarea name="why_problem_statement">{{ $data->why_problem_statement }}</textarea>
                                                        </td>

                                                        </tr>
                                                        <tr class="why-row">
                                                            <th style="width:150px; color: #393cd4;">
                                                                Why 1 <span
                                                                    onclick="addWhyField('why_1_block', 'why_1[]')"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>+</span>
                                                            </th>
                                                            <td>
                                                                <div class="why_1_block"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                                    @if (!empty($data->why_1))
                                                                        @foreach (unserialize($data->why_1) as $key => $measure)
                                                                            <textarea name="why_1[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $measure }}</textarea>
                                                                        @endforeach
                                                                    @endif

                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="why-row">
                                                            <th style="width:150px; color: #393cd4;">
                                                                Why 2 <span
                                                                    onclick="addWhyField('why_2_block', 'why_2[]')"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : ''}}>+</span>
                                                            </th>
                                                            <td>
                                                                <div class="why_2_block">
                                                                    @if (!empty($data->why_2))
                                                                        @foreach (unserialize($data->why_2) as $key => $measure)
                                                                            <textarea name="why_2[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $measure }}</textarea>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="why-row">
                                                            <th style="width:150px; color: #393cd4;">
                                                                Why 3 <span
                                                                    onclick="addWhyField('why_3_block', 'why_3[]')"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>+</span>
                                                            </th>
                                                            <td>
                                                                <div class="why_3_block">
                                                                    @if (!empty($data->why_3))
                                                                        @foreach (unserialize($data->why_3) as $key => $measure)
                                                                            <textarea name="why_3[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $measure }}</textarea>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="why-row">
                                                            <th style="width:150px; color: #393cd4;">
                                                                Why 4 <span
                                                                    onclick="addWhyField('why_4_block', 'why_4[]')"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>+</span>
                                                            </th>
                                                            <td>
                                                                <div class="why_4_block">
                                                                    @if (!empty($data->why_4))
                                                                        @foreach (unserialize($data->why_4) as $key => $measure)
                                                                            <textarea name="why_4[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $measure }}</textarea>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="why-row">
                                                            <th style="width:150px; color: #393cd4;">
                                                                Why 5 <span
                                                                    onclick="addWhyField('why_5_block', 'why_5[]')"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>+</span>
                                                            </th>
                                                            <td>
                                                                <div class="why_5_block">
                                                                    @if (!empty($data->why_5))
                                                                        @foreach (unserialize($data->why_5) as $key => $measure)
                                                                            <textarea name="why_5[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $measure }}</textarea>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr style="background: #0080006b;">
                                                            <th style="width:150px;">Root Cause :</th>
                                                            <td>
                                                                <textarea name="why_root_cause"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->why_root_cause }}</textarea>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 sub-head"></div>
                                    {{-- <div class="col-12">
                                        <div class="group-input">
                                            <label for="why-why-chart">
                                                Is/Is Not Analysis
                                                <span class="text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#is_is_not-instruction-modal"
                                                    style="font-size: 0.8rem; font-weight: 400;">
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
                                                                <textarea name="what_rationable"> </textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="background: #0039bd85">Where</th>
                                                            <td>
                                                                <textarea name="where_will_be"> </textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="where_will_not_be"> </textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="where_rationable"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="background: #0039bd85">When</th>
                                                            <td>
                                                                <textarea name="when_will_be"> </textarea>
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
                                                                <textarea name="coverage_will_be"> </textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="coverage_will_not_be"> </textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="coverage_rationable"> </textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="background: #0039bd85">Who</th>
                                                            <td>
                                                                <textarea name="who_will_be"> </textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="who_will_not_be"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="who_rationable"> </textarea>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> --}}
                                       <div class="col-12" id="is-is-not-section" style="display:none;">
                                 <div class="group-input">
                                            <label for="why-why-chart">
                                                Is/Is Not Analysis
                                                <span class="text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#is_is_not-instruction-modal"
                                                    style="font-size: 0.8rem; font-weight: 400;">
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
                                                                <textarea name="what_will_be" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->what_will_be }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="what_will_not_be" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->what_will_not_be }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="what_rationable"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->what_rationable }}</textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="background: #0039bd85">Where</th>
                                                            <td>
                                                                <textarea name="where_will_be"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->where_will_be }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="where_will_not_be"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->where_will_not_be }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="where_rationable"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->where_rationable }}</textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="background: #0039bd85">When</th>
                                                            <td>
                                                                <textarea name="when_will_be"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->when_will_be }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="when_will_not_be"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->when_will_not_be }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="when_rationable"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->when_rationable }}</textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="background: #0039bd85">Coverage</th>
                                                            <td>
                                                                <textarea name="coverage_will_be"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->coverage_will_be }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="coverage_will_not_be"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->coverage_will_not_be }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="coverage_rationable"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->coverage_rationable }}</textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="background: #0039bd85">Who</th>
                                                            <td>
                                                                <textarea name="who_will_be"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->who_will_be }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="who_will_not_be"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->who_will_not_be }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="who_rationable"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->who_rationable }}</textarea>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {{--  <div class="col-12 sub-head"></div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="root_cause_description">Root Cause Description</label>
                                            <textarea name="root_cause_description"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->root_cause_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="investigation_summary">Investigation Summary</label>
                                            <textarea name="investigation_summary"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> {{ $data->investigation_summary }}</textarea>
                                        </div>
                                    </div>  --}}
                                 {{-- <div class="col-12">
                                        <div class="sub-head">Geographic Information</div>
                                    </div> --}}
                                    {{-- <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Zone">Zone</label>
                                            <select name="zone" id="zone">
                                                <option value="">Enter Your Selection Here</option>
                                                <option @if ($data->zone =='Asia') selected @endif value="Asia">Asia</option>
                                                <option @if ($data->zone =='Europe') selected @endif value="Europe">Europe</option>
                                                <option @if ($data->zone =='Africa') selected @endif value="Africa">Africa</option>
                                                <option @if ($data->zone =='Central_America') selected @endif value="Central_America">Central America</option>
                                                <option @if ($data->zone =='South_America') selected @endif value="South_America">South America</option>
                                                <option @if ($data->zone =='Oceania') selected @endif value="Oceania">Oceania</option>
                                                <option @if ($data->zone =='North_America') selected @endif value="North_America">North America</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Country">Country</label>
                                            <select name="country" class="countries" id="country">
                                                <option value="">Select Country</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="State/District">State/District</label>
                                            <select name="state" class="states" id="stateId">
                                                <option value="">Select State</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="City">City</label>
                                            <select name="city" class="cities" id="city">
                                                <option value="">Select City</option>

                                            </select>
                                        </div>
                                    </div> --}}



                                       <div class="col-12">
                                                <div class="group-input">
                                                    <label for="root_cause_description">Root Cause Description</label>
                                                    <textarea name="root_cause_description">{{$data->root_cause_description}}</textarea>
                                                </div>
                                            </div>

                                             <div class="col-12">
                                                <div class="group-input">
                                                    <label for="investigation_summary">Investigation Summary</label>
                                                    <textarea name="investigation_summary">{{$data->investigation_summary}}</textarea>
                                                </div>
                                            </div>
                                </div>

                                <div class="button-block">
                                    <button type="submit" class="saveButton"
                                        {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>
                                </div>
                            </div>
                        </div>



        
        
                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">
                            Activity Log
                        </div>
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Completed By">Completed By</label>
                                   
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Completedon">Completed on </label>
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
            </div>
        </form>
{{--  ----------------------------------model start---------------------------------------------  --}}
          <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{route('labStage',$data->id)}}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input type="text" name="comments">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                        {{-- <button>Close</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>




     <div class="modal fade" id="cancel-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="route('lab_reject',$data->id)" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input type="text" name="a_l_comments" required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button>Close</button>
                        </div> -->
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="rejection-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature reject</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('lab_reject',$data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input type="text" name="a_l_comments" required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button>Close</button>
                        </div> -->
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  
{{--  ----------------------------------model End---------------------------------------------  --}}



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
        
        function setCurrentDate(item){
            if(item == 'yes'){
                $('#effect_check_date').val('{{ date('d-M-Y')}}');
            }
            else{
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
                    document.addEventListener('DOMContentLoaded', function () {
                        const removeButtons = document.querySelectorAll('.remove-file');
        
                        removeButtons.forEach(button => {
                            button.addEventListener('click', function () {
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


<script>
    $(document).ready(function() {
        $('#root-cause-methodology').on('change', function() {
            var selectedValues = $(this).val() || [];

            // Hide all sections initially
            $('#why-why-chart-section').hide();
            $('#fmea-section').hide();
            $('#fishbone-section').hide();
            $('#is-is-not-section').hide();

            // Show sections based on the selected values
            selectedValues.forEach(function(value) {
                if (value === 'Why-Why Chart') {
                    $('#why-why-chart-section').show();
                }
                if (value === 'Failure Mode and Effect Analysis') {
                    $('#fmea-section').show();
                }
                if (value === 'Fishbone or Ishikawa Diagram') {
                    $('#fishbone-section').show();
                }
                if (value === 'Is/Is Not Analysis') {
                    $('#is-is-not-section').show();
                }
            });
        });

        // Trigger the change event on page load to show the correct sections based on initial values
        $('#root-cause-methodology').trigger('change');
    });
</script>
<script>
              // ================================ FOUR INPUTS
function add4Input_case(tableId) {
    var table = document.getElementById(tableId);
    var currentRowCount = table.rows.length;
    var newRow = table.insertRow(currentRowCount);

    newRow.setAttribute("id", "row" + currentRowCount);
    var cell1 = newRow.insertCell(0);
    cell1.innerHTML = currentRowCount;

    var cell2 = newRow.insertCell(1);
    cell2.innerHTML = "<input type='text' name='Root_Cause_Category[]'>";

    var cell3 = newRow.insertCell(2);
    cell3.innerHTML = "<input type='text'  name='Root_Cause_Sub_Category[]'>";

    var cell4 = newRow.insertCell(3);
    cell4.innerHTML = "<input type='text'  name='Probability[]''>";

    var cell5 = newRow.insertCell(4);
    cell5.innerHTML = "<input type='text'  name='Remarks[]'>";

    var cell6 = newRow.insertCell(5);
    cell6.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

    for (var i = 1; i < currentRowCount; i++) {
        var row = table.rows[i];
        row.cells[0].innerHTML = i;
    }
}

function addRootCauseAnalysisRiskAssessment1(tableId) {
    var table = document.getElementById(tableId);
    var currentRowCount = table.rows.length;
    var newRow = table.insertRow(currentRowCount);
    newRow.setAttribute("id", "row" + currentRowCount);
    var cell1 = newRow.insertCell(0);
    cell1.innerHTML = currentRowCount;

    var cell2 = newRow.insertCell(1);
    cell2.innerHTML = "<input name='risk_factor[]' type='text'>";

    var cell3 = newRow.insertCell(2);
    cell3.innerHTML = "<input name='risk_element[]' type='text'>";

    var cell4 = newRow.insertCell(3);
    cell4.innerHTML = "<input name='problem_cause[]' type='text'>";

    var cell5 = newRow.insertCell(4);
    cell5.innerHTML = "<input name='existing_risk_control[]' type='text'>";

    var cell6 = newRow.insertCell(5);
    cell6.innerHTML =
        "<select onchange='calculateInitialResult(this)' class='fieldR' name='initial_severity[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

    var cell7 = newRow.insertCell(6);
    cell7.innerHTML =
        "<select onchange='calculateInitialResult(this)' class='fieldP' name='initial_probability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

    var cell8 = newRow.insertCell(7);
    cell8.innerHTML =
        "<select onchange='calculateInitialResult(this)' class='fieldN' name='initial_detectability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

    var cell9 = newRow.insertCell(8);
    cell9.innerHTML = "<input name='initial_rpn[]' type='text' class='initial-rpn'  >";

    var cell10 = newRow.insertCell(9);
    cell10.innerHTML =
        "<select name='risk_acceptance[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

    var cell11 = newRow.insertCell(10);
    cell11.innerHTML = "<input name='risk_control_measure[]' type='text'>";

    var cell12 = newRow.insertCell(11);
    cell12.innerHTML =
        "<select onchange='calculateResidualResult(this)' class='residual-fieldR' name='residual_severity[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

    var cell13 = newRow.insertCell(12);
    cell13.innerHTML =
        "<select onchange='calculateResidualResult(this)' class='residual-fieldP' name='residual_probability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

    var cell14 = newRow.insertCell(13);
    cell14.innerHTML =
        "<select onchange='calculateResidualResult(this)' class='residual-fieldN' name='residual_detectability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

    var cell15 = newRow.insertCell(14);
    cell15.innerHTML = "<input name='residual_rpn[]' type='text' class='residual-rpn' >";

    var cell16 = newRow.insertCell(15);
    cell16.innerHTML =
        "<select name='risk_acceptance2[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

    var cell17 = newRow.insertCell(16);
    cell17.innerHTML = "<input name='mitigation_proposal[]' type='text'>";

    var cell18 = newRow.insertCell(17);
    cell18.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

    for (var i = 1; i < currentRowCount; i++) {
        var row = table.rows[i];
        row.cells[0].innerHTML = i;
    }
}

            </script>
             <script>
            $(document).on('click', '.removeRowBtn', function() {
                $(this).closest('tr').remove();
            })
        </script>
  
@endsection