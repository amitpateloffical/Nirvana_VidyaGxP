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

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(6) {
        border-radius: 0px 20px 20px 0px;

    }

    .input_width {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 11px;
        }
</style>

<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / CTA Subject
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head">Record Workflow</div>
                <div class="d-flex" style="gap:20px;">
                    {{-- @if(Auth::check() && isset($data)) --}}
                    @php
                    $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id])->get();
                    $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp
                        <button class="button_theme1">
                            <a class="text-white" href="{{ route('clinicalsiteAuditReport', $data->id) }}">Audit Trail</a>
                        </button>
        
                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                          
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit Subject
                            </button>

                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                            
                        @elseif($data->stage == 2 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Close
                        </button>   
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">
                            Child
                        </button>
                        
                           
                        @elseif($data->stage == 3 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            To In Effect
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">
                            Child
                        </button>
                        @elseif($data->stage == 4 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))

                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Hold Clinical Site

                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Close Protocol
                        </button>   
                        @elseif($data->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                           
                        @elseif($data->stage == 6 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                        {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Close Protocol
                        </button> --}}
                        @endif
                        <button class="button_theme1"> 
                            <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                        </button>
                    {{-- @else
                        <p>User is not authenticated or data is not available.</p> --}}
                    {{-- @endif --}}
                </div>
            </div>
            <div class="status">
                <div class="head">Current Status</div>
                {{-- ------------------------------By Pankaj-------------------------------- --}}
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
                            <div class="active">Active</div>
                        @else
                            <div class="">Active</div>
                        @endif
        
                        
                        @if ($data->stage >= 3)
                            <div class="bg-danger">Closed - Done</div>
                        @else
                            <div class="">Closed - Done</div>
                        @endif
                    </div>
                @endif
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>  


{{-- =======================================================================model ================================================== --}}

  {{-- =============================signature model================= --}}

  <div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('subject_stagechange', $data->id) }}" method="POST">
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


{{-- ===================================================================child model======================================== --}}
<div class="modal fade" id="child-modal1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <div class="model-body">
            <form action="#" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        <label style="  display: flex;     gap: 18px; width: 60px;" for="capa-child">
                            <input type="radio" name="revision" id="capa-child" value="rca-child">
                          Violation
                        </label>
                    </div>
                    <div class="group-input">
                        <label style=" display: flex;     gap: 16px; width: 60px;" for="root-item">
                            <input type="radio" name="revision" id="root-item" value="Action-Item">
                          <span style="width: 100px;">  Subject Action Item</span>
                        </label>
                    </div>
                   
                </div>

               
                <div class="modal-footer">
                          <button type="submit">Submit</button>
                         <button type="button" data-bs-dismiss="modal">Close</button>                         
               </div>
            </form>
            </div>
        </div>
    </div>
</div>



        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Subject</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm2')">Additional Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Important Dates</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signatures</button>
        </div>

        <form action="{{ route('subjectupdate',$data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
