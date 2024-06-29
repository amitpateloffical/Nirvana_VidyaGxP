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
        / CTA Submission
    </div>
</div>

@php
$users = DB::table('users')->get();
@endphp


{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}

<div id="change-control-view">
    <div class="container-fluid">

        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head">Record Workflow </div>

                <div class="d-flex" style="gap:20px;">

                    @php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => 1])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp

                        <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button>
                        <button class="button_theme1"> <a class="text-white" href="{{ route('cta_submission_audit_trail', $data->id) }}">
                                Audit Trail </a> </button>            
                            
                    @if ($data->stage == 1)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#reject-modal">
                            Notification Only 
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Submission
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                    @elseif($data->stage == 3)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Withdraw
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Finalize Dossier
                        </button>
                    @elseif($data->stage == 4)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
                        </button>
                    @elseif($data->stage == 5)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Approved with Conditions/Comments
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#reject-modal">
                            Approved
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Not Approved
                        </button>
                    @elseif($data->stage == 6)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
                        </button>
                    @elseif($data->stage == 7)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            No Conditions to Fulfill Before FPI
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Conditions to Fulfill Before FPI
                        </button>
                    @elseif($data->stage == 8)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Submit response
                        </button>
                    @elseif($data->stage == 9)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            More Comments
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Early Termination
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#reject-modal">
                            All Conditions/Comments are met
                        </button>
                    @endif

                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                    </a> </button>
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
                        <form action="{{ route('cta_submission_send_stage', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password</label>
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
            <div class="modal fade" id="cancel-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
            
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
            
                        <form action="{{ route('cta_submission_cancel', $data->id) }}" method="POST">
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
            <div class="modal fade" id="reject-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
            
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
            
                        <form action="{{ route('cta_submission_reject', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input mb-3">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>
                                <div class="group-input mb-3">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="group-input mb-3">
                                    <label for="comment">Comment <span class="text-danger">*</span></label>
                                    <input type="comment" class="form-control" name="comment" required>
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
            <div class="modal fade" id="child-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
            
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Child</h4>
                        </div>
                        <form action="{{ route('cta_submission_send_stage', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="group-input">
                                    @if ($data->stage == 4)
                                    <label style="display: flex;" for="major">
                                        <input  type="radio" name="child_type" id="major" value="PSUR">
                                         Re-Submit
                                    </label>
                                    @endif
            
                                    @if ($data->stage == 6)
            
                                    <label for="major">
                                        <input type="radio" name="child_type" id="major" value="PSUR Registration">
                                        Amendment
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
            <div class="status">
                <div class="head">Current Status</div>
                @if ($data->stage == 0)
                    <div class="progress-bars">
                        <div class="bg-danger">Closed-Cancelled</div>
                    </div>
                @elseif ($data->stage == 2)
                    <div class="progress-bars">
                        <div class="bg-danger">Closed - Notified</div>
                    </div>
                @elseif ($data->stage == 4)
                    <div class="progress-bars">
                        <div class="bg-danger">Closed - Withdrawn</div>
                    </div>
                @elseif ($data->stage == 6)
                    <div class="progress-bars">
                        <div class="bg-danger">Closed – Not Approved</div>
                    </div>
                @elseif ($data->stage == 11)
                    <div class="progress-bars">
                        <div class="bg-danger">Closed - Approved</div>
                    </div>
                @else
                    <div class="progress-bars" style="font-size: 15px;">
                        @if ($data->stage >= 1)
                            <div class="active">Opened</div>
                        @else
                            <div class="">Opened</div>
                        @endif

                        @if ($data->stage >= 3)
                            <div class="active">Dossier Finalization</div>
                        @else
                            <div class="">Dossier Finalization</div>
                        @endif

                        @if ($data->stage >= 5)
                            <div class="active">Submitted for Authority</div>
                        @else
                            <div class="">Submitted for Authority</div>
                        @endif

                        @if ($data->stage >= 7)
                            <div class="active">Approved with Comments/
                                Conditions</div>
                        @else
                            <div class="">Approved with Comments/
                                Conditions</div>
                        @endif

                        @if ($data->stage >= 8)
                            <div class="active">Pending Comments</div>
                        @else
                            <div class="">Pending Comments</div>
                        @endif

                        @if ($data->stage >= 9)
                            <div class="active">RA Review of Response to
                                Comments</div>
                        @else
                            <div class="">RA Review of Response to
                                Comments</div>
                        @endif

                        @if ($data->stage >= 10)
                            <div class="bg-danger">Closed - Terminated</div>
                        @else
                            <div class="">Closed - Terminated</div>
                        @endif
                    </div>
                @endif

            {{-- @endif --}}
            {{-- ---------------------------------------------------------------------------------------- --}}
        </div>
    </div>
