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
        / Contract testing Lab Audit
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
/*element.style{
border-radius:10px;
}*/
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
                            ->where(['user_id' => auth()->id(), 'q_m_s_divisions_id' => $audit_data->division_id])
                            ->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp
                    <button class="button_theme1"> <a class="text-white"
                            href="{{ route('ctl_audit.audit_trail', $audit_data->id) }}">
                            Audit Trail </a>
                    </button>

                    @if ($audit_data->stage == 1 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Submit
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>

                    @elseif($audit_data->stage == 2 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            CTL Audit Preparation Complete
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#reject-modal">
                            More Info from open state
                        </button>

                    @elseif($audit_data->stage == 3 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            CTL Audit Complete
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#reject-modal">
                            More Info from CTL Audit Preparation
                        </button>

                    @elseif($audit_data->stage == 4 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            CTL Audit Report Complete
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#reject-modal">
                            More Info from CTL Audit Execution
                        </button>

                    @elseif($audit_data->stage == 5 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            CTL Audit Report Issued
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#reject-modal">
                            More Info from CTL Audit Report Prepration
                        </button>

                    @elseif($audit_data->stage == 6 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            CTL Response Received
                        </button>

                    @elseif($audit_data->stage == 7 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            CTL Audit Compliance Acceptance Complete
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
                        </button>

                    @elseif($audit_data->stage == 8 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            CTL Audit Compliance Approval Complete
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#reject-modal">
                            More Info from CTL Audit Comp Accep
                        </button>

                    @elseif($audit_data->stage == 9 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Audit Compliance Monitoring Complete
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">
                            Child
                        </button>

                    @elseif($audit_data->stage == 10 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            CTL Audit Conclusion Complete
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#reject-modal">
                            More Info from CTL Audit Comp Accept
                        </button>

                    @endif
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>
                </div>

            </div>


            <div class="status">
                <div class="head">Current Status</div>
                        @if ($audit_data->stage == 0)
                            <div class="progress-bars">
                                <div class="bg-danger canceled">Closed-Cancelled</div>
                            </div>
                        @else
                    <div class="progress-bars d-flex" style="font-size: 15px;">
                        @if ($audit_data->stage >= 1)
                            <div class="active">Opened</div>
                        @else
                            <div class="">Opened</div>
                        @endif

                        @if ($audit_data->stage >= 2)
                            <div class="active">CTL Audit Preparation</div>
                        @else
                            <div class="">CTL Audit Preparation</div>
                        @endif

                        @if ($audit_data->stage >= 3)
                            <div class="active">CTL Audit Execution</div>
                        @else
                            <div class="">CTL Audit Execution</div>
                        @endif

                        {{--@if($audit_data->stage != 5)--}}
                            @if ($audit_data->stage >= 4)
                                <div class="active">CTL Audit Report Preparation & Approval</div>
                            @else
                                <div class="">CTL Audit Report Preparation & Approval</div>
                            @endif
                        {{--@endif--}}

                       {{--@if($audit_data->stage != 4)--}}
                        @if ($audit_data->stage >= 5)
                            <div class="active">Under CTL Audit Report Issuance</div>
                        @else
                            <div class="">Under CTL Audit Report Issuance</div>
                        @endif
                      {{--@endif--}}

                        @if ($audit_data->stage >= 6)
                            <div class="active">Pending CTL Response</div>
                        @else
                            <div class="">Pending CTL Response</div>
                       @endif

                       @if ($audit_data->stage >= 7)
                            <div class="active">Under CTL Audit Compliance Acceptance</div>
                       @else
                            <div class="">Under CTL Audit Compliance Acceptance</div>
                       @endif

                       @if ($audit_data->stage >= 8)
                           <div class="active">CTL Audit Compliance Approval</div>
                       @else
                           <div class="">CTL Audit Compliance Approval</div>
                       @endif

                       @if ($audit_data->stage >= 9)
                           <div class="active">Under Audit Compliance Monitoring</div>
                       @else
                           <div class="">Under Audit Compliance Monitoring</div>
                       @endif

                       @if ($audit_data->stage >= 10)
                           <div class="active">CTL Audit Conclusion</div>
                       @else
                           <div class="">CTL Audit Conclusion</div>
                       @endif

                       @if ($audit_data->stage >= 11)
                           <div class="bg-danger">Close-Done</div>
                       @else
                           <div class="">Close-Done</div>
                       @endif

                    </div>
                @endif
            </div>
        </div>


{{--workflow end--}}


{{-- signature button Model Open--}}
<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('ctl_audit.send_stage', $audit_data->id) }}" method="POST">
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
                        <input type="comment" name="comment" >
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

{{--signature button Model Open--}}

{{-- cancel button Model Open--}}
<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('ctl_audit.cancel', $audit_data->id) }}" method="POST">
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

{{--cancel button Model Close--}}

{{--reject button Model Open--}}
<div class="modal fade" id="reject-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('ctl_audit.reject', $audit_data->id) }}" method="POST">
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
                        <input type="text" class="new_style" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password<span class="text-danger">*</span></label>
                        <input type="password" class="new_style" name="password" required>
                    </div>
                    <div class="group-input">
                        <label for="comment">Comment</label>
                        <input type="comment" class="new_style" name="comment">
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

{{--reject button Model Close--}}

{{--child button Model Open--}}
<div class="modal fade" id="child-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('ctl_audit.child', $audit_data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        <label style="display: flex;" for="child">
                            <input type="radio" name="child_type" id="child_type" value="audit_task">
                               Audit Task
                        </label>

                        <label style="display: flex;" for="child1">
                            <input type="radio" name="child_type" id="child_type1" value="follow_up_task">
                               Follow Up Task
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

{{--child button Model end--}}

{{--child button Model Open--}}
<div class="modal fade" id="child-modal1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('ctl_audit.child', $audit_data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        <label style="display: flex;" for="major">
                            <input type="radio" name="child_type" id="child_type2">
                               Audit Task
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

{{--child button Model end--}}



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">CTL Audit Preparation</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">CTL Audit Execution</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Audit Report Prep. & Approval</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">CTL Audit Report Issuance</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Pending CTL Response</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm7')">CTL Audit Compliance Accept</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm8')">CTL Audit Compliance Approval</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Audit Conclusion</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm10')">Signatures</button>
        </div>

            {{-- disabled field code start --}}

            <?php if (in_array($audit_data->stage, [0, 11])) : ?>
            <script>
                $(document).ready(function() {
                    $("#target :input").prop("disabled", true);
                });
            </script>
            <?php endif; ?>

            {{-- disabled field code end --}}


        <form id="target" action="{{ route('contract_testing_lab_audit.update', $audit_data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">
                                Parent Record Information
                            </div>
                            {{--<div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date_Opened"><b>(Parent) Date Opened</b></label>
                                    <input type="date" name="date_opened">
                                </div>
                            </div>--}}
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiation"><b>(parent) Audit Scheduled for the year</b></label>
                                     <select name="audit_scheduled_for_the_year">
                                         <option value="">Enter Your Selection Here</option>
                                         <option value="2022" @if($audit_data->audit_scheduled_for_the_year == '2022') selected @endif>2022</option>
                                         <option value="2023" @if($audit_data->audit_scheduled_for_the_year == '2023') selected @endif>2023</option>
                                         <option value="2024" @if($audit_data->audit_scheduled_for_the_year == '2024') selected @endif>2024</option>
                                         <option value="2025" @if($audit_data->audit_scheduled_for_the_year == '2025') selected @endif>2025</option>
                                         <option value="2026" @if($audit_data->audit_scheduled_for_the_year == '2026') selected @endif>2026</option>
                                         <option value="2027" @if($audit_data->audit_scheduled_for_the_year == '2027') selected @endif>2027</option>
                                     </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="ctl_audit_schedule_no">(Parent) CTL Audit Schedule No.</label>
                                    <input type="number" name="ctl_audit_schedule_no" value="{{ $audit_data->ctl_audit_schedule_no }}">
                                </div>
                            </div>

                            <div class="sub-head">
                                Audit Information
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator">Record Number</label>
                                    <input disabled type="text" name="record" value="{{ Helpers::getDivisionName(session()->get('division')) }}/CTL-Audit/{{ date('Y') }}/{{ str_pad($audit_data->record, 4, '0', STR_PAD_LEFT) }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input readonly type="text" name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Originator</b></label>
                                    <input disabled type="text" name="Initiator" value="{{ Auth()->user()->name; }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date of Initiation</b></label>
                                    <input readonly type="text" value="{{ date('d-M-Y', strtotime($audit_data->intiation_date)) }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('d-M-Y', strtotime($audit_data->intiation_date)) }}" name="intiation_date">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span>
                                     <p>255 charaters remaining</p>
                                     <input id="docname" type="text" name="short_description" maxlength="255" required value="{{ $audit_data->short_description }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assigned_to">
                                        <option value="">Select a value</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $user->id == $audit_data->assigned_to ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due</label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input  type="hidden" value="{{ $audit_data->due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($audit_data->due_date) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Name_of_Contract_Testing_Lab">Name of Contract Testing Lab</label>
                                     <input type="text" name="name_of_contract_testing_lab" value="{{ $audit_data->name_of_contract_testing_lab }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Laboratory_Address">Laboratory Address</label>
                                      <textarea name="laboratory_address">{{ $audit_data->laboratory_address }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    @php
                                      $divisions = DB::table('q_m_s_divisions')->where('status', 1)->get();
                                      $selectedSite = explode(',', $audit_data->application_sites);
                                    @endphp
                                    <label for="Application_Sites">Application Sites</label>
                                     <select multiple name="application_sites[]" id="application_sites">
                                       @foreach ($divisions as $division)
                                         <option {{ in_array($division->id, $selectedSite) ? 'selected' : '' }} value="{{ $division->id }}">{{ $division->name }}</option>
                                       @endforeach
                                     </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Customer_organization">New Existing Laboratory</label>
                                    <select name="new_existing_laboratory">
                                        <option value="">Enter your selection here</option>
                                        <option value="ML00" @if($audit_data->new_existing_laboratory == 'ML00') selected @endif>ML00</option>
                                        <option value="ML01" @if($audit_data->new_existing_laboratory == 'ML01') selected @endif>ML01</option>
                                        <option value="ML02" @if($audit_data->new_existing_laboratory == 'ML02') selected @endif>ML02</option>
                                        <option value="ML03" @if($audit_data->new_existing_laboratory == 'ML03') selected @endif>ML03</option>
                                        <option value="ML04" @if($audit_data->new_existing_laboratory == 'ML04') selected @endif>ML04</option>
                                        <option value="ML05" @if($audit_data->new_existing_laboratory == 'ML05') selected @endif>ML05</option>
                                      </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Outcome">Date of Last Audit</label>
                                    <input type="date" name="date_of_last_audit" value="{{ $audit_data->date_of_last_audit }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Patient_Involved">Audit Due On Month</label>
                                     <input type="date" name="audit_due_on_month" value="{{ $audit_data->audit_due_on_month }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="TCD_for_Audit_Completion">TCD For Audit Completion.</label>
                                    <input type="date" name="tcd_for_audit_completion" value="{{ $audit_data->tcd_for_audit_completion }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Planing_to_be_Done_On">Audit Planing to be Done On</label>
                                    <input type="date" name="audit_planing_to_be_done_on" value="{{ $audit_data->audit_planing_to_be_done_on }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Request_Communicated_To">Audit Request Communicated To</label>
                                    <input type="text" name="audit_request_communicated_to" value="{{ $audit_data->audit_request_communicated_to }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Proposed_Audit_Start_Date">Proposed Audit Start Date</label>
                                    <input type="date" name="proposed_audit_start_date" value="{{ $audit_data->proposed_audit_start_date }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Proposed_Audit_Completion">Proposed Audit Completion</label>
                                    <input type="date" name="proposed_audit_completion" value="{{ $audit_data->proposed_audit_completion }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Name_of_Lead_Auditor">Name of Lead Auditor</label>
                                    <select name="name_of_lead_auditor">
                                       <option value="">Enter Your Selection Here</option>
                                       @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $user->id == $audit_data->name_of_lead_auditor ? 'selected' : '' }}>{{ $user->name }}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    @php
                                        $users = DB::table('users')->get();
                                        $selectedAuditor = explode(',', $audit_data->name_of_co_auditor); // Convert to array if it's not already
                                    @endphp
                                    <label for="Name_of_Co_Auditor">Name(s) of Co-Auditor</label>
                                    <select name="name_of_co_auditor[]" multiple id="name_of_co_auditor">
                                        @foreach ($users as $user)
                                            <option {{ in_array($user->id, $selectedAuditor) ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                     </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="External_Auditor_if_Applicable">External Auditor, if Applicable</label>
                                    <input type="text" name="external_auditor_if_applicable" value="{{ $audit_data->external_auditor_if_applicable }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Propose_of_Audit">Propose of Audit.</label>
                                    <select name="propose_of_audit">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="regulatory-compliance" @if($audit_data->propose_of_audit == 'regulatory-compliance') selected @endif>Regulatory Compliance</option>
                                        <option value="quality-control" @if($audit_data->propose_of_audit == 'quality-control') selected @endif>Quality Control</option>
                                        <option value="process-improvement" @if($audit_data->propose_of_audit == 'process-improvement') selected @endif>Process Improvement</option>
                                        <option value="validation-and-verification" @if($audit_data->propose_of_audit == 'validation-and-verification') selected @endif>Validation and Verification</option>
                                        <option value="risk-assessment" @if($audit_data->propose_of_audit == 'risk-assessment') selected @endif>Risk Assessment</option>
                                        <option value="internal-audit" @if($audit_data->propose_of_audit == 'internal-audit') selected @endif>Internal Audit</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Details_of_for_Cause_Audit">Details of for Cause Audit</label>
                                    <textarea name="details_of_for_cause_audit">{{ $audit_data->details_of_for_cause_audit }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Other_Information">Other Information (If Any)</label>
                                    <textarea name="other_information_gi">{{ $audit_data->other_information_gi }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                     @php
                                        $users = DB::table('users')->get();
                                     @endphp
                                    <label for="QA_Approver">QA Approver</label>
                                      <select name="qa_approver">
                                       <option value="">Enter Your Selection Here</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $user->id == $audit_data->qa_approver ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                      </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Proposal_Attachments">Proposal Attachments</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach">
                                            @if ($audit_data->proposal_attachments)
                                            @foreach ($audit_data->proposal_attachments as $file)
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
                                            <input type="file" id="myfile" name="proposal_attachments[]" oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Proposal_By">CTL Audit Proposal By</label>
                                    <input type="text" name="ctl_audit_proposal_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Proposal_By">CTL Audit Proposal On</label>
                                    <input type="date" name="ctl_audit_proposal_on">
                                </div>
                            </div>--}}

                            <div class="sub-head">
                                Cancellation
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Remarks">Remarks</label>
                                    <textarea name="remarks">{{ $audit_data->remarks }}</textarea>
                                </div>
                            </div>

                            {{--<div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancellation_Initiated_By">Cancellation Initiated By</label>
                                    <input type="text" name="cancellation_initiated_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancellation_Initiated_On">Cancellation Initiated On</label>
                                    <input type="date" name="cancellation_initiated_on">
                                </div>
                            </div>--}}

                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>

                {{--CTL Audit Preparation--}}

                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Audit_Agenda">Audit Agenda</label>
                                    <textarea name="audit_agenda">{{ $audit_data->audit_agenda }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Aenda_Sent_On">Audit Agenda Sent On</label>
                                    <input type="date" name="audit_agenda_sent_on" value="{{ $audit_data->audit_agenda_sent_on }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Agenda_Sent_To">Audit Agenda Sent To</label>
                                    <input type="text" name="audit_agenda_sent_to" value="{{ $audit_data->audit_agenda_sent_to }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Comments_Remarks">Comments / Remarks(If Any)</label>
                                    <textarea name="comments_remarks">{{ $audit_data->comments_remarks }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Communication_And_Others">Communication & Others</label>
                                    <select name="communication_and_others">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="communication" @if($audit_data->communication_and_others == 'communication') selected @endif>Communication</option>
                                        <option value="training-and-development" @if($audit_data->communication_and_others == 'training-and-development') selected @endif>Training and Development</option>
                                        <option value="customer-feedback" @if($audit_data->communication_and_others == 'customer-feedback') selected @endif>Customer Feedback</option>
                                        <option value="incident-investigation" @if($audit_data->communication_and_others == 'incident-investigation') selected @endif>Incident Investigation</option>
                                        <option value="performance-review" @if($audit_data->communication_and_others == 'performance-review') selected @endif>Performance Review</option>
                                    </select>
                                </div>
                            </div>

                            {{--<div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Preparation_By">CTL Audit Preparation By</label>
                                    <input type="text" name="ctl_audit_preparation_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Preparation_On">CTL Audit Preparation On</label>
                                    <input type="date" name="ctl_audit_preparation_on">
                                </div>
                            </div>--}}


                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--CTL Audit Execution--}}
                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Started_On">CTL Audit Started On</label>
                                    <input type="date" name="ctl_audit_started_on" value="{{ $audit_data->ctl_audit_started_on }}">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Completed_On">CTL Audit Completed On</label>
                                    <input type="date" name="ctl_audit_completed_on" value="{{ $audit_data->ctl_audit_completed_on }}">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Audit_Execution_Comments">Audit Execution Comments</label>
                                    <textarea name="audit_execution_comments">{{ $audit_data->audit_execution_comments }}</textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Audit_Enclosures">Audit Enclosures</label>
                                    <select name="audit_enclosures">
                                        <option value="">--select--</option>
                                        <option value="risk-assessments" @if($audit_data->audit_enclosures == 'risk-assessments') selected @endif>Risk Assessments</option>
                                        <option value="supplier-audits" @if($audit_data->audit_enclosures == 'supplier-audits') selected @endif>Supplier Audits</option>
                                        <option value="non-conformance-reports" @if($audit_data->audit_enclosures == 'non-conformance-reports') selected @endif>Non-Conformance Reports</option>
                                        <option value="follow-up-reports" @if($audit_data->audit_enclosures == 'follow-up-reports') selected @endif>Follow-Up Reports</option>
                                        <option value="validation-protocols" @if($audit_data->audit_enclosures == 'validation-protocols') selected @endif>Validation Protocols</option>
                                        <option value="validation-reports" @if($audit_data->audit_enclosures == 'validation-reports') selected @endif>Validation Reports</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Delay_Justification_Deviation">Delay Justification/Deviation</label>
                                    <textarea name="delay_justification_deviation">{{ $audit_data->delay_justification_deviation }}</textarea>
                                </div>
                            </div>

                            {{--<div class="col-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Details_Updated_By">CTL Audit Details Updated By</label>
                                    <input type="text" name="ctl_audit_details_updated_by">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Details_Updated_On">CTL Audit Details Updated On</label>
                                    <input type="date" name="ctl_audit_details_updated_on">
                                </div>
                            </div>--}}

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


                {{--Audit Report Prep. & Approval--}}

                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="sub-head">
                                Audit Details
                            </div>

                             <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Auditee(s)
                                    <button type="button" name="auditee" id="Auditee">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Auditee-instruction-modal">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Name</th>
                                                <th style="width: 16%">Designation/Position</th>
                                                <th style="width: 10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                              $data = isset($grid_DataA) && $grid_DataA->data ? json_decode($grid_DataA->data, true) : null;
                                            @endphp

                                             @if ($data && is_array($data))
                                                @foreach ($data as $index => $item)
                                                <tr>
                                                    <td><input disabled type="text" name="[{{ $index }}][serial]" value="{{ $index + 1 }}" value="1"></td>
                                                    <td><input type="text" name="auditee[{{ $index }}][Name]" value="{{ isset($item['Name']) ? $item['Name'] : '' }}"></td>
                                                    <td><input type="text" name="auditee[{{ $index }}][DesignationPosition]" value="{{ isset($item['DesignationPosition']) ? $item['DesignationPosition'] : '' }}"></td>
                                                    <td><button readonly type="text" class="removeRowBtn">Remove</button></td>
                                                </tr>
                                                @endforeach
                                             @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Key Personnel Met During Audit
                                    <button type="button" name="key_personnel_met_during_audit" id="Key_Personnel_Met_During_Audit">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Key_Personnel_Met_During_Audit-field-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Name</th>
                                                <th style="width: 16%">Designation/Position</th>
                                                <th style="width: 10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                              $data = isset($grid_DataK) && $grid_DataK->data ? json_decode($grid_DataK->data, true) : null;
                                            @endphp

                                           @if ($data && is_array($data))
                                              @foreach ($data as $index => $item)
                                              <tr>
                                                  <td><input disabled type="text" name="[{{ $index }}][serial]" value="{{ $index + 1 }}" value="1"></td>
                                                  <td><input type="text" name="key_personnel_met_during_audit[{{ $index }}][Name]" value="{{ isset($item['Name']) ? $item['Name'] : '' }}"></td>
                                                  <td><input type="text" name="key_personnel_met_during_audit[{{ $index }}][DesignationPosition]" value="{{ isset($item['DesignationPosition']) ? $item['DesignationPosition'] : '' }}"></td>
                                                  <td><button readonly type="text" class="removeRowBtn">Remove</button></td>
                                              </tr>
                                              @endforeach
                                           @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="sub-head">
                                Observation/Non-Confirmances
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Critical">Critical</label>
                                    <input type="text" name="critical" value="{{ $audit_data->critical }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Major">Major</label>
                                    <input type="text" name="major" value="{{ $audit_data->major }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Conclusion">Minor</label>
                                    <input type="text" name="minor" value="{{ $audit_data->minor }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Recomendations_Comments">Recomendations/Comments</label>
                                    <input type="text" name="recomendations_comments" value="{{ $audit_data->recomendations_comments }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="total">Total</label>
                                    <input type="text" name="total" value="{{ $audit_data->total }}">
                                </div>
                            </div>

                            <div class="sub-head">
                                Audit Summary
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Corrective_Actions_Agreed">Corrective Actions Agreed</label>
                                    <textarea name="corrective_actions_agreed">{{ $audit_data->corrective_actions_agreed }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Executive_Summary">Executive Summary</label>
                                    <textarea name="executive_summary">{{ $audit_data->executive_summary }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Laboratory_Acceptability">Laboratory Acceptability</label>
                                    <textarea name="laboratory_acceptability">{{ $audit_data->laboratory_acceptability }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Remarks_Conclusion">Remarks & Conclusion</label>
                                    <textarea name="remarks_conclusion">{{ $audit_data->remarks_conclusion }}</textarea>
                                </div>
                            </div>

                            <div class="sub-head">
                                Audit Report Details
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Report_Ref_No">Audit Report Ref. No.</label>
                                    <input type="text" name="audit_report_ref_no" value="{{ $audit_data->audit_report_ref_no }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Report_Signed_On">Audit Report Signed On</label>
                                    <input type="date" name="audit_report_signed_on" value="{{ $audit_data->audit_report_signed_on }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Report_Approved_On">Audit Report Approved On</label>
                                    <input type="date" name="audit_report_approved_on" value="{{ $audit_data->audit_report_approved_on }}">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Report">CTL Audit Report</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach1">
                                            @if ($audit_data->ctl_audit_report)
                                            @foreach ($audit_data->ctl_audit_report as $file)
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
                                            <input type="file" id="myfile" name="ctl_audit_report[]" oninput="addMultipleFiles(this, 'file_attach1')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Delay_Justification">Delay Justification</label>
                                    <textarea name="delay_justification">{{ $audit_data->delay_justification }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Supportive_Documents">Supportive Documents</label>
                                    <select name="supportive_documents">
                                      <option value="">Enter Your Selection</option>
                                      <option value="Training Manuals" @if($audit_data->supportive_documents == 'Training Manuals') selected @endif>Training Manuals</option>
                                      <option value="Equipment Manuals" @if($audit_data->supportive_documents == 'Equipment Manuals') selected @endif>Equipment Manuals</option>
                                      <option value="Calibration Records" @if($audit_data->supportive_documents == 'Calibration Records') selected @endif>Calibration Records</option>
                                      <option value="Quality Control Data" @if($audit_data->supportive_documents == 'validation-reports') selected @endif>Quality Control Data</option>
                                      <option value="Incident Reports" @if($audit_data->supportive_documents == 'validation-reports') selected @endif>Incident Reports</option>
                                    </select>
                                </div>
                            </div>

                            {{--<div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Report_Prepared_By">CTL Audit Report Prepared By</label>
                                    <input type="text" name="ctl_audit_report_prepared_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Report_Prepared_By">CTL Audit Report Prepared On</label>
                                    <input type="date" name="ctl_audit_report_prepared_on">
                                </div>
                            </div>--}}

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

                {{--CTL Audit Report Issueance--}}

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Report_Issue_Date">CTL Audit Report Issue Date</label>
                                    <input type="date" name="ctl_audit_report_issue_date" value="{{ $audit_data->ctl_audit_report_issue_date }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Report_Sent_To_Ctl_On">Audit Report Sent To CTL On</label>
                                    <input type="date" name="audit_report_sent_to_ctl_on" value="{{ $audit_data->audit_report_sent_to_ctl_on }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Report_Sent_To">Audit Report Sent To</label>
                                    <input type="text" name="audit_report_sent_to" value="{{ $audit_data->audit_report_sent_to }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Report_Acknowledged_On">Report Acknowledged On</label>
                                    <input type="date" name="report_acknowledged_on" value="{{ $audit_data->report_acknowledged_on }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="TCD_for_Receipt_of_Compliance">TCD for Receipt of Compliance</label>
                                    <input type="date" name="tcd_for_receipt_of_compliance" value="{{ $audit_data->tcd_for_receipt_of_compliance }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Other_Information">Other Information (If Any)</label>
                                    <textarea name="other_information">{{ $audit_data->other_information }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="File_Attachments_If_Any">File Attachments If Any</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach2">
                                          @if ($audit_data->file_attachments_if_any)
                                            @foreach ($audit_data->file_attachments_if_any as $file)
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
                                            <input type="file" id="myfile" name="file_attachments_if_any[]" oninput="addMultipleFiles(this, 'file_attach2')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Report_Issued_By">CTL Audit Report Issued By</label>
                                    <input type="text" name="ctl_audit_report_issued_by">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Report_Issued_On">CTL Audit Report Issued On</label>
                                    <input type="date" name="ctl_audit_report_issued_on">
                                </div>
                            </div>--}}

                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--Pending CTL Response--}}

                <div id="CCForm6" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="sub-head">
                                Response Details
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initial_Response_Received_On">Initial Response Received On</label>
                                    <input type="date" name="initial_response_received_on" value="{{ $audit_data->initial_response_received_on }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Response_Received_On">Final Response Received On</label>
                                    <input type="date" name="final_response_received_on" value="{{ $audit_data->final_response_received_on }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Response_Received_Within_TCD">Response Received Within TCD</label>
                                    <select name="response_received_within_tcd">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Partially" @if($audit_data->response_received_within_tcd == 'Partially') selected @endif>Partially</option>
                                        <option value="Pending" @if($audit_data->response_received_within_tcd == 'Pending') selected @endif>Pending</option>
                                        <option value="Follow-Up Required" @if($audit_data->response_received_within_tcd == 'Follow-Up Required') selected @endif>Follow-Up Required</option>
                                        <option value="Under Review" @if($audit_data->response_received_within_tcd == 'Under Review') selected @endif>Under Review</option>
                                        <option value="Escalated" @if($audit_data->response_received_within_tcd == 'Escalated') selected @endif>Escalated</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reason_for_Delayed_Response">Reason for Delayed Response</label>
                                    <textarea name="reason_for_delayed_response" cols="30" rows="3">{{ $audit_data->reason_for_delayed_response }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Comments">Comments</label>
                                    <textarea name="comments" cols="30" rows="3">{{ $audit_data->comments }}</textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="CTL_Response_Report">CTL Response Report</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach3">
                                            @if ($audit_data->ctl_response_report)
                                            @foreach ($audit_data->ctl_response_report as $file)
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
                                            <input type="file" id="myfile" name="ctl_response_report[]" oninput="addMultipleFiles(this, 'file_attach3')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Response_Detail_Updated_By">CTL Response Detail Updated By</label>
                                    <input type="text" name="ctl_response_detail_updated_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Response_Detail_Updated_On">CTL Response Detail Updated On</label>
                                    <input type="text" name="ctl_response_detail_updated_on">
                                </div>
                            </div>--}}


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

                {{--CTL Audit Compliance--}}

                <div id="CCForm7" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Response_Review_Comments">Response Review Comments</label>
                                    <textarea name="response_review_comments">{{ $audit_data->response_review_comments }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Task_Required">Audit Task Required?</label>
                                    <select name="audit_task_required">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Document Review" @if($audit_data->audit_task_required == 'Document Review') selected @endif>Document Review</option>
                                        <option value="Interview Staff" @if($audit_data->audit_task_required == 'Interview Staff') selected @endif>Interview Staff</option>
                                        <option value="Inspect Facilities" @if($audit_data->audit_task_required == 'Inspect Facilities') selected @endif>Inspect Facilities</option>
                                        <option value="Check Equipment Calibration" @if($audit_data->audit_task_required == 'Check Equipment Calibration') selected @endif>Check Equipment Calibration</option>
                                        <option value="Review Training Records" @if($audit_data->audit_task_required == 'Review Training Records') selected @endif>Review Training Records</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Task_Ref_No">Audit Task Ref. No</label>
                                    <input type="number" name="audit_task_ref_no" value="{{ $audit_data->audit_task_ref_no }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Follow_Up_Task_Required">Follow Up Task Required</label>
                                    <select name="follow_up_task_required">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Perform Re-Audit" @if($audit_data->follow_up_task_required == 'Perform Re-Audit') selected @endif>Perform Re-Audit</option>
                                        <option value="Implement Process Improvements" @if($audit_data->follow_up_task_required == 'Implement Process Improvements') selected @endif>Implement Process Improvements</option>
                                        <option value="Verify CAPA Implementation" @if($audit_data->follow_up_task_required == 'Verify CAPA Implementation') selected @endif>Verify CAPA Implementation</option>
                                        <option value="Review and Approve Changes" @if($audit_data->follow_up_task_required == 'Review and Approve Changes') selected @endif>Review and Approve Changes</option>
                                        <option value="Complete Risk Assessments" @if($audit_data->follow_up_task_required == 'Complete Risk Assessments') selected @endif>Complete Risk Assessments</option>
                                        <option value="Provide Status Updates" @if($audit_data->follow_up_task_required == 'Provide Status Updates') selected @endif>Provide Status Updates</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Follow_Up_Task_Ref_No">Follow-Up Task Ref. No</label>
                                    <select name="follow_up_task_ref_no">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Ref-002" @if($audit_data->follow_up_task_ref_no == 'Ref-002') selected @endif>Ref-002</option>
                                        <option value="Ref-003" @if($audit_data->follow_up_task_ref_no == 'Ref-003') selected @endif>Ref-003</option>
                                        <option value="Ref-004" @if($audit_data->follow_up_task_ref_no == 'Ref-004') selected @endif>Ref-004</option>
                                        <option value="Ref-005" @if($audit_data->follow_up_task_ref_no == 'Ref-005') selected @endif>Ref-005</option>
                                        <option value="Ref-006" @if($audit_data->follow_up_task_ref_no == 'Ref-006') selected @endif>Ref-006</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="TCD_for_Capa_Implementation">TCD for Capa Implementation</label>
                                    <input type="text" name="tcd_for_capa_implementation" value="{{ $audit_data->tcd_for_capa_implementation }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Response_Review">Response Review</label>
                                    <select name="response_review">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="capa-procedure-document" @if($audit_data->response_review == 'capa-procedure-document') selected @endif>CAPA Procedure Document</option>
                                        <option value="risk-assessment-documentation" @if($audit_data->response_review == 'risk-assessment-documentation') selected @endif>Risk Assessment Documentation</option>
                                        <option value="capa-procedure-document" @if($audit_data->response_review == 'capa-procedure-document') selected @endif>Root Cause Analysis Documentation</option>
                                        <option value="response-evaluation-criteria" @if($audit_data->response_review == 'response-evaluation-criteria') selected @endif>Response Evaluation Criteria</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reason_For_Disqualification">Reason For Disqualification</label>
                                    <textarea name="reason_for_disqualification">{{ $audit_data->reason_for_disqualification }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reason_For_Disqualification">Requalification Frequency</label>
                                    <input type="text" name="requalification_frequency" value="{{ $audit_data->requalification_frequency }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Next_Audit_Due_Date">Next Audit Due Date</label>
                                    <input type="date" name="next_audit_due_date" value="{{ $audit_data->next_audit_due_date }}">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Audit_Closure_Report">Audit Closure Report</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach4">
                                            @if ($audit_data->audit_closure_report)
                                            @foreach ($audit_data->audit_closure_report as $file)
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
                                            <input type="file" id="myfile" name="audit_closure_report[]" oninput="addMultipleFiles(this, 'file_attach4')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Response_File_Attachments">Response File Attachments</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach5">
                                            @if ($audit_data->response_file_attachments)
                                            @foreach ($audit_data->response_file_attachments as $file)
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
                                            <input type="file" id="myfile" name="response_file_attachments[]" oninput="addMultipleFiles(this, 'file_attach5')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Response_Acceptance_By">CTL Response Acceptance By</label>
                                    <input type="text" name="ctl_response_acceptance_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Response_Acceptance_on">CTL Response Acceptance On</label>
                                    <input type="date" name="ctl_response_acceptance_on">
                                </div>
                            </div>--}}

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

                {{--CTL Audit Compliance Approval--}}

                <div id="CCForm8" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Approval_Comments">Approval Comments</label>
                                    <textarea name="approval_comments">{{ $audit_data->approval_comments }}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Approval_Attachments">Approval Attachments</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach6">
                                            @if ($audit_data->approval_attachments)
                                            @foreach ($audit_data->approval_attachments as $file)
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
                                            <input type="file" id="myfile" name="approval_attachments[]" oninput="addMultipleFiles(this, 'file_attach6')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Compliance_Approved_By">Audit Compliance Approved By</label>
                                    <input type="text" name="audit_compliance_approved_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Compliance_Approved_On">Audit Compliance Approved On</label>
                                    <input type="date" name="audit_compliance_approved_on">
                                </div>
                            </div>--}}

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


                {{--Audit Conclusion--}}

                <div id="CCForm9" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="sub-head">
                               Capa Implementation Status
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="All_Observation_Closed">All Observation Closed</label>
                                    <select name="all_observation_closed">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="reporting-and-metrics" @if($audit_data->all_observation_closed == 'reporting-and-metrics') selected @endif>Reporting and Metrics</option>
                                        <option value="review-and-approval" @if($audit_data->all_observation_closed == 'review-and-approval') selected @endif>Review and Approval</option>
                                        <option value="verification-and-validation" @if($audit_data->all_observation_closed == 'verification-and-validation') selected @endif>Verification and Validation</option>
                                        <option value="action-plan-development" @if($audit_data->all_observation_closed == 'action-plan-development') selected @endif>Action Plan Development</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Implementation_Review_Comments">Implementation Review Comments</label>
                                    <textarea name="implementation_review_comments">{{ $audit_data->implementation_review_comments }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Implementation_Completed_On">Implementation Completed On</label>
                                    <input type="date" name="implementation_completed_on" value="{{ $audit_data->implementation_completed_on }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Closure_Report_Issued_On">Audit Closure Report Issued On</label>
                                    <input type="date" name="audit_closure_report_issued_on" value="{{ $audit_data->audit_closure_report_issued_on }}">
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Audit_Closure_Attachments">Audit Closure Attachments</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach7">
                                            @if ($audit_data->audit_closure_attachments)
                                            @foreach ($audit_data->audit_closure_attachments as $file)
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
                                            <input type="file" id="myfile" name="audit_closure_attachments[]" oninput="addMultipleFiles(this, 'file_attach7')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Closure_Done_By">CTL Audit Closure Done By</label>
                                    <input type="date" name="ctl_audit_closure_done_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Closure_Done_On">CTL Audit Closure Done On</label>
                                    <input type="date" name="ctl_audit_closure_done_on">
                                </div>
                            </div>--}}

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

                    <div id="CCForm10" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">Submit</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>Submitted By :</b></label>
                                            <div class="">{{ $audit_data->submitted_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Submitted On : </b></label>
                                            <div class="date">{{ $audit_data->submitted_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Submitted Comments : </b></label>
                                            <div class="date">{{ $audit_data->submitted_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">Cancel</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>Cancelled By :</b></label>
                                            <div class="">{{ $audit_data->cancelled_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Cancelled On : </b></label>
                                            <div class="date">{{ $audit_data->cancelled_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Cancelled Comments : </b></label>
                                            <div class="date">{{ $audit_data->cancelled_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">CTL Audit Preparation Complete</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>Preparation Completed By :</b></label>
                                            <div class="">{{ $audit_data->preparation_completed_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Preparation Completed On : </b></label>
                                            <div class="date">{{ $audit_data->preparation_completed_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Preparation Completed Comments : </b></label>
                                            <div class="date">{{ $audit_data->preparation_completed_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">More Info from open state</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>More Info from open state By :</b></label>
                                            <div class="">{{ $audit_data->open_state_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>More Info from open state On : </b></label>
                                            <div class="date">{{ $audit_data->open_state_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>More Info from open state Comments : </b></label>
                                            <div class="date">{{ $audit_data->open_state_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">CTL Audit Complete</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>CTL Audit Completed By :</b></label>
                                            <div class="">{{ $audit_data->completed_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>CTL Audit Completed On : </b></label>
                                            <div class="date">{{ $audit_data->completed_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>CTL Audit Completed Comments : </b></label>
                                            <div class="date">{{ $audit_data->completed_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">More Info from CTL Audit Preparation</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>CTL Audit Prepared By :</b></label>
                                            <div class="">{{ $audit_data->audit_preparation_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>CTL Audit Prepared On : </b></label>
                                            <div class="date">{{ $audit_data->audit_preparation_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>CTL Audit Prepared Comments : </b></label>
                                            <div class="date">{{ $audit_data->audit_preparation_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">CTL Audit Report Complete</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>CTL Audit Report Completed By :</b></label>
                                            <div class="">{{ $audit_data->report_completed_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>CTL Audit Report Completed On : </b></label>
                                            <div class="date">{{ $audit_data->report_completed_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>CTL Audit Report Completed Comments : </b></label>
                                            <div class="date">{{ $audit_data->report_completed_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">More Info from CTL Audit Execution</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>More Info from CTL Audit Executed By :</b></label>
                                            <div class="">{{ $audit_data->audit_executed_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>More Info from CTL Audit Executed On : </b></label>
                                            <div class="date">{{ $audit_data->audit_executed_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>More Info from CTL Audit Executed Comments : </b></label>
                                            <div class="date">{{ $audit_data->audit_executed_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">CTL Audit Report Issued</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>CTL Audit Report Issued By :</b></label>
                                            <div class="">{{ $audit_data->report_issued_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>CTL Audit Report Issued On : </b></label>
                                            <div class="date">{{ $audit_data->report_issued_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>CTL Audit Report Issued Comments : </b></label>
                                            <div class="date">{{ $audit_data->report_issued_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">More Info from CTL Audit Report Prepration</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>More Info from CTL Audit Report Prepared By :</b></label>
                                            <div class="">{{ $audit_data->report_prepared_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>More Info from CTL Audit Report Prepared On : </b></label>
                                            <div class="date">{{ $audit_data->report_prepared_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>More Info from CTL Audit Report Prepared Comments : </b></label>
                                            <div class="date">{{ $audit_data->report_prepared_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">CTL Response Received</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>CTL Response Received By :</b></label>
                                            <div class="">{{ $audit_data->response_received_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>CTL Response Received On : </b></label>
                                            <div class="date">{{ $audit_data->response_received_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>CTL Response Received Comments : </b></label>
                                            <div class="date">{{ $audit_data->response_received_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">CTL Audit Compliance Acceptance Complete</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>Compliance Acceptance Completed By :</b></label>
                                            <div class="">{{ $audit_data->acceptance_completed_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Compliance Acceptance Completed On : </b></label>
                                            <div class="date">{{ $audit_data->acceptance_completed_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Compliance Acceptance Completed Comments : </b></label>
                                            <div class="date">{{ $audit_data->acceptance_completed_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">CTL Audit Compliance Approval Complete</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>Compliance Approval Completed By :</b></label>
                                            <div class="">{{ $audit_data->approval_completed_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Compliance Approval Completed On : </b></label>
                                            <div class="date">{{ $audit_data->approval_completed_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Compliance Approval Completed Comments : </b></label>
                                            <div class="date">{{ $audit_data->approval_completed_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">More Info from CTL Audit Compliance Accept</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>Compliance Accepted By :</b></label>
                                            <div class="">{{ $audit_data->compliance_accepted_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Compliance Accepted On : </b></label>
                                            <div class="date">{{ $audit_data->compliance_accepted_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Compliance Accepted Comments : </b></label>
                                            <div class="date">{{ $audit_data->compliance_accepted_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">Audit Compliance Monitoring Complete</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>Compliance Monitoring Completed By :</b></label>
                                            <div class="">{{ $audit_data->monitoring_completed_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Compliance Monitoring Completed On : </b></label>
                                            <div class="date">{{ $audit_data->monitoring_completed_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Compliance Monitoring Completed Comments : </b></label>
                                            <div class="date">{{ $audit_data->monitoring_completed_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">CTL Audit Conclusion Complete</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>Conclusion Completed By :</b></label>
                                            <div class="">{{ $audit_data->conclusion_completed_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Conclusion Completed On : </b></label>
                                            <div class="date">{{ $audit_data->conclusion_completed_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Conclusion Completed Comments : </b></label>
                                            <div class="date">{{ $audit_data->conclusion_completed_comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">More Info from CTL Audit Compliance Accept</div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Victim"><b>More Info from CTL Audit Compliance Accepted By :</b></label>
                                            <div class="">{{ $audit_data->audit_comp_accepted_by }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>More Info from CTL Audit Compliance Accepted On : </b></label>
                                            <div class="date">{{ $audit_data->audit_comp_accepted_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="group-input">
                                            <label for="Division Code"><b>More Info from CTL Audit Compliance Accepted Comments : </b></label>
                                            <div class="date">{{ $audit_data->audit_comp_accepted_comment }}
                                            </div>
                                        </div>
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
        ele: '#related_records, #hod, #application_sites, #name_of_co_auditor'
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
    document.getElementById('clearSelection').addEventListener('click', function() {
        var radios = document.querySelectorAll('input[type="radio"]');
        for (var i = 0; i < radios.length; i++) {
            radios[i].checked = false;
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#Auditee').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="auditee[' + serialNumber + '][Name]"></td>' +
                    '<td><input type="text" name="auditee[' + serialNumber + '][DesignationPosition]"></td>' +
                    '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#Auditee-instruction-modal tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#Key_Personnel_Met_During_Audit').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="key_personnel_met_during_audit[' + serialNumber + '][Name]"></td>' +
                    '<td><input type="text" name="key_personnel_met_during_audit[' + serialNumber + '][DesignationPosition]"></td>' +
                    '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#Key_Personnel_Met_During_Audit-field-table tbody');
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
    $(document).ready(function() {
        $('#Product_Material').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#Product-Material-field-instruction-modal tbody');
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const removeButtons = document.querySelectorAll('.remove-file');

        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
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
@endsection