@method('put')
            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                <!-- Tab-1 -->

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="record_number"><b>Record Number</b></label>
                                    <input type="text" name="record_number" id="record_number"> 
                                    {{-- value="{{ Helpers::getDivisionName(session()->get('division')) }}/LI/{{ date('Y') }}/{{ $record }}" disabled> --}}
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="division_code"><b>Division Code</b></label>
                                    <input type="text" name="division_code" id="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}" disabled>
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="initiator"><b>Initiator</b></label>
                                    <input type="text" name="initiator" id="initiator" value="{{ Auth::user()->name }}" disabled>
                                </div>
                            </div>
                
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="initiation_date"><b>Date Of Initiation</b></label>
                                    <input type="text" value="{{ date('d-M-Y') }}" disabled>
                                    <input type="hidden" name="initiation_date" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="short_description"><b>Short Description</b> <span class="text-danger">*</span></label>
                                    <p>255 characters remaining</p>
                                    <input id="short_description" type="text" name="short_description" maxlength="255" required value="{{ $data->short_description }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="phase_of_study">(Parent) Phase Of Study</label>
                                    <select multiple id="phase_of_study" name="PhaseIIQCReviewProposedBy[]">
                                        <option value="">--Select---</option>
                                        <option value="Pankaj" {{ $data->phase_of_study == 'Pankaj' ? 'selected' : '' }}>Pankaj</option>
                                        <option value="Gaurav" {{ $data->phase_of_study == 'Gaurav' ? 'selected' : '' }}>Gaurav</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="study_num">(Parent) Study Num</label>
                                    <input type="text" name="study_num" id="study_num" value="{{ $data->study_num }}">
                                </div>
                            </div>
                
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="assign_to">Assigned To <span class="text-danger"></span></label>
                                    <select id="assign_to" name="assign_to">
                                        <option value="">Select a value</option>
                                        <option value="Pankaj Jat" {{ $data->assign_to == 'Pankaj Jat' ? 'selected' : ''}}>Pankaj Jat</option>
                                        <option value="Gaurav"{{ $data->assign_to == 'Gaurav' ? 'selected' : ''}} >Gaurav</option>
                                        <option value="Manish"{{ $data->assign_to == 'Manish' ? 'selected' : ''}}>Manish</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due_date">Date Due <span class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" value="{{ $data->due_date }}" >
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')">
                                    </div>
                                </div>
                            </div>
                            
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="attached_files">Attached Files</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="File_Attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="attached_files" name="Attachment[]" multiple oninput="addMultipleFiles(this, 'Attachment')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="related_urls">Related URLs</label>
                                    <select name="related_urls" id="related_urls">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $data->related_urls == '1' ? 'selected' : ''}}>P-1</option>
                                        <option value="2"{{  $data->related_urls == '2' ? 'selected' : '' }}>P-2</option>
                                        <option value="3"{{  $data->related_urls == '3' ? 'selected' : '' }}>P-3</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="description">Description</label>
                                    <textarea class="summernote" name="description" id="description">{{ $data->description }}</textarea>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="actual_cost">Actual Cost</label>
                                    <input type="text" name="Actual_Cost" id="actual_cost" value="{{ $data->Actual_Cost }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="currency">Currency</label>
                                    <select name="currency" id="currency">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $data->currency == '1' ? 'selected' : '' }}>Dollar</option>
                                        <option value="2"{{ $data->currency == '2' ? 'selected' : '' }}>Rupees</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="comments">Comments</label>
                                    <textarea class="summernote" name="comments" id="comments">{{ $data->comments }}</textarea>
                                </div>
                            </div>
                
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="source_documents">Source Documents</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="File_Attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="source_documents" name="Source_Documents[]" multiple oninput="addMultipleFiles(this, 'Source_Documents')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="sub-head">Parent Information</div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="subject_name">Subject Name</label>
                                    <input type="text" name="subject_name" id="subject_name" value="{{ $data->subject_name}}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="subject_dob">Date of Birth</label>
                                    <input type="date" name="subject_dob" id="subject_dob" value="{{ $data->subject_dob }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $data->gender == '1' ? 'selected' : '' }}>Male</option>
                                        <option value="2"{{ $data->gender == '2' ? 'selected' : '' }}>Female</option>
                                        <option value="3"{{ $data->gender == '3' ? 'selected' : '' }}>Others</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="race">Race</label>
                                    <select name="race" id="race">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $data->race == '1' ? 'selected' : '' }}>R-1</option>
                                        <option value="2"{{ $data->race == '2' ? 'selected' : '' }}>R-2</option>
                                        <option value="3"{{ $data->race == '3' ? 'selected' : '' }}>R-3</option>
                                    </select>
                                </div>
                            </div>
                
                        </div>
                
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button">
                                <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                            </button>
                        </div>
                    </div>
                </div>
                

                <!-- Tab-2 -->
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Submission Information</div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="screened_successfully">Screened Successfully?</label>
                                    <select name="screened_successfully" id="screened_successfully">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $data->screened_successfully == '1' ? 'selected' : '' }}>AT-1</option>
                                        <option value="2"{{ $data->screened_successfully == '2' ? 'selected' : '' }}>AT-2</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="reason_discontinuation">Reason For Discontinuation</label>
                                    <select name="reason_discontinuation" id="reason_discontinuation">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $data->reason_discontinuation == '1' ? 'selected' : '' }}>AT-1</option>
                                        <option value="2"{{ $data->reason_discontinuation == '2' ? 'selected' : '' }}>AT-2</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="comments">Comments</label>
                                    <textarea class="summernote" name="comments" id="comments"> {{ $data->comments }}</textarea>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="treatment_consent_version">Treatment Consent Version</label>
                                    <input type="text" name="treatment_consent_version" id="treatment_consent_version" value="{{ $data->treatment_consent_version}}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="screening_consent_version">Screening Consent Version</label>
                                    <input type="text" name="screening_consent_version" id="screening_consent_version" value="{{ $data->screening_consent_version }}">
                                </div>
                            </div>
                
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="exception_number">Exception Number</label>
                                    <input type="text" name="exception_number" id="exception_number" value="{{ $data->exception_number }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="signed_consent_form">Signed Consent Form</label>
                                    <select name="signed_consent_form" id="signed_consent_form">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $data->signed_consent_form == '1' ? 'selected' : '' }}>01</option>
                                        <option value="2"{{ $data->signed_consent_form == '2' ? 'selected' : '' }}>02</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="time_point">Time Point</label>
                                    <select name="time_point" id="time_point">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $data->time_point == '1' ? 'selected' : '' }}>T-1</option>
                                        <option value="2"{{ $data->time_point == '2' ? 'selected' : '' }}>T-2</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="family_history">Family History</label>
                                    <textarea class="summernote" name="family_history" id="family_history">{{ $data->family_history }}</textarea>
                                </div>
                            </div>
                
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="baseline_assessment">Baseline Assessment</label>
                                    <textarea class="summernote" name="baseline_assessment" id="baseline_assessment">{{ $data->baseline_assessment }}</textarea>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="representative">Representative</label>
                                    <input type="text" name="representative" id="representative" value="{{ $data->representative }}">
                                </div>
                            </div>
                
                            <div class="sub-head">Location</div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="zone">Zone</label>
                                    <select name="zone" id="zone">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">P-1</option>
                                        <option value="2">P-2</option>
                                        <option value="3">P-3</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="country">Country</label>
                                    <select name="country" id="country">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">India</option>
                                        <option value="2">UK</option>
                                        <option value="3">USA</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="city">City</label>
                                    <select name="city" id="city">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Indore</option>
                                        <option value="2">Bhopal</option>
                                        <option value="3">Dewas</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="state_district">State/District</label>
                                    <select name="state_district" id="state_district">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Dewas</option>
                                        <option value="2">Harda</option>
                                        <option value="3">Sehore</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="site_name">Site Name</label>
                                    <select name="site_name" id="site_name">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">Indore</option>
                                        <option value="2">Bhopal</option>
                                        <option value="3">Dewas</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="building">Building</label>
                                    <select name="building" id="building">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="floor">Floor</label>
                                    <select name="floor" id="floor">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="room">Room</label>
                                    <select name="room" id="room">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button">
                                    <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tab-3 -->

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Important Dates</div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="consent_form_signed_on">Consent Form Signed On</label>
                                    <input type="date" name="consent_form_signed_on" id="consent_form_signed_on" value="{{ $data->consent_form_signed_on }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_granted">Date Granted</label>
                                    <input type="date" name="date_granted" id="date_granted" value="{{ $data->date_granted }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="system_start_date">System Start Date</label>
                                    <input type="date" name="system_start_date" id="system_start_date" value="{{ $data->system_start_date }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="consent_form_signed_date">Consent Form Signed Date</label>
                                    <input type="date" name="consent_form_signed_date" id="consent_form_signed_date" value="{{ $data->consent_form_signed_date  }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_first_treatment">Date Of First Treatment</label>
                                    <input type="date" name="date_first_treatment" id="date_first_treatment" value="{{ $data->date_first_treatment }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_requested">Date Requested</label>
                                    <input type="date" name="date_requested" id="date_requested" value="{{ $data->date_requested }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_screened">Date Screened</label>
                                    <input type="date" name="date_screened" id="date_screened" {{ $data->date_screened}}>
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_signed_treatment_consent">Date Signed Treatment Consent</label>
                                    <input type="date" name="date_signed_treatment_consent" id="date_signed_treatment_consent" value="{{ $data->date_signed_treatment_consentg  }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="effective_from_date">Effective From Date</label>
                                    <input type="date" name="effective_from_date" id="effective_from_date" value="{{ $data->effective_from_date }}"> 
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="effective_to_date">Effective To Date</label>
                                    <input type="date" name="effective_to_date" id="effective_to_date" value="{{  $data->effective_to_date}}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="last_active_treatment_date">Last Active Treatment Date</label>
                                    <input type="date" name="last_active_treatment_date" id="last_active_treatment_date" value="{{ $data->last_active_treatment_date }}">
                                </div>
                            </div>
                
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="last_followup_date">Last Follow-up Date</label>
                                    <input type="date" name="last_followup_date" id="last_followup_date" value="{{ $data->last_followup_date }}">
                                </div>
                            </div>
                
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button">
                                    <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tab-4 -->

               <div id="CCForm4" class="inner-block cctabcontent">
    <div class="inner-block-content">
        <div class="row">
            <div class="sub-head">Approval</div>

            <div class="col-lg-6">
                <div class="group-input">
                    <label for="submitted_by">Enrolled By</label>
                    <div class="static">{{ $data->enrolled_by ?? '' }}</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="group-input">
                    <label for="enrolled_on">Enrolled On</label>
                    <div class="Date">{{ $data->enrolled_on ?? '' }}</div>
                </div>
            </div>

            <div class="sub-head">Close Out</div>

            <div class="col-lg-6">
                <div class="group-input">
                    <label for="withdrawn_by">Withdrawn By</label>
                    <div class="static">{{ $data->withdrawn_by ?? '' }}</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="group-input">
                    <label for="withdrawn_on">Withdrawn On</label>
                    <div class="Date">{{ $data->withdrawn_on ?? '' }}</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="group-input">
                    <label for="closed_by">Closed By</label>
                    <div class="static">{{ $data->closed_by ?? '' }}</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="group-input">
                    <label for="closed_on">Closed On</label>
                    <div class="Date">{{ $data->closed_on ?? '' }}</div>
                </div>
            </div>

            <div class="button-block">
                <button type="submit" class="saveButton">Save</button>
                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                <button type="button">
                    <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
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
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>
@endsection