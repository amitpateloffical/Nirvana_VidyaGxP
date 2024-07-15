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


@php
    $users=DB::table('users')->select('id','name')->get();
@endphp
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

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(5) {
        border-radius: 0px 20px 20px 0px;

    }
</style>




<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / RT-Commitment
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
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $commit->division_id])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    //   dd($userRoles);
                    @endphp
                    <button class="button_theme1" onclick="window.print();return false;"
                        class="new-doc-btn">Print</button>
                        <button class="button_theme1"> <a class="text-white" href="{{ route('commitment.audittrail', $commit->id) }}">
                            Audit Trail </a> </button>

                    @if ($commit->stage == 1)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Acknowledge
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                         {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child --}}
                    @elseif($commit->stage == 2)

                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Task Completed
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
                 @if ($commit->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>

                        @else
                        <div class="progress-bars d-flex">
                            @if ($commit->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($commit->stage >= 2)
                                <div class="active">Execution in Progress</div>
                            @else
                                <div class="">Execution in Progress</div>
                            @endif
                        @if ($commit->stage >= 3)
                        <div class="bg-danger">Closed Done</div>
                       @else
                        <div class="">Closed Done</div>
                    @endif
                    @endif
                        </div>

            </div>

        </div>

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Commitment Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Contact Tracking Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Risk Factors</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Signatures</button>

        </div>

        <form action="{{ route('comm_Update',$commit->id) }}" method="POST" enctype="multipart/form-data" id="target">
            @csrf
            @method('put');



<script>
                $(document).ready(function() {
                    <?php if ($commit->stage == 3): ?>
                        $("#target :input").prop("disabled", true);
                    <?php endif; ?>
                });
            </script>

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

                                    <label for="RLS Record Number"><b>(Parent) Member State</b></label>
                                    <input type="text" name="member_state"   maxlength="255" value="{{ $commit->member_state}}">


                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">

                                    <label for="RLS Record Number"><b>(Parent) Trade Name</b></label>
                                    <input type="text" name="trade_name"  maxlength="255"  value="{{ $commit->trade_name}}">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Record">Record no.</label>
                                    <input disabled type="text" name="record"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}MEDICAL/{{ date('Y') }}/{{ $commit->record }}">
                                </div>
                            </div>

                            {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code </b></label>
                                    <input readonly type="text" name="division_code"
                                        value="{{ Helpers::divisionNameForQMS($commit->division_id) }}/{{ Helpers::year($commit->created_at) }}/{{ str_pad($commit->id, 4, '0', STR_PAD_LEFT) }}
">                                      </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input readonly type="text" name="division_id"
                                            value="{{ Helpers::getDivisionName($commit->division_id) }}">

                                    </div>
                                </div>

                            <div class="col-lg-6">
                                <div class="group-input">

                                    <label for="RLS Record Number"><b>Initiator</b></label>
                                    <input type="hidden" name="initiator" value="{{ auth()->id() }}">
                                    <input disabled type="text" name="initiator " maxlength="255" value="{{ auth()->user()->name }}">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date of Initiation</b></label>
                                    <input readonly type="text" value="{{ date('d-m-Y') }}"
                                    name="date_of_initiaton">
                                <input type="hidden" value="{{ date('Y-m-d') }}" maxlength="255" name="date_of_initiaton">

                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span>
                                        <p>255 characters remaining </p>
                                        <input id="docname" type="text" name="short_description" maxlength="255" required  value="{{ $commit->short_description}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Assigned To</label>
                                    <select name="assigned_to">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $commit->assigned_to == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->assigned_to == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->assigned_to == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Type</label>
                                    <select name="type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $commit->type == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->type == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->type == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>

                           <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Due Date">Date Due</label>
                                    <p class="text-primary"> Please mention expected date of completion</p>
                                    <div class="calenderauditee">
                                        {{-- <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}"
                                            class="hide-input" oninput="handleDateInput(this, 'due_date')" /> --}}
                                            <input type="text" value="{{ $commit->due_date }}" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" value="{{ $commit->due_date }}" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />

                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field pt-3">
                                <div class="group-input input-date">
                                    <label for="due-date">(Parent) Date Due to Authority <span class="text-danger"></span></label>

                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $commit->authority_duedate }}" id="authority_duedate" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $commit->authority_duedate }}" name="authority_duedate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'authority_duedate')" />

                                    </div>
                                </div>
                            </div>


                            <div class="sub-head">Commitment Plan</div>
                            <p class="text-primary">Important Dates</p>


                            <div class="col-md-6 new-date-data-field pt-3">
                                <div class="group-input input-date">

                                    <label for="due-date">Scheduled Start Date <span class="text-danger"></span></label>

                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $commit->start_date }}" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $commit->start_date }}" name="start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'start_date')" />

                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 new-date-data-field pt-3">
                                <div class="group-input input-date">
                                    <label for="due-date">Scheduled End Date <span class="text-danger"></span></label>

                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $commit->end_date }}" id="end_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $commit->end_date }}" name="end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'end_date')" />


                                    </div>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Action Plan (0)
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
                                                <th style="width: 16%">Action</th>
                                                <th style="width: 16%">Responsible</th>
                                                <th style="width: 16%">Deadline</th>
                                                <th style="width: 16%">Item Status</th>
                                                <th style="width: 16%">Remarks</th>
                                                <th style="width: 16%">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($actionData && is_array($actionData))
                                            @foreach ($actionData as $gridData)
                                                <tr>
                                                    <td> <input disabled type="text" name="Action_plan[{{ $loop->index }}][serial]" value="{{ $loop->index+1 }}"></td>
                                                    <td>
                                                        <input class="currentDocNumber" type="text" name="Action_plan[{{ $loop->index }}][Action_plan]" value="{{ isset($gridData['Action_plan']) ? $gridData['Action_plan'] : '' }}">
                                                    </td>
                                                    <td>
                                                        <input class="currentVersionNumber" type="text" name="Action_plan[{{ $loop->index }}][Responsible]" value="{{ isset($gridData['Responsible']) ? $gridData['Responsible'] : '' }}">
                                                    </td>
                                                    <td>
                                                        <input class="newDocNumber" type="date" name="Action_plan[{{ $loop->index }}][Deadline]" value="{{ isset($gridData['Deadline']) ? $gridData['Deadline'] : '' }}">
                                                    </td>
                                                    <td>
                                                        <input class="newVersionNumber" type="text" name="Action_plan[{{ $loop->index }}][ItemStatus]" value="{{ isset($gridData['ItemStatus']) ? $gridData['ItemStatus'] : '' }}">
                                                    </td>
                                                    <td>
                                                        <input class="newVersionNumber" type="text" name="Action_plan[{{ $loop->index }}][Remarks]" value="{{ isset($gridData['Remarks']) ? $gridData['Remarks'] : '' }}">
                                                    </td>
                                                    <td><button onclick="removeRow(this)">Remove</button></td>
                                                </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td><input disabled type="text" name="Action_plan[0][serial]" value="1"></td>
                                                <td><input type="text" name="Action_plan[0][Action_plan]"></td>
                                                {{-- <td><input type="text" name="Action_plan[0][atc_Search]"></td> --}}
                                                <td><input type="text" name="Action_plan[0][Responsible]"></td>
                                                <td><input type="date" name="Action_plan[0][Deadline]"></td>
                                                <td><input type="text" name="Action_plan[0][ItemStatus]"></td>
                                                <td><input type="text" name="Action_plan[0][Remarks]"></td>
                                                {{-- <td><input type="text" class="Action" name="" readonly></td> --}}
                                                <td><button type="text" class="removeRow"> Remove </button></td>

                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <script>
                                function removeRow(button) {
                                    // Find the row containing the button
                                    var row = button.parentNode.parentNode;
                                    // Remove the row from the table
                                    row.parentNode.removeChild(row);
                                }
                            </script>
                            <script>
                                $(document).ready(function() {
                                    let actionDataIndex = {{ $actionData && is_array($actionData) ? count($actionData) : 1 }};
                                    $('#ReferenceDocument').click(function(e) {
                                        function generateTableRow(serialNumber) {


                                            var html =
                                                '<tr>' +
                                                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber +'"></td>' +
                                                '<td><input type="text" name="Action_plan[' + actionDataIndex + '][Action]"></td>' +
                                                '<td><input type="text" name="Action_plan[' + actionDataIndex + '][Responsible]"></td>' +
                                                '<td><input type="date" name="Action_plan[' + actionDataIndex + '][Deadline]"></td>' +
                                                '<td><input type="text" name="Action_plan[' + actionDataIndex + '][ItemStatus]"></td>' +
                                                '<td><input type="text" name="Action_plan[' + actionDataIndex + '][Remarks]"></td>' +
                                                '<td><button type="text" class="removeRowBtn"> Remove </button></td>' +


                                                '</tr>';
                                                actionDataIndex++;

                                            return html;
                                        }

                                        var tableBody = $('#ReferenceDocument_details tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount + 1);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>

                            <div class=" pt-3 col-lg-6">
                                <div class="group-input">

                                    <label for="RLS Record Number"><b>Estimated Man-Hours</b></label>
                                    <input type="text" name="estimated_man"   maxlength="255" value="{{ $commit->estimated_man}}">


                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Inv Attachments"> Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="file_attach">
                                            @if ($commit->file_attach)
                                                @foreach(json_decode($commit->file_attach) as $file)
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
                                            <input type="file" id="file_attach" name="file_attach[]"
                                                oninput="addMultipleFiles(this, 'file_attach')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>


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

                            <div class="sub-head">Commitment Summary</div>
                            <p class="text-primary">The main commitment steps and findings</p>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Actions">Summary<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="summary"value="">{{ $commit->summary}}</textarea>
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

                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="pt-2 col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">(Parent) Priority Level</label>
                                    <select name="priority_level">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $commit->priority_level == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->priority_level == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->priority_level == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) Local Trade Name</b></label>
                                    <p class="text-primary">Person responsible</p>
                                    <input type="text" name="person_responsible"   maxlength="255" value="{{ $commit->person_responsible}}">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Parent Authority</label>
                                    <select name="parent_authority">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $commit->parent_authority == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->parent_authority == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->parent_authority == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">(Parent) Authority Type</label>
                                    <select name="authority_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $commit->authority_type == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->authority_type == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->authority_type == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Actions">(Parent) Description <span class="text-danger"></span></label>
                                    <textarea name="description"value="">{{ $commit->description}}</textarea>
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

                <!-- <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Audit Summary</div>
                            <div class="col-6">
                                <div class="group-input">

                                    <label for="Division Code"><b>Actual start Date</b></label>

                                    <input type="date" name="division_code" value="">


                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">

                                    <label for="Division Code"><b>Actual end Date</b></label>

                                    <input type="date" name="division_code" value="">


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
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="sub-head"> Response Summary</div>
                            <div class="col-6">
                                <div class="group-input">

                                    <label for="Division Code"><b>Date of Response</b></label>

                                    <input type="date" name="division_code" value="">


                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Attached File</label>
                                    <select name="departments">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
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

                {{-- <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Actual_Amount ">Completed by :</label>
                                    <div class="date"></div>

                                </div>
                            </div>
                            <div class="col-6 pb-3">
                                <div class="group-input">

                                    <label for="Division Code"><b>Completed on :</b></label>
                                    <div class="date"></div>
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
                </div> --}}

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Risk Factors</div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Safety_Impact_Probability">Safety Impact Probability</label>
                                    <select name="Safety_Impact_Probability">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Safety_Impact_Probability == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Safety_Impact_Probability == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Safety_Impact_Probability == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Safety_Impact_Severity">Safety Impact Severity</label>
                                    <select name="Safety_Impact_Severity">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Safety_Impact_Severity == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Safety_Impact_Severity == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Safety_Impact_Severity == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Legal_Impact_Probability">Legal Impact Probability</label>
                                    <select name="Legal_Impact_Probability">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Legal_Impact_Probability == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Legal_Impact_Probability == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Legal_Impact_Probability == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Legal_Impact_Severity">Legal Impact Severity</label>
                                    <select name="Legal_Impact_Severity">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Legal_Impact_Severity == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Legal_Impact_Severity == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Legal_Impact_Severity == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Business_Impact_Probability">Business Impact Probability</label>
                                    <select name="Business_Impact_Probability">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Business_Impact_Probability == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Business_Impact_Probability == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Business_Impact_Probability == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Business_Impact_Severity">Business Impact Severity</label>
                                    <select name="Business_Impact_Severity">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Business_Impact_Severity == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Business_Impact_Severity == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Business_Impact_Severity == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Revenue_Impact_Probability">Revenue Impact Probability</label>
                                    <select name="Revenue_Impact_Probability">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Revenue_Impact_Probability == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Revenue_Impact_Probability == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Revenue_Impact_Probability == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Revenue_Impact_Severity">Revenue Impact Severity</label>
                                    <select name="Revenue_Impact_Severity">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Revenue_Impact_Severity == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Revenue_Impact_Severity == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Revenue_Impact_Severity == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Brand_Impact_Probability">Brand Impact Probability</label>
                                    <select name="Brand_Impact_Probability">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Brand_Impact_Probability == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Brand_Impact_Probability == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Brand_Impact_Probability == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Brand_Impact_Severity">Brand Impact Severity</label>
                                    <select name="Brand_Impact_Severity">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Brand_Impact_Severity == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Brand_Impact_Severity == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Brand_Impact_Severity == '3' ? 'selected':''}}>3</option>
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
                                        <option value="1"{{ $commit->Safety_Impact_Risk == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Safety_Impact_Risk == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Safety_Impact_Risk == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Legal_Impact_Risk">Legal Impact Risk</label>
                                    <select name="Legal_Impact_Risk">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Legal_Impact_Risk == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Legal_Impact_Risk == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Legal_Impact_Risk == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Business_Impact_Risk">Business Impact Risk</label>
                                    <select name="Business_Impact_Risk">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Business_Impact_Risk == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Business_Impact_Risk == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Business_Impact_Risk == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Revenue_Impact_Risk">Revenue Impact Risk</label>
                                    <select name="Revenue_Impact_Risk">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Revenue_Impact_Risk == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Revenue_Impact_Risk == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Revenue_Impact_Risk == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Brand_Impact_Risk">Brand Impact Risk</label>
                                    <select name="Brand_Impact_Risk">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Brand_Impact_Risk == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Brand_Impact_Risk == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Brand_Impact_Risk == '3' ? 'selected':''}}>3</option>
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
                                        <option value="1"{{ $commit->Impact == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Impact == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Impact == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Impact_Analysis">Impact Analysis</label>
                                    <textarea name="Impact_Analysis" id="" cols="30" rows="3">{{ $commit->Impact_Analysis}}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Recommended_Action">Recommended Action</label>
                                    <textarea name="Recommended_Action" id="" cols="30" rows="3">{{ $commit->Recommended_Action}}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Comments">Comments</label>
                                    <textarea name="Comments" id="" cols="30" rows="3">{{ $commit->Comments}}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Direct_Cause">Direct Cause</label>
                                    <select name="direct_Cause">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->direct_Cause == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->direct_Cause == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->direct_Cause == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Safeguarding">Safeguarding Measure Taken</label>
                                    <select name="safeguarding">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->safeguarding == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->safeguarding == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->safeguarding == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sub-head">
                                Root Cause Analysis
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Permanent">Root cause Methodology</label>
                                    <select name="root">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->root == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->root == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->root == '3' ? 'selected':''}}>3</option>
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
                                                <th style="width: 16%">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($rootData && is_array($rootData))
                                            @foreach ($rootData as $gridData)
                                                <tr>
                                                    <td> <input disabled type="text" name="root_cause[{{ $loop->index }}][serial]" value="{{ $loop->index+1 }}"></td>
                                                    <td>
                                                        <input class="currentDocNumber" type="text" name="root_cause[{{ $loop->index }}][root_cause_category]" value="{{ isset($gridData['root_cause_category']) ? $gridData['root_cause_category'] : '' }}">
                                                    </td>
                                                    <td>
                                                        <input class="currentVersionNumber" type="text" name="root_cause[{{ $loop->index }}][root_cause_sub_category]" value="{{ isset($gridData['root_cause_sub_category']) ? $gridData['root_cause_sub_category'] : '' }}">
                                                    </td>
                                                    <td>
                                                        <input class="newDocNumber" type="text" name="root_cause[{{ $loop->index }}][probability]" value="{{ isset($gridData['probability']) ? $gridData['probability'] : '' }}">
                                                    </td>
                                                    <td>
                                                        <input class="newVersionNumber" type="text" name="root_cause[{{ $loop->index }}][comments]" value="{{ isset($gridData['comments']) ? $gridData['comments'] : '' }}">
                                                    </td>
                                                    <td>
                                                        <input class="newVersionNumber" type="text" name="root_cause[{{ $loop->index }}][Remarks]" value="{{ isset($gridData['Remarks']) ? $gridData['Remarks'] : '' }}">
                                                    </td>
                                                    <td><button onclick="removeRow(this)">Remove</button></td>
                                                </tr>
                                            @endforeach
                                            @else

                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name="root_cause[0][root_cause_category]"></td>
                                            <td> <input type="text" name="root_cause[0][root_cause_sub_category]"></td>
                                            <td> <input type="text" name="root_cause[0][probability]"></td>
                                            <td> <input type="text" name="root_cause[0][comments]"></td>
                                            <td><input type="text" name="root_cause[0][Remarks]"></td>
                                            <td><button onclick="removeRow(this)">Remove</button></td>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Root_cause_Description">Root cause Description</label>
                                    <textarea name="Root_cause_Description" id="" cols="30" rows="3">{{ $commit->Root_cause_Description}}</textarea>
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
                                        <option value="1"{{ $commit->Severity_Rate == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Severity_Rate == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Severity_Rate == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Occurrence">Occurrence</label>
                                    <select name="Occurrence">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Occurrence == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Occurrence == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Occurrence == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Detection">Detection</label>
                                    <select name="Detection">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Detection == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Detection == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Detection == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="RPN">RPN</label>
                                    <select name="RPN">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->RPN == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->RPN == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->RPN == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Risk_Analysis">Risk Analysis</label>
                                    <textarea name="Risk_Analysis" id="" cols="30" rows="3">{{ $commit->Risk_Analysis}}</textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Criticality">Criticality</label>
                                    <select name="Criticality">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Criticality == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Criticality == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Criticality == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Inform_Local_Authority">Inform Local Authority?</label>
                                    <select name="Inform_Local_Authority">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->Inform_Local_Authority == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->Inform_Local_Authority == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->Inform_Local_Authority == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Authority_Type">Authority Type</label>
                                    <select name="authority">
                                        <option value="">--select--</option>
                                        <option value="1"{{ $commit->authority == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $commit->authority == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $commit->authority == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Actions">(Parent) Description <span class="text-danger"></span></label>
                                    <textarea name="parent_description">{{ $commit->parent_description}}</textarea>
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

            <div id="CCForm6" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="sub-head">
                        Electronic Signatures
                    </div>
                    <div class="row">
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="submitted by">Acknowledged By :</label>
                            <div class="static">{{ $commit->acknowledged_by}}</div>
                        </div>
                    </div>
                    <div class="col-6 pb-3">
                        <div class="group-input">
                            <label for="submitted on">Acknowledged On :</label>
                            <div class="Date">{{ $commit->acknowledged_on}}</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="cancelled by">Cancelled By :</label>
                            <div class="static">{{ $commit->cancelled_by}}</div>
                        </div>
                    </div>
                    <div class="col-6 pb-3">
                        <div class="group-input">
                            <label for="cancelled on">Cancelled On :</label>
                            <div class="Date">{{ $commit->cancelled_on}}</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="cancelled on"> Task Completed By :</label>
                            <div class="Date">{{ $commit->   completed_by}}</div>
                        </div>
                    </div>
                    <div class="col-6 pb-3">
                        <div class="group-input">
                            <label for="cancelled on"> Task Completed On :</label>
                            <div class="Date">{{ $commit->taskcompleted_on}}</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="cancelled on">Cancelled By :</label>
                            <div class="Date">{{ $commit->cancel_by}}</div>
                        </div>
                    </div>
                    <div class="col-6 pb-3">
                        <div class="group-input">
                            <label for="cancelled on">Cancelled On :</label>
                            <div class="Date">{{ $commit->cancel_on}}</div>
                        </div>
                    </div>

                     <div class="button-block">
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        {{-- <button type="submit" class="saveButton">Save</button> --}}
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
        $(document).on('click', '.removeRowBtn', function() {
        $(this).closest('tr').remove();
    })
        let rootDataIndex = {{ $rootData && is_array($rootData) ? count($rootData) : 1 }};
        $('#RootCause').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="root_cause[' + rootDataIndex + '][root_cause_category]"></td>' +
                    '<td><input type="text" name="root_cause[' + rootDataIndex + '][root_cause_sub_category]"></td>' +
                    '<td><input type="text" name="root_cause[' + rootDataIndex + ']probability"></td>' +
                    '<td><input type="text" name="root_cause[' + rootDataIndex + '][comments]"></td>' +
                    '<td><input type="text" name="root_cause[' + rootDataIndex + '][Remarks]"></td>' +
                    // '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                    '<td><button type="button" class="removeRowBtn">Remove</button></td> ' +


                    '</tr>';
                    rootDataIndex++;

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
<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('commitment.cancel', $commit->id) }}" method="POST">
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

<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('commitment.stageChange', $commit->id) }}" method="POST">
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
@endsection
