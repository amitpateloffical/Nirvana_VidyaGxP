@extends('frontend.layout.main')
@section('container')

<style>
textarea.note-codable {
    display: none !important;
}

header {
    display: none;
}


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

#change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(9) {
    border-radius: 0px 20px 20px 0px;

}
</style>

@php

$user=DB::table('users')->get();
@endphp
<!-- <div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / CTA Subject
    </div>


</div> -->

<!---<script>
    function addMultipleFiles(input, fieldName) {
    const fileList = document.getElementById('File_Attachment');
    fileList.innerHTML = ''; // Clear previous file list

    for (const file of input.files) {
    const fileItem = document.createElement('div');
    fileItem.textContent = file.name;
    fileList.appendChild(fileItem);
    }
    }
    </script>-->

<div class="form-field-head">

    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        {{ Helpers::getDivisionName(session()->get('division')) }} / Subject
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
                    @php
                    $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' =>
                    7])->get();
                    $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp

                    <button class="button_theme1"> <a class="text-white"
                            href="{{ url('Subject/auditReport', $openState->id) }}"> Audit Trail </a> </button>

                    @if ($openState->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Submit
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Cancel
                    </button>
                    @elseif($openState->stage == 2 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                        Child
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Close
                    </button>

                    @endif
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>
                </div>
            </div>


            <div class="status">
                <div class="head">Current Status</div>
                @if ($openState->stage == 0)
                <div class="progress-bars">
                    <div class="bg-danger">Closed-Cancelled</div>
                </div>

                @else
                <div class="progress-bars d-flex" style="font-size: 15px;">
                    @if ($openState->stage >= 1)
                    <div class="active">Opened</div>
                    @else
                    <div class="">Opened</div>
                    @endif

                    @if ($openState->stage >= 2)
                    <div class="active">Active</div>
                    @else
                    <div class="">Active</div>
                    @endif


                    @if ($openState->stage >= 3)
                    <div class="bg-danger">Closed-Done</div>
                    @else
                    <div class="">Closed-Done</div>
                    @endif
                    {{-- @endif --}}
                </div>
                @endif
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Subject</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm2')">Additional Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Important Dates</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signatures</button>
        </div>
        <script>
        $(document).ready(function() {
            <?php if (in_array($openState->stage, [3])) : ?>
            $("#target :input").prop("disabled", true);
            <?php endif; ?>
        });
        </script>


        <form id="target" action="{{ route('subjectUpdate',$openState->id)}}" method="POST"
            enctype="multipart/form-data">

            @csrf


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
                                    <label for="Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number"
                                        value="{{ Helpers::getDivisionName($openState->division)}}/SUB/{{Helpers::year($openState->create_at)}}/{{$openState->record }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Site Location"><b>Site/Location Code</b></label>
                                    <input disabled type="text" name="division_code"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator_name " value="{{ Auth::user()->name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date of Initiation"><b>Date Of Initiation</b></label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="initiation_date">
                                    <input type="hidden" value="{{ date('d-m-Y') }}" name="initiation_date">

                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span
                                            class="text-danger">*</span></label>
                                    <p>255 characters remaining</p>
                                    <input id="docname" type="text" name="short_description" maxlength="255"
                                        value="{{ $openState->short_description }}" required>
                                </div>
                            </div>

                            <div class=" col-lg-6">
                                <div class=" group-input">
                                    <label for="phase_of_study">
                                        (Parent) Phase of Study
                                    </label>
                                    <select id="select-state" name="phase_of_study">
                                        <option value="one" @if ($openState->phase_of_study == 'one') selected
                                            @endif>one
                                        </option>
                                        <option value="two" @if ($openState->phase_of_study == 'two') selected
                                            @endif>two
                                        </option>
                                        <option value="three" @if ($openState->phase_of_study == 'three') selected
                                            @endif>three
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reference Recores"> (Parent) Study Num</label>
                                    <input type="text" name="study_Num" value="{{ $openState->study_Num}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="assign_to">
                                        Assigned To
                                    </label>
                                    <select id="select-state" name="assign_to">
                                        <option value="">Select a value</option>
                                        @foreach ($user as $users)
                                        <option {{ $openState->assign_to == $users->name ? 'selected' : '' }}
                                            value="{{ $users->name }}">
                                            {{ $users->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due <span class="text-danger"></span></label>
                                    <div><small class="text-primary">Please mention expected date of
                                            completion</small>
                                    </div>

                                    <div class="calenderauditee">
                                        <input readonly type="text" name="due_date" value="{{$openState->due_date}}" />
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closure attachment">Attached Files </label>
                                    <div>
                                        <small class="text-primary"></small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="File_Attachment">
                                            @if (!empty($openState->file_attach) &&
                                            is_array(json_decode($openState->file_attach)))
                                            @foreach(json_decode($openState->file_attach) as $file)
                                            <h6>
                                                <b>{{ $file }}</b>
                                                <a href=" {{ asset('upload/' . $file) }}" target="_blank">
                                                    <i class="fa fa-eye text-primary"
                                                        style="font-size:20px; margin-right:-10px;"></i>
                                                </a>
                                            </h6>
                                            @endforeach
                                            @endif
                                        </div>
                                        <!-- <div class="file-attachment-list" id="File_Attachment"></div> -->
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="File_Attachment" name="file_attach[]"
                                                oninput="addMultipleFiles(this, 'File_Attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=" col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Related URLs</label>
                                    <select name="related_urls">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="P-1" @if ($openState->related_urls == 'P-1') selected
                                            @endif>P-1
                                        </option>
                                        <option value="P-2" @if ($openState->related_urls == 'P-2') selected
                                            @endif>P-2
                                        </option>
                                        <option value="P-3" @if ($openState->related_urls == 'P-3') selected
                                            @endif>P-3
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Description</label>
                                    <textarea class="summernote" name="Description_Batch"
                                        id="summernote-16">{{ $openState->Description_Batch }}"</textarea>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Actual Cost </label>
                                    <input type="text" id="actual_cost" name="actual_cost"
                                        value="{{ $openState->actual_cost }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Currency</label>
                                    <select name="currency">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Dollar" @if ($openState->currency == 'Dollar') selected
                                            @endif>Dollar
                                        </option>
                                        <option value="Rupees" @if ($openState->currency == 'Rupees') selected
                                            @endif>Rupees
                                        </option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Comments</label>
                                    <textarea class="summernote" name="Comments_Batch"
                                        id="summernote-16">"{{ $openState->Comments_Batch}}"</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="closure attachment">Source Documents </label>
                                    <div><small class="text-primary">
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="source_Attachment">
                                            @if (!empty($openState->document_attach) &&
                                            is_array(json_decode($openState->document_attach)))
                                            @foreach(json_decode($openState->document_attach) as $file)
                                            <h6>
                                                <b>{{ $file }}</b>
                                                <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                    <i class="fa fa-eye text-primary"
                                                        style="font-size:20px; margin-right:-10px;"></i>
                                                </a>
                                            </h6>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="source_Attachment" name="document_attach[]">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class=" sub-head">Parent Information
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Subject Name</label>
                                    <input type="text" name="subject_name" value="{{ $openState->subject_name }}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Subject Name</label>
                                    <input type="date" name="subject_date" value="{{ $openState->subject_date }}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Gender</label>
                                    <select name="gender">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="male" @if ($openState->gender == 'male') selected @endif>Male
                                        </option>
                                        <option value="female" @if ($openState->gender == 'female') selected
                                            @endif>Female
                                        </option>
                                        <option value="others" @if ($openState->gender == 'others') selected
                                            @endif>Others
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Race</label>
                                    <select name="race">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="R-1" @if ($openState->race == 'R-1') selected
                                            @endif>R-1</option>
                                        <option value="R-2" @if ($openState->race == 'R-2') selected @endif>R-2
                                        </option>
                                        <option value="R-3" @if ($openState->race == 'R-2') selected @endif>R-3
                                        </option>
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
                                    <label for="Type">Screened Successfully? </label>
                                    <select name="screened_successfully">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="AT-1" @if ($openState->screened_successully == 'AT-1')
                                            selected
                                            @endif>AT-1
                                        </option>
                                        <option value="AT-2" @if ($openState->screened_successully == 'AT-2')
                                            selected @endif>AT-2</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Reason For Discontinuation </label>
                                    <select name="discontinuation">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="AT-1" @if ($openState->discontinuation == 'AT-1') selected
                                            @endif>AT-1
                                        </option>
                                        <option value="AT-2" @if ($openState->discontinuation == 'AT-2') selected
                                            @endif>AT-2
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments">Comments</label>
                                    <textarea class="summernote" name="Disposition_Batch"
                                        id="summernote-16">{{ $openState->Disposition_Batch}}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Treatment Consent Version</label>
                                    <input type="text" name="treatment_consent"
                                        value="{{ $openState->treatment_consent }}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Screening Consent Version</label>
                                    <input type="text" name="screening_consent"
                                        value="{{ $openState->screening_consent }}" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Type">Exception Number </label>
                                    <input type="text" name="exception_no" value="{{ $openState->exception_no }}" />
                                </div>
                            </div>

                            <div class=" col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Signed Consent Form </label>
                                    <select name="signed_consent">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="01" @if ($openState->signed_consent == '01') selected
                                            @endif>01
                                        </option>
                                        <option value="02" @if ($openState->signed_consent == '02') selected
                                            @endif>02
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Time Point </label>
                                    <select name="time_point">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="T-1" @if ($openState->time_point == 'T-1') selected
                                            @endif>T-1
                                        </option>
                                        <option value="T-2" @if ($openState->time_point == 'T-2') selected
                                            @endif>T-2
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments">Family History</label>
                                    <textarea class="summernote" name="family_history"
                                        id="summernote-16">{{ $openState->family_history }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments">Baseline
                                        Assessment</label>
                                    <textarea class="summernote" name="Baseline_assessment"
                                        id="summernote-16">{{ $openState->Baseline_assessment}}</textarea>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Representive </label>
                                    <input type="text" name="representive" value="{{ $openState->representive}}" />
                                </div>
                            </div>


                            <div class="sub-head">Location</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Zone</label>
                                    <select name="zone">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="P-1" @if ($openState->Zone == 'P-1') selected
                                            @endif>P-1
                                        </option>
                                        <option value="P-2" @if ($openState->Zone == 'P-2') selected
                                            @endif>P-2
                                        </option>
                                        <option value="P-3" @if ($openState->Zone == 'P-3') selected
                                            @endif>P-3
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Country</label>
                                    <select name="country">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="India" @if ($openState->country == 'India') selected
                                            @endif>India
                                        </option>
                                        <option value="UK" @if ($openState->country == 'UK') selected
                                            @endif>UK
                                        </option>
                                        <option value="USA" @if ($openState->country == 'USA') selected
                                            @endif>USA
                                        </option>
                                    </select>
                                </div>
                            </div>




                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">City</label>
                                    <select name="city">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Indore" @if ($openState->city == 'Indore') selected
                                            @endif>Indore
                                        </option>
                                        <option value="Bhopal" @if ($openState->city == 'Bhopal') selected
                                            @endif>Bhopal
                                        </option>
                                        <option value="Dewas" @if ($openState->city == 'Dewas') selected
                                            @endif>Dewas
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">State/District</label>
                                    <select name="district">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Dewas" @if ($openState->district == 'Dewas') selected
                                            @endif>Dewas
                                        </option>
                                        <option value="Harda" @if ($openState->district == 'Harda') selected
                                            @endif>Harda
                                        </option>
                                        <option value="Sehore" @if ($openState->district== 'sehore') selected
                                            @endif>Sehore
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Site Name</label>
                                    <select name="site">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Indore" @if ($openState->site == 'Indore') selected
                                            @endif>Indore
                                        </option>
                                        <option value="Bhopal" @if ($openState->site == 'Bhopal') selected
                                            @endif>Bhopal
                                        </option>
                                        <option value="Dewas" @if ($openState->site == 'Dewas') selected
                                            @endif>Dewas
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Building</label>
                                    <select name="building">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($openState->building == '1') selected
                                            @endif>1
                                        </option>
                                        <option value="2" @if ($openState->building == '2') selected
                                            @endif>2
                                        </option>
                                        <option value="3" @if ($openState->building == '3') selected
                                            @endif>3
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Floor</label>
                                    <select name="floor">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($openState->floor == '1') selected
                                            @endif>1
                                        </option>
                                        <option value="2" @if ($openState->floor == '2') selected
                                            @endif>2
                                        </option>
                                        <option value="3" @if ($openState->floor == '3') selected
                                            @endif>3
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Room</label>
                                    <select name="room">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($openState->room == '1') selected
                                            @endif>1
                                        </option>
                                        <option value="2" @if ($openState->room == '2') selected
                                            @endif>2
                                        </option>
                                        <option value="3" @if ($openState->room == '3') selected
                                            @endif>3
                                        </option>
                                    </select>
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


                            <div class="sub-head">Important Dates</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Consent Form Signed On </label>
                                    <input type="date" name="consent_form" value="{{ $openState->consent_form }}" />
                                </div>
                            </div>

                            <div class=" col-lg-6">
                                <div class="group-input">
                                    <label for="Type"> Date Granted</label>
                                    <input type="date" name="date_granted" value="{{ $openState->date_granted}}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type"> System Start Date</label>
                                    <input type="date" name="system_start" value="{{ $openState->system_start }}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Consent Form Signed Date </label>
                                    <input type="date" name="consent_form_date"
                                        value="{{ $openState->consent_form_date }}" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type"> Date Of First Treatment</label>
                                    <input type="date" name="first_treatment"
                                        value="{{ $openState->first_treatment }}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Date Requested</label>
                                    <input type="date" name="date_requested" value="{{ $openState->date_requested }}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Date Screened </label>
                                    <input type="date" name="date_screened" value="{{ $openState->date_screened }}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type"> Date Signed Treatment Consent</label>
                                    <input type="date" name="date_signed_treatment"
                                        value="{{ $openState->date_signed_treatment }}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Effective From Date </label>
                                    <input type="date" name="date_effective_from"
                                        value="{{ $openState->date_effective_from }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type"> Effective To Date</label>
                                    <input type="date" name="date_effective_to"
                                        value="{{ $openState->date_effective_to}}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Last Active Treatment Date </label>
                                    <input type="date" name="last_active" value="{{ $openState->last_active }}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type"> Last Follow-up Date</label>
                                    <input type="date" name="last_followup" value="{{ $openState->last_followup}}" />
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

                <!-- <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Approval</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted by">Enrolled By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Enrolled on">Enrolled On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="sub-head">Close Out</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted by">Withdrawn By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Withdrawn on">Withdrawn On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted by">Closed By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Closed on">Closed On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>


                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div> -->
                <!-- </div> -->
            </div>
    </div>
    </form>

</div>
</div>



{{{--models--}}

<div class="modal fade" id="child-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <form action="{{ route('subject_child', $openState->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        @if ($openState->stage == 2)
                        <label for="major">

                        </label>
                        <label for="major">
                            <input type="radio" name="child_type" value="violation">
                            Violation
                        </label>
                        <label for="major">
                            <input type="radio" name="child_type" value="Action_Item">
                             Subject Action Item
                        </label>
                        <!-- <label for="major">
                                            <input type="radio" name="child_type" value="extension">
                                            Extension
                                        </label> -->
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

<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('subjectCancel', $openState->id) }}" method="POST">
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


<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('subject_send_stage', $openState->id) }}" method="POST">
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