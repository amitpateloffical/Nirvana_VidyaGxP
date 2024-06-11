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
$users = DB::table('users')->get();
@endphp

<div class="form-field-head">

    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        /National Approval
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
                    $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => 7])->get();
                    $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp

                    <button class="button_theme1"> <a class="text-white" href="{{ url('audit_trail_np', $national->id) }}"> Audit Trail </a> </button>

                    @if ($national->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Send Translation
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Cancel
                    </button>
                    @elseif($national->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Approval Received
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target=" #cancel-modal">
                        Refused
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                        Withdraw
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                        Child
                    </button>
                    @elseif($national->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Retire
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Add Updates
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                        Child
                    </button>

                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                    Update Done
                    </button> -->

                    @elseif($national->stage == 4 &&
                    (in_array(5, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))

                    <button class="button_theme1" data-bs-toggle="modal" name="test_not_required" data-bs-target="#signature-modal">
                        Update Done
                    </button>
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                       Re-Validation
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Deviation Occurred
                    </button> -->

                    @elseif($national->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Take Out of Service
                    </button> -->
                    <!-- 
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qasend">
                                        Document Completed
                                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                        QA Final Review Complete
                                    </button>
                                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                        Child
                                    </button>  -->
                    @elseif($national->stage == 6 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                       Forward to Storage
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" name="re_active_not" data-bs-target="#cancel-modal">
                       Re-Activate
                    </button> 
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                       Re-Validation
                    </button> -->

                    @elseif($national->stage == 7 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Retire
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Report Reject
                    </button> -->
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Obsolete
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                        Initiator Updated Complete
                                    </button> -->
                    @elseif($national->stage == 5 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Obsolete
                    </button> -->

                    @endif
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>
                </div>
            </div>


            <div class="status">
                <div class="head">Current Status</div>
                @if ($national->stage == 0)
                <div class="progress-bars ">
                    <div class="bg-danger">Closed-Cancelled</div>
                </div>
                @elseif ($national->stage == 6)
                <div class="progress-bars ">
                    <div class="bg-danger">Closed – Not Approved </div>
                </div>
                @elseif ($national->stage == 7)
                <div class="progress-bars ">
                    <div class="bg-danger">Closed - Withdrawn</div>
                </div>
                @else
                <div class="progress-bars d-flex" style="font-size: 15px;">
                    @if ($national->stage >= 1)
                    <div class="active">Opened</div>
                    @else
                    <div class="">Opened</div>
                    @endif

                    @if ($national->stage >= 2)
                    <div class="active">Authority Assessment</div>
                    @else
                    <div class="">Authority Assessment</div>
                    @endif

                    @if ($national->stage >= 3)
                    <div class="bg-danger">Approved</div>
                    @else
                    <div class="">Approved</div>
                    @endif

                    @if ($national->stage >= 4)
                    <div class="active">Update Ongoing</div>
                    @else
                    <div class="">Update Ongoing</div>
                    @endif


                    <!-- @if ($national->stage >= 5)
                    <div class="active">Closed - Retired
                    </div>
                    @else
                    <div class="">Closed - Retired
                    </div>
                    @endif -->
                    <!-- @if ($national->stage >= 6)
                    <div class="active">Out of Service</div>
                    @else
                    <div class="">Out of Service</div>
                    @endif -->
                    <!-- @if ($national->stage >= 7)
                    <div class="active">In Storage</div>
                    @else
                    <div class="">In Storage</div>
                    @endif -->
                    <!-- @if ($national->stage >= 8)
                    <div class="active">Active Document</div>
                    @else
                    <div class="">Active Document</div>
                    @endif -->

                    @if ($national->stage >= 5)
                    <div class="bg-danger">Closed - Retired</div>
                    @else
                    <div class="">Closed - Retired</div>
                    @endif
                    {{-- @endif --}}
                </div>
                @endif
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">National Approval</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Approval Plan</button>
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Manufacturer detail</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Registration information</button> -->
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button>
        </div>

        <script>
                $(document).ready(function() {
                    <?php if ($national->stage == 5): ?>
                        $("#target :input").prop("disabled", true);
                    <?php endif; ?>
                });
            </script>

        <form id="target" action="{{ route('national_approval.update', $national->id) }}" method="POST" enctype="multipart/form-data">
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
                            <div class="sub-head">
                                General Information
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Manufacturer">(Root Parent) Manufacturer</label>
                                    <input type="text" name="manufacturer" id="" value="{{$national->manufacturer}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Trade Name">(Root Parent) Trade Name</label>
                                    <input type="text" name="trade_name" id="" value="{{$national->trade_name}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator" value="" value="{{$national->initiator}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiation"><b>Date of Initiation</b></label>
                                    <!-- <input disabled type="date" name="Date_of_Initiation" value="">
                                    <input type="hidden" name="initiation_date" value=""> -->
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" id="initiation_date_display">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" id="intiation_date" name="initiation_date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <!-- <label for="RLS Record Number">Record Number</label> -->
                                    <label for="RLS Record Number">Record Number</label>
                                    <input disabled type="text" name="record" value="{{ Helpers::getDivisionName($national->division_id) }}/NP/{{ Helpers::year($national->created_at) }}/{{ $national->record }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="assign_to">Select a value</option>
                                        @foreach ($users as $datas)
                                        @if(Helpers::checkUserRolesassign_to($datas))
                                        <option value="{{ $datas->id }}" {{ $national->assign_to == $datas->id ? 'selected' : '' }}>
                                            {{ $datas->name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due</label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{$national->due_date}}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Procedure Type">(Parent) Procedure Type</label>
                                    <select name="procedure_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($national->procedure_type == 1) selected @endif>1</option>
                                        <option value="2" @if ($national->procedure_type == 2) selected @endif>2</option>
                                        <option value="3" @if ($national->procedure_type == 3) selected @endif>3</option>
                                        <option value="4" @if ($national->procedure_type == 4) selected @endif>4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Procedure Type">Planned Subnission Date</label>
                                    <input type="date" name="planned_subnission_date" id="" value="{{$national->planned_subnission_date}}">

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" value="{{$national->short_description}}" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Member State">Member State</label>
                                    <input type="text" name="member_state" value="{{$national->member_state}}" id="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Local Trade Name</label>
                                    <input type="text" name="local_trade_name" value="{{$national->local_trade_name}}" id="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Registration Number</label>
                                    <input type="number" name="registration_number" value="{{$national->registration_number}}" id="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Renewal Rule">Renewal Rule</label>
                                    <select name="renewal_rule">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($national->renewal_rule == 1) selected @endif>1</option>
                                        <option value="2" @if ($national->renewal_rule == 2) selected @endif>2</option>
                                        <option value="3" @if ($national->renewal_rule == 3) selected @endif>3</option>
                                        <option value="4" @if ($national->renewal_rule == 4) selected @endif>4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Dossier Parts">Dossier Parts</label>
                                    <textarea name="dossier_parts" id="" cols="30" rows="3">{{$national->dossier_parts}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Related Dossier Documents">Related Dossier Documents</label>
                                    <select name="related_dossier_documents">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($national->related_dossier_documents == 1) selected @endif>1</option>
                                        <option value="2" @if ($national->related_dossier_documents == 2) selected @endif>2</option>
                                        <option value="3" @if ($national->related_dossier_documents == 3) selected @endif>3</option>
                                        <option value="4" @if ($national->related_dossier_documents == 4) selected @endif>4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Pack Size">Pack Size</label>
                                    <input type="text" name="pack_size" value="{{$national->pack_size}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Shelf Life">Shelf Life</label>
                                    <select name="shelf_life">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($national->shelf_life == 1) selected @endif>1</option>
                                        <option value="2" @if ($national->shelf_life == 2) selected @endif>2</option>
                                        <option value="3" @if ($national->shelf_life == 3) selected @endif>3</option>
                                        <option value="4" @if ($national->shelf_life == 4) selected @endif>4</option>
                                    </select>
                                </div>
                            </div>



                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Packaging Information({{ is_array($details) ? count($details) : 0 }})
                                    <button type="button" name="details" id="Details-add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Details-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Primary Packaging</th>
                                                <th style="width: 16%">Material</th>
                                                <th style="width: 16%">Pack Size</th>
                                                <th style="width: 16%">Shelf Life</th>
                                                <th style="width: 15%">Storage Condition</th>
                                                <th style="width: 15%">Secondary Packaging</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (is_array($details))
                                            @foreach($details as $index => $detail)
                                            <tr>
                                                <td><input disabled type="text" name="details[{{ $index }}][serial]" value="{{ $index + 1 }}"></td>
                                                <td><input type="text" name="details[{{ $index }}][primary_packaging]" value="{{ $detail['primary_packaging'] }}"></td>
                                                <td><input type="text" name="details[{{ $index }}][material]" value="{{ $detail['material'] }}"></td>
                                                <td><input type="text" name="details[{{ $index }}][pack_size]" value="{{ $detail['pack_size'] }}"></td>
                                                <td><input type="text" name="details[{{ $index }}][shelf_life]" value="{{ $detail['shelf_life'] }}"></td>
                                                <td><input type="text" name="details[{{ $index }}][storage_condition]" value="{{ $detail['storage_condition'] }}"></td>
                                                <td><input type="text" name="details[{{ $index }}][secondary_packaging]" value="{{ $detail['secondary_packaging'] }}"></td>
                                                <td><input type="text" name="details[{{ $index }}][remarks]" value="{{ $detail['remarks'] }}"></td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <script>
                                document.getElementById('Details-add').addEventListener('click', function() {
                                    var table = document.getElementById('Details-table').getElementsByTagName('tbody')[0];
                                    var rowCount = table.rows.length;
                                    var row = table.insertRow(rowCount);

                                    row.innerHTML = `
            <td><input disabled type="text" name="details[${rowCount}][serial]" value="${rowCount + 1}"></td>
            <td><input type="text" name="details[${rowCount}][primary_packaging]"></td>
            <td><input type="text" name="details[${rowCount}][material]"></td>
            <td><input type="text" name="details[${rowCount}][pack_size]"></td>
            <td><input type="text" name="details[${rowCount}][shelf_life]"></td>
            <td><input type="text" name="details[${rowCount}][storage_condition]"></td>
            <td><input type="text" name="details[${rowCount}][secondary_packaging]"></td>
            <td><input type="text" name="details[${rowCount}][remarks]"></td>
        `;
                                });
                            </script>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="PSUP Cycle">PSUP Cycle</label>
                                    <select name="psup_cycle">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($national->psup_cycle == 1) selected @endif>1</option>
                                        <option value="2" @if ($national->psup_cycle == 2) selected @endif>2</option>
                                        <option value="3" @if ($national->psup_cycle == 3) selected @endif>3</option>
                                        <option value="4" @if ($national->psup_cycle == 4) selected @endif>4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Expiration Date">Expiration Date</label>
                                    <input type="date" name="expiration_date" value="{{$national->expiration_date}}">
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
                            <div class="sub-head">
                                Approval Plan
                            </div>
                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Patient_Involved">Assigned To</label>
                                    <input type="text" name="ap_assigned_to" id="" value="{{$national->ap_assigned_to}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Due">Date Due</label>
                                    <input type="date" name="ap_date_due" value="{{$national->ap_date_due}}">
                                </div>
                            </div> -->

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Auditee">Approval Status</label>
                                    <!-- <select multiple name="approval_status" placeholder="Select Auditee" data-search="false" data-silent-initial-value-set="true" id="Auditee">
                                        <option value="">cfgg</option> 
                                    </select> -->
                                    <select name="approval_status" value="{{$national->approval_status}}">
                                        <!-- <option value="">Enter Your Selection Here</option> -->
                                        <option value="status-1">status-1</option>
                                        <option value="status-2">status-2</option>
                                        <option value="status-3">status-3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Marketing Authorization Holder">Marketing Authorization Holder</label>
                                    <input type="text" name="marketing_authorization_holder" value="{{$national->marketing_authorization_holder}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Planned Submission Date">Planned Submission Date</label>
                                    <input type="date" name="planned_submission_date" value="{{$national->planned_submission_date}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Submission Date">Actual Submission Date</label>
                                    <input type="date" name="actual_submission_date" value="{{$national->actual_submission_date}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Planned Approval Date">Planned Approval Date</label>
                                    <input type="date" name="planned_approval_date" value="{{$national->planned_approval_date}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Approval Date">Actual Approval Date</label>
                                    <input type="date" name="actual_approval_date" value="{{$national->actual_approval_date}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Withdrawn Date">Actual Withdrawn Date</label>
                                    <input type="date" name="actual_withdrawn_date" value="{{$national->actual_withdrawn_date}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Rejection Date">Actual Rejection Date</label>
                                    <input type="date" name="actual_rejection_date" value="{{$national->actual_rejection_date}}">
                                </div>
                            </div>

                            <div class="col-lg-12 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Comments">Comments</label>
                                    <textarea name="comments" id="" cols="30" rows="3">{{$national->comments}}</textarea>
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
                </div>

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Started by">Started By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Started on">Started On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Submitted by">Submitted By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Submitted on">Submitted On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Approved by">Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Approved on">Approved On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Refused by">Refused By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Refused On">Refused On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Withdrawn by">Withdrawn By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Withdrawn On">Withdrawn On</label>
                                    <div class="Date"></div>
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
        $('#Packaging_Information').click(function(e) {
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

            var tableBody = $('#Packaging_Information-field-instruction-modal tbody');
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

<!-- signature model -->

<div class="modal fade" id="more-info-required-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('nationalApprovalReject', $national->id) }}" method="POST">
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

<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('nationalApprovalCancel', $national->id) }}" method="POST">
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


<div class="modal fade" id="deviationIsCFTRequired">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            
            <form action="{{ url('deviationIsCFTRequired', $national->id) }}" method="POST">
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


                <div class="modal-footer">
                    <button type="submit">Submit</button>
                    <button type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="sendToInitiator">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('national_approval_check', $national->id) }}" method="POST">
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
<div class="modal fade" id="hodsend">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('national_approval_check2', $national->id) }}" method="POST">
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
<div class="modal fade" id="qasend">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('national_approval_check3', $national->id) }}" method="POST">
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


<div class="modal fade" id="child-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <form action="{{ route('np_child_1', $national->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        @if ($national->stage == 2)
                        <label style="display: flex;" for="major">
                            <input type="radio" name="child_type" id="major" value="correspondence">
                            Correspondence
                        </label>
                        @else($national->stage == 3)

                        <label style="display: flex;" for="major">
                            <input type="radio" name="child_type" id="major" value="variation">
                            Variation
                        </label>

                        <label for="major">
                            <input type="radio" name="child_type" id="major" value="renewal">
                            Renewal
                        </label>

                        <label for="major">
                            <input type="radio" name="child_type" id="major" value="correspondence">
                            Correspondence
                        </label>
                        <label for="major">
                            <input type="radio" name="child_type" id="major" value="osur">
                            PSUR
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


<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('national_approval_send_stage', $national->id) }}" method="POST">
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
<div class="modal fade" id="cft-not-reqired">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cftnotreqired', $national->id) }}" method="POST">
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
<div class="modal fade" id="modal1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('np_qa_more_info', $national->id) }}" method="POST">
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

@endsection