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
        $users = DB::table('users')->select('id', 'name')->get();
    @endphp

    <div class="form-field-head">
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / Meeting Management
        </div>
    </div>
    <div id="change-control-view">
        <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow </div>

                    <div class="d-flex" style="gap:20px;">
                        @php
                            $userRoles = DB::table('user_roles')
                                ->where(['user_id' => Auth::user()->id])
                                ->get();
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        @endphp
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                        <button class="button_theme1"> <a class="text-white"
                                href="{{ route('meeting_management_AuditTrial', $data->id) }}"> Audit Trail </a> </button>

                        @if ($data->stage == 1)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Auto Submit
                            </button>
                        @elseif($data->stage == 2)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>

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
                        <div class="progress-bars">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active">In Progress </div>
                            @else
                                <div class="">In Progress</div>
                            @endif
                            @if ($data->stage >= 3)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif
                    @endif



                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>

    </div>


    {{-- ! ========================================= --}}
    {{-- !               DATA FIELDS                 --}}
    {{-- ! ========================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Operational Planning & Control</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Meetings & Summary</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Closure</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button>
            </div>

            <form action="{{ route('meeting_update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div id="step-form">
                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif
                    <!-- ==========================================General Information============================================ -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">
                                    General Information
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="RLS Record Number"><b>Record Number</b></label>
                                            <input disabled type="text" name="record_number"
                                                value="{{ Helpers::getDivisionName(session()->get('division')) }}/MM/{{ date('Y') }}/{{ $data->record }}">
                                            {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Site/Location Code</b></label>
                                            <input disabled type="text" name="division_code"
                                                value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                            <input type="hidden" name="division_id"
                                                value="{{ session()->get('division') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Initiator">Initiator</label>
                                            <input disabled type="text" name="initiator"
                                                value="{{ Auth::user()->name }}" />
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-6">
                                        <div class="group-input ">
                                            <label for="Date Due"><b>Date of Initiation</b></label>
                                            <input disabled type="text" value="{{ date('d-M-Y') }}"
                                                name="intiation_date">
                                            <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Date Opened">Date of Initiation</label>
                                            @if (isset($data) && $data->intiation_date)
                                                <input disabled type="text"
                                                    value="{{ \Carbon\Carbon::parse($data->intiation_date)->format('d-M-Y') }}"
                                                    name="intiation_date_display">
                                                <input type="hidden" value="{{ $data->intiation_date }}"
                                                    name="intiation_date">
                                            @else
                                                <input disabled type="text" value="{{ date('d-M-Y') }}"
                                                    name="intiation_date_display">
                                                <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="If Others">Assigned To</label>
                                            <select name="assigned_to" onchange="">
                                                <option value="">Select a value</option>
                                                @if ($users->isNotEmpty())
                                                    @foreach ($users as $value)
                                                        <option {{ $data->assigned_to == $value->name ? 'selected' : '' }}
                                                            value='{{ $value->name }}'>{{ $value->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="If Others">Customer Name</label>
                                        <select name="Customer_names" onchange="">
                                            <option value="">Select a value</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $value)
                                                    <option {{ $data->Customer_names == $value->name ? 'selected' : '' }}
                                                        value='{{ $value->name }}'>{{ $value->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> --}}


                                    {{-- <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Due Date">Date Due</label>

                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($data->due_date)
                                                        ? new \DateTime($data->due_date)
                                                        : null;
                                                @endphp
                                                {{-- Format the date as desired --}}
                                    {{-- <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="due_date"
                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    value="{{ $data->due_date ?? '' }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'due_date')" />
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Due Date"> Due Date </label>
                                            <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                                value="{{ \Carbon\Carbon::parse($due_date)->format('d-M-Y') }}" />
                                            <input type="hidden" name="due_date" id="due_date_input"
                                                value="{{ $due_date }}" />

                                            {{-- <input type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}"> --}}
                                            {{-- <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="" name="due_date"> --}}
                                        </div>

                                    </div>
                                    {{-- <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Initiator Group"><b>Initiator Group</b></label>
                                            <select name="initiator_group"
                                                {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                                id="initiator_group">
                                                <option value="">-- Select --</option>
                                                <option value="CQA" @if ($data->initiator_group == 'CQA') selected @endif>
                                                    Corporate Quality Assurance
                                                </option>
                                                <option value="QAB" @if ($data->initiator_group == 'QAB') selected @endif>
                                                    Quality Assurance Biopharma
                                                </option>
                                                <option value="CQC" @if ($data->initiator_group == 'CQC') selected @endif>
                                                    Central Quality Control
                                                </option>
                                                <option value="MANU" @if ($data->initiator_group == 'MANU') selected @endif>
                                                    Manufacturing
                                                </option>
                                                <option value="PSG" @if ($data->initiator_group == 'PSG') selected @endif>
                                                    Plasma Sourcing Group
                                                </option>
                                                <option value="CS" @if ($data->initiator_group == 'CS') selected @endif>
                                                    Central Stores
                                                </option>
                                                <option value="ITG" @if ($data->initiator_group == 'ITG') selected @endif>
                                                    Information Technology Group
                                                </option>
                                                <option value="MM" @if ($data->initiator_group == 'MM') selected @endif>
                                                    Molecular Medicine
                                                </option>
                                                <option value="CL" @if ($data->initiator_group == 'CL') selected @endif>
                                                    Central Laboratory
                                                </option>
                                                <option value="TT" @if ($data->initiator_group == 'TT') selected @endif>
                                                    Tech team
                                                </option>
                                                <option value="QA" @if ($data->initiator_group == 'QA') selected @endif>
                                                    Quality Assurance
                                                </option>
                                                <option value="QM" @if ($data->initiator_group == 'QM') selected @endif>
                                                    Quality Management
                                                </option>
                                                <option value="IA" @if ($data->initiator_group == 'IA') selected @endif>
                                                    IT Administration
                                                </option>
                                                <option value="ACC" @if ($data->initiator_group == 'ACC') selected @endif>
                                                    Accounting
                                                </option>
                                                <option value="LOG" @if ($data->initiator_group == 'LOG') selected @endif>
                                                    Logistics
                                                </option>
                                                <option value="SM" @if ($data->initiator_group == 'SM') selected @endif>
                                                    Senior Management
                                                </option>
                                                <option value="BA" @if ($data->initiator_group == 'BA') selected @endif>
                                                    Business Administration
                                                </option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Initiator Group Code">Initiator Group Code</label>
                                            <input type="text" name="initiator_group_code" id="initiator_group_code"
                                                value="{{ $data->initiator_group_code }}" readonly>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Short Description">Initiator Department <span
                                                    class="text-danger"></span></label>
                                            <select name="initiator_group" id="initiator_group"
                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                <option selected disabled value="">---select---</option>
                                                @foreach (Helpers::getInitiatorGroups() as $code => $initiator_group)
                                                    <option value="{{ $initiator_group }}"
                                                        data-code="{{ $code }}"
                                                        @if ($data->initiator_group == $initiator_group) selected @endif>
                                                        {{ $initiator_group }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Initiator Group Code">Department Code</label>
                                            <input readonly type="text" name="initiator_group_code"
                                                id="initiator_group_code" value="{{ $data->initiator_group_code ?? '' }}"
                                                {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                        </div>
                                    </div>

                                    <script>
                                        document.getElementById('initiator_group').addEventListener('change', function() {
                                            var selectedOption = this.options[this.selectedIndex];
                                            var selectedCode = selectedOption.getAttribute('data-code');
                                            document.getElementById('initiator_group_code').value = selectedCode;
                                        });

                                        // Set the group code on page load if a value is already selected
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var initiatorGroupElement = document.getElementById('initiator_group');
                                            if (initiatorGroupElement.value) {
                                                var selectedOption = initiatorGroupElement.options[initiatorGroupElement.selectedIndex];
                                                var selectedCode = selectedOption.getAttribute('data-code');
                                                document.getElementById('initiator_group_code').value = selectedCode;
                                            }
                                        });
                                    </script>
                                    {{-- <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="Initiator Group Code">Short Description <span
                                                    class="text-danger">*</span></label><span
                                                id="initiator_group_code">255</span>
                                            characters remaining
                                            <input type="text" name="short_description" id="initiator_group_code"
                                                value="{{ $data->short_description }}">
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="Initiator Group Code">Short Description <span
                                                    class="text-danger">*</span></label><span id="rchars">255</span>
                                            characters remaining
                                            <input type="text" name="short_description" id="docname"
                                                value="{{ $data->short_description }}"maxlength="255" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="type">Type</label>
                                            <select name="type" value="{{ $data->type }}">
                                                <option value="0">-- Select type --</option>
                                                <option value="Other"{{ $data->type == 'Other' ? 'selected' : '' }}>Other
                                                </option>
                                                <option value="Training"{{ $data->type == 'Training' ? 'selected' : '' }}>
                                                    Training</option>
                                                <option value="Finance"{{ $data->type == 'Finance' ? 'selected' : '' }}>
                                                    Finance</option>
                                                <option
                                                    value="Follow Up"{{ $data->type == 'Follow Up' ? 'selected' : '' }}>
                                                    Follow Up</option>
                                                <option
                                                    value="Marketing"{{ $data->type == 'Marketing' ? 'selected' : '' }}>
                                                    Marketing</option>
                                                <option value="Sales"{{ $data->type == 'Sales' ? 'selected' : '' }}>Sales
                                                </option>
                                                <option
                                                    value="Account Service"{{ $data->type == 'Account Service' ? 'selected' : '' }}>
                                                    Account Service</option>
                                                <option
                                                    value=" Recent Product Launch"{{ $data->type == ' Recent Product Launch' ? 'selected' : '' }}>
                                                    Recent Product Launch</option>
                                                <option value="IT"{{ $data->type == 'IT' ? 'selected' : '' }}>IT
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Priority Level">Priority Level</label>
                                            <select name="priority_level">
                                                <option value="0">-- Select type --</option>
                                                <option
                                                    value="High"{{ $data->priority_level == 'High' ? 'selected' : '' }}>
                                                    High</option>
                                                <option
                                                    value="Medium"{{ $data->priority_level == 'Medium' ? 'selected' : '' }}>
                                                    Medium</option>
                                                <option
                                                    value="Low"{{ $data->priority_level == 'Low' ? 'selected' : '' }}>
                                                    Low</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Scheduled Start Date">Scheduled Start Date</label>
                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($data->start_date)
                                                        ? new \DateTime($data->start_date)
                                                        : null;
                                                @endphp
                                                <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="start_date" {{-- min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" --}}
                                                    value="{{ $data->start_date ?? '' }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'start_date')" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Scheduled end Date">Scheduled end Date</label>
                                            <div class="calenderauditee">
                                                @php
                                                    $Date = isset($data->end_date)
                                                        ? new \DateTime($data->end_date)
                                                        : null;
                                                @endphp
                                                <input type="text" id="end_date" readonly placeholder="DD-MMM-YYYY"
                                                    value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                                <input type="date" name="end_date" {{-- min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" --}}
                                                    value="{{ $data->end_date ?? '' }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'end_date')" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Attendees">Attendess</label>
                                            <textarea name="attendees">{{ $data->attendees }}</textarea>
                                        </div>
                                    </div>


                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                            Agenda
                                            <button type="button" name="audit-agenda-grid" id="agenda-but">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="agenda-field">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%">Row#</th>
                                                        <th style="width: 12%">Date</th>
                                                        <th style="width: 16%">Topic</th>
                                                        <th style="width: 16%">Responsible</th>
                                                        <th style="width: 16%">Shelf Life</th>
                                                        <th style="width: 15%">Time Start</th>
                                                        <th style="width: 15%">Time End</th>
                                                        <th style="width: 15%">Comments</th>
                                                        <th style="width: 15%">Remarks</th>
                                                        <th style="width: 5%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($grid_Data && is_array($grid_Data->data))
                                                        @foreach ($grid_Data->data as $grid)
                                                            <tr>
                                                                <td><input disabled type="text" name="serial[]"
                                                                        value="{{ $loop->index + 1 }}"></td>
                                                                <td>
                                                                    <div class="new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input class="click_date"
                                                                                    id="date_display_{{ $loop->index }}"
                                                                                    type="text"
                                                                                    name="agenda[{{ $loop->index }}][info_mfg_date]"
                                                                                    value="{{ isset($grid['info_mfg_date']) ? \Carbon\Carbon::parse($grid['info_mfg_date'])->format('d-M-Y') : '' }}"
                                                                                    placeholder="DD-MMM-YYYY" readonly />
                                                                                <input type="date"
                                                                                    name="agenda[{{ $loop->index }}][info_mfg_date]"
                                                                                    {{-- min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" --}}
                                                                                    id="date_input_{{ $loop->index }}"
                                                                                    value="{{ isset($grid['info_mfg_date']) ? $grid['info_mfg_date'] : '' }}"
                                                                                    class="hide-input show_date"
                                                                                    style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                                    onchange="handleDateInput(this, 'date_display_{{ $loop->index }}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="text"
                                                                        name="agenda[{{ $loop->index }}][Topic]"
                                                                        value="{{ isset($grid['Topic']) ? $grid['Topic'] : '' }}">
                                                                </td>
                                                                <td><input type="text"
                                                                        name="agenda[{{ $loop->index }}][Responsible]"
                                                                        value="{{ isset($grid['Responsible']) ? $grid['Responsible'] : '' }}">
                                                                </td>
                                                                <td><input type="text"
                                                                        name="agenda[{{ $loop->index }}][Shelf_Life]"
                                                                        value="{{ isset($grid['Shelf_Life']) ? $grid['Shelf_Life'] : '' }}">
                                                                </td>
                                                                <td><input type="time"
                                                                        name="agenda[{{ $loop->index }}][Time_Start]"
                                                                        value="{{ isset($grid['Time_Start']) ? $grid['Time_Start'] : '' }}">
                                                                </td>
                                                                <td><input type="time"
                                                                        name="agenda[{{ $loop->index }}][Time_End]"
                                                                        value="{{ isset($grid['Time_End']) ? $grid['Time_End'] : '' }}">
                                                                </td>
                                                                <td><input type="text"
                                                                        name="agenda[{{ $loop->index }}][Comments]"
                                                                        value="{{ isset($grid['Comments']) ? $grid['Comments'] : '' }}">
                                                                </td>
                                                                <td><input type="text"
                                                                        name="agenda[{{ $loop->index }}][Remarker]"
                                                                        value="{{ isset($grid['Remarker']) ? $grid['Remarker'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="removeRowBtn">remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <script>
                                        function handleDateInput(dateInput, displayId) {
                                            var date = new Date(dateInput.value);
                                            var formattedDate = date.toLocaleDateString('en-GB', {
                                                day: '2-digit',
                                                month: 'short',
                                                year: 'numeric'
                                            }).replace(/ /g, '-');
                                            document.getElementById(displayId).value = formattedDate;
                                        }
                                    </script>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Description</label>
                                            characters remaining
                                            <textarea name="description" id="docname" type="text">{{ $data->description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                            Management Review Participants
                                            <button type="button" name="audit-agenda-grid"
                                                id="Management_Review_Participants">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered"
                                                id="Management_Review_Participants-field-instruction-modal">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%">Row#</th>
                                                        <th style="width: 12%">Invite Person</th>
                                                        <th style="width: 16%">Designee</th>
                                                        <th style="width: 16%">Department</th>
                                                        <th style="width: 16%">Meeting Attended</th>
                                                        <th style="width: 15%">Designee Name</th>
                                                        <th style="width: 15%">Designee Department/Designation</th>
                                                        <th style="width: 15%">Remarks</th>
                                                        <th style="width: 5%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($grid_Data1 && is_array($grid_Data1->data))
                                                        @foreach ($grid_Data1->data as $grid_Data1)
                                                            <tr>
                                                                <td>
                                                                    <input disabled type="text"
                                                                        name="Management_Review_Participants[{{ $loop->index }}][serial_number]"
                                                                        value="{{ $loop->index + 1 }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="Management_Review_Participants[{{ $loop->index }}][Invite_Person]"
                                                                        value="{{ isset($grid_Data1['Invite_Person']) ? $grid_Data1['Invite_Person'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="Management_Review_Participants[{{ $loop->index }}][Designee]"
                                                                        value="{{ isset($grid_Data1['Designee']) ? $grid_Data1['Designee'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="Management_Review_Participants[{{ $loop->index }}][Department]"
                                                                        value="{{ isset($grid_Data1['Department']) ? $grid_Data1['Department'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="Management_Review_Participants[{{ $loop->index }}][Meeting_Attended]"
                                                                        value="{{ isset($grid_Data1['Meeting_Attended']) ? $grid_Data1['Meeting_Attended'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="Management_Review_Participants[{{ $loop->index }}][Designee_Name]"
                                                                        value="{{ isset($grid_Data1['Designee_Name']) ? $grid_Data1['Designee_Name'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="Management_Review_Participants[{{ $loop->index }}][Designee_Department_Designation]"
                                                                        value="{{ isset($grid_Data1['Designee_Department_Designation']) ? $grid_Data1['Designee_Department_Designation'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text"
                                                                        name="Management_Review_Participants[{{ $loop->index }}][manage_remark]"
                                                                        value="{{ isset($grid_Data1['manage_remark']) ? $grid_Data1['manage_remark'] : '' }}">
                                                                </td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="removeBtn">remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{-- 
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="File_Attachment">File Attachment</label>
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="Attached_File"></div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input type="file" id="myfile" name="Attached_File[]"
                                                        oninput="addMultipleFiles(this, 'Attached_File')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                    {{-- <div class="col-12">
                                        <div class="group-input">
                                            <label for="Inv Attachments">File Attachment</label>
                                            <div>
                                                <small class="text-primary">
                                                    Please Attach all relevant or supporting documents
                                                </small>
                                            </div>
                                            <div class="file-attachment-field">
                                                <div disabled class="file-attachment-list" id="Attached_File">
                                                    @if ($data->Attached_File)
                                                        @foreach (json_decode($data->Attached_File) as $file)
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
                                                    <input type="file" id="Attached_File" name="Attached_File[]"
                                                        {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                                        oninput="addMultipleFiles(this, 'Attached_File')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Inv Attachments">File Attachment</label>
                                            <div>
                                                <small class="text-primary">
                                                    Please Attach all relevant or supporting documents
                                                </small>
                                            </div>
                                            <div class="file-attachment-field">
                                                <div disabled class="file-attachment-list" id="Attached_File">
                                                    @if ($data->Attached_File)
                                                        @foreach (json_decode($data->Attached_File) as $file)
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
                                                    <input type="file" id="Attached_File" name="Attached_File[]"
                                                        {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                                        oninput="addMultipleFiles(this, 'Attached_File')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ==========================================Operational Planning & Control============================================ -->
                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Operations">Operations
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-operations-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="operations">{{ $data->operations }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Requirements for Products and Services">Requirements for Products
                                            and
                                            Services
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-requirement_products_services-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Requirements_for_Products">{{ $data->Requirements_for_Products }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Design and Development of Products and Services">
                                            Design and Development of Products and Services
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-design_development_product_services-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Design_and_Development">{{ $data->Design_and_Development }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Control of Externally Provided Processes, Products and Services">
                                            Control of Externally Provided Processes, Products and Services
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-control_externally_provide_services-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Control_of_Externally">{{ $data->Control_of_Externally }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Production and Service Provision">
                                            Production and Service Provision
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-production_service_provision-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Production_and_Service">{{ $data->Production_and_Service }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Release of Products and Services">
                                            Release of Products and Services
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-release_product_services-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Release_of_Products">{{ $data->Release_of_Products }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Control of Non-conforming Outputs ">
                                            Control of Non-conforming Outputs
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#management-review-control_nonconforming_outputs-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <textarea name="Control_of_Non">{{ $data->Control_of_Non }}</textarea>
                                    </div>
                                </div>

                                <div class="group-input">
                                    <label for="audit-agenda-grid">
                                        Performance Evaluation
                                        <button type="button" name="audit-agenda-grid"
                                            id="performance_evaluation">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#observation-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered"
                                            id="performance_evaluation-field-instruction-modal">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">Row#</th>
                                                    <th style="width: 12%">Monitoring</th>
                                                    <th style="width: 16%">Measurement</th>
                                                    <th style="width: 16%">Analysis</th>
                                                    <th style="width: 16%">Evalutaion</th>
                                                    <th style="width: 15%">Remarks</th>
                                                    <th style="width: 5%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($grid_Data2 && is_array($grid_Data2->data))
                                                    @foreach ($grid_Data2->data as $grid_Data2)
                                                        <tr>
                                                            <td>
                                                                <input disabled type="text"
                                                                    name="performance_evaluation[{{ $loop->index }}][serial_number]"
                                                                    value="{{ $loop->index + 1 }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="performance_evaluation[{{ $loop->index }}][Monitoring]"
                                                                    value="{{ isset($grid_Data2['Monitoring']) ? $grid_Data2['Monitoring'] : '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="performance_evaluation[{{ $loop->index }}][Measurement]"
                                                                    value="{{ isset($grid_Data2['Measurement']) ? $grid_Data2['Measurement'] : '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="performance_evaluation[{{ $loop->index }}][Analysis]"
                                                                    value="{{ isset($grid_Data2['Analysis']) ? $grid_Data2['Analysis'] : '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="performance_evaluation[{{ $loop->index }}][Evalutaion]"
                                                                    value="{{ isset($grid_Data2['Evalutaion']) ? $grid_Data2['Evalutaion'] : '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="performance_evaluation[{{ $loop->index }}][Remarks]"
                                                                    value="{{ isset($grid_Data2['Remarks']) ? $grid_Data2['Remarks'] : '' }}">
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="removeRowBtnpe">remove</button>
                                                            </td>
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
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ==========================================Meetings & Summary============================================ -->
                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Risk & Opportunities">Risk & Opportunities</label>
                                    <textarea name="Risk_Opportunities" id="" type="text" rows="3">{{ $data->Risk_Opportunities }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="External Supplier Performance">External Supplier Performance</label>
                                    <textarea name="External_Supplier_Performance" id="" type="text" rows="3">{{ $data->External_Supplier_Performance }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Customer Satisfaction Level">Customer Satisfaction Level</label>
                                    <textarea name="Customer_Satisfaction_Level" id="" type="text" rows="3">{{ $data->Customer_Satisfaction_Level }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Budget Estimates">Budget Estimates</label>
                                    <textarea name="Budget_Estimates" id="" type="text" rows="3">{{ $data->Budget_Estimates }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Completion of Previous Tasks">Completion of Previous Tasks</label>
                                    <textarea name="Completion_of_Previous_Tasks" id="" type="text" rows="3">{{ $data->Completion_of_Previous_Tasks }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Production">Production</label>
                                    <textarea name="Production" id="" type="text" rows="3">{{ $data->Production }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Plans">Plans</label>
                                    <textarea name="Plans" id="" type="text" rows="3">{{ $data->Plans }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Forecast">Forecast</label>
                                    <textarea name="Forecast" id="" type="text" rows="3">{{ $data->Forecast }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Any Additional Support Required">Any Additional Support
                                        Required</label>
                                    <textarea name="Any_Additional_Support_Required" id="" type="text" rows="3">{{ $data->Any_Additional_Support_Required }}</textarea>
                                </div>
                            </div>
                            {{-- <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="File Attachment, if any">File Attachment, if any</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="File Attachment, if any"
                                                oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Inv Attachments">File Attachment</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    {{-- <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="file_attach">
                                            @if ($data->file_attach)
                                                @foreach (json_decode($data->file_attach) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                class="fa fa-eye text-primary"
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
                                            <input type="file" id="file_attach" name="file_attach[]"
                                                {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                        </div> --}}
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
                <!-- ==========================================Closure============================================ -->
                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Action Item Details
                                    <button type="button" name="audit-agenda-grid" id="action_Item_Details">+</button>
                                    <span class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#observation-field-instruction-modal"
                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="action_Item_Details-field-instruction-modal">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Short Description</th>
                                                <th style="width: 15%">Due Date</th>
                                                <th style="width: 15%">Site / Division</th>
                                                <th style="width: 15%">Person Responsible</th>
                                                <th style="width: 15%">Current Status</th>
                                                <th style="width: 15%">Date Closed</th>
                                                <th style="width: 15%">Remarks</th>
                                                <th style="width: 5%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($grid_Data3 && is_array($grid_Data3->data))
                                                @foreach ($grid_Data3->data as $grid)
                                                    <tr>
                                                        <td><input disabled type="text"
                                                                name="action_Item_Details[{{ $loop->index }}][serial_number]"
                                                                value="{{ $loop->index + 1 }}"></td>
                                                        <td><input type="text"
                                                                name="action_Item_Details[{{ $loop->index }}][Short_Description]"
                                                                value="{{ isset($grid['Short_Description']) ? $grid['Short_Description'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <div class="new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input class="click_date"
                                                                            id="due_date_display_{{ $loop->index }}"
                                                                            type="text"
                                                                            name="action_Item_Details[{{ $loop->index }}][Due_Date_display]"
                                                                            value="{{ isset($grid['Due_Date']) ? \Carbon\Carbon::parse($grid['Due_Date'])->format('d-M-Y') : '' }}"
                                                                            placeholder="DD-MMM-YYYY" readonly />
                                                                        <input type="date"
                                                                            name="action_Item_Details[{{ $loop->index }}][Due_Date]"
                                                                            min=""
                                                                            id="due_date_input_{{ $loop->index }}"
                                                                            value="{{ isset($grid['Due_Date']) ? $grid['Due_Date'] : '' }}"
                                                                            class="hide-input show_date"
                                                                            style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                            onchange="handleDateInput(this, 'due_date_display_{{ $loop->index }}')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><input type="text"
                                                                name="action_Item_Details[{{ $loop->index }}][Site_Division]"
                                                                value="{{ isset($grid['Site_Division']) ? $grid['Site_Division'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <div class="col-lg-6">
                                                                <div class="group-input">
                                                                    <select
                                                                        name="action_Item_Details[{{ $loop->index }}][Person_Responsible]">
                                                                        <option value="">Select a value</option>
                                                                        @if ($users->isNotEmpty())
                                                                            @foreach ($users as $value)
                                                                                <option value="{{ $value->name }}"
                                                                                    {{ isset($grid['Person_Responsible']) && $grid['Person_Responsible'] == $value->name ? 'selected' : '' }}>
                                                                                    {{ $value->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="time"
                                                                name="action_Item_Details[{{ $loop->index }}][current_status]"
                                                                value="{{ isset($grid['current_status']) ? $grid['current_status'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <div class="new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input class="click_date"
                                                                            id="date_closed_display_{{ $loop->index }}"
                                                                            type="text"
                                                                            name="action_Item_Details[{{ $loop->index }}][Date_Closed_display]"
                                                                            value="{{ isset($grid['Date_Closed']) ? \Carbon\Carbon::parse($grid['Date_Closed'])->format('d-M-Y') : '' }}"
                                                                            placeholder="DD-MMM-YYYY" readonly />
                                                                        <input type="date"
                                                                            name="action_Item_Details[{{ $loop->index }}][Date_Closed]"
                                                                            min=""
                                                                            id="date_closed_input_{{ $loop->index }}"
                                                                            value="{{ isset($grid['Date_Closed']) ? $grid['Date_Closed'] : '' }}"
                                                                            class="hide-input show_date"
                                                                            style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                            onchange="handleDateInput(this, 'date_closed_display_{{ $loop->index }}')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><input type="text"
                                                                name="action_Item_Details[{{ $loop->index }}][Remarking]"
                                                                value="{{ isset($grid['Remarking']) ? $grid['Remarking'] : '' }}">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="removeRowBtnaid">remove</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    CAPA Details
                                    <button type="button" name="audit-agenda-grid" id="capa_Details">+</button>
                                    <span class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#observation-field-instruction-modal"
                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="capa_Details-field-instruction-modal">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">CAPA Details</th>
                                                <th style="width: 15%">CAPA Type</th>
                                                <th style="width: 15%">Site / Division</th>
                                                <th style="width: 15%">Person Responsible</th>
                                                <th style="width: 15%">Current Status</th>
                                                <th style="width: 15%">Date Closed</th>
                                                <th style="width: 16%">Remarks</th>
                                                <th style="width: 5%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($grid_Data4 && is_array($grid_Data4->data))
                                                @foreach ($grid_Data4->data as $grid4)
                                                    <tr>
                                                        <td><input disabled type="text"
                                                                name="capa_Details[{{ $loop->index }}][serial_number]"
                                                                value="{{ $loop->index + 1 }}"></td>
                                                        <td><input type="text"
                                                                name="capa_Details[{{ $loop->index }}][CAPA_Details]"
                                                                value="{{ $grid4['CAPA_Details'] ?? '' }}"></td>
                                                        <td>
                                                            <select name="capa_Details[{{ $loop->index }}][CAPA_Type]">
                                                                <option value="">Select a value</option>
                                                                <option value="corrective"
                                                                    {{ isset($grid4['CAPA_Type']) && $grid4['CAPA_Type'] == 'corrective' ? 'selected' : '' }}>
                                                                    Corrective Action</option>
                                                                <option value="preventive"
                                                                    {{ isset($grid4['CAPA_Type']) && $grid4['CAPA_Type'] == 'preventive' ? 'selected' : '' }}>
                                                                    Preventive Action</option>
                                                                <option value="corrective_preventive"
                                                                    {{ isset($grid4['CAPA_Type']) && $grid4['CAPA_Type'] == 'corrective_preventive' ? 'selected' : '' }}>
                                                                    Corrective &amp; Preventive Action</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text"
                                                                name="capa_Details[{{ $loop->index }}][Site_Division]"
                                                                value="{{ $grid4['Site_Division'] ?? '' }}"></td>
                                                        <td>
                                                            <div class="group-input">
                                                                <select
                                                                    name="capa_Details[{{ $loop->index }}][Person_Responsible]">
                                                                    <option value="">Select a value</option>
                                                                    @foreach ($users as $value)
                                                                        <option value="{{ $value->name }}"
                                                                            {{ isset($grid4['Person_Responsible']) && $grid4['Person_Responsible'] == $value->name ? 'selected' : '' }}>
                                                                            {{ $value->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td><input type="time"
                                                                name="capa_Details[{{ $loop->index }}][Current_Status]"
                                                                value="{{ $grid4['Current_Status'] ?? '' }}"></td>
                                                        <td>
                                                            <div class="new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input class="click_date"
                                                                            id="closed_display_{{ $loop->index }}"
                                                                            type="text"
                                                                            name="capa_Details[{{ $loop->index }}][date_Closed]"
                                                                            value="{{ isset($grid4['date_Closed']) ? \Carbon\Carbon::parse($grid4['date_Closed'])->format('d-M-Y') : '' }}"
                                                                            placeholder="DD-MMM-YYYY" readonly />
                                                                        <input type="date"
                                                                            name="capa_Details[{{ $loop->index }}][date_Closed]"
                                                                            min=""
                                                                            id="date_input_{{ $loop->index }}"
                                                                            value="{{ isset($grid4['date_Closed']) ? $grid4['date_Closed'] : '' }}"
                                                                            class="hide-input show_date"
                                                                            style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                            onchange="handleDateInput(this, 'closed_display_{{ $loop->index }}')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><input type="text"
                                                                name="capa_Details[{{ $loop->index }}][Remarked]"
                                                                value="{{ $grid4['Remarked'] ?? '' }}"></td>
                                                        <td>
                                                            <button type="button" class="removeRowBtncd">remove</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Next Management Review Date">Next Management Review Date</label>

                                    <div class="calenderauditee">
                                        @php
                                            $Date = isset($data->start_date_checkdate)
                                                ? new \DateTime($data->start_date_checkdate)
                                                : null;
                                        @endphp
                                        {{-- Format the date as desired --}}
                                        <input type="text" id="start_date_checkdate" readonly
                                            placeholder="DD-MMM-YYYY"
                                            value="{{ $Date ? $Date->format('j-F-Y') : '' }}" />
                                        <input type="date" name="start_date_checkdate"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="{{ $data->start_date_checkdate ?? '' }}" class="hide-input"
                                            oninput="handleDateInput(this, 'start_date_checkdate')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Summary & Recommendation">Summary & Recommendation</label>
                                    <textarea name="Summary_Recommendation" id="" type="text" rows="3">{{ $data->Summary_Recommendation }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Conclusion">Conclusion</label>
                                    <textarea name="Conclusion" id="" type="text" rows="3">{{ $data->Conclusion }}</textarea>
                                </div>
                            </div>
                            {{-- <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Closure Attachments">Closure Attachments</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_attachment[]"
                                                oninput="addMultipleFiles(this, 'file_attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Inv Attachments">Closure Attachment</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="file_Attachment">
                                            @if ($data->file_Attachment)
                                                @foreach (json_decode($data->file_Attachment) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                class="fa fa-eye text-primary"
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
                                            <input type="file" id="file_Attachment" name="file_Attachment[]"
                                                {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'file_Attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">
                                Extension Justification
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Due Date Extension Justification">Due Date Extension
                                        Justification</label>
                                    <textarea name="Due_Date_Extension_Justification" id="" type="text" rows="3">{{ $data->Due_Date_Extension_Justification }}</textarea>
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
                <!-- ==========================================Signatures============================================ -->
                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">
                                Signatures
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submited By">Submited By</label>
                                        <div class="static">{{ $data->Submitted_By }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Submited">Submited on </label>
                                        <div class="static">{{ $data->Submitted_on }}</div>

                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Comments">Comments </label>
                                        <div class="static">{{ $data->Submitted_comment }}</div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="Cancel By">Completed By</label>
                                            <div class="static">{{ $data->completed_by }}</div>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Cancel">Completed on </label>
                                            <div class="static">{{ $data->completed_on }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Comments">Comments </label>
                                            <div class="static">{{ $data->completed_comment }}</div>

                                        </div>
                                    </div>
                                </div>
                                <div class="button-block">
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    {{-- <button type="submit" class="saveButton">Save</button> --}}
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">Exit
                                        </a> </button>
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
                <form action="{{ route('MMStage_change', $data->id) }}" method="POST">
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
                <form action="{{ route('action_item_show', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            <label for="major">
                                <input type="radio" name="revision" id="major" value="Action-Item">
                                Action Item
                            </label>
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
    <style>
        #step-form>div {
            display: none
        }

        #step-form>div:nth-child(1) {
            display: block;
        }
    </style>
    {{-- <script>
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
    </script> --}}
    {{-- <script>
        $(document).ready(function() {
            $('#Management_Review_Participants').click(function(e) {
                function generateTableRow(serialNumber) {

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
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

                var tableBody = $('#Management_Review_Participants-field-instruction-modal tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            $('#Management_Review_Participants').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][Invite_Person]"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][Designee]"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][Department]"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][Meeting_Attended]"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][Designee_Name]"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][Designee_Department_Designation]"></td>' +
                        '<td><input type="text" name="Management_Review_Participants[' + serialNumber +
                        '][manage_remark]"></td>' +
                        '<td><button type="text" class="removeBtn">remove</button></td>' +
                        '</tr>';
                    '</tr>';
                    // for (var i = 0; i < data.length; i++) {
                    //     html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    // }

                    // html += '</select></td>' +
                    //     '</tr>';
                    return html;
                }
                var tableBody = $('#Management_Review_Participants-field-instruction-modal tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#agenda-but').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td>' +
                        '<div class="new-date-data-field">' +
                        '<div class="group-input input-date">' +
                        '<div class="calenderauditee">' +
                        '<input class="click_date" id="date_0_mfg_date' + serialNumber +
                        '" type="text" name="agenda[' + serialNumber +
                        '][info_mfg_date]" placeholder="DD-MMM-YYYY" readonly />' +
                        '<input type="date" name="agenda[' + serialNumber +
                        '][info_mfg_date]" min="" id="closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'date_0_mfg_date' +
                        serialNumber + '\')">' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td><input type="text" name="agenda[' + serialNumber + '][Topic]"></td>' +
                        '<td><input type="text" name="agenda[' + serialNumber + '][Responsible]"></td>' +
                        '<td><input type="text" name="agenda[' + serialNumber + '][Shelf_Life]"></td>' +
                        '<td><input type="time" name="agenda[' + serialNumber + '][Time_Start]"></td>' +
                        '<td><input type="time" name="agenda[' + serialNumber + '][Time_End]"></td>' +
                        '<td><input type="text" name="agenda[' + serialNumber + '][Comments]"></td>' +
                        '<td><input type="text" name="agenda[' + serialNumber + '][Remarker]"></td>' +
                        '<td><button type="text" class="removeRowBtn">remove</button></td>' +
                        '</tr>';
                    '</tr>';
                    return html;
                }
                var tableBody = $('#agenda-field tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#performance_evaluation').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="performance_evaluation[' + serialNumber +
                        '][Monitoring]"></td>' +
                        '<td><input type="text" name="performance_evaluation[' + serialNumber +
                        '][Measurement]"></td>' +
                        '<td><input type="text" name="performance_evaluation[' + serialNumber +
                        '][Analysis]"></td>' +
                        '<td><input type="text" name="performance_evaluation[' + serialNumber +
                        '][Evalutaion]"></td>' +
                        '<td><input type="text" name="performance_evaluation[' + serialNumber +
                        '][Remarks]"></td>' +
                        '<td><button type="text" class="removeBtnpe">remove</button></td>' +
                        '</tr>';
                    '</tr>';
                    return html;
                }
                var tableBody = $('#performance_evaluation-field-instruction-modal tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#action_Item_Details').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="action_Item_Details[' + serialNumber +
                        '][Short_Description]"></td>' +
                        '<td><div class="new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input class="click_date" id="due_date_display_' +
                        serialNumber + '" type="text" name="action_Item_Details[' + serialNumber +
                        '][Due_Date_display]" placeholder="DD-MMM-YYYY" readonly /><input type="date" name="action_Item_Details[' +
                        serialNumber +
                        '][Due_Date]" id="due_date_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'due_date_display_' +
                        serialNumber + '\')"></div></div></div></td>' +
                        '<td><input type="text" name="action_Item_Details[' + serialNumber +
                        '][Site_Division]"></td>' +
                        '<td><div class="group-input"><select name="action_Item_Details[' + serialNumber +
                        '][Person_Responsible]"><option value="">Select a value</option>@foreach ($users as $value)<option value="{{ $value->name }}">{{ $value->name }}</option>@endforeach</select></div></td>' +
                        '<td><input type="time" name="action_Item_Details[' + serialNumber +
                        '][current_status]"></td>' +
                        '<td><div class="new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input class="click_date" id="date_closed_display_' +
                        serialNumber + '" type="text" name="action_Item_Details[' + serialNumber +
                        '][Date_Closed_display]" placeholder="DD-MMM-YYYY" readonly /><input type="date" name="action_Item_Details[' +
                        serialNumber +
                        '][Date_Closed]" id="date_closed_input_' +
                        serialNumber +
                        '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'date_closed_display_' +
                        serialNumber + '\')"></div></div></div></td>' +
                        '<td><input type="text" name="action_Item_Details[' + serialNumber +
                        '][Remarking]"></td>' +
                        '<td><button type="text" class="removeBtnaid">remove</button></td>' +
                        '</tr>';
                    '</tr>';
                    return html;
                }
                var tableBody = $('#action_Item_Details-field-instruction-modal tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });

        function handleDateInput(dateInput, displayId) {
            var date = new Date(dateInput.value);
            var formattedDate = date.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            }).replace(/ /g, '-');
            document.getElementById(displayId).value = formattedDate;
        }
    </script>
    <script>
        $(document).ready(function() {
            // Function to generate options for the Person Responsible dropdown
            function generateOptions(users) {
                var options = '<option value="">Select a value</option>';
                users.forEach(function(user) {
                    options += '<option value="' + user.id + '">' + user.name + '</option>';
                });
                return options;
            }
            // Function to generate a new row in the CAPA Details table
            function generateTableRow(serialNumber, users) {
                var options = generateOptions(users);
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="capa_Details[' + serialNumber +
                    '][serial_number]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="capa_Details[' + serialNumber +
                    '][CAPA_Details]"></td>' +
                    '<td>' +
                    '<select name="capa_Details[' + serialNumber + '][CAPA_Type]">' +
                    '<option value="">Select a value</option>' +
                    '<option value="corrective">Corrective Action</option>' +
                    '<option value="preventive">Preventive Action</option>' +
                    '<option value="corrective_preventive">Corrective &amp; Preventive Action</option>' +
                    '</select>' +
                    '</td>' +
                    '<td><input type="text" name="capa_Details[' + serialNumber +
                    '][Site_Division]"></td>' +
                    '<td>' +
                    '<div class="group-input">' +
                    '<select name="capa_Details[' + serialNumber + '][Person_Responsible]">' +
                    options +
                    '</select>' +
                    '</div>' +
                    '</td>' +
                    '<td><input type="time" name="capa_Details[' + serialNumber +
                    '][Current_Status]"></td>' +
                    '<td>' +
                    '<div class="new-date-data-field">' +
                    '<div class="group-input input-date">' +
                    '<div class="calenderauditee">' +
                    '<input class="click_date" id="closed_display_' + serialNumber +
                    '" type="text" name="capa_Details[' + serialNumber +
                    '][date_Closed]" placeholder="DD-MMM-YYYY" readonly />' +
                    '<input type="date" name="capa_Details[' + serialNumber +
                    '][date_Closed]"  id="date_input_' +
                    serialNumber +
                    '" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" onchange="handleDateInput(this, \'closed_display_' +
                    serialNumber + '\')">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td><input type="text" name="capa_Details[' + serialNumber +
                    '][Remarked]"></td>' +
                    '<td><button type="text" class="removeBtncd">remove</button></td>' +
                    '</tr>';
                '</tr>';
                return html;
            }
            // Initial users data - Replace with your actual data
            var users = @json($users);
            // Event listener for adding new rows
            $('#capa_Details').click(function(e) {
                e.preventDefault();

                var tableBody = $('#capa_Details-field-instruction-modal tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1, users);
                tableBody.append(newRow);
            });
            // Function to handle date input change
            window.handleDateInput = function(dateInput, displayInputId) {
                var date = new Date(dateInput.value);
                var options = {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                };
                var formattedDate = date.toLocaleDateString('en-GB', options).replace(/ /g, '-');
                $('#' + displayInputId).val(formattedDate);
            };
        });
    </script>
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
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>
    <script>
        $(document).on('click', '.removeBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>
    <script>
        $(document).on('click', '.removeBtnpe', function() {
            $(this).closest('tr').remove();
        })
    </script>
    <script>
        $(document).on('click', '.removeBtnaid', function() {
            $(this).closest('tr').remove();
        })
    </script>
    <script>
        $(document).on('click', '.removeBtncd', function() {
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