</div>

<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">CTA Submission</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm2')">CTA Submission Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Root Cause Analysis</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signatures</button>
        </div>

        <form action="{{ route('cta_submission_update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")
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
                                    <label for="Initiator"><b>Record Number</b></label>
                                    <input readonly type="text" name="record" value="{{ Helpers::getDivisionName(session()->get('division')) }}/RCA/{{ Helpers::year($data->created_at) }}/{{ $data->record }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input type="text" readonly name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator_name" value="{{ $data->initiator_name }} ">
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="date_initiation">Date of Initiation <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('d-m-Y') }}" name="intiation_date">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="ShortDescription">Short Description<span class="text-danger">*</span></label>
                                    <input id="ShortDescription" type="text" name="short_description" maxlength="255" required value="{{ $data->short_description }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assigned_to">
                                        <option value="">Select a value</option>
                                        <option value="Pankaj Jat" @if ($data->assigned_to =='Pankaj Jat') selected @endif>Pankaj Jat</option>
                                        <option value="Gaurav" @if ($data->assigned_to =='Gaurav') selected @endif>Gaurav</option>
                                        <option value="Manish" @if ($data->assigned_to =='Manish') selected @endif>Manish</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due_date">Date Due <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"  value="{{ $data->due_date }}" />
                                        <input type="date" value="{{ $data->due_date }}" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Type</label>
                                    <select name="type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="T-1" @if ($data->type =='T-1') selected @endif>T-1</option>
                                        <option value="T-2" @if ($data->type =='T-2') selected @endif>T-2</option>
                                        <option value="T-3" @if ($data->type =='T-3') selected @endif>T-3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="other_type">Other Type</label>
                                    <input type="text" name="other_type" maxlength="255" id="other_type" value="{{ $data->other_type }}"/>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Inv Attachments">Attached Files</label>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="attached_files">
                                            @if ($data->attached_files)
                                                @foreach (json_decode($data->attached_files) as $files)                                                    
                                                    <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $files }}</b>
                                                        <a href="{{ asset('upload/' . $files) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a  type="button" class="remove-file" data-file-name="{{ $files }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            
                                            <input type="file" id="myfile" name="attached_files[]"
                                                oninput="addMultipleFiles(this, 'attached_files')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="description"> Description</label>
                                    <textarea  value="" class="summernote" name="description" id="summernote-16">{{ $data->description }}</textarea>
                                </div>
                            </div>

                            <div class="sub-head">Location</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="zone">Zone</label>
                                    <select name="zone" id="zone">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="P-1" @if ($data->zone =='P-1') selected @endif>P-1</option>
                                        <option value="P-2" @if ($data->zone =='P-2') selected @endif>P-2</option>
                                        <option value="P-3" @if ($data->zone =='P-3') selected @endif>P-3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="country">Country</label>
                                    <select name="country" id="country">
                                        <option value="">Enter Your Selection Here</option>
                                        <option @if ($data->country =='India') selected @endif value="India">India</option>
                                        <option @if ($data->country =='UK') selected @endif value="UK">UK</option>
                                        <option @if ($data->country =='USA') selected @endif value="USA">USA</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="city">City</label>
                                    <select name="city" id="city">
                                        <option value="">Enter Your Selection Here</option>
                                        <option @if ($data->city =='Indore') selected @endif value="Indore">Indore</option>
                                        <option @if ($data->city =='Bhopal') selected @endif value="Bhopal">Bhopal</option>
                                        <option @if ($data->city =='Dewas') selected @endif value="Dewas">Dewas</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="state_district">State/District</label>
                                    <select name="state_district" id="state_district">
                                        <option value="">Enter Your Selection Here</option>
                                        <option @if ($data->state_district =='Dewas') selected @endif value="Dewas">Dewas</option>
                                        <option @if ($data->state_district =='Harda') selected @endif value="Harda">Harda</option>
                                        <option @if ($data->state_district =='Sehore') selected @endif value="Sehore">Sehore</option>
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

                <!-- Tab-2 -->
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Submission Information</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="procedure_number">Procedure Number</label>
                                    <input type="text" maxlength="255" value="{{ $data->procedure_number }}" name="procedure_number" id="procedure_number" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="project_code">Project Code</label>
                                    <input type="text" maxlength="255" value="{{ $data->project_code }}" id="project_code" name="project_code" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="authority_type">Authority Type </label>
                                    <select name="authority_type" id="authority_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option @if ($data->authority_type =='AT-1') selected @endif value="AT-1">AT-1</option>
                                        <option @if ($data->authority_type =='AT-2') selected @endif value="AT-2">AT-2</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="authority">Authority </label>
                                    <select name="authority" id="authority">
                                        <option value="">Enter Your Selection Here</option>
                                        <option @if ($data->authority =='AT-1') selected @endif value="AT-1">AT-1</option>
                                        <option @if ($data->authority =='AT-2') selected @endif value="AT-2">AT-2</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="registration_number">Registration Number</label>
                                    <input type="number" value="{{ $data->registration_number }}" name="registration_number" id="registration_number"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="other_authority">Other Authority</label>
                                    <input type="text" maxlength="255" name="other_authority" id="other_authority" value="{{ $data->other_authority }}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="year">Year </label>
                                    <select name="year" id="year">
                                        <option value="">Enter Your Selection Here</option>
                                        <option @if ($data->year =='2020') selected @endif value="2020">2020</option>
                                        <option @if ($data->year =='2021') selected @endif value="2021">2021</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="procedure_type">Procedure Type</label>
                                    <input type="text" maxlength="255" value="{{ $data->procedure_type }}" name="procedure_type" id="procedure_type"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="registration_status">Registration Status </label>
                                    <select name="registration_status" id="registration_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option @if ($data->registration_status =='Pending') selected @endif value="Pending">Pending</option>
                                        <option @if ($data->registration_status =='Done') selected @endif value="Done">Done</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="outcome"> Outcome </label>
                                    <select name="outcome" id="outcome">
                                        <option value="">Enter Your Selection Here</option>
                                        <option @if ($data->outcome =='O-1') selected @endif value="O-1">O-1</option>
                                        <option @if ($data->outcome =='O-2') selected @endif value="O-2">O-2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="trade_name"> Trade Name </label>
                                    <select name="trade_name" id="trade_name">
                                        <option value="">Enter Your Selection Here</option>
                                        <option @if ($data->trade_name =='T-1') selected @endif value="T-1">T-1</option>
                                        <option @if ($data->trade_name =='T-2') selected @endif value="T-2">T-2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="comments">Comments</label>
                                    <textarea class="summernote" name="comments" id="summernote-16">{{$data->comments}}</textarea>
                                </div>
                            </div>

                            <div class="sub-head">Product Information</div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="manufacturer">Manufacturer</label>
                                    <input type="text" maxlength="255" name="manufacturer" value="{{ $data->manufacturer }}" id="manufacturer"/>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Product/Material(0)
                                    <button type="button" name="audit-agenda-grid" id="productAdd">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="product-Table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Product Name</th>
                                                <th style="width: 16%">Batch Number</th>
                                                <th style="width: 16%">Manufactured Date</th>
                                                <th style="width: 16%">Expiry Date</th>
                                                <th style="width: 15%">Disposition</th>
                                                <th style="width: 15%">Comments</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        {{-- ------------------------------------------ --}}
                                        @if ($newData && is_array($newData))
                                            @foreach ($newData as $gridData)
                                            <tr>
                                            <td><input disabled type="text" name="serial_number_gi[{{ $loop->index }}][serial]" value="{{ $loop->index+1 }}"></td>
                                            <td><input type="text" maxlength="255" name="serial_number_gi[{{ $loop->index }}][info_product_name]" value="{{ isset($gridData['info_product_name']) ? $gridData['info_product_name'] : '' }}"></td>
                                            <td><input type="text" maxlength="255" name="serial_number_gi[{{ $loop->index }}][info_batch_number]" value="{{ isset($gridData['info_batch_number']) ? $gridData['info_batch_number'] : '' }}"></td>
                                            <td>
                                                <div class="new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input
                                                                class="click_date"
                                                                id="date_0_mfg_date"
                                                                type="text"
                                                                name="serial_number_gi[{{ $loop->index }}][info_mfg_date]"
                                                                value="{{ isset($gridData['info_mfg_date']) ? $gridData['info_mfg_date'] : '' }}"
                                                                placeholder="DD-MMM-YYYY"
                                                            />
                                                            <input
                                                                type="date"
                                                                name="serial_number_gi[{{ $loop->index }}][info_mfg_date]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                id="date_0_mfg_date"
                                                                value="{{ isset($gridData['info_mfg_date']) ? $gridData['info_mfg_date'] : '' }}"
                                                                class="hide-input show_date"
                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                oninput="handleDateInput(this, 'date_0_mfg_date')"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input
                                                                class="click_date"
                                                                id="date_0_expiry_date"
                                                                type="text"
                                                                name="serial_number_gi[{{ $loop->index }}][info_expiry_date]"
                                                                value="{{ isset($gridData['info_expiry_date']) ? $gridData['info_expiry_date'] : '' }}"
                                                                placeholder="DD-MMM-YYYY"
                                                            />
                                                            <input
                                                                type="date"
                                                                name="serial_number_gi[{{ $loop->index }}][info_expiry_date]"
                                                                value="{{ isset($gridData['info_expiry_date']) ? $gridData['info_expiry_date'] : '' }}"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                id="date_0_expiry_date"
                                                                class="hide-input show_date"
                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                oninput="handleDateInput(this, 'date_0_expiry_date')"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><input type="text" maxlength="255" name="serial_number_gi[{{ $loop->index }}][info_disposition]" value="{{ isset($gridData['info_disposition']) ? $gridData['info_disposition'] : '' }}"></td>
                                            <td><input type="text" maxlength="255" name="serial_number_gi[{{ $loop->index }}][info_comments]" value="{{ isset($gridData['info_comments']) ? $gridData['info_comments'] : '' }}"></td>
                                            <td><input type="text" maxlength="255" name="serial_number_gi[{{ $loop->index }}][info_remarks]" value="{{ isset($gridData['info_remarks']) ? $gridData['info_remarks'] : '' }}"></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                            <td><input disabled type="text" name="serial_number_gi[0][serial]" value="1"></td>
                                            <td><input type="text" maxlength="255" name="serial_number_gi[0][info_product_name]" value=""></td>
                                            <td><input type="text" maxlength="255" name="serial_number_gi[0][info_batch_number]" value=""></td>
                                            <td>
                                                <div class="new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input
                                                                class="click_date"
                                                                id="date_0_mfg_date"
                                                                type="text"
                                                                name="serial_number_gi[0][info_mfg_date]"
                                                                value=""
                                                                placeholder="DD-MMM-YYYY"
                                                            />
                                                            <input
                                                                type="date"
                                                                name="serial_number_gi[0][info_mfg_date]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                id="date_0_mfg_date"
                                                                value=""
                                                                class="hide-input show_date"
                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                oninput="handleDateInput(this, 'date_0_mfg_date')"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input
                                                                class="click_date"
                                                                id="date_0_expiry_date"
                                                                type="text"
                                                                name="serial_number_gi[0][info_expiry_date]"
                                                                value=""
                                                                placeholder="DD-MMM-YYYY"
                                                            />
                                                            <input
                                                                type="date"
                                                                name="serial_number_gi[0][info_expiry_date]"
                                                                value=""
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                id="date_0_expiry_date"
                                                                class="hide-input show_date"
                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                oninput="handleDateInput(this, 'date_0_expiry_date')"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><input type="text" maxlength="255" name="serial_number_gi[0][info_disposition]" value=""></td>
                                            <td><input type="text" maxlength="255" name="serial_number_gi[0][info_comments]" value=""></td>
                                            <td><input type="text" maxlength="255" name="serial_number_gi[0][info_remarks]" value=""></td>
                                        </tr>
                                        @endif
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            
                            <script>
                                $(document).ready(function() {
                                    let parentDataIndex = {{ $newData && is_array($newData) ? count($newData) : 1 }};
                                    $('#productAdd').click(function(e) {
                                        function generateTableRow(serialNumber) {
                                            var html =
                                                '<tr>' +
                                                '<td><input disabled type="text" name="serial_number_gi[][serial]" value="' + serialNumber + '"></td>' +
                                                '<td><input type="text" maxlength="255" name="serial_number_gi['+ parentDataIndex +'][info_product_name]"></td>' +
                                                '<td><input type="text" maxlength="255" name="serial_number_gi['+ parentDataIndex +'][info_batch_number]"></td>' +
                                                // '<td><input type="date" name="ExpiryDate[]"></td>' +
                                                // '<td><input type="date" name="ManufacturedDate[]"></td>' +
                                                '<td><div class="col-md-6 new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input type="text" id="date_'+ parentDataIndex +'_mfg_date" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="serial_number_gi['+ parentDataIndex +'][info_mfg_date]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="" class="hide-input" oninput="handleDateInput(this, \'date_'+ parentDataIndex +'_mfg_date\')" /></div></div></div></td>' +
                                                '<td><div class="col-md-6 new-date-data-field"> <div class="group-input input-date"> <div class="calenderauditee"><input type="text" id="date_'+ parentDataIndex +'_expiry_date" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="serial_number_gi['+ parentDataIndex +'][info_expiry_date]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="" class="hide-input" oninput="handleDateInput(this, \'date_'+ parentDataIndex +'_expiry_date\')" /></div></div></div></td>' +
                                                '<td><input type="text" maxlength="255" name="serial_number_gi['+ parentDataIndex +'][info_disposition]"></td>' +
                                                '<td><input type="text" maxlength="255" name="serial_number_gi['+ parentDataIndex +'][info_comments]"></td>' +
                                                '<td><input type="text" maxlength="255" name="serial_number_gi['+ parentDataIndex +'][info_remarks]"></td>'+
                                                '</tr>';
                                            '</tr>';
                                            parentDataIndex++;
                                            return html;
                                        }
                            
                                        var tableBody = $('#product-Table tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount + 1);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>

                            <div class="sub-head">Important Dates</div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="actual_submission_date">Actual Submission Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $data->actual_submission_date }}" id="actual_submission_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $data->actual_submission_date }}" name="actual_submission_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'actual_submission_date')" />
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="actual_rejection_date">Actual Rejection Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $data->actual_rejection_date }}" id="actual_rejection_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $data->actual_rejection_date }}" name="actual_rejection_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'actual_rejection_date')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="actual_withdrawn_date">Actual Withdrawn Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $data->actual_withdrawn_date }}" id="actual_withdrawn_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $data->actual_withdrawn_date }}" name="actual_withdrawn_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'actual_withdrawn_date')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="inquiry_date">Inquiry Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $data->inquiry_date }}" id="inquiry_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $data->inquiry_date }}" name="inquiry_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'inquiry_date')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="planned_submission_date">Planned Submission Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $data->planned_submission_date }}" id="planned_submission_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $data->planned_submission_date }}" name="planned_submission_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'planned_submission_date')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="planned_date_sent_to_affilate">Planned Date Sent To Affilate</label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $data->planned_date_sent_to_affilate }}" id="planned_date_sent_to_affilate" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $data->planned_date_sent_to_affilate }}" name="planned_date_sent_to_affilate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'planned_date_sent_to_affilate')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="effective_date">Effective Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $data->effective_date }}" id="effective_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $data->effective_date }}" name="effective_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'effective_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">Persons Involved</div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="additional_assignees">Additional Assignees</label>
                                    <select name="additional_assignees" id="additional_assignees">
                                        <option value="">--Select---</option>
                                        <option @if ($data->additional_assignees =='Pankaj') selected @endif value="Pankaj">Pankaj</option>
                                        <option @if ($data->additional_assignees =='Gaurav') selected @endif value="Gaurav">Gaurav</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="additional_investigators">Additional Investigators</label>
                                    <select id="additional_investigators" name="additional_investigators">
                                        <option value="">--Select---</option>
                                        <option @if ($data->additional_investigators =='Pankaj') selected @endif value="Pankaj">Pankaj</option>
                                        <option @if ($data->additional_investigators =='Gaurav') selected @endif value="Gaurav">Gaurav</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="approvers">Approvers</label>
                                    <select id="approvers" name="approvers">
                                        <option value="">--Select---</option>
                                        <option @if ($data->approvers =='Pankaj') selected @endif value="Pankaj">Pankaj</option>
                                        <option @if ($data->approvers =='Gaurav') selected @endif value="Gaurav">Gaurav</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="negotiation_team">Negotiation Team</label>
                                    <select id="negotiation_team" name="negotiation_team">
                                        <option value="">--Select---</option>
                                        <option @if ($data->negotiation_team =='Pankaj') selected @endif value="Pankaj">Pankaj</option>
                                        <option @if ($data->negotiation_team =='Gaurav') selected @endif value="Gaurav">Gaurav</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="trainer">Trainer</label>
                                    <input type="text" maxlength="255" name="trainer" value="{{ $data->trainer }}" />
                                </div>
                            </div>

                            <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab-3 -->

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">


                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="root_cause_description">Root Cause Description</label>
                                    <textarea class="summernote" name="root_cause_description" id="summernote-16">{{ $data->root_cause_description }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="reason_for_non_approval">Reason(s) For Non-Approval</label>
                                    <textarea class="summernote" name="reason_for_non_approval" id="summernote-16">{{ $data->reason_for_non_approval }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="reason_for_withdrawal">Reason(s) For Withdrawal</label>
                                    <textarea class="summernote" name="reason_for_withdrawal" id="summernote-16">{{ $data->reason_for_withdrawal }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="justification_rationale">Justification/Rationale</label>
                                    <textarea class="summernote" name="justification_rationale" id="summernote-16">{{ $data->justification_rationale }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="meeting_minutes">Meeting Minutes</label>
                                    <textarea class="summernote" name="meeting_minutes" id="summernote-16">{{ $data->meeting_minutes }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="rejection_reason">Rejection Reason</label>
                                    <textarea class="summernote" name="rejection_reason" id="summernote-16">{{ $data->rejection_reason }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="effectiveness_check_summary">Effectiveness Check Summary</label>
                                    <textarea class="summernote" name="effectiveness_check_summary" id="summernote-16">{{ $data->effectiveness_check_summary }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="decisions">Decisions</label>
                                    <textarea class="summernote" name="decisions" id="summernote-16">{{ $data->decisions }}</textarea>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="group-input">
                                    <label class="mt-4" for="summary"> Summary</label>
                                    <textarea class="summernote" name="summary" id="summernote-16">{{ $data->summary }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="documents_affected">Documents Affected </label>
                                    <select id="documents_affected" name="documents_affected">
                                        <option value="">--Select---</option>
                                        <option @if ($data->documents_affected =='Pankaj') selected @endif value="Pankaj">Pankaj</option>
                                        <option @if ($data->documents_affected =='Gaurav') selected @endif value="Gaurav">Gaurav</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="actual_time_spent">Actual Time Spent</label>
                                    <input type="text" maxlength="255" name="actual_time_spent" id="actual_time_spent" value="{{ $data->actual_time_spent }}" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="documents">Documents</label>
                                    <input type="text" maxlength="255" name="documents" id="documents"  value="{{ $data->documents }}"/>
                                </div>
                            </div>

                            <div class="button-block">                                
                            <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab-4 -->

                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Submission By</label>
                                    <div class="static">{{ $data->submission_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Submission On</label>
                                    <div class="Date">{{ $data->submission_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Submission Comment</label>
                                    <div class="static">{{ $data->submission_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Withdraw By</label>
                                    <div class="static">{{ $data->withdraw_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Withdraw On</label>
                                    <div class="Date">{{ $data->withdraw_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Withdraw Comment</label>
                                    <div class="static">{{ $data->withdraw_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Finalize Dossier By</label>
                                    <div class="static">{{ $data->finalize_dossier_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Finalize Dossier On</label>
                                    <div class="Date">{{ $data->finalize_dossier_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Finalize Dossier Comment</label>
                                    <div class="static">{{ $data->finalize_dossier_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Notification By</label>
                                    <div class="Date">{{ $data->notification_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Notification On</label>
                                    <div class="static">{{ $data->notification_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Notification Comment</label>
                                    <div class="static">{{ $data->notification_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Cancelled By</label>
                                    <div class="static">{{ $data->cancelled_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Cancelled On</label>
                                    <div class="Date">{{ $data->cancelled_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Cancelled Comment</label>
                                    <div class="static">{{ $data->cancelled_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Not Approved By</label>
                                    <div class="static">{{ $data->not_approved_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Not Approved On</label>
                                    <div class="Date">{{ $data->not_approved_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Not Approved Comment</label>
                                    <div class="static">{{ $data->not_approved_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Approved with Conditions By</label>
                                    <div class="static">{{ $data->approved_with_conditions_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Approved with Conditions On</label>
                                    <div class="Date">{{ $data->approved_with_conditions_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Approved with Conditions Comment</label>
                                    <div class="static">{{ $data->approved_with_conditions_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Approved By</label>
                                    <div class="static">{{ $data->approved_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Approved On</label>
                                    <div class="Date">{{ $data->approved_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Approved Comment</label>
                                    <div class="static">{{ $data->approved_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Conditions to Fulfill Before
                                        FPI By</label>
                                    <div class="static">{{ $data->conditions_to_fulfill_before_FPI_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Conditions to Fulfill Before
                                        FPI On</label>
                                    <div class="Date">{{ $data->conditions_to_fulfill_before_FPI_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Conditions to Fulfill Before
                                        FPI Comment</label>
                                    <div class="static">{{ $data->conditions_to_fulfill_before_FPI_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">More Comments By</label>
                                    <div class="static">{{ $data->more_comments_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">More Comments On</label>
                                    <div class="Date">{{ $data->more_comments_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">More Comments</label>
                                    <div class="static">{{ $data->more_comments }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Submit response By</label>
                                    <div class="static">{{ $data->submit_response_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Submit response On</label>
                                    <div class="Date">{{ $data->submit_response_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Submit response Comment</label>
                                    <div class="static">{{ $data->submit_response_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Early Termination By</label>
                                    <div class="static">{{ $data->early_termination_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Early Termination On</label>
                                    <div class="Date">{{ $data->early_termination_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Early Termination Comment</label>
                                    <div class="static">{{ $data->early_termination_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">All Conditions
                                        are met By</label>
                                    <div class="static">{{ $data->all_conditions_are_met_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">All Conditions
                                        are met On</label>
                                    <div class="Date">{{ $data->all_conditions_are_met_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">All Conditions
                                        are met - Comment</label>
                                    <div class="static">{{ $data->all_conditions_are_met_comment }}</div>
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