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

{{--workflow css start--}}
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
    .new_style{
        width: 100%;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    #change-control-view > div.container-fluid > div.inner-block.state-block > div.status > div.progress-bars > div.canceled{
        border-radius:20px;
        }
</style>

{{--workflow css end--}}

{{--workflow--}}

<div id="change-control-view">
  <div class="container-fluid">
        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head">Record Workflow</div>

                <div class="d-flex" style="gap:20px;">
                    @php
                        $userRoles = DB::table('user_roles')
                            ->where(['user_id' => auth()->id(), 'q_m_s_divisions_id' => $study_data->division_id])
                            ->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp
                    <button class="button_theme1"> <a class="text-white"
                            href="{{ route('GCP_study_audit_trail', $study_data->id) }}">
                            Audit Trail </a>
                    </button>

                    @if ($study_data->stage == 1 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Initiate
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                    @elseif($study_data->stage == 2 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Study Complete
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
                        </button>
                    @elseif($study_data->stage == 3 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal-issue-report">
                            Issue Report
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            No Report Required
                        </button>

                    @endif
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>
                </div>

            </div>


            <div class="status">
                <div class="head">Current Status</div>
                @if ($study_data->stage == 0)
                    <div class="progress-bars ">
                        <div class="bg-danger canceled">Closed-Cancelled</div>
                    </div>
                @else
                    <div class="progress-bars d-flex" style="font-size: 15px;">
                        @if ($study_data->stage >= 1)
                            <div class="active">Opened</div>
                        @else
                            <div class="">Opened</div>
                        @endif
                        @if ($study_data->stage >= 2)
                            <div class="active">Study in progress</div>
                        @else
                            <div class="">Study in progress</div>
                        @endif
                        @if ($study_data->stage >= 3)
                            <div class="active">Pending Report Issuance</div>
                        @else
                            <div class="">Pending Report Issuance</div>
                        @endif
                        @if ($study_data->stage >= 4)
                            <div class="bg-danger">Closed Done</div>
                        @else
                            <div class="">Closed Done</div>
                        @endif

                    </div>
                @endif
            </div>
        </div>


{{--workflow end--}}


{{--Initiate button Model Open--}}
<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('GCP_study_send_stage', $study_data->id) }}" method="POST">
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

<div class="modal fade" id="signature-modal-issue-report">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('GCP_study_send_stage', $study_data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-3 text-justify">
                        Please select a meaning and a outcome for this task and enter your username
                        and password for this task. You are performing an electronic signature,
                        which is legally binding equivalent of a hand written signature.
                    </div>
                    <input type="hidden" value="issue_report" id="type" name="type" >
                    <div class="group-input">
                        <label for="username">Username</label>
                        <input class="new_style" type="text" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password</label>
                        <input class="new_style" type="password" name="password" required>
                    </div>
                    <div class="group-input">
                        <label for="comment">Comment</label>
                        <input class="new_style" type="comment" name="comment">
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

</style>
{{--Initiate button Model Close--}}

{{--cancel button Model Open--}}
<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('GCP_study_cancel', $study_data->id) }}" method="POST">
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

{{--E-Signature cancel botton Model Close--}}


