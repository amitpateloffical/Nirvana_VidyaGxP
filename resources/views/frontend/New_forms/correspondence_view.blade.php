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

<script>
    $(document).ready(function() {
        $('#ReferenceDocument').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="action_plan[' + serialNumber + '][Action]"></td>' +
                    '<td><input type="text" name="action_plan[' + serialNumber + '][Responsible]"></td>' +
                    '<td><input type="date" name="action_plan[' + serialNumber + '][Deadline]"></td>' +
                    '<td><input type="text" name="action_plan[' + serialNumber + '][ItemStatus]"></td>' +
                    '<td><input type="text" name="action_plan[' + serialNumber + '][Remarks]"></td>' +
                    '<td><button type="text" class="removeRowBtn">Remove</button></td>' +



                    //     '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' +

                    '</tr>';

                return html;
            }

            var tableBody = $('#ReferenceDocument_details tbody');
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

<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / Correspondence
    </div>
</div>

{{-- workflow css start --}}
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

    .new_style {
        width: 100%;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    #change-control-view>div.container-fluid>div.inner-block.state-block>div.status>div.progress-bars>div.canceled {
        border-radius: 20px;
    }

    /*element.style{
            border-radius:10px;
            }*/
</style>

{{-- workflow css end --}}

{{-- workflow --}}

<div id="change-control-view">
    <div class="container-fluid">
        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head">Record Workflow</div>

                <div class="d-flex" style="gap:20px;">
                    @php
                        $userRoles = DB::table('user_roles')
                            ->where([
                                'user_id' => auth()->id(),
                                'q_m_s_divisions_id' => $correspondence_data->division_id,
                            ])
                            ->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp
                    <button class="button_theme1"> <a class="text-white"
                            href="{{ route('correspondence.audit_trail', $correspondence_data->id) }}">
                            Audit Trail </a>
                    </button>

                    @if ($correspondence_data->stage == 1 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Questions Recieved
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                    @elseif($correspondence_data->stage == 2 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Finalize Response
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                    @endif
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>
                </div>

            </div>


            <div class="status">
                <div class="head">Current Status</div>
                @if ($correspondence_data->stage == 0)
                    <div class="progress-bars">
                        <div class="bg-danger canceled">Closed-Cancelled</div>
                    </div>
                @else
                    <div class="progress-bars d-flex" style="font-size: 15px;">
                        @if ($correspondence_data->stage >= 1)
                            <div class="active">Opened</div>
                        @else
                            <div class="">Opened</div>
                        @endif

                        @if ($correspondence_data->stage >= 2)
                            <div class="active">Response Preparation</div>
                        @else
                            <div class="">Response Preparation</div>
                        @endif

                        @if ($correspondence_data->stage >= 3)
                            <div class="bg-danger">Closed-Done</div>
                        @else
                            <div class="">Closed-Done</div>
                        @endif

                    </div>
                @endif
            </div>
        </div>

        {{-- workflow end --}}

        {{-- Submit Supplier Details button Model Open --}}
        <div class="modal fade" id="signature-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('correspondence.send_stage', $correspondence_data->id) }}" method="POST">
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

        {{-- Submit audit passed button Model Open --}}

        {{-- Cancel button Model Open --}}
        <div class="modal fade" id="cancel-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('correspondence.cancel', $correspondence_data->id) }}" method="POST">
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

        {{-- Cancel button Model Open --}}

        {{-- ---------Child Button Model Open--------- --}}

        <div class="modal fade" id="child-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('correspondence.child', $correspondence_data->id) }}" method="POST">
                        @csrf
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="group-input">
                                <label style="display: flex;" for="major">
                                    <input type="radio" name="child_type" id="child_type">
                                    Supplier Audit
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
        {{-- ---------Child Button Model Open--------- --}}


{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Correspondence</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Signatures</button>

        </div>

        {{-- disabled field code start --}}

        <?php if (in_array($correspondence_data->stage, [0, 3])) : ?>
        <script>
            $(document).ready(function() {
                $("#target :input").prop("disabled", true);
            });
        </script>
        <?php endif; ?>

        {{-- disabled field code end --}}


        <form id="target" action="{{ route('correspondence.update', $correspondence_data->id) }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="Initiator">Record Number </label>
                                    <input disabled type="text" name="record"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/Correspondence/{{ date('Y') }}/{{ str_pad($correspondence_data->record, 4, '0', STR_PAD_LEFT) }}">
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
                                    <input type="text" disabled name="record_number" value="{{ auth()->user()->name }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date of Initiation</b></label>
                                    <input readonly type="text" value="{{ date('d-M-Y', strtotime($correspondence_data->intiation_date)) }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d', strtotime($correspondence_data->intiation_date)) }}" name="intiation_date">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span>
                                        <p>255 charaters remaining</p>
                                        <input id="docname" type="text" name="short_description" maxlength="255" required value="{{ $correspondence_data->short_description }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assigned_to">
                                        <option value="">Select a value</option>
                                        @if(!empty($users))
                                            @foreach ($users as $user)
                                               <option value="{{ $user->id }}" {{ $user->id == $correspondence_data->assigned_to ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due <span class="text-danger"></span></label>
                                    <p class="text-primary">Please mention expected date of completion</p>
                                    <div class="calenderauditee">
                                        <input  type="hidden" value="{{ $correspondence_data->due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ \Carbon\Carbon::parse($correspondence_data->due_date)->format('d-M-Y') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        (Parent) Process/Application
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="process_application">
                                        <option value="">Select a value</option>
                                        <option value="research-and-development" @if($correspondence_data->process_application == 'research-and-development') selected @endif>Research and Development</option>
                                        <option value="regulatory-affairs" @if($correspondence_data->process_application == 'regulatory-affairs') selected @endif>Regulatory Affairs</option>
                                        <option value="quality-assurance-and-control" @if($correspondence_data->process_application == 'quality-assurance-and-control') selected @endif>Quality Assurance and Control</option>
                                        <option value="manufacturing" @if($correspondence_data->process_application == 'manufacturing') selected @endif>Manufacturing</option>
                                        <option value="clinical-operations" @if($correspondence_data->process_application == 'clinical-operations') selected @endif>Clinical Operations</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>(Root Parent) Trade Name</b></label>
                                    <input type="text" name="trade_name" value="{{ $correspondence_data->trade_name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">How Initiated</label>
                                    <select name="how_initiated">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="general-triggers" @if($correspondence_data->how_initiated == 'general-triggers') selected @endif>General Triggers</option>
                                        <option value="research-and-development" @if($correspondence_data->how_initiated == 'research-and-development') selected @endif>Research and Development</option>
                                        <option value="quality-assurance-and-control" @if($correspondence_data->how_initiated == 'quality-assurance-and-control') selected @endif>Quality Assurance and Control</option>
                                        <option value="clinical-operations" @if($correspondence_data->how_initiated == 'clinical-operations') selected @endif>Clinical Operations</option>
                                        <option value="Medical Affairs" @if($correspondence_data->how_initiated == 'Medical Affairs') selected @endif>Medical Affairs</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Type</label>
                                    <select name="type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="general-types" @if($correspondence_data->type == 'general-types') selected @endif>General Types</option>
                                        <option value="research-and-development" @if($correspondence_data->type == 'research-and-development') selected @endif>Research and Development</option>
                                        <option value="regulatory-affairs" @if($correspondence_data->type == 'regulatory-affairs') selected @endif>Regulatory Affairs</option>
                                        <option value="quality-assurance-and-control" @if($correspondence_data->type == 'quality-assurance-and-control') selected @endif>Quality Assurance and Control</option>
                                        <option value="legal-and-compliance" @if($correspondence_data->type == 'legal-and-compliance') selected @endif>Legal and Compliance</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit Attachments">File Attachments</label>
                                    <small class="text-primary">
                                        Please Attach all relevant or supporting documents
                                    </small>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach">
                                          @if ($correspondence_data->file_attachments)
                                            @foreach ($correspondence_data->file_attachments as $file)
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
                                            <input type="file" id="myfile" name="file_attachments[]" oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Authority Type</label>
                                    <select name="authority_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="regulatory-authorities" @if($correspondence_data->authority_type == 'regulatory-authorities') selected @endif>Regulatory Authorities</option>
                                        <option value="international-organizations" @if($correspondence_data->authority_type == 'international-organizations') selected @endif>International Organizations</option>
                                        <option value="national-regulatory-bodies" @if($correspondence_data->authority_type == 'national-regulatory-bodies') selected @endif>National Regulatory Bodies</option>
                                        <option value="ethics-and-compliance-committees" @if($correspondence_data->authority_type == 'ethics-and-compliance-committees') selected @endif>Ethics and Compliance Committees</option>
                                        <option value="quality-and-standards-organizations" @if($correspondence_data->authority_type == 'quality-and-standards-organizations') selected @endif>Quality and Standards Organizations</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Responsible Department">Authority</label>
                                    <select name="authority">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="occupational-safety-and-health-administration" @if($correspondence_data->authority == 'occupational-safety-and-health-administration') selected @endif>Occupational Safety and Health Administration</option>
                                        <option value="national-institute-for-occupational-safety-and-health" @if($correspondence_data->authority == 'national-institute-for-occupational-safety-and-health') selected @endif>National Institute for Occupational Safety and Health</option>
                                        <option value="international-organization-for-standardization" @if($correspondence_data->authority == 'international-organization-for-standardization') selected @endif>International Organization for Standardization</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Actions">Description<span class="text-danger"></span></label>
                                    <textarea name="description">{{ $correspondence_data->description }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Responsible Department">Commitment Required?</label>
                                    <select name="commitment_required">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="approval-of-study-protocol" @if($correspondence_data->commitment_required == 'approval-of-study-protocol') selected @endif>Approval of Study Protocol</option>
                                        <option value="submission-of-research-data" @if($correspondence_data->commitment_required == 'submission-of-research-data') selected @endif>Submission of Research Data</option>
                                        <option value="participation-in-collaborative-research" @if($correspondence_data->commitment_required == 'participation-in-collaborative-research') selected @endif>Participation in Collaborative Research</option>
                                        <option value="compliance-with-study-requirements" @if($correspondence_data->commitment_required == 'compliance-with-study-requirements') selected @endif>Compliance with Study Requirements</option>
                                        <option value="ethics-committee-approval" @if($correspondence_data->commitment_required == 'ethics-committee-approval') selected @endif>Ethics Committee Approval</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                Action Plan
                                <button type="button" name="action_plan" id="ReferenceDocument">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (open)
                                </span>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="ReferenceDocument_details" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 4%">Row#</th>
                                            <th style="width: 16%">Action</th>
                                            <th style="width: 16%">Responsible</th>
                                            <th style="width: 16%">Deadline</th>
                                            <th style="width: 16%">Item Status</th>
                                            <th style="width: 16%">Remarks</th>
                                            <th style="width: 16%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                          $data = isset($grid_Data) && $grid_Data->data ? json_decode($grid_Data->data, true) : null;
                                        @endphp

                                    @if ($data && is_array($data))
                                       @foreach ($data as $index => $item)
                                        <tr>
                                            <td><input disabled type="text" name="[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}"></td>
                                            <td><input type="text" name="action_plan[{{ $loop->index }}][Action]" value="{{ isset($item['Action']) ? $item['Action'] : '' }}"></td>
                                            <td><input type="text" name="action_plan[{{ $loop->index }}][Responsible]" value="{{ isset($item['Responsible']) ? $item['Responsible'] : '' }}"></td>
                                            <td><input type="date" name="action_plan[{{ $loop->index }}][Deadline]" value="{{ isset($item['Deadline']) ? $item['Deadline'] : '' }}"></td>
                                            <td><input type="text" name="action_plan[{{ $loop->index }}][ItemStatus]" value="{{ isset($item['ItemStatus']) ? $item['ItemStatus'] : '' }}"></td>
                                            <td><input type="text" name="action_plan[{{ $loop->index }}][Remarks]" value="{{ isset($item['Remarks']) ? $item['Remarks'] : '' }}"></td>
                                            <td><button readonly type="text" class="removeRowBtn">Remove</button></td>
                                        </tr>
                                      @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Priority Level</label>
                                    <select name="priority_level">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="general-priority-levels" @if($correspondence_data->priority_level == 'general-priority-levels') selected @endif>General Priority Levels</option>
                                        <option value="detailed-priority-levels" @if($correspondence_data->priority_level == 'detailed-priority-levels') selected @endif>Detailed Priority Levels</option>
                                        <option value="specific-contexts" @if($correspondence_data->priority_level == 'specific-contexts') selected @endif>Specific Contexts</option>
                                        <option value="quality-assurance-and-control" @if($correspondence_data->priority_level == 'quality-assurance-and-control') selected @endif>Quality Assurance and Control</option>
                                        <option value="finance-and-procurement" @if($correspondence_data->priority_level == 'finance-and-procurement') selected @endif>Finance and Procurement</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date Due to Authority</b></label>
                                    <input type="date" name="date_due_to_authority" value="{{ $correspondence_data->date_due_to_authority }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Scheduled Start Date</b></label>
                                    <input type="date" name="scheduled_start_date" value="{{ $correspondence_data->scheduled_start_date }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Scheduled End Date</b></label>
                                    <input type="date" name="scheduled_end_date" value="{{ $correspondence_data->scheduled_end_date }}">
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

                <!-- TAB 1 ENDS HERE -->

                <!-- <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Scheduled start Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="start_date" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Scheduled end Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="start_date" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Assigned To</b></label>
                                    <p class="text-primary">Person responsible</p>
                                    <input type="text" name="record_number" value="">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label class="mb-4" for="RLS Record Number"><b>CRO/Vendor</b></label>

                                    <input type="text" name="record_number" value="">

                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Date response due</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="start_date" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>




                        </div>




                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                Financial Transaction (0)
                                <button type="button" name="audit-agenda-grid" id="ReferenceDocument">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (open)
                                </span>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="ReferenceDocument_details" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 4%">Row#</th>

                                            <th style="width: 16%">Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>

                                            <td><input type="date" name="Date[]"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Co-Auditors <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Distribution List <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Scope <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Comments <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
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
                </div> -->
<!--
                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Audir Summary</div>
                            <div class="col-6">
                                <div class="group-input">

                                    <label for="Division Code"><b>Actual start Date</b></label>

                                    <input disabled type="date" name="division_code" value="">


                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">

                                    <label for="Division Code"><b>Actual end Date</b></label>

                                    <input disabled type="date" name="division_code" value="">


                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Actions">Executive Summary <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Audit Result</label>
                                    <select name="departments">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="sub-head"> Response Summary</div>
                            <div class="col-6">
                                <div class="group-input">

                                    <label for="Division Code"><b>Date of Response</b></label>

                                    <input disabled type="date" name="division_code" value="">


                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Attached File</label>
                                    <select name="departments">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Actions">Response Summary <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
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
                </div> -->

                <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Questions Recieved</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Questions Recieved By :</b></label>
                                        <div class="">{{ $correspondence_data->questions_recieved_by }}</div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Questions Recieved On : </b></label>
                                        <div class="date">{{ $correspondence_data->questions_recieved_on }}</div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Questions Recieved Comments : </b></label>
                                        <div class="date">{{ $correspondence_data->questions_recieved_comment }}
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
                                        <div class="">{{ $correspondence_data->open_cancel_by }}</div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Cancelled On : </b></label>
                                        <div class="date">{{ $correspondence_data->open_cancel_on }}</div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Cancelled Comments : </b></label>
                                        <div class="date">{{ $correspondence_data->open_cancel_comment }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Finalize Response</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Finalize Responsed By :</b></label>
                                        <div class="">{{ $correspondence_data->finalize_response_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Finalize Responsed On : </b></label>
                                        <div class="date">{{ $correspondence_data->finalize_response_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Finalize Responsed Comments : </b></label>
                                        <div class="date">{{ $correspondence_data->finalize_response_comment }}
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
                                        <div class="">{{ $correspondence_data->cancel_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Cancelled On : </b></label>
                                        <div class="date">{{ $correspondence_data->cancel_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Cancelled Comments : </b></label>
                                        <div class="date">{{ $correspondence_data->cancel_comment }}
                                        </div>
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

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Risk Factors</div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Safety_Impact_Probability">Safety Impact Probability</label>
                                    <select name="Safety_Impact_Probability">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Safety_Impact_Severity">Safety Impact Severity</label>
                                    <select name="Safety_Impact_Severity">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Legal_Impact_Probability">Legal Impact Probability</label>
                                    <select name="Legal_Impact_Probability">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Legal_Impact_Severity">Legal Impact Severity</label>
                                    <select name="Legal_Impact_Severity">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Business_Impact_Probability">Business Impact Probability</label>
                                    <select name="Business_Impact_Probability">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Business_Impact_Severity">Business Impact Severity</label>
                                    <select name="Business_Impact_Severity">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Revenue_Impact_Probability">Revenue Impact Probability</label>
                                    <select name="Revenue_Impact_Probability">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Revenue_Impact_Severity">Revenue Impact Severity</label>
                                    <select name="Revenue_Impact_Severity">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Brand_Impact_Probability">Brand Impact Probability</label>
                                    <select name="Brand_Impact_Probability">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Brand_Impact_Severity">Brand Impact Severity</label>
                                    <select name="Brand_Impact_Severity">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 sub-head">
                                Calculated Risk and Further Actions
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Safety_Impact_Risk">Safety Impact Risk</label>
                                    <select name="Safety_Impact_Risk">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Legal_Impact_Risk">Legal Impact Risk</label>
                                    <select name="Legal_Impact_Risk">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Business_Impact_Risk">Business Impact Risk</label>
                                    <select name="Business_Impact_Risk">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Revenue_Impact_Risk">Revenue Impact Risk</label>
                                    <select name="Revenue_Impact_Risk">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Brand_Impact_Risk">Brand Impact Risk</label>
                                    <select name="Brand_Impact_Risk">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sub-head">
                                General Risk Information
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Impact">Impact</label>
                                    <select name="Impact">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Impact_Analysis">Impact Analysis</label>
                                    <textarea name="Impact_Analysis" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Recommended_Action">Recommended Action</label>
                                    <textarea name="Recommended_Action" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Comments">Comments</label>
                                    <textarea name="Comments" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Direct_Cause">Direct Cause</label>
                                    <select name="Direct_Cause">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Safeguarding">Safeguarding Measure Taken</label>
                                    <select name="Safeguarding">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sub-head">
                                Root Cause Analysis
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Permanent">Root cause Methodlogy</label>
                                    <select name="Permanent">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Root Cause(0)
                                    <button type="button" name="audit-agenda-grid" id="RootCause">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#RootCause-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="RootCause-field-instruction-modal">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Root Cause Category</th>
                                                <th style="width: 16%"> Root Cause Sub Category</th>
                                                <th style="width: 16%"> Probability</th>
                                                <th style="width: 16%"> Comments</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name="IDnumber[]"></td>
                                            <td> <input type="text" name=""></td>
                                            <td> <input type="text" name=""></td>
                                            <td> <input type="text" name=""></td>
                                            <td><input type="text" name="Remarks[]"></td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Root_cause_Description">Root cause Description</label>
                                    <textarea name="Root_cause_Description" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="sub-head">
                                Risk Analysis
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Severity_Rate">Severity Rate</label>
                                    <select name="Severity_Rate">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Occurrence">Occurrence</label>
                                    <select name="Occurrence">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Detection">Detection</label>
                                    <select name="Detection">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="RPN">RPN</label>
                                    <select name="RPN">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Risk_Analysis">Risk Analysis</label>
                                    <textarea name="Risk_Analysis" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Criticality">Criticality</label>
                                    <select name="Criticality">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Inform_Local_Authority">Inform Local Authority?</label>
                                    <select name="Inform_Local_Authority">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Authority_Type">Authority Type</label>
                                    <select name="Authority_Type">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Authority(s)_Notified">Authority(s) Notified</label>
                                    <select name="Authority(s)_Notified">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Other_Authority">Other Authority</label>
                                <input type="text" name="Other_Authority">
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
                    <div class="sub-head">
                        Electronic Signatures
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="submitted by">Response Finalized By</label>
                            <div class="static"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="submitted on">Response Finalized On</label>
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
    $(document).ready(function() {
        $('#Witness_details').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="WitnessName[]"></td>' +
                    '<td><input type="text" name="WitnessType[]"></td>' +
                    '<td><input type="text" name="ItemDescriptions[]"></td>' +
                    '<td><input type="text" name="Comments[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +
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
    $(document).ready(function() {
        $('#MaterialsReleased').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
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
    $(document).ready(function() {
        $('#RootCause').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
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
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>
@endsection
