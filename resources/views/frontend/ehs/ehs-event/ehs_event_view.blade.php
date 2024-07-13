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

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(8) {
        border-radius: 0px 20px 20px 0px;

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
        <strong>Site Division/Project</strong> :{{ Helpers::getDivisionName(session()->get('division')) }}
        / EHS_Event
    </div>
</div>

@php
$users = DB::table('users')->get();
@endphp
{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head">Record Workflow </div>

                <div class="d-flex" style="gap:20px;">
                    <!-- @php
                        $userRoles = DB::table('user_roles')
                            ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' =>1])->get();
                            
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp -->

                    @php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => 1])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp

                            <button class="button_theme1"> <a class="text-white" href="{{ url('ehsEventAuditTrail',$ehsevent->id)}}">
                                Audit Trail </a> </button>
              
                    @if ($ehsevent->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Submit
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-model">
                        cancel
                    </button>
                    
                    @elseif ($ehsevent->stage == 2 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                        More Info Required
                    </button> 
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                    Review Complete
                    </button> 
                
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-model">
                        Cancel
                    </button>
                    @elseif ($ehsevent->stage == 3 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds))) 
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                    Complete Investigation

                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                        Child
                    </button>
                    
                    @elseif($ehsevent->stage == 4 &&(in_array(3, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))
                    
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                    More Investigation Required
                    </button> 
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                    Analysis Complete
                    </button>

                    @elseif ($ehsevent->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                    Propose Plan
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                        Child
                    </button> 
                    

                    @elseif ($ehsevent->stage == 6 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                    Approve Plan
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                    Reject
                    </button> 
                    
                    @elseif ($ehsevent->stage == 7 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        All CAPA Closed
                    </button> 
                    
                    @endif 
  
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>
                </div>
            </div>

{{-- =============================================================================================================== --}}
            <div class="status">
                <div class="head">Current Status</div>
                @if ($ehsevent->stage == 0) 
                <div class="progress-bars ">
                    <div class="bg-danger">Closed-Cancelled</div>
                </div> 
                

                @else 
                <div class="progress-bars d-flex" style="font-size: 15px;">
                    @if ($ehsevent->stage >= 1)
                    <div class="active">Opened</div>
                    @else 
                    <div class="">Opened</div> 
                    @endif

                    @if ($ehsevent->stage >= 2)
                    <div class="active">Pending Review</div>
                    @else
                    <div class="">Pending Review</div>
                    @endif 

                    @if ($ehsevent->stage >= 3) 
                    <div class="active">Pending Investigation</div> 
                    @else 
                    <div class="">Pending Investigation</div>
                    @endif 

                    @if ($ehsevent->stage >= 4)
                    <div class="active">Root Cause and Risk Analysis</div> 
                    @else
                    <div class="">Root Cause and Risk Analysis</div>
                    @endif 

                    @if ($ehsevent->stage >= 5) 
                    <div class="active">Pending Action Planning</div> 
                    @else 
                    <div class="">Pending Action Planning</div>
                    @endif

                    @if ($ehsevent->stage >= 6)
                    <div class="active">Pending Approval
</div> 
                    @else 
                    <div class="">Pending Approval
</div>
                    @endif

  @if ($ehsevent->stage >= 7)
                    <div class="active">CAPA Execution in Progress
</div> 
                    @else 
                    <div class="">CAPA Execution in Progress
</div>
                    @endif

                    @if ($ehsevent->stage >= 8) 
                    <div class="bg-danger">Close-Done</div>
                    @else 
                    <div class="">Close-Done</div>
                    @endif  
                    @endif 

                    {{-- <div class="progress-bars d-flex" style="font-size: 15px;">
                        <div class="{{ $renewal->stage >= 1 ? 'active' : '' }}">Opened</div>
            
                        <div class="{{ $renewal->stage >= 2 ? 'active' : '' }}">Submission Preparation</div>
            
                        <div class="{{ $renewal->stage >= 3 ? 'active' : '' }}">Pending Submission Review</div>
            
                        <div class="{{ $renewal->stage >= 4 ? 'active' : '' }}">Authority Assessment</div>
            
                        @if ($renewal->stage == 5)
                            <div class="bg-danger">Closed - Withdrawn</div>
                        @elseif ($renewal->stage == 6)  
                            <div class="bg-danger">Closed - Not Approved</div>
                        @elseif ($renewal->stage == 8)
                            <div class="bg-danger">Approved</div>
                        @elseif ($renewal->stage == 9)
                            <div class="bg-danger">Closed - Retired</div>
                        @else
                            <div class="{{ $renewal->stage >= 7 ? 'active' : '' }}">Pending Registration Update</div>
                        @endif
                    </div>
                @endif --}}

                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>



        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Detailed Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Damage Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Investigation Summary</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Root casue and Risk Analysis</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
        </div>

        <form action="{{ route('ehs_event_update',$ehsevent->id) }}" method="POST" enctype="multipart/form-data">
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
                                        <input  disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/EHS/{{ date('Y') }}/{{ str_pad($ehsevent->record, 4, '0', STR_PAD_LEFT) }}">
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
                                    <label for="RLS Record Number"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator_id" value="{{ Auth::user()->name }}">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Opened">Date of Initiation</label>
                                    @if (isset($ehsevent) && $ehsevent->intiation_date)
                                        <input disabled type="text"
                                            value="{{ \Carbon\Carbon::parse($ehsevent->intiation_date)->format('d-M-Y') }}"
                                            name="intiation_date_display">
                                    @else
                                        <input disabled type="text" value="" name="intiation_date_display">
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
                                                <option {{ $ehsevent->assigned_to == $value->name ? 'selected' : '' }} value="{{ $value->name }}">{{ $value->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('assigned_to')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror 
                                </div>
                            </div>
                            {{-- <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Due Date <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MM-YYYY" />
                                        <input type="date" name="date_due" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{$ehsevent->date_due}}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Due Date">Due Date </label>
                                    <div class="calenderauditee">
                                        @php
                                            $Date = isset($ehsevent->date_due)
                                                ? new \DateTime($ehsevent->date_due)
                                                : null;
                                        @endphp
                                        {{-- Format the date as desired --}}
                                        <input type="text" id="date_due" readonly placeholder="DD-MM-YYYY"
                                            value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                        <input type="date" name="date_due"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="{{ $data->date_occurred ?? '' }}" class="hide-input"
                                            oninput="handleDateInput(this, 'date_due')" />
                                    </div>
                                </div>
                            </div>

                           


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" maxlength="255" required value="{{$ehsevent->short_description}}">
                                </div>
                            </div>

                            <div class="sub-head">
                                EHS Event Details
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Event type</label>
                                    <select name="event_type">
                                        <option value="" >Enter Your Selection Here</option>
                                        <option value="event_type_1"{{ $ehsevent->event_type == 'event_type_1' ? 'selected' : ''  }}>Event-Type-1</option>
                                        <option value="event_type_2"{{ $ehsevent->event_type == 'event_type_2' ? 'selected' : ''  }}>Event-Type-2</option>
                                        <option value="event_type_3"{{ $ehsevent->event_type == 'event_type_3' ? 'selected' : ''  }}>Event-Type-3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Incident Sub-Type</label>
                                    <select name="incident_sub_type" value="{{$ehsevent->incident_sub_type}}">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="sub_type_1"{{ $ehsevent->incident_sub_type == 'sub_type_1' ? 'selected' : ''  }}>Sub-Type-1</option>
                                        <option value="sub_type_2"{{ $ehsevent->incident_sub_type == 'sub_type_2' ? 'selected' : ''  }}>Sub-Type-2</option>
                                        <option value="sub_type_3"{{ $ehsevent->incident_sub_type == 'sub_type_3' ? 'selected' : ''  }}>Sub-Type-3</option>
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Date Occurred</b></label>
                                    <input type="date" name="date_occurred" value="{{$ehsevent->date_occurred}}" value="">
                                </div>
                            </div> -->

                            <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Due Date">Date Occurred</label>
                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($ehsevent->date_occurred)
                                                        ? new \DateTime($ehsevent->date_occurred)
                                                        : null;
                                                @endphp
                                                {{-- Format the date as desired --}}
                                                <input type="text" id="date_occurred" readonly placeholder="DD-MM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="date_occurred"
                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    value="{{ $data->date_occurred ?? '' }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'date_occurred')" />
                                            </div>
                                        </div>
                                    </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Time Occurred</label>
                                    <select name="time_occurred" value="{{$ehsevent->time_occurred}}">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $ehsevent->time_occurred == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->time_occurred == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->time_occurred == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Date of Reporting</b></label>
                                    <input type="date" name="date_of_reporting" value="{{$ehsevent->date_of_reporting}}" value="">
                                </div>
                            </div> -->

                            <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Due Date">Date of Reporting</label>
                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($ehsevent->date_of_reporting)
                                                        ? new \DateTime($ehsevent->date_of_reporting)
                                                        : null;
                                                @endphp
                                                {{-- Format the date as desired --}}
                                                <input type="text" id="date_of_reporting" readonly placeholder="DD-MM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="date_of_reporting"
                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    value="{{ $data->date_of_reporting ?? '' }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'date_of_reporting')" />
                                            </div>
                                        </div>
                                    </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Reporter</b></label>
                                    <input type="text" name="reporter" value="{{$ehsevent->reporter}}">

                                </div>
                            </div>


                            <!-- <div class="col-12">
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
                                </div> -->

                                <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="File Attachments">File Attachments</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>
                                         
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="file_attachment">
                                                    @if ($ehsevent->file_attachment)
                                                        @foreach (json_decode($ehsevent->file_attachment) as $file)
                                                            <h6 type="button" class="file-container text-dark"
                                                                style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}"
                                                                    target="_blank"><i class="fa fa-eye text-primary"
                                                                        style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a type="button" class="remove-file"
                                                                    data-file-name="{{ $file }}"><i
                                                                        class="fa-solid fa-circle-xmark"
                                                                        style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input 
                                                        type="file" id="file_attachment" name="file_attachment[]"
                                                        oninput="addMultipleFiles(this, 'file_attachment')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>







                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Responsible Department">Similar Incidents(s)</label>
                                    <select name="similar_incidents">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $ehsevent->similar_incidents == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->similar_incidents == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->similar_incidents == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Short Description"> Description<span class="text-danger"></span></label>
                                    <textarea name="description"  >{{$ehsevent->description}}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Immediate Actions<span class="text-danger"></span></label>
                                    <textarea name="immediate_actions"  >{{$ehsevent->immediate_actions}}</textarea>
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
                                        <option value="1"{{ $ehsevent->accident_type == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->accident_type == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->accident_type == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">OSHA Reportable?</label>
                                    <select name="osha_reportable">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $ehsevent->osha_reportable == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->osha_reportable == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->osha_reportable == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">First Lost Work Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="first_lost_work_date"  class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Due Date">First Lost Work Date</label>
                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($ehsevent->first_lost_work_date)
                                                        ? new \DateTime($ehsevent->first_lost_work_date)
                                                        : null;
                                                @endphp
                                                {{-- Format the date as desired --}}
                                                <input type="text" id="first_lost_work_date" readonly placeholder="DD-MM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="first_lost_work_date"
                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    value="{{ $data->first_lost_work_date ?? '' }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'first_lost_work_date')" />
                                            </div>
                                        </div>
                                    </div>

                            <!-- <div class="col-lg-6  new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="end_date">Last Lost Work Date</lable>
                                        <div class="calenderauditee">
                                            <input type="text" id="end_date" placeholder="DD-MMM-YYYY" />
                                            <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="end_date_checkdate" name="last_lost_work_date" class="hide-input" oninput="handleDateInput(this, 'end_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                        </div>
                                </div>
                            </div> -->
                            <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Due Date">Last Lost Work Date</label>
                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($ehsevent->last_lost_work_date)
                                                        ? new \DateTime($ehsevent->last_lost_work_date)
                                                        : null;
                                                @endphp
                                                {{-- Format the date as desired --}}
                                                <input type="text" id="last_lost_work_date" readonly placeholder="DD-MM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="last_lost_work_date"
                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    value="{{ $data->last_lost_work_date ?? '' }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'last_lost_work_date')" />
                                            </div>
                                        </div>
                                    </div>


                            <!-- <div class="col-lg-6  new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="end_date">First Restricted Work Date</lable>
                                        <div class="calenderauditee">
                                            <input type="text" id="end_date2" placeholder="DD-MMM-YYYY" />
                                            <input type="date" min="" id="end_date_checkdate" name="first_restricted_work_date" class="hide-input" oninput="handleDateInput(this, 'end_date2');checkDate('start_date_checkdate','end_date_checkdate')" />
                                        </div>
                                </div>
                            </div> -->
                            <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Due Date">First Restricted Work Date</label>
                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($ehsevent->first_restricted_work_date)
                                                        ? new \DateTime($ehsevent->first_restricted_work_date)
                                                        : null;
                                                @endphp
                                                {{-- Format the date as desired --}}
                                                <input type="text" id="first_restricted_work_date" readonly placeholder="DD-MM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="first_restricted_work_date"
                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    value="{{ $data->first_restricted_work_date ?? '' }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'first_restricted_work_date')" />
                                            </div>
                                        </div>
                                    </div>
<!-- 
                            <div class="col-lg-6  new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="end_date">Last Restricted Work Date</lable>
                                        <div class="calenderauditee">
                                            <input type="text" id="end_date3" placeholder="DD-MMM-YYYY" />
                                            <input type="date" min="" id="end_date_checkdate" name="last_restricted_work_date" class="hide-input" oninput="handleDateInput(this, 'end_date3');checkDate('start_date_checkdate','end_date_checkdate')" />
                                        </div>
                                </div>
                            </div> -->
                            <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Due Date">Last Restricted Work Date</label>
                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($ehsevent->last_restricted_work_date)
                                                        ? new \DateTime($ehsevent->last_restricted_work_date)
                                                        : null;
                                                @endphp
                                                {{-- Format the date as desired --}}
                                                <input type="text" id="last_restricted_work_date" readonly placeholder="DD-MM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="last_restricted_work_date"
                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    value="{{ $data->last_restricted_work_date ?? '' }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'last_restricted_work_date')" />
                                            </div>
                                        </div>
                                    </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Vehicle Type</label>
                                    <select name="vehicle_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $ehsevent->vehicle_type == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->vehicle_type == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->vehicle_type == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Vehicle Number</label>
                                    <div class="calenderauditee">
                                        <input name="vehicle_number" value="{{$ehsevent->vehicle_number}}" type="text" id="start_date"  />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Litigation</label>
                                    <select name="litigation">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $ehsevent->litigation == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->litigation == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->litigation == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Department(s)</label>
                                    <div class="calenderauditee">
                                        <input name="department" value="{{$ehsevent->department}}" type="text" id="start_date"  />
                                    </div>
                                </div>
                            </div>
                            <div class="sub-head col-12">Involved Persons</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Employee(s) Involved<span class="text-danger"></span></label>
                                    <textarea name="employee_involved">{{$ehsevent->employee_involved}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Involved(s) Contractor(s)<span class="text-danger"></span></label>
                                    <textarea name="involved_contractor">{{$ehsevent->involved_contractor}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Attorneys (s) Involved(s)<span class="text-danger"></span></label>
                                    <textarea name="attorneys_involved">{{$ehsevent->attorneys_involved}}</textarea>
                                </div>
                            </div>

                            <!-- Grid start -->

                            <div class="group-input">
    <label for="audit-agenda-grid">
        Witness(es) Information
        <button type="button" name="details1" id="Witness_details">+</button>
        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size:.8rem; font-weight: 400; cursor: pointer;">
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
        @foreach($grid_data1->data as $grid)
                        <tr> 
                            <td><input disabled type="text" name="Witness_details_details[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}"></td>
                            <td><input type="text" name="Witness_details_details[{{ $loop->index }}][witness_name]" value="{{ $grid['witness_name']}}"></td>
                            <td><input type="text" name="Witness_details_details[{{ $loop->index }}][witness_type]" value="{{ $grid['witness_type'] }}"></td>
                            <td><input type="text" name="Witness_details_details[{{ $loop->index }}][item_descriptions]" value="{{$grid['item_descriptions']}}"></td>
                            <td><input type="text" name="Witness_details_details[{{ $loop->index }}][comments]" value="{{ $grid['comments']}}"></td>
                            <td><input type="text" name="Witness_details_details[{{ $loop->index }}][remarks]" value="{{ $grid['remarks']}}"></td>
                            <td>
                                <button type="button"
                                         class="removeBtn">remove</button>
                                 </td>
                        </tr>
                    @endforeach
     
            </tbody>
        </table>
    </div>
</div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Comments">Lead Investigator </label>
                                    <Input name="lead_investigator" value="{{$ehsevent->lead_investigator}}" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Comments">Line Operator </label>
                                    <Input name="line_operator" value="{{$ehsevent->line_operator}}"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Comments">Reporter </label>
                                    <Input name="detail_info_reporter" value="{{$ehsevent->detail_info_reporter}}" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Comments">Supervisor </label>
                                    <Input name="supervisor" value="{{$ehsevent->supervisor}}"/>
                                </div>
                            </div>

                            <div class="sub-head col-12">Near Miss and Measures</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Unsafe Situation</label>
                                    <select name="unsafe_situation">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $ehsevent->unsafe_situation == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->unsafe_situation == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->unsafe_situation == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Safeguarding Measure Taken</label>
                                    <select name="safeguarding_measure_taken">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $ehsevent->safeguarding_measure_taken == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->safeguarding_measure_taken == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->safeguarding_measure_taken == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sub-head col-12">Enviromental Information</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Enviromental Category</label>
                                    <select name="enviromental_category">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $ehsevent->enviromental_category == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->enviromental_category == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->enviromental_category == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Special Weather Conditions">Special Weather Conditions</label>
                                    <select name="Special_Weather_Conditions">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $ehsevent->Special_Weather_Conditions == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->Special_Weather_Conditions == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->Special_Weather_Conditions == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Source Department">Source Of Release or Spill</label>
                                    <select name="source_Of_release_or_spill">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $ehsevent->source_Of_release_or_spill == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->source_Of_release_or_spill == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->source_Of_release_or_spill == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Special Weather Conditions">Special Weather Conditions</label>
                                    <select name="Special_Weather_Conditions">
                                        <option value="">Cause Of Release or Spill</option>
                                        <option value="1"{{ $ehsevent->Special_Weather_Conditions == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->Special_Weather_Conditions == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->Special_Weather_Conditions == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Environment Evacuation Ordered">Environment Evacuation Ordered</label>
                                    <select name="environment_evacuation_ordered">
                                        <option value="">Environment Evacuation Ordered</option>
                                        <option value="1"{{ $ehsevent->environment_evacuation_ordered == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->environment_evacuation_ordered == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->environment_evacuation_ordered == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date">Date Simples Taken</label>
                                    <input type="date" name="date_simples_taken" >
                                </div>
                            </div> -->
                            <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Due Date">Date Simples Taken</label>

                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($ehsevent->date_simples_taken)
                                                        ? new \DateTime($ehsevent->date_simples_taken)
                                                        : null;
                                                @endphp
                                                {{-- Format the date as desired --}}
                                                <input type="text" id="date_simples_taken" readonly placeholder="DD-MM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="date_simples_taken"
                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    value="{{ $ehsevent->date_simples_taken ?? '' }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'date_simples_taken')" />
                                            </div>
                                        </div>
                                    </div>


                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Agency">Agency(s) Notified</label>
                                    <select name="agency_notified">
                                        <option value="">Environment Evacuation Ordered</option>
                                        <option value="1"{{ $ehsevent->agency_notified == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->agency_notified == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->agency_notified == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="audit-agenda-grid">
                                        Materials Released
                                        <button type="button" name="audit-agenda-grid" id="MaterialsReleased">+</button>
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size:.8rem; font-weight: 400; cursor: pointer;">
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
                                      @foreach($grid_data2->data as $grid)
                                            <td><input disabled type="text" name="materials_released[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}"></td>
                                                <td><input type="text" name="materials_released[{{ $loop->index }}][type_of_material_released]"  value="{{ $grid['type_of_material_released']}}"></td>
                                                <td><input type="text" name="materials_released[{{ $loop->index }}][quantity_Of_materials_released]" value="{{ $grid['quantity_Of_materials_released']}}" ></td>
                                                <td><input type="text" name="materials_released[{{ $loop->index }}][medium_affected_by_released]" value="{{ $grid['medium_affected_by_released']}}"></td>
                                                <td><input type="text" name="materials_released[{{ $loop->index }}][health_risk]" value="{{ $grid['health_risk']}}"></td>
                                                <td><input type="text" name="materials_released[{{ $loop->index }}][remarks]" value="{{ $grid['remarks']}}"></td>
                                                <td>
                                                    <button type="button"
                                                             class="removeBtn2">remove</button>
                                                     </td>
                                            </tbody>
                    @endforeach


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
                                     <option value="1"{{ $ehsevent->fire_category == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->fire_category == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->fire_category == '3' ? 'selected' : ''  }}>3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Agency">Fire Evacuation Ordered?</label>
                                <select name="fire_evacuation_ordered">
                                    <option value="">--select--</option>
                                     <option value="1"{{ $ehsevent->fire_evacuation_ordered == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->fire_evacuation_ordered == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->fire_evacuation_ordered == '3' ? 'selected' : ''  }}>3</option>
                                </select>
                            </div>
                        </div>
                        <!-- </div> -->
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Agency">Combat By</label>
                                <select name="combat_by">
                                    <option value="">--select--</option>
                                     <option value="1"{{ $ehsevent->combat_by == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->combat_by == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->combat_by == '3' ? 'selected' : ''  }}>3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Agency">Fire Fighting Equipment Used</label>
                                <input type="text" name="fire_fighting_equipment_used" value="{{$ehsevent->fire_fighting_equipment_used}}">
                            </div>
                        </div>

                        <div class="sub-head col-12">Event Location</div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Agency">Zone</label>
                                <select name="zone">
                                    <option value="">--select--</option>
                                    <option value="Asia" @if ($ehsevent->zone == 'Asia') selected @endif>
                                        Asia</option>
                                    <option value="Europe" @if ($ehsevent->zone == 'Europe') selected @endif>
                                        Europe</option>
                                    <option value="Africa" @if ($ehsevent->zone == 'Africa') selected @endif>
                                        Africa</option>
                                    <option value="Central America"
                                        @if ($ehsevent->zone == 'Central America') selected @endif>Central America
                                    </option>
                                    <option value="South America"
                                        @if ($ehsevent->zone == 'South America') selected @endif>South America
                                    </option>
                                    <option value="Oceania" @if ($ehsevent->zone == 'Oceania') selected @endif>
                                        Oceania</option>
                                    <option value="North America"
                                        @if ($ehsevent->zone == 'North America') selected @endif>North America
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Agency">Country</label>
                                <select name="country" class="form-select country"
                                aria-label="Default select example" onchange="loadStates()">
                                <option value="{{ $ehsevent->country }}">
                                    {{ $ehsevent->country }}</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="State">State/District</label>
                                <select name="state" class="form-select state"
                                aria-label="Default select example" onchange="loadCities()">
                                <option value="{{ $ehsevent->state }}">{{ $ehsevent->state }}
                                </option>
                            </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Agency">City</label>
                                <select name="city" class="form-select city"
                                            aria-label="Default select example">
                                            <option value="{{ $ehsevent->city }}">{{ $ehsevent->city }}
                                            </option>
                                        </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Site">Site Name</label>
                                <select name="site_name">
                                    <option value="">--select--</option>
                                     <option value="1"{{ $ehsevent->site_name == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->site_name == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->site_name == '3' ? 'selected' : ''  }}>3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Building">Building</label>
                                <select name="building">
                                    <option value="">--select--</option>
                                     <option value="1"{{ $ehsevent->building == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->building == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->building == '3' ? 'selected' : ''  }}>3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Floor">Floor</label>
                                <select name="floor">
                                    <option value="">--select--</option>
                                     <option value="1"{{ $ehsevent->floor == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->floor == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->floor == '3' ? 'selected' : ''  }}>3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Room">Room</label>
                                <select name="room">
                                    <option value="">--select--</option>
                                     <option value="1"{{ $ehsevent->room == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->room == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->room == '3' ? 'selected' : ''  }}>3</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Location">Location</label>
                                <input type="text" name="location" value="{{$ehsevent->location}}">
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
                                    <input type="text" name="victim" value="{{$ehsevent->victim}}" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Medical">Medical Treatment?(Y/N)</label>
                                    <select name="medical_treatment">
                                        <option value="">--select--</option>
                                        <option value="yes"{{ $ehsevent->medical_treatment == 'yes' ? 'selected' : ''  }}>Yes</option>
                                        <option value="no"{{ $ehsevent->medical_treatment == 'no' ? 'selected' : ''  }}>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Victim_Position">Victim Position</label>
                                    <select name="victim_position">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->victim_position == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->victim_position == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->victim_position == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Victim_Realation">Victim Realation To Company</label>
                                    <select name="victim_realation">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->victim_realation == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->victim_realation == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->victim_realation == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Hospitalization">Hospitalization</label>
                                    <select name="hospitalization">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->hospitalization == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->hospitalization == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->hospitalization == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Hospital_name">Hospital Name</label>
                                    <input type="text" name="hospital_name" value="{{$ehsevent->hospital_name}}" />
                                </div>
                            </div>
                            <!-- <div class="col-6">
                                <div class="group-input">
                                    <label for="Date">Date of Treatment</label>
                                    <input type="date" name="date_of_treatment" value="{{$ehsevent->date_of_treatment}}"/>
                                </div>
                            </div> -->
                            <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Due Date">Date of Treatment</label>

                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($ehsevent->date_of_treatment)
                                                        ? new \DateTime($ehsevent->date_of_treatment)
                                                        : null;
                                                @endphp
                                                {{-- Format the date as desired --}}
                                                <input type="text" id="date_of_treatment" readonly placeholder="DD-MM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="date_of_treatment"
                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    value="{{ $ehsevent->date_of_treatment ?? '' }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'date_of_treatment')" />
                                            </div>
                                        </div>
                                    </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Victim_Treated">Victim Treated By</label>
                                    <input type="text" name="victim_treated_by" value="{{$ehsevent->victim_treated_by}}" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Victim_Treated">Medical Treatment Discription</label>
                                    <textarea name="medical_treatment_discription" id="" cols="30" rows="3">{{$ehsevent->medical_treatment_discription}}</textarea>
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
                                         <option value="1"{{ $ehsevent->injury_type == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->injury_type == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->injury_type == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Injury">Number of Injuries</label>
                                    <input type="text" name="number_of_injuries" value="{{$ehsevent->number_of_injuries}}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Injury">Type of Illness</label>
                                    <select name="type_of_illness">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->type_of_illness == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->type_of_illness == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->type_of_illness == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Injury">Permanent Disability?</label>
                                    <select name="permanent_disability">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $ehsevent->permanent_disability == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->permanent_disability == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->permanent_disability == '3' ? 'selected' : ''  }}>3</option>
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
                                        <option value="1"{{ $ehsevent->damage_category == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->damage_category == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->damage_category == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Related_Equipment">Related Equipment</label>
                                    <input type="text" name="related_equipment" value="{{$ehsevent->related_equipment}}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Estimated_Amount">Estimated Amount of Damage Equipment</label>
                                    <input type="text" name="estimated_amount" value="{{$ehsevent->estimated_amount}}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Permanent">Currency</label>
                                    <select name="currency">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->currency == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->currency == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->currency == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Involved">Insurance Company Involved?</label>
                                    <select name="insurance_company_involved">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->insurance_company_involved == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->insurance_company_involved == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->insurance_company_involved == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Denied_By_Insurance">Denied By Insurance Company?</label>
                                    <select name="denied_by_insurance">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->denied_by_insurance == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->denied_by_insurance == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->denied_by_insurance == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Damage_Details">Damage Details</label>
                                    <textarea name="damage_details" id="" cols="30" rows="3">{{$ehsevent->damage_details}}</textarea>
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
                                    <input type="text" name="actual_amount" value="{{$ehsevent->actual_amount}}"/>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Currency">Currency</label>
                                    <select name="currency">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->currency == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->currency == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->currency == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="investigation_summary">Investigation summary</label>
                                    <textarea name="investigation_summary" id="" cols="30" rows="5">{{$ehsevent->investigation_summary}}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Conclusion">Conclusion</label>
                                    <textarea name="conclusion" id="" cols="30" rows="5">{{$ehsevent->conclusion}}</textarea>
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
                                         <option value="1"{{ $ehsevent->safety_impact_probability == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->safety_impact_probability == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->safety_impact_probability == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Safety_Impact_Severity">Safety Impact Severity</label>
                                    <select name="safety_impact_severity">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->safety_impact_severity == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->safety_impact_severity == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->safety_impact_severity == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Legal_Impact_Probability">Legal Impact Probability</label>
                                    <select name="legal_impact_probability">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->legal_impact_probability == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->legal_impact_probability == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->legal_impact_probability == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Legal_Impact_Severity">Legal Impact Severity</label>
                                    <select name="legal_impact_severity">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->legal_impact_severity == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->legal_impact_severity == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->legal_impact_severity == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Business_Impact_Probability">Business Impact Probability</label>
                                    <select name="business_impact_probability">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->business_impact_probability == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->business_impact_probability == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->business_impact_probability == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Business_Impact_Severity">Business Impact Severity</label>
                                    <select name="business_impact_severity">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->business_impact_severity == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->business_impact_severity == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->business_impact_severity == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Revenue_Impact_Probability">Revenue Impact Probability</label>
                                    <select name="revenue_impact_probability">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->revenue_impact_probability == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->revenue_impact_probability == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->revenue_impact_probability == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Revenue_Impact_Severity">Revenue Impact Severity</label>
                                    <select name="revenue_impact_severity">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->revenue_impact_severity == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->revenue_impact_severity == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->revenue_impact_severity == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Brand_Impact_Probability">Brand Impact Probability</label>
                                    <select name="brand_impact_probability">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->brand_impact_probability == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->brand_impact_probability == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->brand_impact_probability == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Brand_Impact_Severity">Brand Impact Severity</label>
                                    <select name="brand_impact_severity">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->brand_impact_severity == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->brand_impact_severity == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->brand_impact_severity == '3' ? 'selected' : ''  }}>3</option>
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
                                         <option value="1"{{ $ehsevent->safety_impact_risk == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->safety_impact_risk == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->safety_impact_risk == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Legal_Impact_Risk">Legal Impact Risk</label>
                                    <select name="legal_impact_risk">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->legal_impact_risk == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->legal_impact_risk == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->legal_impact_risk == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Business_Impact_Risk">Business Impact Risk</label>
                                    <select name="business_impact_risk">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->business_impact_risk == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->business_impact_risk == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->business_impact_risk == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Revenue_Impact_Risk">Revenue Impact Risk</label>
                                    <select name="revenue_impact_risk">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->revenue_impact_risk == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->revenue_impact_risk == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->revenue_impact_risk == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Brand_Impact_Risk">Brand Impact Risk</label>
                                    <select name="brand_impact_risk">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->brand_impact_risk == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->brand_impact_risk == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->brand_impact_risk == '3' ? 'selected' : ''  }}>3</option>
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
                                         <option value="1"{{ $ehsevent->impact == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->impact == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->impact == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Impact_Analysis">Impact Analysis</label>
                                    <textarea name="impact_analysis" id="" cols="30" rows="3">{{$ehsevent->impact_analysis}}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Recommended_Action">Recommended Action</label>
                                    <textarea name="recommended_action" id="" cols="30" rows="3">{{$ehsevent->recommended_action}}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Comments">Comments</label>
                                    <textarea name="comments" id="" cols="30" rows="3">{{$ehsevent->comments}}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Direct_Cause">Direct Cause</label>
                                    <select name="direct_cause">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->direct_cause == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->direct_cause == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->direct_cause == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Safeguarding">Safeguarding Measure Taken</label>
                                    <select name="root_cause_safeguarding_measure_taken">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->root_cause_safeguarding_measure_taken == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->root_cause_safeguarding_measure_taken == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->root_cause_safeguarding_measure_taken == '3' ? 'selected' : ''  }}>3</option>
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
                                         <option value="1"{{ $ehsevent->root_cause_methodlogy == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->root_cause_methodlogy == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->root_cause_methodlogy == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Root Cause
                                    <button type="button" name="audit-agenda-grid" id="RootCause">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#RootCause-field-instruction-modal" style="font-size:.8rem; font-weight: 400; cursor: pointer;">
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
                                        @foreach($grid_data3->data as $grid)
                                        <td><input disabled type="text" name="root_cause[{{ $loop->index }}]serial[]" value="{{ $loop->index + 1 }}"></td>
                                            <td><input type="text" name="root_cause[{{ $loop->index }}][root_cause_category]" value="{{ $grid['root_cause_category']}}"></td>
                                            <td> <input type="text" name="root_cause[{{ $loop->index }}][root_cause_sub_category]" value="{{ $grid['root_cause_sub_category']}}"></td>
                                            <td> <input type="text" name="root_cause[{{ $loop->index }}][probability]" value="{{ $grid['probability']}}"></td>
                                            <td> <input type="text" name="root_cause[{{ $loop->index }}][comments]" value="{{ $grid['comments']}}"></td>
                                            <td><input type="text" name="root_cause[{{ $loop->index }}][remarks]" value="{{ $grid['remarks']}}"></td>
                                            <td>
                                                <button type="button"
                                                         class="removeBtn3">remove</button>
                                                 </td>
                                        </tbody>
                                        @endforeach

                                    </table>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Root_cause_Description">Root cause Description</label>
                                    <textarea name="root_cause_description" id="" cols="30" rows="3">{{$ehsevent->root_cause_description}}</textarea>
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
                                         <option value="1"{{ $ehsevent->severity_rate == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->severity_rate == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->severity_rate == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Occurrence">Occurrence</label>
                                    <select name="occurrence">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->occurrence == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->occurrence == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->occurrence == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Detection">Detection</label>
                                    <select name="detection">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->detection == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->detection == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->detection == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="RPN">RPN</label>
                                    <select name="rpn">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->rpn == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->rpn == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->rpn == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Risk_Analysis">Risk Analysis</label>
                                    <textarea name="risk_analysis" id="" cols="30" rows="3">{{$ehsevent->risk_analysis}}</textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Criticality">Criticality</label>
                                    <select name="criticality">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->criticality == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->criticality == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->criticality == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Inform_Local_Authority">Inform Local Authority?</label>
                                    <select name="inform_local_authority">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->inform_local_authority == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->inform_local_authority == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->inform_local_authority == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Authority_Type">Authority Type</label>
                                    <select name="authority_type">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->authority_type == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->authority_type == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->authority_type == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Authority(s)_Notified">Authority(s) Notified</label>
                                    <select name="authority_notified">
                                        <option value="">--select--</option>
                                         <option value="1"{{ $ehsevent->authority_notified == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $ehsevent->authority_notified == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $ehsevent->authority_notified == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Other_Authority">Other Authority</label>
                                <input type="text" name="other_authority" value="{{$ehsevent->other_authority}}">
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
                                <div class="static">{{ $ehsevent->submitted_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Submitted On</label>
                                <div class="static">{{ $ehsevent->submitted_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Submitted Comment</label>
                                <div class="static">{{ $ehsevent->submitted_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head">Cancel</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Cancel By</label>
                                <div class="static">{{ $ehsevent->cancel_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Cancel On</label>
                                <div class="static">{{ $ehsevent->cancel_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Cancel Comment</label>
                                <div class="static">{{ $ehsevent->cancel_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head">Review Complete</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Review Complete By</label>
                                <div class="static">{{ $ehsevent->review_complete_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Review Complete On</label>
                                <div class="static">{{ $ehsevent->review_complete_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Review Complete Comment</label>
                                <div class="static">{{ $ehsevent->review_complete_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head">More Information Required</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">More Information Required By</label>
                                <div class="static">{{ $ehsevent->more_info_required_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">More Information Required On</label>
                                <div class="static">{{ $ehsevent->more_info_required_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">More Information Required Comment</label>
                                <div class="static">{{ $ehsevent->more_info_required_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head">Complete Investigation</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Complete Investigation By</label>
                                <div class="static">{{ $ehsevent->complete_investigation_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Complete Investigation On</label>
                                <div class="static">{{ $ehsevent->complete_investigation_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Complete Investigation Comment</label>
                                <div class="static">{{ $ehsevent->complete_investigation_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head">Analysis Complete</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Analysis Complete By</label>
                                <div class="static">{{ $ehsevent->analysis_complete_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Analysis Complete On</label>
                                <div class="static">{{ $ehsevent->analysis_complete_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Analysis Complete Comment</label>
                                <div class="static">{{ $ehsevent->analysis_complete_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head">More Investigation Required</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">More Investigation Required By</label>
                                <div class="static">{{ $ehsevent->more_investig_required_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">More Investigation Required On</label>
                                <div class="static">{{ $ehsevent->more_investig_required_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">More Investigation Required Comment</label>
                                <div class="static">{{ $ehsevent->more_investig_required_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head">Propose Plan
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Propose Plan By</label>
                                <div class="static">{{ $ehsevent->propose_plan_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Propose Plan On</label>
                                <div class="static">{{ $ehsevent->propose_plan_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Propose Plan Comment</label>
                                <div class="static">{{ $ehsevent->propose_plan_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head">Approve Plan</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Approve Plan By</label>
                                <div class="static">{{ $ehsevent->approve_plan_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Approve Plan On</label>
                                <div class="static">{{ $ehsevent->approve_plan_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Approve Plan Comment</label>
                                <div class="static">{{ $ehsevent->approve_plan_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head">Reject </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">Reject By</label>
                                <div class="static">{{ $ehsevent->reject_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">Reject On</label>
                                <div class="static">{{ $ehsevent->reject_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">Reject Comment</label>
                                <div class="static">{{ $ehsevent->reject_comment }}</div>
                            </div>
                        </div>

                        <div class="sub-head">All CAPA Closed</div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted by">All CAPA Closed By</label>
                                <div class="static">{{ $ehsevent->all_capa_closed_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="submitted on">All CAPA Closed On</label>
                                <div class="static">{{ $ehsevent->all_capa_closed_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="group-input">
                                <label for="submitted on">All CAPA Closed Comment</label>
                                <div class="static">{{ $ehsevent->all_capa_closed_comment }}</div>
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

    </div>
    </form>

</div>
</div>


<div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('ehs_event_stateChange', $ehsevent->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username<span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input type="comment" name="comment">
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

    <div class="modal fade" id="modal1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('ehs_event_more_info', $ehsevent->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username<span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment<span class="text-danger">*</span></label>
                            <input type="comment" name="comment" required>
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

    {{-- ------------------------- Child Model----------------------------------------------}}

    
    <div class="modal fade" id="child-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form action="{{ route('ehs_event_child', $ehsevent->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            @if($ehsevent->stage== 3)
                            <label for="major">
                                <input type="radio" name="revision" id="major" value="investigation">
                                Investigation
                            </label>
                            @elseif($ehsevent->stage==5)
                            <label for="major2">
                                <input type="radio" name="revision" id="major2" value="CAPA">
                                CAPA
                            </label>
                            <label for="major3">
                                <input type="radio" name="revision" id="major3" value="Sanction">
                                Sanction
                            </label>
                            @endif
                             


                        </div>

                    </div>

                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal">Close</button>
                        <button type="submit">Continue</button>
                    </div> -->
                    <div class="modal-footer">
                              <button type="submit">Submit</button>
                             <button type="button" data-bs-dismiss="modal">Close</button>                         
                   </div>
                </form>

            </div>
        </div>
    </div>
     
    {{-- ------------------------- Cancel Model----------------------------------------------}}

    <div class="modal fade" id="cancel-model">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('ehs_event_cancel_model', $ehsevent->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username<span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment<span class="text-danger">*</span></label>
                            <input type="comment" name="comment" required>
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
        for (i = 0 ; i < cctabcontent.length; i++) {
            cctabcontent[i].style.display = "none";
        }
        cctablinks = document.getElementsByClassName("cctablinks");
        for (i = 0 ; i < cctablinks.length; i++) {
            cctablinks[i].className = cctablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";

        // Find the loop->index of the clicked tab button
        // const loop->index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);
        const loopIndex = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);


        // Update the currentStep to the loop->index of the clicked tab
        currentStep = loopIndex;
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
        if (currentStep > 0 ) {
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
                    '<td><input disabled type="text" name="Witness_details_details[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
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
        $('#MaterialsReleased').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="materials_released[' + serialNumber + ']serial[]" value="' + serialNumber + '"></td>' +
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