{{--study-complete button Model Open--}}
<div class="modal fade" id="child-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('GCP_child', $study_data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        <label style="display: flex;" for="major">
                            <input type="radio" name="child_type" id="child_type">
                              Audit
                        </label>

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

        <form action="{{ route('GCP_study.update', $study_data->id) }}" method="POST" enctype="multipart/form-data">
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
                                        value="{{ Helpers::getDivisionName($study_data->division_id) }}/GCP_Study/{{ Helpers::year($study_data->created_at) }}/{{ $study_data->record }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input readonly type="text" name="division_code"
                                        value="{{ $divisionName }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    {{-- <div class="static">QMS-North America</div> --}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Initiator</b></label>
                                      <input type="text" disabled name="initiator_id" value="{{ Auth::user()->name }}">
                                </div>
                            </div>

                            {{--<div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Devision</b></label>
                                    <select id="select-state" placeholder="Select..." name="division_id">
                                        <option value="">Select a value</option>
                                        @if($users->isNotEmpty())
                                            @foreach($qmsDevisions as $qmsDevision)
                                            <option value='{{ $qmsDevision->id }}' {{ $qmsDevision->id == $study_data->division_id ? 'selected' : '' }}>{{ $qmsDevision->name }}</option>
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
                                        <input type="hidden" value="{{ date('d-m-Y') }}" name="intiation_date">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description <span class="text-danger">*</span></label>
                                    <p class="text-primary">Short Description to be presented on dekstop</p>
                                    <input id="docname" type="text" name="short_description_gi" maxlength="255" required value="{{ $study_data->short_description_gi }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <p class="text-primary">Person responsible</p>

                                    <select id="select-state" placeholder="Select..." name="assign_to_gi" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                        <option value="">Select a value</option>
                                        @if($users->isNotEmpty())
                                            @foreach($users as $user)
                                            <option value='{{ $user->id }}' {{ $user->id == $study_data->assign_to_gi ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>


                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due <span class="text-danger"></span></label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input  type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator Group"><b>Department(s)</b></label>
                                    <p class="text-primary">Add all the related departments</p>
                                    <select name="department_gi" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}
                                         id="initiator_group">
                                         <option value="">Enter Your Selection Here</option>
                                        <option value="CQA"
                                            @if ($study_data->department_gi == 'CQA') selected @endif>Corporate
                                            Quality Assurance</option>
                                        <option value="QAB"
                                            @if ($study_data->department_gi == 'QAB') selected @endif>Quality
                                            Assurance Biopharma</option>
                                        <option value="CQC"
                                            @if ($study_data->department_gi == 'CQC') selected @endif>Central
                                            Quality Control</option>
                                        <option value="MANU"
                                            @if ($study_data->department_gi == 'MANU') selected @endif>Manufacturing
                                        </option>
                                        <option value="PSG"
                                            @if ($study_data->department_gi == 'PSG') selected @endif>Plasma
                                            Sourcing Group</option>
                                        <option value="CS"
                                            @if ($study_data->department_gi == 'CS') selected @endif>Central
                                            Stores</option>
                                        <option value="ITG"
                                            @if ($study_data->department_gi == 'ITG') selected @endif>Information
                                            Technology Group</option>
                                        <option value="MM"
                                            @if ($study_data->department_gi == 'MM') selected @endif>Molecular
                                            Medicine</option>
                                        <option value="CL"
                                            @if ($study_data->department_gi == 'CL') selected @endif>Central
                                            Laboratory</option>
                                        <option value="TT"
                                            @if ($study_data->department_gi == 'TT') selected @endif>Tech
                                            team</option>
                                        <option value="QA"
                                            @if ($study_data->department_gi == 'QA') selected @endif>Quality
                                            Assurance</option>
                                        <option value="QM"
                                            @if ($study_data->department_gi == 'QM') selected @endif>Quality
                                            Management</option>
                                        <option value="IA"
                                            @if ($study_data->department_gi == 'IA') selected @endif>IT
                                            Administration</option>
                                        <option value="ACC"
                                            @if ($study_data->department_gi == 'ACC') selected @endif>Accounting
                                        </option>
                                        <option value="LOG"
                                            @if ($study_data->department_gi == 'LOG') selected @endif>Logistics
                                        </option>
                                        <option value="SM"
                                            @if ($study_data->department_gi == 'SM') selected @endif>Senior
                                            Management</option>
                                        <option value="BA"
                                            @if ($study_data->department_gi == 'BA') selected @endif>Business
                                            Administration</option>

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
                                      <input type="number" name="study_number_sd" value="{{ $study_data->study_number_sd }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Name of Product</label>
                                    <input type="text" name="name_of_product_sd" value="{{ $study_data->name_of_product_sd }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Study Title</label>
                                    <input type="text" name="study_title_sd" value="{{ $study_data->study_title_sd }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Study type</label>
                                    <select name="study_type_sd" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="interventional-studies" @if($study_data->study_type_sd == 'interventional-studies') selected @endif>Interventional Studies</option>
                                        <option value="observational-Studies" @if($study_data->study_type_sd == 'observational-Studies') selected @endif>Observational Studies</option>
                                        <option value="preclinical-studies" @if($study_data->study_type_sd == 'preclinical-studies') selected @endif>Preclinical Studies</option>
                                        <option value="regulatory-studies" @if($study_data->study_type_sd == 'regulatory-studies') selected @endif>Regulatory Studies</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Study Protocol Number</label>
                                    <input id="docname" type="number" name="study_protocol_number_sd" value="{{ $study_data->study_protocol_number_sd }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <p class="text-primary">Detailed Description</p>
                                    <label for="Responsible Department">Description</label>
                                    <textarea name="description_sd" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>{{ $study_data->description_sd }}</textarea>
                                    {{--<input type="text" name="description_sd" value="{{ $study_data->description_sd }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>--}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label class="mb-4" for="Responsible Department">Comments</label>
                                    <textarea name="comments_sd" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>{{ $study_data->comments_sd }}</textarea>
                                    {{--<input type="text" name="comments_sd" value="{{ $study_data->comments_sd }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>--}}
                                </div>
                            </div>
                            <div class="sub-head">
                                Additional Information
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Related studies</label>
                                    <p class="text-primary">Link between study records related to the same study type or topic</p>
                                    <select name="related_studies_ai" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="toxicology" @if($study_data->related_studies_ai == 'toxicology') selected @endif>Toxicology</option>
                                        <option value="microbiome" @if($study_data->related_studies_ai == 'microbiome') selected @endif>Microbiome</option>
                                        <option value="formulation-and-stability" @if($study_data->related_studies_ai == 'formulation-and-stability') selected @endif>Formulation and Stability</option>
                                        <option value="adaptive-clinical" @if($study_data->related_studies_ai == 'adaptive-clinical') selected @endif>Adaptive Clinical</option>
                                        <option value="Translational" @if($study_data->related_studies_ai == 'Translational') selected @endif>Translational</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label class="mb-4" for="Responsible Department">Document Link</label>
                                    <input type="text" name="document_link_ai" value="{{ $study_data->document_link_ai }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Appendiceis</label>
                                    <select name="appendiceis_ai" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="statistical-analysis-plan" @if($study_data->appendiceis_ai == 'statistical-analysis-plan') selected @endif>Statistical Analysis Plan (SAP)</option>
                                        <option value="patient-information-sheet" @if($study_data->appendiceis_ai == 'patient-information-sheet') selected @endif>Patient Information Sheet (PIS)</option>
                                        <option value="data-management-plan" @if($study_data->appendiceis_ai == 'data-management-plan') selected @endif>Data Management Plan (DMP)</option>
                                        <option value="quality-assurance-plan" @if($study_data->appendiceis_ai == 'quality-assurance-plan') selected @endif>Quality Assurance (QA) Plan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Related Audits</label>
                                    <select name="related_audits_ai" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="quality-assurance-audits" @if($study_data->related_audits_ai == 'quality-assurance-audits') selected @endif>Quality Assurance Audits</option>
                                        <option value="regulatory-compliance-audits" @if($study_data->related_audits_ai == 'regulatory-compliance-audits') selected @endif>Regulatory Compliance Audits</option>
                                        <option value="clinical-trial-audits" @if($study_data->related_audits_ai == 'clinical-trial-audits') selected @endif>Clinical Trial Audits</option>
                                        <option value="data-integrity-audits" @if($study_data->related_audits_ai == 'data-integrity-audits') selected @endif>Data Integrity Audits</option>
                                        <option value="process-and-documentation-audits" @if($study_data->related_audits_ai == 'process-and-documentation-audits') selected @endif>Process and Documentation Audits</option>
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
                                    <input type="text" id="start_date" name="generic_product_name_gcpd" value="{{ $study_data->generic_product_name_gcpd }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="start_date">Indication Name</label>
                                <div class="calenderauditee">
                                    <input type="text" id="start_date" name="indication_name_gcpd" value="{{ $study_data->indication_name_gcpd }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="start_date">Clinical Study Manager</label>
                                <div class="calenderauditee">
                                    <input type="text" id="start_date" name="clinical_study_manager_gcpd" value="{{ $study_data->clinical_study_manager_gcpd }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="start_date">Clinical Expert</label>
                                <div class="calenderauditee">
                                    <input type="text" id="start_date" name="clinical_expert_gcpd" value="{{ $study_data->clinical_expert_gcpd }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Responsible Department">Phase Level</label>
                                <select name="phase_level_gcpd" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="phase-I" @if($study_data->phase_level_gcpd == 'phase-I') selected @endif>Phase I</option>
                                    <option value="phase-II" @if($study_data->phase_level_gcpd == 'phase-II') selected @endif>Phase II</option>
                                    <option value="phase-advanced-trials" @if($study_data->phase_level_gcpd == 'phase-advanced-trials') selected @endif>Phase-Advanced Trials</option>
                                    <option value="phase-transition-trials" @if($study_data->phase_level_gcpd == 'phase-transition-trials') selected @endif>Phase Transition Trials</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Responsible Department">Therapeutic Area</label>
                                <select name="therapeutic_area_gcpd" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="cardiology" @if($study_data->therapeutic_area_gcpd == 'cardiology') selected @endif>Cardiology</option>
                                    <option value="oncology" @if($study_data->therapeutic_area_gcpd == 'oncology') selected @endif>Oncology</option>
                                    <option value="neurology" @if($study_data->therapeutic_area_gcpd == 'neurology') selected @endif>Neurology</option>
                                    <option value="endocrinology" @if($study_data->therapeutic_area_gcpd == 'endocrinology') selected @endif>Endocrinology</option>
                                    <option value="pulmonology" @if($study_data->therapeutic_area_gcpd == 'pulmonology') selected @endif>Pulmonology</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="start_date">IND No.</label>
                                <div class="calenderauditee">
                                    <input type="number" id="start_date" name="ind_no_gcpd" value="{{ $study_data->ind_no_gcpd }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="start_date">Number of Centers</label>
                                <div class="calenderauditee">
                                    <input type="number" id="start_date" name="number_of_centers_gcpd" value="{{ $study_data->number_of_centers_gcpd }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="start_date">#of Subjects</label>
                                <div class="calenderauditee">
                                    <input type="text" id="start_date" name="of_subjects_gcpd" value="{{ $study_data->of_subjects_gcpd }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            Audit Site Information(0)
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
                                        <th style="width: 12%">Number</th>
                                        <th style="width: 16%">Audit Frequency</th>
                                        <th style="width: 16%"> Current</th>
                                        <th style="width: 16%"> CRO</th>
                                        <th style="width: 16%">Remark</th>
                                        <th style="width: 16%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 @if ($grid_DataA && is_array($grid_DataA->data))
                                    @foreach ($grid_DataA->data as $grid_DataA)
                                    <tr>
                                        <td><input disabled type="text" name="[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}"></td>
                                        <td><input type="number" name="audit_site_information[{{ $loop->index }}][Number]" value="{{ isset($grid_DataA['Number']) ? $grid_DataA['Number'] : '' }}"></td>
                                        <td><input type="text" name="audit_site_information[{{ $loop->index }}][AuditFrequency]" value="{{ isset($grid_DataA['AuditFrequency']) ? $grid_DataA['AuditFrequency'] : '' }}"></td>
                                        <td><input type="text" name="audit_site_information[{{ $loop->index }}][Current]" value="{{ isset($grid_DataA['Current']) ? $grid_DataA['Current'] : '' }}"></td>
                                        <td><input type="text" name="audit_site_information[{{ $loop->index }}][CRO]" value="{{ isset($grid_DataA['CRO']) ? $grid_DataA['CRO'] : '' }}"></td>
                                        <td><input type="text" name="audit_site_information[{{ $loop->index }}][Remark]" value="{{ isset($grid_DataA['Remark']) ? $grid_DataA['Remark'] : '' }}"></td>
                                        <td><button type="text" class="removeRowBtn">Remove</button></td>
                                    </tr>
                                    @endforeach
                                @endif
                                </tbody>

                            </table>

                        </div>
                    </div>
                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            Study Site Information(0)
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
                                        <th style="width: 16%">Site No.</th>
                                        <th style="width: 16%"> Investigator</th>
                                        <th style="width: 16%"> First Patient in Date</th>
                                        <th style="width: 16%">Enrolled No.</th>
                                        <th style="width: 16%">Current</th>
                                        <th style="width: 16%">Remark</th>
                                        <th style="width: 16%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($grid_DataS && is_array($grid_DataS->data))
                                     @foreach ($grid_DataS->data as $grid_DataS)
                                      <tr>
                                        <td><input disabled type="text" name="[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}"></td>
                                        <td><input type="text" name="study_site_information[{{ $loop->index }}][AuditSite]" value="{{ isset($grid_DataS['AuditSite']) ? $grid_DataS['AuditSite'] : '' }}"></td>
                                        <td><input type="number" name="study_site_information[{{ $loop->index }}][SiteNo]" value="{{ isset($grid_DataS['SiteNo']) ? $grid_DataS['SiteNo'] : '' }}"></td>
                                        <td><input type="text" name="study_site_information[{{ $loop->index }}][Investigator]" value="{{ isset($grid_DataS['Investigator']) ? $grid_DataS['Investigator'] : '' }}"></td>
                                        <td><input type="date" name="study_site_information[{{ $loop->index }}][FirstPatientInDate]" value="{{ isset($grid_DataS['FirstPatientInDate']) ? $grid_DataS['FirstPatientInDate'] : '' }}"></td>
                                        <td><input type="number" name="study_site_information[{{ $loop->index }}][EnrolledNo]" value="{{ isset($grid_DataS['EnrolledNo']) ? $grid_DataS['EnrolledNo'] : '' }}"></td>
                                        <td><input type="text" name="study_site_information[{{ $loop->index }}][Current]" value="{{ isset($grid_DataS['Current']) ? $grid_DataS['Current'] : '' }}"></td>
                                        <td><input type="text" name="study_site_information[{{ $loop->index }}][Remark]" value="{{ isset($grid_DataS['Remark']) ? $grid_DataS['Remark'] : '' }}"></td>
                                        <td><button type="text" class="removeRowBtn">Remove</button></td>
                                     </tr>
                                     @endforeach
                                    @endif
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
                                <input type="date" name="initiation_date_i" value="{{ $study_data->initiation_date_i }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Date">Study Start Date</label>
                                <input type="date" name="study_start_date" value="{{ $study_data->study_start_date }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Date">Study End Date</label>
                                <input type="date" name="study_end_date" value="{{ $study_data->study_end_date }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Date">Study Protocol</label>
                                <input type="text" name="study_protocol" value="{{ $study_data->study_protocol }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Date">First Subject in(FSI)</label>
                                <input type="date" name="first_subject_in" value="{{ $study_data->first_subject_in }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Date">Last Subject Out</label>
                                <input type="date" name="last_subject_out" value="{{ $study_data->last_subject_out }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Date">Data Base Lock(DBL)</label>
                                <input type="text" name="databse_lock" value="{{ $study_data->databse_lock }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="group-input">
                                <label for="Date">Integrated CTR</label>
                                <input type="text" name="integrated_ctr" value="{{ $study_data->integrated_ctr }}" {{ $study_data->stage == 0 || $study_data->stage == 4 ? 'disabled' : '' }}>
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
                                <div class="">{{ $study_data->initiate_by }}</div>

                            </div>
                        </div>
                        <div class="col-4">
                            <div class="group-input">

                                <label for="Division Code"><b>Initiated On : </b></label>
                                <div class="date">{{ $study_data->initiate_on }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="group-input">

                                <label for="Division Code"><b>Initiate Comments : </b></label>
                                <div class="date">{{ $study_data->initiate_comment }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="inner-block-content">
                    <div class="row">
                        <div class="sub-head">Initiate Cancel</div>
                        <div class="col-4">
                            <div class="group-input">
                                <label for="Victim"><b>Initiate Cancelled By :</b></label>
                                <div class="">{{ $study_data->initiate_cancel_by }}</div>

                            </div>
                        </div>
                        <div class="col-4">
                            <div class="group-input">

                                <label for="Division Code"><b>Initiate Cancelled On : </b></label>
                                <div class="date">{{ $study_data->initiate_cancel_on }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="group-input">

                                <label for="Division Code"><b>Initiate Cancelled Comments : </b></label>
                                <div class="date">{{ $study_data->initiate_cancel_comment }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="inner-block-content">
                    <div class="row">
                        <div class="sub-head">Study Complete</div>
                        <div class="col-4">
                            <div class="group-input">
                                <label for="Victim"><b>Study Completed By :</b></label>
                                <div class="">{{ $study_data->study_complete_by }}</div>

                            </div>
                        </div>
                        <div class="col-4">
                            <div class="group-input">

                                <label for="Division Code"><b>Study Completed On : </b></label>
                                <div class="date">{{ $study_data->study_complete_on }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="group-input">

                                <label for="Division Code"><b>Study Complete Comments : </b></label>
                                <div class="date">{{ $study_data->study_complete_comment }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="inner-block-content">
                    <div class="row">
                        <div class="sub-head">Study Cancel</div>
                        <div class="col-4">
                            <div class="group-input">
                                <label for="Victim"><b>Study Cancelled By :</b></label>
                                <div class="">{{ $study_data->person_cancel_by }}</div>

                            </div>
                        </div>
                        <div class="col-4">
                            <div class="group-input">

                                <label for="Division Code"><b>Study Cancelled On : </b></label>
                                <div class="date">{{ $study_data->person_cancel_on }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="group-input">

                                <label for="Division Code"><b>Person Cancelled Comments : </b></label>
                                <div class="date">{{ $study_data->person_cancel_comment }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="inner-block-content">
                    <div class="row">
                        <div class="sub-head">Issue Report</div>
                        <div class="col-4">
                            <div class="group-input">
                                <label for="Victim"><b>Issue Reported By :</b></label>
                                <div class="">{{ $study_data->issue_report_by }}</div>

                            </div>
                        </div>
                        <div class="col-4">
                            <div class="group-input">

                                <label for="Division Code"><b>Issue Reported On : </b></label>
                                <div class="date">{{ $study_data->issue_report_on }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="group-input">

                                <label for="Division Code"><b>Issue Reported Comments : </b></label>
                                <div class="date">{{ $study_data->issue_report_comment }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="inner-block-content">
                    <div class="row">
                        <div class="sub-head">No Report Require</div>
                        <div class="col-4">
                            <div class="group-input">
                                <label for="Victim"><b>No Report Required By :</b></label>
                                <div class="">{{ $study_data->no_report_require_by }}</div>

                            </div>
                        </div>
                        <div class="col-4">
                            <div class="group-input">

                                <label for="Division Code"><b>No Report Required By : </b></label>
                                <div class="date">{{ $study_data->no_report_require_on }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="group-input">

                                <label for="Division Code"><b>No Report Required Comments : </b></label>
                                <div class="date">{{ $study_data->no_report_require_comment }}</div>
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
                                '<td><input type="text" name="audit_site_information[' + serialNumber + '][Number]"></td>' +
                                '<td><input type="text" name="audit_site_information[' + serialNumber + '][Audit Frequency]"></td>' +
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
                                '<td><input type="text" name="study_site_information[' + serialNumber + '][SiteNo]"></td>' +
                                '<td><input type="text" name="study_site_information[' + serialNumber + '][Investigator]"></td>' +
                                '<td><input type="text" name="study_site_information[' + serialNumber + '][First Patient in Date]"></td>' +
                                '<td><input type="text" name="study_site_information[' + serialNumber + '][Enrolled No.]"></td>' +
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
