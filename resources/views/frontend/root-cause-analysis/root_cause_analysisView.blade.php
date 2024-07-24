@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }

        .input_width{
            width: 100%;
            border-radius: 5px;
            margin-bottom: 11px;
        }

    </style>
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
<div class="form-field-head">
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        {{ Helpers::getDivisionName($data->division_id) }} / Root Cause Analysis
    </div>
</div>
    @php
        $users = DB::table('users')->get();
    @endphp

    <!-- ======================================
                    DATA FIELDS
    ======================================= -->
    <div id="change-control-view">
        <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow </div>

                    <div class="d-flex" style="gap:20px;">
                        @php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rootAuditTrial', $data->id) }}">
                             Audit Trail </a> </button>

                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Acknowledge
                            </button> --}}
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                             Cancel
                            </button>
                        @elseif($data->stage == 2 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                             More Info. Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             HOD Review Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                             Child
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                             Cancel
                            </button>
                        @elseif($data->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                              More Info. Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             Responsible Person Update Complete
                            </button>
                        @elseif($data->stage == 4  && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             Initial QA Review Complete

                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                             CFT Review Not Required
                            </button>
                        @elseif($data->stage == 5  && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                             More Info. Required
                            </button>

                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             CFT Review Complete
                            </button>
                        @elseif($data->stage == 6 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                              Send to Initial
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#backword-modal">
                             Send to HOD
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#backword_2-modal">
                             Send to Initial QA Review
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             QA Approver Review Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                             Child
                            </button>

                        @elseif($data->stage == 7 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             HOD Final Review Complete
                            </button>
                        @elseif($data->stage == 8 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             All Child Closed
                            </button>
                        @elseif($data->stage == 9 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             Send to Initiator
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             Send to HOD 
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             Send to QA Reviewer
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             Send to QA Approver
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             QA Head Review Complete
                            </button>
                        
                        @elseif($data->stage == 10 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                             Child
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             Re-open
                            </button>
                        @elseif($data->stage == 11 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             Re-open Addendum Complete
                            </button>
                        @elseif($data->stage == 12 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             Addendum Approved Complete
                            </button>
                        @elseif($data->stage == 13 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                             Reject Re-open Request
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             Addendum Execution Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                             Child
                            </button>
                        @elseif($data->stage == 14 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             All Re-open Child Close
                            </button>
                        @elseif($data->stage == 15 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                             HOD Final Review Complete
                            </button>
                        @elseif($data->stage == 16 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                        {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            HOD Final Review Complete
                        </button> --}}

                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>
                    </div>
                </div>

                <div class="status">
                    <div class="head">Current Status</div>
                    {{-- ------------------------------By Pankaj-------------------------------- --}}
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @elseif ($data->stage <= 10 )
                        <div class="progress-bars">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active"> HOD Review </div>
                            @else
                                <div class=""> HOD Review</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">Responsible Person Update</div>
                            @else
                                <div class="">Responsible Person Update</div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="active">QA Initial Review</div>
                            @else
                                <div class=""> QA Initial Review</div>
                            @endif

                            @if ($data->stage >= 5)
                                <div class="active"> CFT Review</div>
                            @else
                                <div class=""> CFT Review</div>
                            @endif

                            @if ($data->stage >= 6)
                                <div class="active"> QA Approve Review</div>
                            @else
                                <div class=""> QA Approve Review</div>
                            @endif

                            @if ($data->stage >= 7)
                                <div class="active">HOD Final Review</div>
                            @else
                                <div class="">HOD Final Review</div>
                            @endif

                            @if ($data->stage >= 8)
                                <div class="active">Child Closure</div>
                            @else
                                <div class="">Child Closure</div>
                            @endif

                            @if ($data->stage >= 9)
                                <div class="active">QA Head Review</div>
                            @else
                                <div class="">QA Head Review</div>
                            @endif
        
                            @if ($data->stage >= 10)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif                            
                        </div>
                    @else
                    <div class="progress-bars">

                        @if ($data->stage >= 11)                            
                            <div class="active">Re-open Addendum</div>
                        @else
                            <div class="">Re-open Addendum</div>
                        @endif

                        @if ($data->stage >= 12)
                            <div class="active">Addendum Approved</div>
                        @else
                            <div class="">Addendum Approved</div>
                        @endif

                        @if ($data->stage >= 13)
                            <div class="active">Under Addendum Executione</div>
                        @else
                            <div class="">Under Addendum Execution</div>
                        @endif

                        @if ($data->stage >= 14)
                            <div class="active">Re-open Child Close</div>
                        @else
                            <div class="">Re-open Child Close</div>
                        @endif

                        @if ($data->stage >= 15)
                            <div class="active">Under Addendum Verification</div>
                        @else
                            <div class="">Under Addendum Verification</div>
                        @endif

                        @if ($data->stage >= 16)
                            <div class="bg-danger">Closed - Done</div>
                        @else
                            <div class="">Closed - Done</div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>


        <div id="change-control-fields">

            <div class="container-fluid">

                <!-- Tab links -->
                <div class="cctab">
                    <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Investigation</button>
                    <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Investigation & Root Cause</button>
                    <button class="cctablinks " onclick="openCity(event, 'CCForm8')">CFT</button>

                    <button class="cctablinks" onclick="openCity(event, 'CCForm4')">QA Review</button>
                    <!-- {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Environmental Monitoring</button> --}}
                    {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Lab Investigation Remark</button> --}}
                    {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm6')">QC Head/Designee Eval Comments</button> --}} -->
                    <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Activity Log</button>
                </div>

                <form action="{{ route('root_update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div id="step-form">

                         <div id="CCForm1" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}/RCA/{{ Helpers::year($data->created_at) }}/{{ $data->record }}">
                                    </div>
                                </div>
                                   
                                <div class="col-lg-6">
                                    <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code </b></label>
                                    <input readonly type="text" name="division_code"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    {{-- <div class="static">QMS-North America</div> --}}
                                      </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        <input type="hidden" name="initiator_id">
                                        {{-- <div class="static">{{ $data->initiator_name }} </div> --}}
                                        <input disabled type="text" value="{{ $data->initiator_name }} ">
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
                                            <select name="initiator_Group"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : ''}}
                                                 id="initiator_group">
                                               
                                                <option value="CQA"
                                                    @if ($data->initiator_Group== 'CQA') selected @endif>Corporate
                                                    Quality Assurance</option>
                                                <option value="QAB"
                                                    @if ($data->initiator_Group== 'QAB') selected @endif>Quality
                                                    Assurance Biopharma</option>
                                                <option value="CQC"
                                                    @if ($data->initiator_Group== 'CQC') selected @endif>Central
                                                    Quality Control</option>
                                                <option value="MANU"
                                                    @if ($data->initiator_Group== 'MANU') selected @endif>Manufacturing
                                                </option>
                                                <option value="PSG"
                                                    @if ($data->initiator_Group== 'PSG') selected @endif>Plasma
                                                    Sourcing Group</option>
                                                <option value="CS"
                                                    @if ($data->initiator_Group== 'CS') selected @endif>Central
                                                    Stores</option>
                                                <option value="ITG"
                                                    @if ($data->initiator_Group== 'ITG') selected @endif>Information
                                                    Technology Group</option>
                                                <option value="MM"
                                                    @if ($data->initiator_Group== 'MM') selected @endif>Molecular
                                                    Medicine</option>
                                                <option value="CL"
                                                    @if ($data->initiator_Group== 'CL') selected @endif>Central
                                                    Laboratory</option>
                                                <option value="TT"
                                                    @if ($data->initiator_Group== 'TT') selected @endif>Tech
                                                    team</option>
                                                <option value="QA"
                                                    @if ($data->initiator_Group== 'QA') selected @endif>Quality
                                                    Assurance</option>
                                                <option value="QM"
                                                    @if ($data->initiator_Group== 'QM') selected @endif>Quality
                                                    Management</option>
                                                <option value="IA"
                                                    @if ($data->initiator_Group== 'IA') selected @endif>IT
                                                    Administration</option>
                                                <option value="ACC"
                                                    @if ($data->initiator_Group== 'ACC') selected @endif>Accounting
                                                </option>
                                                <option value="LOG"
                                                    @if ($data->initiator_Group== 'LOG') selected @endif>Logistics
                                                </option>
                                                <option value="SM"
                                                    @if ($data->initiator_Group== 'SM') selected @endif>Senior
                                                    Management</option>
                                                <option value="BA"
                                                    @if ($data->initiator_Group== 'BA') selected @endif>Business
                                                    Administration</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Initiator Group Code">Initiator Group Code</label>
                                            <input type="text" name="initiator_group_code"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : ''}}
                                                value="{{ $data->initiator_Group}}" id="initiator_group_code"
                                                readonly>
                                        </div>
                                    </div>
                                   
                                    <div class="col-12">
                                                <div class="group-input">
                                                    <label for="Short Description">Short Description<span
                                                            class="text-danger">*</span></label><span id="rchars">255</span>
                                                    characters remaining
                                                    
                                                    <textarea name="short_description"   id="docname" type="text"    maxlength="255" required  {{ $data->stage == 0 || $data->stage == 6 ? "disabled" : "" }}>{{ $data->short_description }}</textarea>
                                                </div>
                                                <p id="docnameError" style="color:red">**Short Description is required</p>
            
                                            </div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="severity-level">Severity Level</label>
                                            <span class="text-primary">Severity levels in a QMS record gauge issue seriousness, guiding priority for corrective actions. Ranging from low to high, they ensure quality standards and mitigate critical risks.</span>
                                             <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="severity_level">
                                                <option value="0">-- Select --</option>
                                                <option @if ($data->severity_level =='minor') selected @endif
                                                    value="minor">Minor</option>
                                                    <option @if ($data->severity_level =='major') selected @endif
                                                        value="major">Major</option>
                                                        <option @if ($data->severity_level =='critical') selected @endif
                                                            value="critical">Critical</option>
                                            </select>
                                                {{-- <option value="minor">Minor</option>
                                                <option value="major">Major</option>
                                                <option value="critical">Critical</option>
                                            </select> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="search">
                                                Assigned To <span class="text-danger"></span>
                                            </label>
                                            <select id="select-state" placeholder="Select..." name="assign_to"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                <option value="">Select a value</option>
                                                @foreach ($users as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        @if ($data->assign_to == $value->id) selected @endif>
                                                        {{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('assign_to')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Due Date"> Due Date</label>
                                        <div><small class="text-primary">If revising Due Date, kindly mention revision reason in "Due Date Extension Justification" data field.</small></div>
                                       
                                            <input type="text" id="due_date" name="due_date" 
                                                placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->due_date) }}"min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                                            <!-- <input type="date" name="due_date" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : ''}} min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" -->
 
                                    </div>  
                                 </div>                                  <!-- <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Initiator Group"><b>Initiator Group</b></label>
                                            <select name="initiatorGroup" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                id="initiator-group">
                                                <option value="CQA"
                                                    @if ($data->initiatorGroup == 'CQA') selected @endif>Corporate
                                                    Quality Assurance</option>
                                                <option value="QAB"
                                                    @if ($data->initiatorGroup == 'QAB') selected @endif>Quality
                                                    Assurance Biopharma</option>
                                                <option value="CQC"
                                                    @if ($data->initiatorGroup == 'CQC') selected @endif>Central
                                                    Quality Control</option>
                                                <option value="CQC"
                                                    @if ($data->initiatorGroup == 'CQC') selected @endif>Manufacturing
                                                </option>
                                                <option value="PSG"
                                                    @if ($data->initiatorGroup == 'PSG') selected @endif>Plasma 
                                                     Sourcing Group</option>
                                                <option value="CS"
                                                    @if ($data->initiatorGroup == 'CS') selected @endif>Central
                                                    Stores</option>
                                                <option value="ITG"
                                                    @if ($data->initiatorGroup == 'ITG') selected @endif>Information
                                                    Technology Group</option>
                                                <option value="MM"
                                                    @if ($data->initiatorGroup == 'MM') selected @endif>Molecular
                                                    Medicine</option>
                                                <option value="CL"
                                                    @if ($data->initiatorGroup == 'CL') selected @endif>Central
                                                    Laboratory</option>
                                                <option value="TT"
                                                    @if ($data->initiatorGroup == 'TT') selected @endif>Tech
                                                    team</option>
                                                <option value="QA"
                                                    @if ($data->initiatorGroup == 'QA') selected @endif>Quality
                                                    Assurance</option>
                                                <option value="QM"
                                                    @if ($data->initiatorGroup == 'QM') selected @endif>Quality
                                                    Management</option>
                                                <option value="IA"
                                                    @if ($data->initiatorGroup == 'IA') selected @endif>IT
                                                    Administration</option>
                                                <option value="ACC"
                                                    @if ($data->initiatorGroup == 'ACC') selected @endif>Accounting
                                                </option>
                                                <option value="LOG"
                                                    @if ($data->initiatorGroup == 'LOG') selected @endif>Logistics
                                                </option>
                                                <option value="SM"
                                                    @if ($data->initiatorGroup == 'SM') selected @endif>Senior
                                                    Management</option>
                                                <option value="BA"
                                                    @if ($data->initiatorGroup == 'BA') selected @endif>Business
                                                    Administration</option>

                                            </select>
                                        </div>
                                    </div> 
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Initiator Group Code">Initiator Group Code</label>
                                            <input type="text" name="initiator_group_code"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                value="{{ $data->initiator_Group }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Short Description">Short Description <span
                                                    class="text-danger">*</span></label>
                                            <div><small class="text-primary">Please mention brief summary</small></div>
                                            <textarea name="short_description" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->short_description }}</textarea>
                                        </div>
                                    </div> -->
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Initiator Group">Initiated Through</label>
                                            <div><small class="text-primary">Please select related information</small></div>
                                            <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="initiated_through"
                                                onchange="otherController(this.value, 'others', 'initiated_through_req')">
                                                <option value="">-- select --</option>
                                                <option @if ($data->initiated_through == 'recall') selected @endif
                                                    value="recall">Recall</option>
                                                <option @if ($data->initiated_through == 'return') selected @endif
                                                    value="return">Return</option>
                                                <option @if ($data->initiated_through == 'deviation') selected @endif
                                                    value="deviation">Deviation</option>
                                                <option @if ($data->initiated_through == 'complaint') selected @endif
                                                    value="complaint">Complaint</option>
                                                <option @if ($data->initiated_through == 'regulatory') selected @endif
                                                    value="regulatory">Regulatory</option>
                                                <option @if ($data->initiated_through == 'lab-incident') selected @endif
                                                    value="lab-incident">Lab Incident</option>
                                                <option @if ($data->initiated_through == 'improvement') selected @endif
                                                    value="improvement">Improvement</option>
                                                <option @if ($data->initiated_through == 'others') selected @endif
                                                    value="others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input" id="initiated_through_req">
                                            <label for="If Other">Others<span
                                                    class="text-danger d-none">*</span></label>
                                            <textarea {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="initiated_if_other">{{$data->initiated_if_other}}</textarea>
                                        </div>
                                    </div>
                                     
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Type">Type</label>
                                            <select  {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="Type" value={{$data->Type}}>
                                                <option value="0">-- Select --</option>
                                                <option {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="0">-- Select --</option>
                                                <option @if ($data->Type =='1') selected @endif value="1">Facillties</option>
                                                <option @if ($data->Type =='2') selected @endif value="2">Other</option>
                                                <option @if ($data->Type =='3') selected @endif value="3">Stabillity</option>
                                                <option @if ($data->Type =='4') selected @endif value="4">Raw Material</option>
                                                <option @if ($data->Type =='5') selected @endif value="5">Clinical Production</option>
                                                <option @if ($data->Type =='6') selected @endif value="6">Commercial Production</option>
                                                <option @if ($data->Type =='7') selected @endif  value="7">Labellling</option>
                                                <option @if ($data->Type =='8') selected @endif value="8">laboratory</option>
                                                <option @if ($data->Type =='9') selected @endif value="9">Utillities</option>
                                                <option @if ($data->Type =='10') selected @endif value="10">Validation</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="priority_level">Priority Level</label>
                                            <div><small class="text-primary">Choose high if Immidiate actions are
                                                    required</small></div>
                                           
                                            <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="priority_level">
                                                <!-- {{-- <option value="0">-- Select --</option>
                                                <option value="low">Low</option>
                                                <option value="medium">Medium</option>
                                                <option value="high">High</option> --}} -->
                                                <option value="0">-- Select --</option>
                                                <option @if ($data->priority_level == 'low') selected @endif value="low">Low</option>
                                                <option @if ($data->priority_level == 'medium') selected @endif value="medium">Medium</option>
                                                <option @if ($data->priority_level == 'high') selected @endif value="high">High</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="investigators">Additional Investigators</label>
                                            <select  name="investigators" placeholder="Select Investigators"
                                             {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}  name="investigators" placeholder="Select Investigators"
                                                data-search="false" data-silent-initial-value-set="true" id="investigators">
                                                <option value="">Select Investigators</option>
                                                <option @if ($data->investigators=='1') selected @endif value="1">Amit Guru</option>
                                                <option @if ($data->investigators=='2') selected @endif value="2">Shaleen Mishra</option>
                                                <option @if ($data->investigators=='3') selected @endif value="3">Madhulika Mishra</option>
                                                <option @if ($data->investigators=='4') selected @endif value="4"> Patel</option>
                                                <option @if ($data->investigators=='5') selected @endif value="5">Harsh Mishra</option>
                                            </select>
                                        </div>
                                    </div> --}}
                            
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="department">Department(s)</label>
                                            <select name="department" placeholder="Select Department(s)"
                                             name="department"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} placeholder="Select Department(s)"
                                                data-search="false" data-silent-initial-value-set="true" id="department">
                                                <option @if ($data->department== '1') selected @endif  value="1">Work Instruction</option>
                                                <option @if ($data->department== '2') selected @endif value="2">Quality Assurance</option>
                                                <option @if ($data->department== '3') selected @endif value="3">Specifications</option>
                                                <option @if ($data->department== '4') selected @endif value="4">Production</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="sub-head">Investigation details</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="description">Description</label>
                                         
                                            <textarea name="description"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="comments">Comments</label>
                                            <textarea  name="comments"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->comments }}</textarea>
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
                                                    @if ($data->root_cause_initial_attachment)
                                                    @foreach(json_decode($data->root_cause_initial_attachment) as $file)
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
                                                    
                                                    <input type="file" id="myfile" name="root_cause_initial_attachment[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                        oninput="addMultipleFiles(this, 'root_cause_initial_attachment')"
                                                        multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                      <!-- <div class="col-12">
                                        <div class="group-input">
                                            <label for="severity-level">Sevrity Level</label>
                                            <select name="severity-level">
                                                <option value="0">-- Select --</option>
                                                <option value="minor">Minor</option>
                                                <option value="major">Major</option>
                                                <option value="critical">Critical</option>
                                            </select>
                                        </div>
                                    </div>  -->
                                    
                                    <div class="col-12">
                               <div class="group-input">
                              <label for="related_url">Related URL</label>
                           <input name="related_url" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $data->related_url }}"> 
                       </div>
                     </div>

                                                <div class="button-block">
                                                    <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                                    <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                                    <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                                                </div>
                                </div>
                            </div>
                        </div>
     
                        <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                                <div class="row">
                                    {{-- <div class="col-12">
                                        <div class="group-input">
                                            <label for="root-cause-methodology">Root Cause Methodology</label>
                                            <select name="root_cause_methodology[]"  placeholder="-- Select --"
                                                data-search="false" data-silent-initial-value-set="true"
                                                id="root-cause-methodology">
                                                <option @if ($data->root_cause_methodology== '1') selected @endif value="1">Why-Why Chart</option>
                                                <option @if ($data->root_cause_methodology== '2') selected @endif value="2">Failure Mode and Efect Analysis</option>
                                                <option @if ($data->root_cause_methodology== '3') selected @endif value="3">Fishbone or Ishikawa Diagram</option>
                                                <option @if ($data->root_cause_methodology== '4') selected @endif value="4">Is/Is Not Analysis</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="root-cause-methodology">Root Cause Methodology</label>
                                            <select name="root_cause_methodology[]"  {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $data->related_url }}"> 
                                                placeholder="-- Select --" data-search="false"            {{--{{$data->stage==2?'':'disabled'}}--}}
                                                data-silent-initial-value-set="true" id="root-cause-methodology">
                                                <option value="0">-- Select --</option>
                                                <option value="1"
                                                    {{ in_array('1', explode(',', $data->root_cause_methodology)) ? 'selected' : '' }}>
                                                    Why-Why Chart</option>
                                                <option value="2"
                                                    {{ in_array('2', explode(',', $data->root_cause_methodology)) ? 'selected' : '' }}>
                                                    Failure Mode and Efect Analysis</option>
                                                <option value="3"
                                                    {{ in_array('3', explode(',', $data->root_cause_methodology)) ? 'selected' : '' }}>
                                                    Fishbone or Ishikawa Diagram</option>
                                                <option value="4"
                                                    {{ in_array('4', explode(',', $data->root_cause_methodology)) ? 'selected' : '' }}>
                                                    Is/Is Not Analysis</option>


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
                                                            <th>Row #</th>
                                                            <th>Root Cause Category</th>
                                                            <th>Root Cause Sub-Category</th>
                                                            <th>Probability</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!empty($data->Root_Cause_Category))
                                                        @foreach (unserialize($data->Root_Cause_Category) as $key => $Root_Cause_Category)
                                                                <tr>
                                                                <td><input disabled type="text" name="serial_number[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $key + 1 }}"></td>
                                                                <td><input type="text" name="Root_Cause_Category[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->Root_Cause_Category)[$key] ? unserialize($data->Root_Cause_Category)[$key] : '' }}"></td>
                                                                <td><input type="text" name="Root_Cause_Sub_Category[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->Root_Cause_Sub_Category)[$key] ? unserialize($data->Root_Cause_Sub_Category)[$key] : '' }}"></td>
                                                                <td><input type="text" name="Probability[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->Probability)[$key] ? unserialize($data->Probability)[$key] : '' }}"></td>
                                                                <td><input type="text" name="Remarks[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->Remarks)[$key] ?? null }}"></td>
                                                                </tr>
                                                            @endforeach
                                                            @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                     
                                    <div class="col-12 sub-head"></div>
                                    <div class="col-12 mb-4">
                                        <div class="group-input">
                                            <label for="agenda">
                                                Failure Mode and Effect Analysis<button type="button" name="agenda"
                                                    onclick="addRootCauseAnalysisRiskAssessment('risk-assessment-risk-management')"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>+</button>
                                            </label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" style="width: 200%"
                                                    id="risk-assessment-risk-management">
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
                                                            <th>Proposed Additional Risk control measure (Mandatory for
                                                                Risk
                                                                elements having RPN>4)</th>
                                                            <th>Residual Severity- H(3)/M(2)/L(1)</th>
                                                            <th>Residual Probability- H(3)/M(2)/L(1)</th>
                                                            <th>Residual Detectability- H(1)/M(2)/L(3)</th>
                                                            <th>Residual RPN</th>
                                                            <th>Risk Acceptance (Y/N)</th>
                                                            <th>Mitigation proposal (Mention either CAPA reference
                                                                number, IQ,
                                                                OQ or
                                                                PQ)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!empty($data->risk_factor))
                                                            @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td><input name="risk_factor[]" type="text" value="{{ $riskFactor }}" ></td>
                                                                <td><input name="risk_element[]" type="text" value="{{ unserialize($data->risk_element)[$key] ?? null }}" >
                                                                </td>
                                                                <td> <input name="problem_cause[]" type="text" value="{{ unserialize($data->problem_cause)[$key] ?? null }}" >
                                                                </td>
                                                                <td><input name="existing_risk_control[]" type="text" value="{{ unserialize($data->existing_risk_control)[$key] ?? null }}" >
                                                                </td>
                                                                <td><select onchange="calculateInitialResult(this)" class="fieldR" name="initial_severity[]">
                                                                        <option value="">-- Select --</option>
                                                                        <option value="1" {{ (unserialize($data->initial_severity)[$key] ?? null)== 1 ? 'selected' :''}}>1</option>
                                                                        <option value="2"  {{ (unserialize($data->initial_severity)[$key] ?? null)== 2 ? 'selected' :''}}>2</option>
                                                                        <option value="3"  {{ (unserialize($data->initial_severity)[$key] ?? null)== 3 ? 'selected' :''}}>3</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select onchange="calculateInitialResult(this)" class="fieldP" name="initial_detectability[]">
                                                                        <option value="">-- Select --</option>
                                                                        <option value="1" {{ (unserialize($data->initial_detectability)[$key] ?? null)== 1 ? 'selected' :''}}>1</option>
                                                                        <option value="2"  {{ (unserialize($data->initial_detectability)[$key] ?? null)== 2 ? 'selected' :''}}>2</option>
                                                                        <option value="3"  {{ (unserialize($data->initial_detectability)[$key] ?? null)== 3 ? 'selected' :''}}>3</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select onchange="calculateInitialResult(this)" class="fieldN" name="initial_probability[]">
                                                                        <option value="">-- Select --</option>
                                                                        <option value="1" {{ (unserialize($data->initial_probability)[$key] ?? null)== 1 ? 'selected' :''}}>1</option>
                                                                        <option value="2"  {{ (unserialize($data->initial_probability)[$key] ?? null)== 2 ? 'selected' :''}}>2</option>
                                                                        <option value="3"  {{ (unserialize($data->initial_probability)[$key] ?? null)== 3 ? 'selected' :''}}>3</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input name="initial_rpn[]" class='initial-rpn'  disabled="text" value="{{ unserialize($data->initial_rpn)[$key] ?? null }}" >
                                                                </td>
                                                                <td>
                                                                    {{-- <input name="risk_acceptance[]" class="fieldR"  value="{{ unserialize($data->risk_acceptance)[$key] ?? null }}" > --}}
                                                                    <select onchange="calculateInitialResult(this)" class="fieldR" name="risk_acceptance[]">
                                                                        <option value="">-- Select --</option>
                                                                        <option value="Y" {{ (unserialize($data->risk_acceptance)[$key] ?? null)== 'Y' ? 'selected' :''}}>Y</option>
                                                                        <option value="N"  {{ (unserialize($data->risk_acceptance)[$key] ?? null)== 'N' ? 'selected' :''}}>N</option>
                                                                     </select>
                                                                </td>
                                                                <td>
                                                                    <input name="risk_control_measure[]" type="text" value="{{ unserialize($data->risk_control_measure)[$key] ?? null }}" >
                                                                     
                                                                </td>
                                                                <td>
                                                                    <select onchange="calculateResidualResult(this)" class="residual-fieldR" name="residual_severity[]">
                                                                        <option value="">-- Select --</option>
                                                                        <option value="1" {{ (unserialize($data->residual_severity)[$key] ?? null)== 1 ? 'selected' :''}}>1</option>
                                                                        <option value="2"  {{ (unserialize($data->residual_severity)[$key] ?? null)== 2 ? 'selected' :''}}>2</option>
                                                                        <option value="3"  {{ (unserialize($data->residual_severity)[$key] ?? null)== 3 ? 'selected' :''}}>3</option>
                                                                    </select>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <select onchange="calculateResidualResult(this)" class="residual-fieldP" name="residual_probability[]">
                                                                        <option value="">-- Select --</option>
                                                                        <option value="1" {{ (unserialize($data->residual_probability)[$key] ?? null)== 1 ? 'selected' :''}}>1</option>
                                                                        <option value="2"  {{ (unserialize($data->residual_probability)[$key] ?? null)== 2 ? 'selected' :''}}>2</option>
                                                                        <option value="3"  {{ (unserialize($data->residual_probability)[$key] ?? null)== 3 ? 'selected' :''}}>3</option>
                                                                    </select>
                                                                     
                                                                </td>

                                                                <td>
                                                                    <select onchange="calculateResidualResult(this)" class="residual-fieldN" name="residual_detectability[]">
                                                                        <option value="">-- Select --</option>
                                                                        <option value="1" {{ (unserialize($data->residual_detectability)[$key] ?? null)== 1 ? 'selected' :''}}>1</option>
                                                                        <option value="2"  {{ (unserialize($data->residual_detectability)[$key] ?? null)== 2 ? 'selected' :''}}>2</option>
                                                                        <option value="3"  {{ (unserialize($data->residual_detectability)[$key] ?? null)== 3 ? 'selected' :''}}>3</option>
                                                                    </select>
                                                                </td>
                                                               

                                                                <td>
                                                                    <input name="residual_rpn[]" class='residual-rpn'  disabled ="text" value="{{ unserialize($data->residual_rpn)[$key] ?? null }}" >
                                                               </td>
                                                               <td>
                                                                <select onchange="calculateInitialResult(this)" class="fieldR" name="risk_acceptance2[]">
                                                                    <option value="">-- Select --</option>
                                                                    <option value="Y" {{ (unserialize($data->risk_acceptance2)[$key] ?? null)== 'Y' ? 'selected' :''}}>Y</option>
                                                                    <option value="N"  {{ (unserialize($data->risk_acceptance2)[$key] ?? null)== 'N' ? 'selected' :''}}>N</option>
                                                                 </select>
                                                            </td>
                                                                <td>
                                                                    <input name="mitigation_proposal[]" type="text" value="{{ unserialize($data->mitigation_proposal)[$key] ?? null }}" >
                                                                </td>
                                                            </tr>    
                                                            @endforeach
                                                        @endif
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
                                    <div class="col-12 sub-head"></div>
                                    <div class="col-12">
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
                                    <div class="col-12">
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
                                    <div class="col-12 sub-head"></div>
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
                                    </div>
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
                        <!-- ===============================================CFT================================ -->
                    {{-- @php
                    $deviationsCFTs = DB::table('deviationcfts')->where('deviation_id', $id)->first();
                    @endphp --}}
                    <div id="CCForm8" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                            <div class="sub-head">
                            Production
                           </div>
                           <div class="col-lg-6">
                            {{-- @php
                                    $data = DB::table('deviationcfts')->where('deviation_id', $data->id)->first();
                            @endphp --}}
                                    {{-- <div class="group-input">
                                        <label for="Production Review">Production Review Required ?</label>
                                        <select name="Production_Review" id="Production_Review">
                                            <option value="">-- Select --</option>
                                            <option @if ($data1->Production_Review == 'yes') selected @endif value="yes">Yes</option>
                                            <option  @if ($data1->Production_Review == 'no') selected @endif  value="no">No</option>
                                            <option  @if ($data1->Production_Review == 'na') selected @endif value="na">NA</option>
                                        </select>
                                  
                                    </div> --}}


                                    <div class="group-input">
                                        <label for="Production Review">Production Review Required ?</label>
                                        <select name="Production_Review" id="Production_Review"{{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="">-- Select --</option>
                                            <option @if ($data1?->Production_Review == 'yes') selected @endif value="yes">Yes</option>
                                            <option @if ($data1?->Production_Review == 'no') selected @endif value="no">No</option>
                                            <option @if ($data1?->Production_Review == 'na') selected @endif value="na">NA</option>
                                        </select>
                                    </div>
                                    
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Production notification">Production Person</label>
                                        <select name="Production_person" id="Production_person" {{$data->stage == 5 ? '' : 'disabled' }} value={{$data1?->Production_person}}>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" @if ($user->id == ($data1?->Production_person?? '')) selected @endif>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Production assessment">Impact Assessment (By Production)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea {{$data->stage == 5 ? '' : 'disabled' }} class="summernote" name="Production_assessment" id="summernote-17" >{{ $data1?->Production_assessment }} </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Production feedback">Production Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Production_feedback" id="summernote-18">{{ $data1?->Production_feedback }}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="production attachment">Production Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="production_attachment">
                                                @if ($data1?->production_attachment)
                                                @foreach(json_decode($data1?->production_attachment) as $file)
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
                                                {{-- <input type="file" id="myfile" name="production_attachment[]" oninput="addMultipleFiles(this, 'production_attachment')" multiple> --}}
                                               
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="production_attachment[]"
                                                    oninput="addMultipleFiles(this, 'production_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                  <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Production Review Completed By">Production Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="production_by" id="production_by" value={{$data1?->QualityAssurance_by}}  >
                                    
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Production Review Completed On">Production Review Completed On</label>
                                        <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                        <input type="date"id="production_on" name="production_on" value="{{ $data1?->production_on }}"  {{$data->stage == 5 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                <div class="sub-head">
                                Warehouse
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Warehouse Review Required">Warehouse Review Required ?</label>
                                        <select name="Warehouse_review" id="Warehouse_review" value={{$data1?->Warehouse_review}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1?->Warehouse_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option @if ($data1?->Warehouse_review == 'no') selected @endif value="no">No</option>
                                            <option @if ($data1?->Warehouse_review == 'na') selected @endif value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 23, 'q_m_s_divisions_id' => $data->division_id])->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Warehouse Person">Warehouse Person</label>
                                        <select name="Warehouse_notification" id="Warehouse_notification" value="{{ $data1?->Warehouse_notification}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value=""> -- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->Warehouse_notification == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment1">Impact Assessment (By Warehouse)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Warehouse_assessment" id="summernote-19">{{ $data1?->Warehouse_assessment }}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Warehouse Feedback">Warehouse Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Warehouse_feedback" id="summernote-20">{{ $data1?->Warehouse_feedback }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Warehouse attachment">Warehouse Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Warehouse_attachment">
                                                @if ($data1?->Warehouse_attachment)
                                                @foreach(json_decode($data1?->Warehouse_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Warehouse_attachment[]" oninput="addMultipleFiles(this, 'Warehouse_attachment')" multiple>
                                                {{-- <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Warehouse_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Warehouse_attachment')"
                                                    multiple> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Warehouse Review Completed By">Warehouse Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Warehouse_by" id="Warehouse_by" value={{ $data1?->Warehouse_by }} >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Warehouse Review Completed On">Warehouse Review Completed On</label>
                                        <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                        <input type="date"id="Warehouse_on" name="Warehouse_on" value="{{ $data1?->Warehouse_on }}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                <div class="sub-head">
                                Quality Control
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Quality Control Review Required">Quality Control Review Required?</label>
                                        <select name="Quality_review" id="Quality_review" value={{$data1?->Quality_review}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="">-- Select --</option>
                                            <option @if ($data1?->Quality_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option @if ($data1?->Quality_review == 'no') selected @endif value="no">No</option>
                                            <option @if ($data1?->Quality_review == 'na') selected @endif value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 24, 'q_m_s_divisions_id' => $data->division_id])->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Quality Control Person">Quality Control Person</label>
                                        <select name="Quality_Control_Person" id="Quality_Control_Person"value="{{$data->Quality_Control_Person}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->Quality_Control_Person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment2">Impact Assessment (By Quality Control)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Quality_Control_assessment" id="summernote-21">{{ $data1?->Quality_Control_assessment }}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Quality Control Feedback">Quality Control Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Quality_Control_feedback" id="summernote-22">{{$data1?->Quality_Control_feedback}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Quality Control Attachments">Quality Control Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Quality_Control_attachment">
                                                @if ($data1?->Quality_Control_attachment)
                                                @foreach(json_decode($data1?->Quality_Control_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Quality_Control_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Quality_Control_attachment')"
                                                    multiple>
                                                {{-- <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Quality_Control_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Quality_Control_attachment')"
                                                    multiple> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Quality Control Review Completed By">Quality Control Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Quality_Control_by" id="Quality_Control_by" value={{ $data1?->Quality_Control_by }} >
                                    
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Quality Control Review Completed On">Quality Control Review Completed On</label>
                                        <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                        <input type="date"id="Quality_Control_on" name="Quality_Control_on" value="{{ $data1?->Quality_Control_on }}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                  <div class="sub-head">
                                  Quality Assurance
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Quality Assurance Review Required">Quality Assurance Review Required ?</label>
                                        <select name="Quality_Assurance_Review" id="Quality_Assurance_Review" value="{{$data1?->Quality_Assurance_Review}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1?->Quality_Assurance_Review == 'yes') selected @endif value="yes">Yes</option>
                                        <option  @if ($data1?->Quality_Assurance_Review == 'no') selected @endif value="no">No</option>
                                        <option  @if ($data1?->Quality_Assurance_Review == 'na') selected @endif value="na">NA</option>
                                        </select>
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 26, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Quality Assurance Person">Quality Assurance Person</label>
                                        <select name="QualityAssurance_person" id="QualityAssurance_person" value={{$data1?->QualityAssurance_person}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->QualityAssurance_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment3">Impact Assessment (By Quality Assurance)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="QualityAssurance_assessment" id="summernote-23">{{ $data1?->QualityAssurance_assessment }}
                                    </textarea>
                                    </div>
                                </div>   
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Quality Assurance Feedback">Quality Assurance Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="QualityAssurance_feedback" id="summernote-24">{{ $data1?->QualityAssurance_feedback }}
                                    </textarea>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Quality Assurance Attachments">Quality Assurance  Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Quality_Assurance_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Initial_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Initial_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Quality Assurance Attachments">Quality Assurance Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Quality_Assurance_attachment">
                                                @if ($data1?->Quality_Assurance_attachment)
                                                @foreach(json_decode($data1?->Quality_Assurance_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }} type="file" id="myfile" name="Quality_Assurance_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Quality_Assurance_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Quality Assurance Review Completed By">Quality Assurance Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="QualityAssurance_by" id="QualityAssurance_by" value={{$data1?->QualityAssurance_by}}  >
                                    
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Quality Assurance Review Completed On">Quality Assurance Review Completed On</label>
                                        <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                        <input type="date"id="QualityAssurance_on" name="QualityAssurance_on" value="{{ $data1?->QualityAssurance_on }}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                <div class="sub-head">
                                Engineering
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer notification">Engineering Review Required ?</label>
                                        <select name="Engineering_review" id="Engineering_review" value={{$data1?->Engineering_review}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="">-- Select --</option>
                                            <option @if ($data1?->Engineering_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option  @if ($data1?->Engineering_review == 'no') selected @endif value="no">No</option>
                                            <option  @if ($data1?->Engineering_review == 'na') selected @endif value="na">NA</option>
                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 25, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer notification">Engineering  Person</label>
                                        <select name="Engineering_person" id="Engineering_person" value={{$data1?->Engineering_person}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->Engineering_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment4">Impact Assessment (By Engineering)</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Engineering_assessment" id="summernote-25" >{{$data1?->Engineering_assessment}}
                                    </textarea>
                                    </div>
                                </div>  
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Engineering Feedback">Engineering  Feedback</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Engineering_feedback" id="summernote-26" >{{$data1?->Engineering_feedback}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Engineering  Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Engineering_attachment">
                                                @if ($data1?->Engineering_attachment)
                                                @foreach(json_decode($data1?->Engineering_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Engineering_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Engineering_attachment')"
                                                    multiple>
                                            </div>
                                                {{-- <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Engineering_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Engineering_attachment')"
                                                    multiple>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Engineering Review Completed By">Engineering Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Engineering_by" id="Engineering_by" value={{$data1?->Engineering_by}}  >
                                    
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Engineering Review Completed On">Engineering Review Completed On</label>
                                        <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                        <input type="date" id="Engineering_on" name="Engineering_on" value="{{ $data1?->Engineering_on }}" {{$data->stage == 5 ? '' : 'disabled' }} >
                                    </div>
                                </div>
                                <div class="sub-head">
                                Analytical Development Laboratory
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Review Required">Analytical Development Laboratory Review Required ?</label>
                                        <select name="Analytical_Development_review" id="Analytical_Development_review" value={{$data1?->Analytical_Development_review}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1?->Analytical_Development_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option  @if ($data1?->Analytical_Development_review == 'no') selected @endif value="no">No</option>
                                            <option  @if ($data1?->Analytical_Development_review == 'na') selected @endif value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 27, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Person"> Analytical Development Laboratory Person</label>
                                        <select name="Analytical_Development_person" id="Analytical_Development_person" value={{$data1?->Analytical_Development_person}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->Analytical_Development_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment5">Impact Assessment (By Analytical Development Laboratory)</label>
                                        <textarea class="summernote" name="Analytical_Development_assessment" id="summernote-27">{{$data1?->Analytical_Development_assessment}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Feedback"> Analytical Development Laboratory Feedback</label>
                                        <textarea class="summernote" name="Analytical_Development_feedback" id="summernote-28">{{$data1?->Analytical_Development_feedback}}
                                    </textarea>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Analytical Development Laboratory Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Analytical_Development_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Initial_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Initial_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Analytical Development Laboratory Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Analytical_Development_attachment">
                                                @if ($data1?->Analytical_Development_attachment)
                                                @foreach(json_decode($data1?->Analytical_Development_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Analytical_Development_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Analytical_Development_attachment')"
                                                    multiple>
                                                {{-- <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Analytical_Development_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Analytical_Development_attachment')"
                                                    multiple> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Review Completed By">Analytical Development Laboratory Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Analytical_Development_by" id="Analytical_Development_by" value={{$data1?->Analytical_Development_by}}>
                                    
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Review Completed On">Analytical Development Laboratory Review Completed On</label>
                                        <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                        <input type="date" id="Analytical_Development_on" name="Analytical_Development_on" value="{{ $data1?->Analytical_Development_on }}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                <div class="sub-head">
                                Process Development Laboratory / Kilo Lab
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Process Development Laboratory"> Process Development Laboratory / Kilo Lab Review Required ?</label>
                                        <select name="Kilo_Lab_review" id="Kilo_Lab_review" value={{$data1?->Kilo_Lab_review}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1?->Kilo_Lab_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option @if ($data1?->Kilo_Lab_review == 'no') selected @endif value="no">No</option>
                                            <option @if ($data1?->Kilo_Lab_review == 'na') selected @endif value="na">NA</option>

                                        </select>

                                    </div>
                                </div>
                                @php
                                $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 28, 'q_m_s_divisions_id' => $data->division_id])->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Process Development Laboratory"> Process Development Laboratory / Kilo Lab  Person</label>
                                        <select name="Kilo_Lab_person" id="Kilo_Lab_person" value={{$data1?->Kilo_Lab_person}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @if ($user->id == $data1?->Kilo_Lab_person) selected @endif>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment6">Impact Assessment (By Process Development Laboratory / Kilo Lab)</label>
                                        <textarea class="summernote" name="Kilo_Lab_assessment" id="summernote-29">{{$data1?->Kilo_Lab_assessment}}
                                    </textarea>
                                    </div>
                                </div> 
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Kilo Lab Feedback"> Process Development Laboratory / Kilo Lab  Feedback</label>
                                        <textarea class="summernote" name="Kilo_Lab_feedback" id="summernote-30">{{$data1?->Kilo_Lab_feedback}}
                                    </textarea>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Process Development Laboratory / Kilo Lab Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Kilo_Lab_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Initial_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Initial_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Process Development Laboratory / Kilo Lab Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Kilo_Lab_attachment">
                                                @if ($data1?->Kilo_Lab_attachment)
                                                @foreach(json_decode($data1?->Kilo_Lab_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Kilo_Lab_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Kilo_Lab_attachment')"
                                                    multiple>
                                                {{-- <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Kilo_Lab_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Kilo_Lab_attachment')"
                                                    multiple> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Kilo Lab Review Completed By">Process Development Laboratory / Kilo Lab Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Kilo_Lab_attachment_by" id="Kilo_Lab_attachment_by" value={{$data1?->Kilo_Lab_attachment_by}} >
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Kilo Lab Review Completed On">Process Development Laboratory / Kilo Lab Review Completed On</label>
                                        <input type="date" id="Kilo_Lab_attachment_on" name="Kilo_Lab_attachment_on" value="{{ $data1?->Kilo_Lab_attachment_on }}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                    
                                    </div>
                                </div>
                                <div class="sub-head">
                                Technology Transfer / Design
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Design Review Required">Technology Transfer / Design Review Required ?</label>
                                        <select name="Technology_transfer_review" id="Technology_transfer_review" value="{{$data1?->Technology_transfer_review}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1?->Technology_transfer_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option @if ($data1?->Technology_transfer_review == 'no') selected @endif value="no">No</option>
                                            <option @if ($data1?->Technology_transfer_review == 'na') selected @endif value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 29, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Design Person"> Technology Transfer / Design  Person</label>
                                        <select name="Technology_transfer_person" id="Technology_transfer_person" value={{$data1?->Technology_transfer_person}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @if($user->id == $data1?->Technology_transfer_person) selected @endif>{{ $user->name }}</option>
                                            
                                            @endforeach

                                        </select>


                                        
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment7">Impact Assessment (By Technology Transfer / Design)</label>
                                        <textarea class="summernote" name="Technology_transfer_assessment" id="summernote-31">{{$data1?->Technology_transfer_assessment}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Design Feedback"> Technology Transfer / Design  Feedback</label>
                                        <textarea class="summernote" name="Technology_transfer_feedback" id="summernote-32">{{$data1?->Technology_transfer_feedback}}
                                    </textarea>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Technology Transfer / Design Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Technology_transfer_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Initial_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Initial_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Technology Transfer / Design Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Technology_transfer_attachment">
                                                @if ($data1?->Technology_transfer_attachment)
                                                @foreach(json_decode($data1?->Technology_transfer_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Technology_transfer_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Technology_transfer_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Technology Transfer / Design Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Technology_transfer_by" id="Technology_transfer_by" value={{$data1?->Technology_transfer_by}}  >
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Technology Transfer / Design Review Completed On</label>
                                        <input type="date" id="Technology_transfer_on" name="Technology_transfer_on" value="{{ $data1?->Technology_transfer_on }}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                <div class="sub-head">
                                Environment, Health & Safety
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Safety Review Required">Environment, Health & Safety Review Required ?</label>
                                        <select name="Environment_Health_review" id="Environment_Health_review" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1?->Environment_Health_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option @if ($data1?->Environment_Health_review == 'no') selected @endif value="no">No</option>
                                            <option @if ($data1?->Environment_Health_review == 'na') selected @endif value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 30, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Safety Person"> Environment, Health & Safety  Person</label>
                                        <select name="Environment_Health_Safety_person" id="Environment_Health_Safety_person" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->Environment_Health_Safety_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment8">Impact Assessment (By Environment, Health & Safety)</label>
                                        <textarea class="summernote" name="Health_Safety_assessment" id="summernote-33">{{$data1?->Health_Safety_assessment}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Safety Feedback">Environment, Health & Safety  Feedback</label>
                                        <textarea class="summernote" name="Health_Safety_feedback" id="summernote-34">{{$data1?->Health_Safety_feedback}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">  Environment, Health & Safety Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Environment_Health_Safety_attachment">
                                                @if ($data1?->Environment_Health_Safety_attachment)
                                                @foreach(json_decode($data1?->Environment_Health_Safety_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Environment_Health_Safety_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Environment_Health_Safety_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Safety Review Completed By">Environment, Health & Safety Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Environment_Health_Safety_by" id="Environment_Health_Safety_by" value={{$data1?->Environment_Health_Safety_by}}  >
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Safety Review Completed On">Environment, Health & Safety Review Completed On</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="date" id="Environment_Health_Safety_on" name="Environment_Health_Safety_on" value={{ $data1?->Environment_Health_Safety_on }} >
                                    
                                    </div>
                                </div>
                                <div class="sub-head">
                                Human Resource & Administration
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer notification">Human Resource & Administration Review Required ?</label>
                                        <select name="Human_Resource_review" id="Human_Resource_review" value={{$data1?->Human_Resource_review}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1?->Human_Resource_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option @if ($data1?->Human_Resource_review == 'no') selected @endif value="no">No</option>
                                            <option @if ($data1?->Human_Resource_review == 'na') selected @endif value="na">NA</option>
                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 31, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer notification"> Human Resource & Administration  Person</label>
                                        <select name="Human_Resource_person" id="Human_Resource_person" value={{$data1?->Human_Resource_person}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->Human_Resource_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Impact Assessment (By Human Resource & Administration)</label>
                                        <textarea class="summernote" name="Human_Resource_assessment" id="summernote-35">{{$data1?->Human_Resource_assessment}}
                                    </textarea>
                                    </div>
                                </div> 
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Human Resource & Administration  Feedback</label>
                                        <textarea class="summernote" name="Human_Resource_feedback" id="summernote-36">{{$data1?->Human_Resource_feedback}}
                                    </textarea>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Human Resource & Administration Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Human_Resource_attachment">
                                                @if ($data1?->Human_Resource_attachment)
                                                @foreach(json_decode($data1?->Human_Resource_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Human_Resource_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Human_Resource_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Administration Review Completed By"> Human Resource & Administration Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Human_Resource_by" id="Human_Resource_by" value={{$data1?->Human_Resource_by}} >
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Administration Review Completed On"> Human Resource & Administration Review Completed On</label>
                                        <input type="date" id="Environment_Health_Safety_on" name="Environment_Health_Safety_on" value="{{ $data1?->Environment_Health_Safety_on }}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                    
                                    </div>
                                </div>
                                <div class="sub-head">
                                Information Technology
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Information Technology Review Required"> Information Technology Review Required ?</label>
                                        <select name=" Information_Technology_review" id=" Information_Technology_review" value={{$data1?->Information_Technology_review}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1?->Information_Technology_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option @if ($data1?->Information_Technology_review == 'no') selected @endif value="no">No</option>
                                            <option @if ($data1?->Information_Technology_review == 'na') selected @endif value="na">NA</option>
                                        </select>

                                        {{-- </select> --}}
                                  
                                    </div>
                                </div>
                                @php
                                $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 32, 'q_m_s_divisions_id' => $data->division_id])->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Information Technology Person"> Information Technology  Person</label>
                                        <select name=" Information_Technology_person" id=" Information_Technology_person" value={{$data1?->Information_Technology_person}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->Information_Technology_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment10">Impact Assessment (By Information Technology)</label>
                                        <textarea class="summernote" name="Information_Technology_assessment" id="summernote-37">{{$data1?->Information_Technology_assessment}}
                                    </textarea>
                                    </div>
                                </div>  
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Information Technology Feedback">Information Technology Feedback</label>
                                        <textarea class="summernote" name="Information_Technology_feedback" id="summernote-38">{{$data1?->Information_Technology_feedback}}
                                    </textarea>
                                    </div>
                                </div>
                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Information Technology Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Information_Technology_attachment">
                                                @if ($data1?->Information_Technology_attachment)
                                                @foreach(json_decode($data1?->Information_Technology_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Information_Technology_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Information_Technology_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Information Technology Review Completed By"> Information Technology Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Information_Technology_by" id="Information_Technology_by" value={{$data1?->Information_Technology_by}} >

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Information Technology Review Completed On">Information Technology Review Completed On</label>
                                        <input type="date" name="Information_Technology_on" id="Information_Technology_on" value="{{$data1?->Information_Technology_on}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                <div class="sub-head">
                                Project Management
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Project management Review Required"> Project management Review Required ?</label>
                                        <select name="Project_management_review" id="Project_management_review" value={{$data1?->Project_management_review}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1?->Project_management_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option @if ($data1?->Project_management_review == 'no') selected @endif value="no">No</option>
                                            <option @if ($data1?->Project_management_review == 'na') selected @endif value="na">NA</option>
                                        </select>
                                    </div>
                           </div>
                                    @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 33, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Project management Person"> Project management Person</label>
                                        <select name="Project_management_person" id="Project_management_person" value="{{$data1?->Project_management_person}}" {{$data->stage ==5 ? '' : 'disabled' }}>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->Project_management_person == $user->id ? 'selected' : '' }}value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment11">Impact Assessment (By  Project management )</label>
                                        <textarea class="summernote" name="Project_management_assessment" id="summernote-39">{{$data1?->Project_management_assessment}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Project management Feedback"> Project management  Feedback</label>
                                        <textarea class="summernote" name="Project_management_feedback" id="summernote-40">{{$data1?->Project_management_feedback}}
                                    </textarea>
                                    </div>
                                </div>
                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Project management Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Project_management_attachment">
                                                @if ($data1?->Project_management_attachment)
                                                @foreach(json_decode($data1?->Project_management_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Project_management_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Project_management_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Project management Review Completed By"> Project management Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Project_management_by" id="Project_management_by" value={{$data1?->Project_management_by}} >
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Project management Review Completed On">Project management Review Completed On</label>
                                        <input type="date" name="Project_management_on" id="Project_management_on" value="{{$data1?->Project_management_on}}" {{$data->stage == 5 ? '' : 'disabled' }}>

                                    
                                    </div>
                                </div>
                                <div class="sub-head">
                                Other's 1 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Review Required1"> Other's 1 Review Required ?</label>
                                        <select name="Other1_review" id="Other1_review" value="{{ $data1?->Other1_review }}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1?->Other1_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option @if ($data1?->Other1_review == 'no') selected @endif value="no">No</option>
                                            <option @if ($data1?->Other1_review == 'na') selected @endif value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->whereBetween('q_m_s_roles_id', [22, 33])->where('q_m_s_divisions_id', $data->division_id)->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person1"> Other's 1 Person</label>
                                        <select name="Other1_person" id="Other1_person" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->Other1_person == $user->id ? 'selected' : '' }}value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department1"> Other's 1 Department</label>
                                        <select name="Other1_Department_person" id="Other1_Department_person" value="{{ $data1?->Other1_Department_person }}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1?->Other1_Department_person == 'Production') selected @endif value="Production">Production</option>
                                            <option @if ($data1?->Other1_Department_person == 'Warehouse') selected @endif value="Warehouse"> Warehouse</option>
                                            <option @if ($data1?->Other1_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control</option>  
                                            <option @if ($data1?->Other1_Department_person == 'Quality_Assurance') selected @endif value="Quality_Assurance">Quality Assurance</option>
                                            <option @if ($data1?->Other1_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                            <option @if ($data1?->Other1_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">Analytical Development Laboratory</option> 
                                            <option @if ($data1?->Other1_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                            <option @if ($data1?->Other1_Department_person == 'Technology_transfer_Design') selected @endif value="Technology transfer/Design"> Technology Transfer/Design</option>
                                            <option @if ($data1?->Other1_Department_person == 'Environment_Health_Safety') selected @endif value="Environment, Health & Safety">Environment, Health & Safety</option>   
                                            <option @if ($data1?->Other1_Department_person == 'Human_Resource_Administration') selected @endif value="Human Resource & Administration">Human Resource & Administration</option>
                                            <option @if ($data1?->Other1_Department_person == 'Information_Technology') selected @endif value="Information Technology">Information Technology</option>
                                            <option @if ($data1?->Other1_Department_person == 'Project_management') selected @endif value="Project management">Project management</option>  

                                            {{-- <option value="Production">Production</option>
                                            <option value="Warehouse">Warehouse</option>
                                            <option value="Quality_Control">Quality Control</option> --}}
                                            {{-- <option value="Quality_Assurance">Quality Assurance</option>
                                            <option value="Engineering">Engineering</option>
                                            <option value="Analytical_Development_Laboratory">Analytical Development Laboratory</option> --}}
                                            {{-- <option value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                            <option value="Technology transfer/Design">Technology Transfer/Design</option>
                                            <option value="Environment, Health & Safety">Environment, Health & Safety</option> --}}
                                            {{-- <option value="Human Resource & Administration">Human Resource & Administration</option>
                                            <option value="Information Technology">Information Technology</option>
                                            <option value="Project management">Project management</option> --}}
                                            


                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment12">Impact Assessment (By  Other's 1)</label>
                                        <textarea class="summernote" name="Other1_assessment" id="summernote-41">{{$data1?->Other1_assessment}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Feedback1"> Other's 1 Feedback</label>
                                        <textarea class="summernote" name="Other1_feedback" id="summernote-42">{{$data1?->Other1_feedback}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 1 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other1_attachment" name ="Other1_attachment">
                                                @if ($data1?->Other1_attachment)
                                                @foreach(json_decode($data1?->Other1_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }} type="file" id="myfile" name="Other1_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other1_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed By1"> Other's 1 Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Other1_by" id="Other1_by" value={{$data1?->Other1_by}}>
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed On1">Other's 1 Review Completed On</label>
                                        <input type="date" name="Other1_on" id="Other1_on" value="{{$data1?->Other1_on}}"  {{$data->stage == 5 ? '' : 'disabled' }}>
                                    
                                    </div>
                                </div>

                                <div class="sub-head">
                                Other's 2 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review2"> Other's 2 Review Required ?</label>
                                        <select name="Other2_review" id="Other2_review" value="{{ $data1?->Other2_review }}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1?->Other2_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option @if ($data1?->Other2_review == 'no') selected @endif value="no">No</option>
                                            <option @if ($data1?->Other2_review == 'na') selected @endif value="na">NA</option>
                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->whereBetween('q_m_s_roles_id', [22, 33])->where('q_m_s_divisions_id', $data->division_id)->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person2"> Other's 2 Person</label>
                                        <select name="Other2_person" id="Other2_person" value="{{$data1?->Other2_person}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->Other2_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department2"> Other's 2 Department</label>
                                        <select name="Other2_Department_person" id="Other2_Department_person" value="{{$data1?->Other2_Department_person}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if($data1?->Other2_Department_person == 'Production') selected @endif value="Production">Production</option>
                                            <option @if($data1?->Other2_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                            <option @if($data1?->Other2_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control</option>
                                            <option @if($data1?->Other2_Department_person == 'Quality_Assurance') selected @endif value="Quality_Assurance">Quality Assurance</option>
                                            <option @if($data1?->Other2_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                            <option @if($data1?->Other2_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                            <option @if($data1?->Other2_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                            <option @if($data1?->Other2_Department_person == 'Technology_transfer_Design') selected @endif value="Technology_transfer_Design">Technology Transfer/Design</option>
                                            <option @if($data1?->Other2_Department_person == 'Environment_Health_Safety') selected @endif value="Environment_Health_Safety">Environment, Health & Safety</option>
                                            <option @if($data1?->Other2_Department_person == 'Human_Resource_Administration') selected @endif value="Human_Resource_Administration">Human Resource & Administration</option>
                                            <option @if($data1?->Other2_Department_person == 'Information_Technology') selected @endif value="Information_Technology">Information Technology</option>
                                            <option @if($data1?->Other2_Department_person == 'Project_management') selected @endif value="Project_management">Project management</option>
                                        
                                        </select>
                                  
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment13">Impact Assessment (By  Other's 2)</label>
                                        <textarea class="summernote" name="Other2_Assessment" id="summernote-43">{{$data1?->Other2_Assessment}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Feedback2"> Other's 2 Feedback</label>
                                        <textarea class="summernote" name="Other2_feedback" id="summernote-44">{{$data1?->Other2_feedback}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 2 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other2_attachment" name="Other2_attachment">
                                                @if ($data1?->Other2_attachment)
                                                @foreach(json_decode($data1?->Other2_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Other2_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other2_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed By2"> Other's 2 Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Other2_by" id="Other2_by" value={{$data1?->Other2_by}} >
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed On2">Other's 2 Review Completed On</label>
                                        <input type="date" name="Other2_on" id="Other2_on" value="{{$data1?->Other2_on}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                    </div>
                                </div>

                                <div class="sub-head">
                                Other's 3 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review3"> Other's 3 Review Required ?</label>
                                        <select name="Other3_review" id="Other3_review" value="{{ $data1?->Other3_review }}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                                <option value="0">-- Select --</option>
                                                <option @if ($data1?->Other3_review == 'yes') selected @endif value="yes">Yes</option>
                                                <option @if ($data1?->Other3_review == 'no') selected @endif value="no">No</option>
                                                <option @if ($data1?->Other3_review == 'na') selected @endif value="na">NA</option>
                                            </select>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->whereBetween('q_m_s_roles_id', [22, 33])->where('q_m_s_divisions_id', $data->division_id)->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person3">Other's 3 Person</label>
                                        <select name="Other3_person" id="Other3_person" value="{{$data->Other3_person}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->Other3_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department3">Other's 3 Department</label>
                                        <select name="Other3_Department_person" id="Other3_Department_person" value="{{$data1?->Other3_Department_person}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if($data1?->Other3_Department_person == 'Production') selected @endif value="Production">Production</option>
                                            <option @if($data1?->Other3_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                            <option @if($data1?->Other3_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control</option>
                                            <option @if($data1?->Other3_Department_person == 'Quality_Assurance') selected @endif value="Quality_Assurance">Quality Assurance</option>
                                            <option @if($data1?->Other3_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                            <option @if($data1?->Other3_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                            <option @if($data1?->Other3_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                            <option @if($data1?->Other3_Department_person == 'Technology_transfer_Design') selected @endif value="Technology_transfer_Design">Technology Transfer/Design</option>
                                            <option @if($data1?->Other3_Department_person == 'Environment_Health_Safety') selected @endif value="Environment_Health_Safety">Environment, Health & Safety</option>
                                            <option @if($data1?->Other3_Department_person == 'Human_Resource_Administration') selected @endif value="Human_Resource_Administration">Human Resource & Administration</option>
                                            <option @if($data1?->Other3_Department_person == 'Information_Technology') selected @endif value="Information_Technology">Information Technology</option>
                                            <option @if($data1?->Other3_Department_person == 'Project_management') selected @endif value="Project_management">Project management</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment14">Impact Assessment (By  Other's 3)</label>
                                        <textarea class="summernote" name="Other3_Assessment" id="summernote-45">{{$data1?->Other3_Assessment}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="feedback3"> Other's 3 Feedback</label>
                                        <textarea class="summernote" name="Other3_feedback" id="summernote-46">{{$data1?->Other3_Assessment}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 3 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other3_attachment" name="Other3_attachment">
                                                @if ($data1?->Other3_attachment)
                                                @foreach(json_decode($data1?->Other3_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Other3_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other3_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback"> Other's 3 Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Other3_by" id="Other3_by" value={{ $data1?->Other3_by }}>
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Other's 3 Review Completed On</label>
                                        <input type="date" name="Other3_on" id="Other3_on" value="{{$data1?->Other3_on}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                <div class="sub-head">
                                Other's 4 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review4">Other's 4 Review Required ?</label>
                                        <select name="Other4_review" id="Other4_review" value="{{ $data1?->Other4_review }}"{{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1?->Other4_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option @if ($data1?->Other4_review == 'no') selected @endif value="no">No</option>
                                            <option @if ($data1?->Other4_review == 'na') selected @endif value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->whereBetween('q_m_s_roles_id', [22, 33])->where('q_m_s_divisions_id', $data->division_id)->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person4"> Other's 4 Person</label>
                                        <select name="Other4_person" id="Other4_person" value={{$data1?->Other4_person}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->Other4_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department4"> Other's 4 Department</label>
                                        <select name="Other4_Department_person" id="Other4_Department_person" value="{{$data1?->Other4_Department_person}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if($data1?->Other4_Department_person == 'Production') selected @endif value="Production">Production</option>
                                            <option @if($data1?->Other4_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                            <option @if($data1?->Other4_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control</option>
                                            <option @if($data1?->Other4_Department_person == 'Quality_Assurance') selected @endif value="Quality_Assurance">Quality Assurance</option>
                                            <option @if($data1?->Other4_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                            <option @if($data1?->Other4_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                            <option @if($data1?->Other4_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                            <option @if($data1?->Other4_Department_person == 'Technology_transfer_Design') selected @endif value="Technology_transfer_Design">Technology Transfer/Design</option>
                                            <option @if($data1?->Other4_Department_person == 'Environment_Health_Safety') selected @endif value="Environment_Health_Safety">Environment, Health & Safety</option>
                                            <option @if($data1?->Other4_Department_person == 'Human_Resource_Administration') selected @endif value="Human_Resource_Administration">Human Resource & Administration</option>
                                            <option @if($data1?->Other4_Department_person == 'Information_Technology') selected @endif value="Information_Technology">Information Technology</option>
                                            <option @if($data1?->Other4_Department_person == 'Project_management') selected @endif value="Project_management">Project management</option>
                                          
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment15">Impact Assessment (By  Other's 4)</label>
                                        <textarea class="summernote" name="Other4_Assessment" id="summernote-47">{{$data1?->Other4_Assessment}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="feedback4"> Other's 4 Feedback</label>
                                        <textarea class="summernote" name="Other4_feedback" id="summernote-48">{{$data1?->Other4_feedback}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 4 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other4_attachment" name="Other4_attachment">
                                                @if ($data1?->Other4_attachment)
                                                @foreach(json_decode($data1?->Other4_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Other4_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other4_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed By4"> Other's 4 Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Other4_by" id="Other4_by" value={{$data1?->Other4_by}}>
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed On4">Other's 4 Review Completed On</label>
                                        <input type="date" name="Other4_on" id="Other4_on" value="{{$data1?->Other4_on}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                    
                                    </div>
                                </div>


                                <div class="sub-head">
                                Other's 5 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review5">Other's 5 Review Required ?</label>
                                        <select name="Other5_review" id="Other5_review" value="{{ $data1?->Other5_review }}"{{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1?->Other5_review == 'yes') selected @endif value="yes">Yes</option>
                                            <option @if ($data1?->Other5_review == 'no') selected @endif value="no">No</option>
                                            <option @if ($data1?->Other5_review == 'na') selected @endif value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->whereBetween('q_m_s_roles_id', [22, 33])->where('q_m_s_divisions_id', $data->division_id)->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person5">Other's 5 Person</label>
                                        <select name="Other5_person" id="Other5_person" value={{$data1?->Other5_person}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1?->Other5_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department5"> Other's 5 Department</label>
                                        <select name="Other5_Department_person" id="Other5_Department_person" value={{$data1?->Other5_Department_person}} {{$data->stage == 5 ? '' : 'disabled' }}>
                                            <option value="0">-- Select --</option>
                                            <option @if($data1?->Other5_Department_person == 'Production') selected @endif value="Production">Production</option>
                                            <option @if($data1?->Other5_Department_person == 'Warehouse') selected @endif value="Warehouse">Warehouse</option>
                                            <option @if($data1?->Other5_Department_person == 'Quality_Control') selected @endif value="Quality_Control">Quality Control</option>
                                            <option @if($data1?->Other5_Department_person == 'Quality_Assurance') selected @endif value="Quality_Assurance">Quality Assurance</option>
                                            <option @if($data1?->Other5_Department_person == 'Engineering') selected @endif value="Engineering">Engineering</option>
                                            <option @if($data1?->Other5_Department_person == 'Analytical_Development_Laboratory') selected @endif value="Analytical_Development_Laboratory">Analytical Development Laboratory</option>
                                            <option @if($data1?->Other5_Department_person == 'Process_Development_Lab') selected @endif value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                            <option @if($data1?->Other5_Department_person == 'Technology_transfer_Design') selected @endif value="Technology_transfer_Design">Technology Transfer/Design</option>
                                            <option @if($data1?->Other5_Department_person == 'Environment_Health_Safety') selected @endif value="Environment_Health_Safety">Environment, Health & Safety</option>
                                            <option @if($data1?->Other5_Department_person == 'Human_Resource_Administration') selected @endif value="Human_Resource_Administration">Human Resource & Administration</option>
                                            <option @if($data1?->Other5_Department_person == 'Information_Technology') selected @endif value="Information_Technology">Information Technology</option>
                                            <option @if($data1?->Other5_Department_person == 'Project_management') selected @endif value="Project_management">Project management</option>
                                            


                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment16">Impact Assessment (By  Other's 5)</label>
                                        <textarea class="summernote" name="Other5_Assessment" id="summernote-49">{{$data1?->Other5_Assessment}}
                                    </textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback"> Other's 5 Feedback</label>
                                        <textarea class="summernote" name="Other5_feedback" id="summernote-50">{{$data1?->Other5_feedback}}
                                    </textarea>
                                    </div>
                                </div>
                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 5 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other5_attachment" name="Other5_attachment">
                                                @if ($data1?->Other5_attachment)
                                                @foreach(json_decode($data1?->Other5_attachment) as $file)
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
                                                <input {{$data->stage == 5 ? '' : 'disabled' }}  type="file" id="myfile" name="Other5_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other5_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed By5"> Other's 5 Review Completed By</label>
                                        <input {{$data->stage == 5 ? '' : 'disabled' }} type="text" name="Other5_by" id="Other5_by" value={{$data1->Other5_by}}>
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed On5">Other's 5 Review Completed On</label>
                                        <input type="date" name="Other5_on" id="Other5_on" value="{{$data1?->Other5_on}}" {{$data->stage == 5 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                
                                
 
                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                                </div>
                    </div>
                               
                       <!-- ========================================================================================= -->
                        <div id="CCForm4" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                             <!-- <div class="sub-head">
                                    CFT Feedback
                                </div>  -->
                                <div class="row">
    
                                <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="comments">Final Comments</label>
                                            <textarea name="cft_comments_new">{{ $data->cft_comments_new }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="comments">Final Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>
                                            <div  class="file-attachment-field">
                                                <div disabled class="file-attachment-list" id="cft_attchament_new" name="cft_attchament_new">
                                                    {{-- @if(!is_null($data->cft_attchament_new) && is_array(json_decode($data->cft_attchament_new))) --}}
                                                    @if ($data->cft_attchament_new)
                                                        @foreach(json_decode($data->cft_attchament_new) as $file)
                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                            <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                        </h6>
                                                    @endforeach
                                                   {{-- @endif --}}
                                                   @endif
                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input type="file" id="myfile" name="cft_attchament_new[]"
                                                        oninput="addMultipleFiles(this, 'cft_attchament_new')" multiple>
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
 
                        <div id="CCForm7" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Acknowledge_By" name="submit_by">Submit By</label>
                                            <div class="static">{{ $data->submit_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Acknowledge_On" name="submit_on">Submit On</label>
                                            <div class="static">{{ $data->submit_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Submit_By">HOD Review Complete By</label>
                                            <div class="static">{{ $data->hod_review_complete_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Submit_On">HOD Review Complete On</label>
                                            <div class="static">{{ $data->hod_review_complete_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="QA_Review_Complete_By">Responsible Person Update By</label>
                                            <div class="static">{{ $data->responsible_person_update_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="QA_Review_Complete_On">Responsible Person Update On</label>
                                            <div class="static">{{ $data->responsible_person_update_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Cancelled By">Initial QA Review By</label>
                                            <div class="static">{{ $data->initial_qa_review_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Cancelled By">Initial QA Review on</label>
                                            <div class="static">{{ $data->initial_qa_review_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Cancelled By">CFT Review By</label>
                                            <div class="static">{{ $data->cft_review_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Cancelled By">CFT Review On</label>
                                            <div class="static">{{ $data->cft_review_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Cancelled By">QA Approve Review By</label>
                                            <div class="static">{{ $data->qa_approve_review_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Cancelled By">QA Approve Review On</label>
                                            <div class="static">{{ $data->qa_approve_review_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Cancelled By">HOD Final Review By</label>
                                            <div class="static">{{ $data->hod_final_review_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Cancelled By">HOD Final Review On</label>
                                            <div class="static">{{ $data->hod_final_review_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Cancelled By">Child Closure By</label>
                                            <div class="static">{{ $data->child_closure_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Cancelled By">Child Closure On</label>
                                            <div class="static">{{ $data->child_closure_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Cancelled By">Close-Done By</label>
                                            <div class="static">{{ $data->close_done_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Cancelled By">Close-Done On</label>
                                                <div class="static">{{ $data->close_done_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Cancelled By">Re-open Addendum By</label>
                                                <div class="static">{{ $data->re_open_addendum_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Cancelled By">Re-open Addendum On</label>
                                                <div class="static">{{ $data->re_open_addendum_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Cancelled By">Addendum Approved By</label>
                                                <div class="static">{{ $data->addendum_approved_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Cancelled By">Addendum Approved On</label>
                                                <div class="static">{{ $data->addendum_approved_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Cancelled By">Under Addendum Execution By</label>
                                                <div class="static">{{ $data->under_addendum_execution_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Cancelled By">Under Addendum Execution On</label>
                                                <div class="static">{{ $data->under_addendum_execution_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Cancelled By">Re-open Child Close By</label>
                                                <div class="static">{{ $data->re_open_child_close_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Cancelled By">Re-open Child Close On</label>
                                                <div class="static">{{ $data->re_open_child_close_on }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Cancelled On">Under Addendum Verification By</label>
                                                <div class="static">{{ $data->under_addendum_verification_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Cancelled On">Under Addendum Verification On</label>
                                                <div class="static">{{ $data->under_addendum_verification_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Cancelled On">Closed-Done By</label>
                                                <div class="static">{{ $data->closed_done_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Cancelled On">Closed-Done On</label>
                                                <div class="static">{{ $data->closed_done_ON }}</div>
                                            </div>
                                        </div>
                                </div>
                                <div class="button-block">
                                    <button type="submit" class="saveButton"
                                        {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="submit"
                                        {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Submit</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
{{-- ========================================= reject-modal=========================================================== --}}
        <div class="modal fade" id="rejection-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('root_reject', $data->id) }}" method="POST">
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
                                <input type="comment" name="comment" required>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        {{-- <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button>Close</button>
                        </div> --}}
                        <div class="modal-footer">
                            <button type="submit">Submit</button>
                              <button type="button" data-bs-dismiss="modal">Close</button>   
                        </div>
                    </form>
                </div>
            </div>
        </div>

{{-- ========================================= backword-modal=========================================================== --}}
        <div class="modal fade" id="backword-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('root_backword', $data->id) }}" method="POST">
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
                                <input class="input_width" type="text" name="username" required>
                            </div>
                            <div class="group-input">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input class="input_width" type="password" name="password" required>
                            </div>
                            <div class="group-input">
                                <label for="comment">Comment <span class="text-danger">*</span></label>
                                <input class="input_width" type="comment" name="comment" required>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        {{-- <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button>Close</button>
                        </div> --}}
                        <div class="modal-footer">
                            <button type="submit">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>   
                        </div>
                    </form>
                </div>
            </div>
        </div>

{{-- ========================================= backword2-modal=========================================================== --}}
        <div class="modal fade" id="backword_2-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('root_backword_2', $data->id) }}" method="POST">
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
                                <input class="input_width" type="text" name="username" required>
                            </div>
                            <div class="group-input">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input class="input_width" type="password" name="password" required>
                            </div>
                            <div class="group-input">
                                <label for="comment">Comment <span class="text-danger">*</span></label>
                                <input class="input_width" type="comment" name="comment" required>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        {{-- <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button>Close</button>
                        </div> --}}
                        <div class="modal-footer">
                            <button type="submit">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>   
                        </div>
                    </form>
                </div>
            </div>
        </div>
{{-- ========================================= cancel-modal=========================================================== --}}
        <div class="modal fade" id="cancel-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('root_Cancel', $data->id) }}" method="POST">
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
                                <input type="comment" name="comment" required>
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
<!-- ===============================signature model======================== -->

        <div class="modal fade" id="signature-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('root_send_stage', $data->id) }}" method="POST">
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
                                <input type="comment" name="comment">
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
{{-- ========================================= child-modal=========================================================== --}}
       
       <div class="modal fade" id="child-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
        
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Child</h4>
                    </div>
                    <form action="{{ route('root_child', $data->id) }}" method="POST">
                        @csrf
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="group-input">
                                @if ($data->stage == 2)
                                <label for="major">
                                    <input type="radio" name="child_type" id="major"
                                        value="notification">
                                        Notification
                                </label>
                                <br>
                                <label for="major">
                                    <input type="radio" name="child_type" id="major"
                                        value="action_item">
                                        Action Item
                                </label>
                                <br>
                                <label for="major">
                                    <input type="radio" name="child_type" id="major"
                                        value="document">
                                        Document
                                </label>
                                <br>
                                    <label for="major">
                                        <input type="radio" name="child_type" id="major"
                                            value="rca">
                                            RCA
                                    </label>
                                    <br>
                                    <label for="major">
                                        <input type="radio" name="child_type" id="major"
                                            value="risk_management">
                                            Risk Management
                                    </label>
                                    <br>
                                    <label for="major">
                                        <input type="radio" name="child_type" id="major"
                                            value="extension">
                                            Extension
                                    </label>
                                @endif
                                
                                @if ($data->stage == 6)
                                <label for="major">
                                    <input type="radio" name="child_type" id="major"
                                        value="notification">
                                        Notification
                                </label>
                                <br>
                                <label for="major">
                                    <input type="radio" name="child_type" id="major"
                                        value="action_item">
                                        Action Item
                                </label>
                                <br>
                                <label for="major">
                                    <input type="radio" name="child_type" id="major"
                                        value="document">
                                        Document
                                </label>
                                <br>
                                    <label for="major">
                                        <input type="radio" name="child_type" id="major"
                                            value="rca">
                                            RCA
                                    </label>
                                    <br>
                                    <label for="major">
                                        <input type="radio" name="child_type" id="major"
                                            value="risk_management">
                                            Risk Management
                                    </label>
                                    <br>
                                    <label for="major">
                                        <input type="radio" name="child_type" id="major"
                                            value="extension">
                                            Extension
                                    </label>
                                @endif

                                @if ($data->stage == 10)
                                <label for="major">
                                    <input type="radio" name="child_type" id="major"
                                        value="notification">
                                        Effectivness Checking
                                </label>
                                @endif
                            </div>
                        </div>
        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" data-bs-dismiss="modal">Close</button>
                            <button type="submit">Continue</button>
                        </div>
                    </form>
        
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
                // ================================ FOUR INPUTS==========================================//
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
    for (var i = 1; i < currentRowCount; i++) {
        var row = table.rows[i];
        row.cells[0].innerHTML = i;
    }
}
            </script>
        <script>
            VirtualSelect.init({
                ele: '#investigators'
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
                ele: '#departments, #team_members, #training-require, #impacted_objects'
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
            $('#rchars').text(textlen);});
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

    @endsection
