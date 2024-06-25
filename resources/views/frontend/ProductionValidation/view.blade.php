
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
    .input_width {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 11px;
        }

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(1) {
        border-radius: 20px 0px 0px 20px;
    }

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(9) {
        border-radius: 0px 20px 20px 0px;

    }
</style>

<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / First Production Validation
    </div>
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
                    {{-- @php
                        $userRoles = DB::table('user_roles')
                            ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' =>$data->division_id])->get();

                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp --}}

                    @php
                    $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id])->get();
                    $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                @endphp

                    {{-- <button class="button_theme1" onclick="window.print();return false;"
                        class="new-doc-btn">Print</button> --}}
                    <button class="button_theme1"> <a class="text-white" href="{{route('ProductionAuditTrialDetails', $data->id)}} ">


                            {{-- add here url for auditTrail i.e. href="{{ url('CapaAuditTrial', $data->id) }}" --}}
                            Audit Trail </a> </button>
                            <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>

                     @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Submit
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Cancel
                    </button>
                    @elseif($data->stage == 2 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Schedule & Send Sample
                    </button>

                    @elseif($data->stage == 3 && (in_array(24, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#RejectStateChanges">
                        Reject Sample
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#">
                        Recall Product
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signatures-modal">
                        Approve Sample
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Send For Analysis
                    </button>
                    @elseif($data->stage == 4 &&(in_array(24, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))
                    {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                        Closed - Done
                    </button> --}}
                    <button class="button_theme1"> <a class="text-white" href="#"> Child
                    </a> </button>

                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signaturess-modal">
                        Recall Closed
                    </button>
                     <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>


                        @elseif($data->stage == 6 && (in_array(24, $userRoleIds) || in_array(18, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signaturess-modal">
                            Analyze
                        </button>

                    @elseif($data->stage == 5 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signaturess-modal">
                        Release
                    </button>


@elseif($data->stage == 7 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
<button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signaturess-modal">
    Start Production
</button>

@endif
                </div>
            </div>

{{-- =============================================================================================================== --}}
            <div class="status">
                <div class="head">Current Status</div>
                @if ($data->stage == 0)
                <div class="progress-bars ">
                    <div class="bg-danger">Closed-Cancelled</div>
                </div>

                @else
               <div class="progress-bars d-flex" style="font-size: 15px;">
                    @if ($data->stage >= 1)
                    <div class="active">Opened</div>
                    @else
                    <div class="">Opened</div>
                    @endif

                    @if ($data->stage >= 2)
                    <div class="active">Pending Scheduling & Sample</div>
                    @else
                    <div class="">Pending Scheduling & Sample</div>
                    @endif


                    @if ($data->stage >= 3)
                    <div class="active">Pending Samples Validation</div>
                    @else
                    <div class="">Pending Samples Validation</div>
                    @endif

                    @if ($data->stage >= 4)
                    <div class="active">Product Recalled</div>
                    @else
                    <div class="">Product Recalled</div>
                    @endif
                    @if ($data->stage >= 5)
                    <div class="active">Pending Product Release</div>
                    @else
                    <div class="">Pending Product Release</div>

@endif
                    @if ($data->stage >= 6)
                    <div class="active">Pending Analysis</div>
                    @else
                    <div class="">Pending Analysis</div>
@endif


@if ($data->stage >= 7)
<div class="active">Product Released</div>
@else
<div class="">Product Released</div>
@endif
@if ($data->stage == 8 && $data->stage < 9)
<div class="bg-danger">Closed - Recalled</div>
@elseif ($data->stage < 8)
<div class="">Closed - Recalled</div>
@endif

@if ($data->stage == 9)
<div class="bg-danger">Closed - Done</div>
@elseif ($data->stage < 9 && $data->stage != 8)
<div class="">Closed - Done</div>
@endif




{{-- New logic Deed for Buttons Hide --}}





               </div>

                    @endif
                </div>



                    {{-- <div class="progress-bars d-flex" style="font-size: 15px;">
                        <div class="{{ $data->stage >= 1 ? 'active' : '' }}">Opened</div>

                        <div class="{{ $data->stage >= 2 ? 'active' : '' }}">Submission Preparation</div>

                        <div class="{{ $data->stage >= 3 ? 'active' : '' }}">Pending Submission Review</div>

                        <div class="{{ $data->stage >= 4 ? 'active' : '' }}">Authority Assessment</div>

                        @if ($data->stage == 5)
                            <div class="bg-danger">Closed - Withdrawn</div>
                        @elseif ($data->stage == 6)
                            <div class="bg-danger">Closed - Not Approved</div>
                        @elseif ($data->stage == 8)
                            <div class="bg-danger">Approved</div>
                        @elseif ($data->stage == 9)
                            <div class="bg-danger">Closed - Retired</div>
                        @else
                            <div class="{{ $data->stage >= 7 ? 'active' : '' }}">Pending Registration Update</div>
                        @endif
                    </div>
                @endif --}}

                {{-- </div>
              @endif
                ---------------------------------------------------------------------------------------- --}}
                {{-- @if ($renewal->stage == 5)
                            <div class="bg-danger">Closed - Withdrawn</div>
                        @elseif ($renewal->stage == 6)
                            <div class="bg-danger">Closed - Not Approved</div>
                        @elseif ($renewal->stage == 8)
                            <div class="bg-danger">Approved</div>
                        @elseif ($renewal->stage == 9)
                            <div class="bg-danger">Closed - Retired</div>
                        @else
                            <div class="{{ $renewal->stage >= 7 ? 'active' : '' }}">Pending Registration Update</div>
                        @endif --}}
            </div>
















        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">First Production Validation</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Validation Information</button>

            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Activity Log</button>
        </div>

        <form action="{{ route('ProductionValidationfollow.update' , $data->id) }}" method="post" enctype="multipart/form-data">
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

                        <div class="sub-head">General Information</div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Originator"><b>Record Number</b></label>
                                 <input type="text" name="record_number" value="{{ Helpers::getDivisionName(session()->get('division')) }}/PV/{{ date('Y') }}/{{ $data->record }}">


                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Originator"><b>Division Id</b></label>
                                <input readonly type="text" name="division_id" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                <input type="hidden" name="division_id" value="{{ session()->get('division') }}">


                            </div>
                        </div>


                            <div class="col-lg-6">
                                <div class="group-input">

                                    <label for="Originator"><b>Initiator</b></label>
                                    <input type="text" name="initiator_id" value="{{ $validation->initiator_id ?? Auth::user()->name }}">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date Of Initiation</b></label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="date_of_initiation">
                                    <input type="hidden" value="" name="date_of_initiation">

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">


                                    <label for="Short Description">Product<span class="text-danger">*</span></label>
                                    <input id="docname" type="text" name="product"   value = "{{$data->product}}" maxlength="255" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description"  value = "{{ $data->short_description }}"   maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="">Select a value</option>
                                        <option value="Vibha" @if (isset($data->assign_to) && $data->assign_to == 'Vibha') selected @endif>Vibha</option>
                                        <option value="Shruti" @if (isset($data->assign_to) && $data->assign_to == 'Shruti') selected @endif>Shruti</option>
                                        <option value="Monika" @if (isset($data->assign_to) && $data->assign_to == 'Monika') selected @endif>Monika</option>

                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">

                                    <label for="due-date">Date Due <span class="text-danger"></span></label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input type="text"    value="{{ date('d-M-Y') }}" name="due_date" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                            oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Type Of Product</label>
                                    <select name="product_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if (isset($data->product_type) && $data->product_type == '1') selected @endif>1</option>
                                        <option value="2" @if (isset($data->product_type) && $data->product_type == '2') selected @endif>2</option>
                                        <option value="3" @if (isset($data->product_type) && $data->product_type == '3') selected @endif>3</option>


                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Priority Level</label>
                                    <select name="priority_level">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if (isset($data->priority_level) && $data->priority_level == '1') selected @endif>1</option>
                                        <option value="2" @if (isset($data->priority_level) && $data->priority_level == '2') selected @endif>2</option>
                                        <option value="3" @if (isset($data->priority_level) && $data->priority_level == '3') selected @endif>3</option>


                                    </select>
                                </div>
                            </div>



                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Actions">Description<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="discription"> {{$data->discription}}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Comments</label>
                                    <textarea   name="comments" >{{$data->comments}}</textarea>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">

                                    <label for="Inv Attachments">File Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="attachment">
                                            @if ($data->attachment)
                                                @foreach(json_decode($data->attachment) as $file)
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
                                            <input type="file" id="HOD_Attachments" name=" file_attachment"
                                                oninput="addMultipleFiles(this, 'attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Related Record</label>
                                    <select name="related_record">
                                        <option value="">Enter Your Selection Here</option>

                                        <option value="1" @if (isset($data->related_record) && $data->related_record == '1') selected @endif>1</option>
                                        <option value="2" @if (isset($data->related_record) && $data->related_record == '2') selected @endif>2</option>
                                        <option value="3" @if (isset($data->related_record) && $data->related_record == '3') selected @endif>3</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Reference Recores"> Related Url</label>
                                    <select name="related_url">
                                        <option value="">Enter Your Selection Here</option>

                                        <option value="Ankit" @if (isset($data->related_url) && $data->related_url == 'Ankit') selected @endif>Ankit</option>
                                        <option value="Rohit" @if (isset($data->related_url) && $data->related_url == 'Rohit') selected @endif>Rohit</option>
                                        <option value="Ank" @if (isset($data->related_url) && $data->related_url == 'Ank') selected @endif>Ankit</option>

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
                        <div class="sub-head">
                            Sample Information
                        </div>
                        <div class="row">
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Sample Scheduled To</label>
                                    <div class="calenderauditee">
                                        <input type="text"    value="{{ date('d-M-Y') }}" name="start_date" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="start_date" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')"     />
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Sample details<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="sample_details">{{$data->sample_details}}</textarea>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Sample Validation Summary<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="validation_summary">{{$data->validation_summary}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Send to external lab?</label>
                                    <select name="externail_lab">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Actions">Lab Comments<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="lab_commnets">{{$data->lab_commnets}}</textarea>
                                </div>
                            </div>

                        </div>







                        <div class="row">
                            <div class="sub-head">Product Status Information</div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Actions">Product Release Summary<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="product_release">{{$data->product_release}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Actions">Product Recall Details<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="product_recelldetails">{{$data->product_recelldetails}}</textarea>
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
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Submitted By">Submit By</label>
                                    <div class="static">{{ $data->acknowledge_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Submitted On">Submit On</label>
                                    <div class="Date">{{ $data->acknowledge_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Incident Review Completed By">Schedule & Send Sample
                                        By</label>
                                    <div class="static">{{ $data->Schedule_Send_Sample_by }} </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Incident Review Completed On">Schedule & Send Sample
                                        On</label>
                                    <div class="Date">{{ $data->Schedule_Send_Sample_on }} </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Investigation Completed By">Reject Sample By</label>
                                    <div class="static">{{ $data->Reject_Sample_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Investigation Completed On">Reject Sample On</label>
                                    <div class="Date">{{ $data->Reject_Sample_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA Review Completed By">Send For Analysis By</label>
                                    <div class="static">{{ $data->Send_For_Analysis_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA Review Completed On">Send For Analysis On</label>
                                    <div class="Date">{{ $data->Send_For_Analysis_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA Head Approval Completed By">Approve Sample By</label>
                                    <div class="static">{{ $data->Approve_Sample_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA Head Approval Completed On">Approve Sample On</label>
                                    <div class="Date">{{ $data->Approve_Sample_on }}</div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="All Activities Completed By">Release By</label>
                                    <div class="static">{{ $data->Release_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="All Activities Completed On">Release On</label>
                                    <div class="Date">{{ $data->Release_on }}</div>
                                </div>
                            </div>
                             <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Review Completed By">Start Production By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Review Completed On">Start Production on</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled By">Analyze By</label>
                                    <div class="static">{{ $data->Analyzee_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled On">Analyze On</label>
                                    <div class="Date">{{ $data->Analyzee_on }}</div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="All Activities Completed By">All Activities Completed By</label>
                                    <div class="static">{{ $data->all_activities_completed_by }}</div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="All Activities Completed On">All Activities Completed On</label>
                                    <div class="Date">{{ $data->all_activities_completed_on }}</div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Review Completed By">Review Completed By</label>
                                    <div class="static">{{$data->review_completed_by}}</div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Review Completed On">Review Completed On</label>
                                    <div class="Date">{{$data->review_completed_on}}</div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="submit" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }}>Submit</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
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
            <form action="{{ route('production_send_stage', $data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-3 text-justify">
                        Please select a meaning and a outcome for this task and enter your username
                        and password for this task. You are performing an electronic signature,
                        which is legally binding equivalent of a hand written signature.
                    </div>
                    <div class="group-input">
                        <label for="username">Username  <span
                            class="text-danger">*</span></label>
                        <input type="text" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password  <span
                            class="text-danger">*</span></label>
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

<div class="modal fade" id="RejectStateChanges">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('rejectstateproductionValidation', $data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-3 text-justify">
                        Please select a meaning and a outcome for this task and enter your username
                        and password for this task. You are performing an electronic signature,
                        which is legally binding equivalent of a hand written signature.
                    </div>
                    <div class="group-input">
                        <label for="username">Username  <span
                            class="text-danger">*</span></label>
                        <input type="text" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password  <span
                            class="text-danger">*</span></label>
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
<div class="modal fade" id="signaturess-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('renewal_forword2_close', $data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-3 text-justify">
                        Please select a meaning and a outcome for this task and enter your username
                        and password for this task. You are performing an electronic signature,
                        which is legally binding equivalent of a hand written signature.
                    </div>
                    <div class="group-input">
                        <label for="username">Username  <span
                            class="text-danger">*</span></label>
                        <input type="text" class="input_width" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password  <span
                            class="text-danger">*</span></label>
                        <input type="password" class="input_width" name="password" required>
                    </div>
                    <div class="group-input">
                        <label for="comment">Comment</label>
                        <input type="comment" class="input_width" name="comment">
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

<div class="modal fade" id="rejectstateproductionValidation2">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('rejectstateproductionValidation2', $data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-3 text-justify">
                        Please select a meaning and a outcome for this task and enter your username
                        and password for this task. You are performing an electronic signature,
                        which is legally binding equivalent of a hand written signature.
                    </div>
                    <div class="group-input">
                        <label for="username">Username  <span
                            class="text-danger">*</span></label>
                        <input type="text" class="input_width" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password  <span
                            class="text-danger">*</span></label>
                        <input type="password" class="input_width" name="password" required>
                    </div>
                    <div class="group-input">
                        <label for="comment">Comment</label>
                        <input type="comment" class="input_width" name="comment">
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

<div class="modal fade" id="signatures-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('renewal_forword_close', $data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-3 text-justify">
                        Please select a meaning and a outcome for this task and enter your username
                        and password for this task. You are performing an electronic signature,
                        which is legally binding equivalent of a hand written signature.
                    </div>
                    <div class="group-input">
                        <label for="username">Username  <span
                            class="text-danger">*</span></label>
                        <input type="text" class="input_width" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password  <span
                            class="text-danger">*</span></label>
                        <input type="password" class="input_width" name="password" required>
                    </div>
                    <div class="group-input">
                        <label for="comment">Comment</label>
                        <input type="comment" class="input_width" name="comment">
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


































































































