@extends('frontend.layout.main')
@section('container')
<style>
    textarea.note-codable {
        display: none !important;
    }

    header {
        display: none;
    }


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
        /* border-radius: 25px; */
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

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(5) {
        border-radius: 0px 20px 20px 0px;

    }

</style>

<div class="form-field-head">

    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        {{ Helpers::getDivisionName(session()->get('division')) }} / Management Review
    </div>
</div>

@php
$users = DB::table('users')->get();
@endphp
{{-- ======================================
                    DATA FIELDS
    ======================================= --}}

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
                            <button class="button_theme1"> <a class="text-white" href="{{route('RecommendedAuditTrialDetails', $data->id)}} ">


                                    {{-- add here url for auditTrail i.e. href="{{ url('CapaAuditTrial', $data->id) }}" --}}
                                    Audit Trail </a> </button>
                                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                                    </a> </button>

                             @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature2-modal">
                                Cancellation Request
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            @elseif($data->stage == 2 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature2-modal">
                                More Info from Open
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Action Review by AQA Approver Complete
                            </button>
                            @elseif($data->stage == 3 && (in_array(24, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Action Execution Complete
                            </button>

                            @elseif($data->stage == 4 &&(in_array(24, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))

                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Closed - Done
                            </button> --}}

<button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
    Action Execution Review Complete                            </button>


<button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature2-modal">
    More Info from Rec Action Execution
                            </button>

                                @elseif($data->stage == 5 && (in_array(24, $userRoleIds) || in_array(18, $userRoleIds)))

                            @elseif($data->stage == 6 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                              Exit
                            </button>


@endif
                        </div>
                    </div>

        {{-- =============================================================================================================== --}}
                    <div class="status">
                        <div class="head">Current Status</div>
                        @if ($data->stage == 0)
                        <div class="progress-bars ">
                            <div class="bg-danger" style="border-radius: 25px;">Closed-Cancelled</div>
                        </div>

                        @else
                       <div class="progress-bars d-flex" style="font-size: 15px;">
                            @if ($data->stage >= 1)
                            <div class="active">Opened</div>
                            @else
                            <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                            <div class="active">Rec. Action Review by AQA Approver</div>
                            @else
                            <div class="">Rec. Action Review by AQA Approver</div>
                            @endif


                            @if ($data->stage >= 3)
                            <div class="active">Recommendation Action Execution</div>
                            @else
                            <div class="">Recommendation Action Execution</div>
                            @endif

                            @if ($data->stage >= 4)
                            <div class="active">Recommendation Action Execution Review</div>
                            @else
                            <div class="">Recommendation Action Execution Review</div>
                            @endif
                            @if ($data->stage >= 5)
                            <div class="bg-danger">Closed - Done</div>
                            @else
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
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Rec.Action Review by AQA</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Recommended Action Execution</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Action Execution Review</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Activity Log</button>

        </div>

        <form action="{{ route('reccomended.update', $data->id) }}" method="post" enctype="multipart/form-data">
            @csrf

            @method('PUT')
            <div id="step-form">
                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class='sub-head'>Parent Record Information</div>


                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="RLS Record Number"><b>(Parent) OOS No.</b></label>
                            <input type="text" name="parent_oos_no" value = "{{$data->parent_oos_no}}" disabled>

                        <!-- {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}} -->
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Division Code"><b>(Parent) OOT No.</b></label>
                            <input type="text" name=""   disabled>
                        </div>
                    </div>

             {{-- <div class="col-lg-6">
                    <div class="group-input">
                                        <label for="Date Due"><b>(Parent) Date Opened</b></label>
                                         <input  type="text" value="{{ date('d-M-Y') }}" name="intiation_date"> -->
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date"
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Due"> (parent) Date Opened </label>
                                        <div><small class="text-primary">Please mention expected date of completion</small>
                                        </div>
                                        <div class="calenderauditee">
                                            <input disabled type="text" value="{{ date('d-M-Y') }}" name="parent_date_opened" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>
                                            <input type="hidden" disabled value="" name="parent_date_opened"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}></div></div>

                                    </div>



                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Division Code"><b>(Parent) Short Desecription<span
                            class="text-danger">*</span></b></label>
                            <input type="text" name="parent_short_desecription"  value = "{{$data->parent_short_desecription}}"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due"><b>(Parent) Target Closure Date</b></label>
                                        <input  type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date" >
                                {{-- <div class="static">{{ date('d-M-Y') }}</div> --}}
                            </div>
                                </div> -->

                    <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="Scheduled Start Date">(Parent) Target Closure Date</label>
                            <div class="calenderauditee">
                                <input type="text"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}  value="{{ \Carbon\Carbon::parse($data->target_closure_date)->format('d-M-Y') }}" name="target_closure_date" id="target_closure_date" readonly placeholder="DD-MMM-YYYY" />
                                <input type="date"   {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} value="{{ \Carbon\Carbon::parse($data->target_closure_date)->format('Y-m-d') }}" id="start_date_checkdate" name="target_closure_date" class="hide-input" oninput="handleDateInput(this, 'target_closure_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                            </div>
                        </div>
                    </div>


                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Division Code"><b>(Parent) Product/Material Name</b></label>
                    <input type="text" name="parent_product_material_name"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} value = "{{$data->parent_product_material_name}}" >
                </div>
            </div>


        </div>

        <!-- <div class="col-lg-6">
            <div class="group-input">
                                        <label for="Division Code"><b>(Parent) Product/Material Name</b></label>
                                        <input  type="text" name="division_code">
                                    </div>
                                </div> -->

                            <!-- <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="assign_to">
                                            <option value="assign_to">Select a value</option>
                                    {{-- @foreach ($users as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    @error('assign_to')
                <p class="text-danger">{{ $message }}</p>
                                    @enderror --}}
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Due">Date Due</label>
                                        <div><small class="text-primary">Please mention expected date of completion</small>
                                        </div>
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group"><b>Initiator Group</b></label>
                                        <select name="initiator_Group" id="initiator_group">
                                            <option value="">-- Select --</option>
                                            <option value="CQA" @if (old('initiator_Group') == 'CQA') selected @endif>
                                                Corporate Quality Assurance</option>
                                            <option value="QAB" @if (old('initiator_Group') == 'QAB') selected @endif>Quality
                                                Assurance Biopharma</option>
                                            <option value="CQC" @if (old('initiator_Group') == 'CQA') selected @endif>Central
                                                Quality Control</option>
                                            <option value="CQC" @if (old('initiator_Group') == 'MANU') selected @endif>
                                                Manufacturing</option>
                                            <option value="PSG" @if (old('initiator_Group') == 'PSG') selected @endif>Plasma
                                                Sourcing Group</option>
                                            <option value="CS" @if (old('initiator_Group') == 'CS') selected @endif>Central
                                                Stores</option>
                                            <option value="ITG" @if (old('initiator_Group') == 'ITG') selected @endif>
                                                Information Technology Group</option>
                                            <option value="MM" @if (old('initiator_Group') == 'MM') selected @endif>
                                                Molecular Medicine</option>
                                            <option value="CL" @if (old('initiator_Group') == 'CL') selected @endif>Central
                                                Laboratory</option>

                                            <option value="TT" @if (old('initiator_Group') == 'TT') selected @endif>Tech
                                                team</option>
                                            <option value="QA" @if (old('initiator_Group') == 'QA') selected @endif>
                                                Quality Assurance</option>
                                            <option value="QM" @if (old('initiator_Group') == 'QM') selected @endif>
                                                Quality Management</option>
                                            <option value="IA" @if (old('initiator_Group') == 'IA') selected @endif>IT
                                                Administration</option>
                                            <option value="ACC" @if (old('initiator_Group') == 'ACC') selected @endif>
                                                Accounting</option>
                                            <option value="LOG" @if (old('initiator_Group') == 'LOG') selected @endif>
                                                Logistics</option>
                                            <option value="SM" @if (old('initiator_Group') == 'SM') selected @endif>
                                                Senior Management</option>
                                            <option value="BA" @if (old('initiator_Group') == 'BA') selected @endif>
                                                Business Administration</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group Code"><b>Initiator Group Code</b></label>
                                        <input type="text" name="initiator_group_code" id="initiator_group_code"
                                            value="" disabled>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="short_description">Short Description<span
                                                class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please mention brief summary</small></div>
                                        <textarea name="short_description"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" name="short_description" maxlength="255" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="type">Type</label>
                                        <select name="type">
                                            <option value="0">Select Type</option>
                                            <option value="Other">Other</option>
                                            <option value="Training">Training</option>
                                            <option value="Finance">Finance</option>
                                            <option value="follow Up">Follow Up</option>
                                            <option value="Marketing">Marketing</option>
                                            <option value="Sales">Sales</option>
                                            <option value="Account Service">Account Service</option>
                                            <option value="Recent Product Launch">Recent Product Launch</option>
                                            <option value="IT">IT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Priority Level">Priority Level</label>
                                        <select name="priority_level">
                                            <option value="">Select Priority Level</option>
                                            <option value="High">High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Scheduled Start Date">Scheduled Start Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="start_date_checkdate"  name="start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Scheduled end date">Scheduled End Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="end_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="end_date_checkdate" name="end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'end_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Attendees">Attendess</label>
                                        <textarea name="attendees"></textarea>
                                    </div>
                                </div> -->
                    <!-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="agenda">
                                            (Parent) Info. On Product/Material..(0)<button type="button" name="agenda" id="meetingagenda">+</button>
                                        </label>
                                        <table class="table table-bordered" id="meeting_agenda_body">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>Item/Product Code</th>
                                                    <th>Lot/Batch Number</th>
                                                    <th>A.R.Number</th>
                                                    <th>Mfg.Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Label Claim</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input disabled type="text" name="serial_number[]" value="1"></td>

                                           <td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee">
                                                        <input type="text" id="agenda_date0" readonly placeholder="DD-MMM-YYYY" />
                                                        <input type="date" name="date[]"   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                        oninput="handleDateInput(this, `agenda_date0`);" /></div></div></div></td>
                                                    <td><input type="text" name="topic[]"></td>
                                                    <td><input type="text" name="responsible[]"></td>
                                                    <td><input type="time" name="start_time[]"></td>
                                                    <td><input type="time" name="end_time[]"></td>
                                                    <td><input type="text" name="comment[]"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> -->

                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                                (Parent) Info. On Product/Material..<button type="button" name="parent_info_on_product_material" id="product_material" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>+</button>
                            </label>
                            <table class="table table-bordered" id="product_material_body">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Row #</th>
                                        <th>Item/Product Code</th>
                                        <th>Lot/Batch Number</th>
                                        <th>A.R.Number</th>
                                        <th>Mfg.Date</th>
                                        <th>Expiry Date</th>
                                        <th>Label Claim</th>
                                        <th>Pack Size</th>
                                         <th style="width: 5%">Action</th>
                                        {{-- <th>Instru. Caliberation Due Date</th> --}}
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($rgrid->data as $index => $item)
                                    <tr>
                                        <td><input disabled type="text"    name="serial_number[]"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}  value="{{ $loop->index  + 1 }}"></td>
                                        <td><input type="text" name="parent_info_on_product_material[{{$loop->index }}][item_product_code]"   {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} value="{{ isset($item['item_product_code']) ? $item['item_product_code'] : '' }}"></td>
                                        <td><input type="text" name="parent_info_on_product_material[{{$loop->index }}][lot_batch_number]"   {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}  value="{{ isset($item['lot_batch_number']) ? $item['lot_batch_number'] : '' }}"></td>
                                        <td><input type="text" name="parent_info_on_product_material[{{$loop->index }}][a_r_number]"   {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}  value="{{ isset($item['a_r_number']) ? $item['a_r_number'] : '' }}"></td>
                                        <td><input type="date" name="parent_info_on_product_material[{{$loop->index }}][mfg_date]"    {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} value="{{ isset($item['mfg_date']) ? $item['mfg_date'] : '' }}"></td>
                                        <td><input type="date" name="parent_info_on_product_material[{{$loop->index }}][expiry_date]"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} value="{{ isset($item['expiry_date']) ? $item['expiry_date'] : '' }}"></td>
                                        <td><input type="text" name="parent_info_on_product_material[{{$loop->index }}][label_claim]"   {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}  value="{{ isset($item['label_claim']) ? $item['label_claim'] : '' }}"></td>
                                        <td><input type="text" name="parent_info_on_product_material[{{$loop->index }}][pack_size]"   {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}   value="{{ isset($item['pack_size']) ? $item['pack_size'] : '' }}"></td>
                                        <td><button type="button" class="removeRowBtn"    >Remove</button></td>

                                    </tr>
                                    @endforeach

                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                                (Parent) OOS Details <button type="button" name="parent_oos_details" id="oos_details" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>+</button>
                            </label>
                            <table class="table table-bordered" id="oos_details_body2">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Row #</th>
                                        <th>AR Number</th>
                                        <th>Test Name of OOS</th>
                                        <th>Results Obtained</th>
                                        <th>Specification Limit</th>
                                        <th style="width: 5%">Action</th>
                                        {{-- <th>Instru. Caliberation Due Date</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($secoundgrid->data as $item)
                                    <tr>
                                        <td><input disabled type="text" name="serial_number[]" value="{{ $loop->index + 1 }}" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}></td>
                                        <td><input type="text" name="parent_oos_details[{{ $loop->index }}][ar_no]" value="{{ array_key_exists('ar_no', $item) ? $item['ar_no'] : '' }}" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} ></td>
                                        <td><input type="text" name="parent_oos_details[{{ $loop->index }}][test_name_of_oos]" value="{{ array_key_exists('test_name_of_oos', $item) ? $item['test_name_of_oos'] : '' }}" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} ></td>
                                        <td><input type="text" name="parent_oos_details[{{ $loop->index }}][results_obtained]" value="{{ array_key_exists('results_obtained', $item) ? $item['results_obtained'] : '' }}" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} ></td>
                                        <td><input type="text" name="parent_oos_details[{{ $loop->index }}][specification_limit]" value="{{ array_key_exists('specification_limit', $item) ? $item['specification_limit'] : '' }}" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} ></td>
                                        <td><button type="button" class="removeRowBtn" >Remove</button></td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>



                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                                (Parent) OOT Results <button type="button" name="parent_oot_results" id="oot_results" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>+</button>
                            </label>
                            <table class="table table-bordered" id="oot_results_body3">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Row #</th>
                                        <th>AR Number</th>
                                        <th>Test Name of OOT</th>
                                        <th>Result Obtained</th>
                                        <th>Initial Intervel Details</th>
                                        <th>Previous Interval Details</th>
                                        <th>%Difference of Results</th>
                                        <th>Initial Interview Details</th>
                                        <th>Trend Limit</th>
                                        <th style="width: 5%">Action</th>
                                        {{-- <th>Instru. Caliberation Due Date</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($thirdgrid->data as $index => $item)
                                        <tr>
                                            <td><input disabled type="text" name="serial_number[]" value="{{ $loop->index + 1 }}"></td>
                                            <td><input type="text" name="parent_oot_results[{{ $loop->index }}][ar_no]" value="{{ array_key_exists('ar_no', $item) ? $item['ar_no'] : '' }}" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} ></td>
                                            <td><input type="text" name="parent_oot_results[{{ $loop->index }}][test_name_of_oot]" value="{{ array_key_exists('test_name_of_oot', $item) ? $item['test_name_of_oot'] : '' }}"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} ></td>
                                            <td><input type="text" name="parent_oot_results[{{ $loop->index }}][results_obtained]" value="{{ array_key_exists('results_obtained', $item) ? $item['results_obtained'] : '' }}"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} ></td>
                                            <td><input type="text" name="parent_oot_results[{{ $loop->index }}][initial_intervel_details]" value="{{ array_key_exists('initial_intervel_details', $item) ? $item['initial_intervel_details'] : '' }}"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}></td>
                                            <td><input type="text" name="parent_oot_results[{{ $loop->index }}][previous_interval_details]" value="{{ array_key_exists('previous_interval_details', $item) ? $item['previous_interval_details'] : '' }}" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} ></td>
                                            <td><input type="text" name="parent_oot_results[{{ $loop->index }}][difference_of_results]" value="{{ array_key_exists('difference_of_results', $item) ? $item['difference_of_results'] : '' }}"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} ></td>
                                            <td><input type="text" name="parent_oot_results[{{ $loop->index }}][initial_interview_details]" value="{{ array_key_exists('initial_interview_details', $item) ? $item['initial_interview_details'] : '' }}"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} ></td>
                                            <td><input type="text" name="parent_oot_results[{{ $loop->index }}][trend_limit]" value="{{ array_key_exists('trend_limit', $item) ? $item['trend_limit'] : '' }}"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} ></td>
                                            <td><button type="button" class="removeRowBtn" >Remove</button></td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                                (Parent) Details of Stability Study <button type="button" name="parent_details_of_stability_study" id="details_of_stability_study" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>+</button>
                            </label>
                            <table class="table table-bordered" id="details_of_stability_study_body4">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Row #</th>
                                        <th>AR Number</th>
                                        <th>Condition: Temperature & RH</th>
                                        <th>Interval</th>
                                        <th>Orientation</th>
                                        <th>Pack Details(if any)</th>
                                        <th style="width: 5%">Action</th>
                                        {{-- <th>Instru. Caliberation Due Date</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fourthgrid->data as $index => $item)
                                        <tr>
                                            <td><input disabled type="text" name="serial_number[]" value="{{ $loop->index + 1 }}"></td>
                                            <td><input type="text" name="parent_details_of_stability_study[{{ $loop->index }}][ar_no]" value="{{ array_key_exists('ar_no', $item) ? $item['ar_no'] : '' }}" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}></td>
                                            <td><input type="text" name="parent_details_of_stability_study[{{ $loop->index }}][condition_temperature_&_rh]" value="{{ array_key_exists('condition_temperature_&_rh', $item) ? $item['condition_temperature_&_rh'] : '' }}" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}></td>
                                            <td><input type="text" name="parent_details_of_stability_study[{{ $loop->index }}][interval]" value="{{ array_key_exists('interval', $item) ? $item['interval'] : '' }}" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}></td>
                                            <td><input type="text" name="parent_details_of_stability_study[{{ $loop->index }}][orientation]" value="{{ array_key_exists('orientation', $item) ? $item['orientation'] : '' }}" {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}></td>
                                            <td><input type="text" name="parent_details_of_stability_study[{{ $loop->index }}][pack_details]" value="{{ array_key_exists('pack_details', $item) ? $item['pack_details'] : '' }}"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}></td>
                                            <td><button type="button" class="removeRowBtn" >Remove</button></td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>



                    <div class="sub-head">General Information</div>
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number"
                                        value="{{ Helpers::getDivisionName($data->division_id) }}/RA/{{ Helpers::year($data->created_at) }}/{{ $data->record }}">
                                    {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input readonly type="text" name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division" value="{{ session()->get('division') }}">
                                </div>
                            </div>
                        <div class="col-lg-6">
                            <div class="group-input">

                                <label for="Originator"><b>Initiator</b></label>
                                <input type="text" name="initiator_id"  disabled   value="{{ $validation->initiator_id ?? Auth::user()->name }}">
                            </div>
                        </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Division Code"><b>Date Of Initiation</b></label>
                            <input disabled type="text" value="{{ date('d-M-Y') }}" name="date_of_initiation">
                            <input type="hidden" value="" name="date_of_initiation"    {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>
                </div>

                </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Assignee"><b>Assignee</b></label>
                            <input type="text" name="assignee" value="{{$data->assignee}}"    {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>
                        </div>
                    </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="RLS Record Number"><b>AQA Approver</b></label>
                    <input type="text" name="aqa_approver" value = "{{$data->aqa_approver}}"   {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>
                </div>
            </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="RLS Record Number"><b>Supervisor</b></label>
                        <input type="text" name="supervisor" value = "{{$data->supervisor}}"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>
                    </div>
                </div>
                <div class="col-lg-6 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="Date Due"> Due Date</label>
                        <div><small class="text-primary">Please mention expected date of completion</small>
                        </div>
                        <div class="calenderauditee">
                            <input type="hidden" value="{{$due_date}}" name="due_date">
                            <input  type="text" value="{{Helpers::getdateFormat($due_date)}}"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>
                        </div>
                    </div>
                </div>


            <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Recommended Action</label>
                            <textarea type = "text" name="recommended_action"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} >{{$data->recommended_action}}</textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Justify-Recommended Actions</label>
                            <textarea type = "text" name="ustify_recommended_actions"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} >{{$data->ustify_recommended_actions}}</textarea>
                        </div>
                    </div>
                    <!--
                    <div class="col-6">
                        <div class="group-input">
                            <label for="Description">Submit BY</label>
                            <input type="text"></input>
                        </div>
                    </div>

                    <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="Scheduled Start Date">Submit On</label>
                            <div class="calenderauditee">
                                <input type="text" id="start_date" readonly placeholder="DD-MM-YYYY" />
                                <input type="date" id="start_date_checkdate" name="start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                            </div>
                        </div>
                    </div> -->




    <div class="col-12">
    <div class="group-input">
        <label for="Description">File Attachment</label>

        <div><small class="text-primary">Please Attach all relevant or supporting
                documents</small></div>
                <div class="file-attachment-field">
                    <div class="file-attachment-list" id="inv_attachment[]"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>
                        @if ($data->inv_attachment)
                        @foreach (json_decode($data->inv_attachment) as $file)
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
                        <input  type="file" id="inv_attachment[]" name="inv_attachment[]"
                            oninput="addMultipleFiles(this, 'inv_attachment[]')" multiple   {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>
                    </div>
                </div>
    </div>
</div>
                </div>
                <div class="button-block">
                    <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                    <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                    <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                </div>
            </div>
    </div>
</div>



    <div id="CCForm2" class="inner-block cctabcontent">
        <div class="inner-block-content">
            {{-- <div class="row">
                            <div class="sub-head">AQA Comments </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Actual Start Date">Actual Start Date</label>
                                        <input type="date" name="actual_start_date">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Actual End Date">Actual End Date</label>
                                        <input type="date" name="actual_end_date">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Meeting minutes">Meeting minutes</label>
                                        <textarea name="meeting_minute"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Decisions">Decisions</label>
                                        <textarea name="decision"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 sub-head">
                                    Geographic Information
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">Zone</label>
                                        <input type="text" name="zone">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Country">Country</label>
                                        <input type="text" name="country">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="City">City</label>
                                        <input type="text" name="city">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="State/District">State/District</label>
                                        <input type="text" name="state/district">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Site Name">Site Name</label>
                                        <input type="text" name="site_name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Building">Building</label>
                                        <input type="text" name="building">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Floor">Floor</label>
                                        <input type="text" name="floor">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Room">Room</label>
                                        <input type="text" name="room">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="action-item-details">
                                            Action Item Details<button type="button" name="action-item-details"
                                                id="action_item">+</button>
                                        </label>
                                        <table class="table table-bordered" id="action_item_details">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>Record Number</th>
                                                    <th>Short Description</th>
                                                    <th>CAPA Type (Corrective Action / Preventive Action)</th>
                                                    <th>Date Opened</th>
                                                    <th>Site / Division</th>
                                                    <th>Date Due</th>
                                                    <th>Current Status</th>
                                                    <th>Person Responsible</th>
                                                    <th>Date Closed</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><input disabled type="text" name="serial_number[]" value="1">
                                                </td>
                                                <td><input type="text" name="record[]"></td>
                                                <td><input type="text" name="short_desc[]"></td>
                                                <td><input type="text" name="capa_type[]"></td>
                                                <td><input type="date" name="date_opened[]"></td>
                                                <td><input type="text" name="site[]"></td>
                                                <td><input type="date" name="date_due[]"></td>
                                                <td><input type="text" name="current_status[]"></td>
                                                <td> <select id="select-state" placeholder="Select..."
                                                        name="responsible_person[]">
                                                        <option value="">Select a value</option>
                                                        @foreach ($users as $data)
                                                            <option value="{{ $data->id }}">{{ $data->name }}
            </option>
            @endforeach
            </select></td>
            <td><input type="date" name="date_closed[]"></td>

            </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="policies-procedure">Suitability of Policies and Procedure</label>
            <textarea name="policies-procedure"></textarea>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="prevent-management-reviews">
                Status of Actions from Previous Management Reviews
                <button type="button" name="prevent-management-reviews" id="management_plan3">+</button>
            </label>
            <table class="table table-bordered" id="management_plan_details3">
                <thead>
                    <tr>
                        <th>Row #</th>
                        <th>Action Item Details</th>
                        <th>Owner</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <td><input disabled type="text" name="serial_number[]" value="1">
                    </td>
                    <td><input type="text" name="action_item_details[]"></td>
                    <td> <select id="select-state" placeholder="Select..." name="owner[]">
                            <option value="">Select a value</option>
                            @foreach ($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}
                            </option>
                            @endforeach
                        </select></td>
                    <td><input type="date" name="due_date[]"></td>
                    <td><input type="text" name="status[]"></td>
                    <td><input type="text" name="remarks[]"></td>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="recent-internal-audits">
                Outcome of Recent Internal Audits
                <button type="button" name="recent-internal-audits" id="external_plan4">+</button>
            </label>
            <table class="table table-bordered" id="external_plan_details4">
                <thead>
                    <tr>
                        <th>Row #</th>
                        <th>Month</th>
                        <th>Sites Audited</th>
                        <th>Critical</th>
                        <th>Major</th>
                        <th>Minor</th>
                        <th>Recommendation</th>
                        <th>CAPA Details if any</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="recent-external-audits">
                Outcome of Recent External Audits
                <button type="button" name="recent-external-audits" onclick="add7Input('recent-external-audits')">+</button>
            </label>
            <table class="table table-bordered" id="recent-external-audits">
                <thead>
                    <tr>
                        <th>Row #</th>
                        <th>Month</th>
                        <th>Sites Audited</th>
                        <th>Critical</th>
                        <th>Major</th>
                        <th>Minor</th>
                        <th>Recommendation</th>
                        <th>CAPA Details if any</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="capa-details">
                CAPA Details<button type="button" name="capa-details" id="capa_detail"">+</button>
                                        </label>
                                        <table class=" table table-bordered" id="capa_detail_details">
                    <thead>
                        <tr>
                            <th>Row #</th>
                            <th>Record Number</th>
                            <th>Short Description</th>
                            <th>CAPA Type (Corrective Action / Preventive Action)</th>
                            <th>Date Opened</th>
                            <th>Site / Division</th>
                            <th>Date Due</th>
                            <th>Current Status</th>
                            <th>Person Responsible</th>
                            <th>Date Closed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td><input disabled type="text" name="serial_number[]" value="1">
                        </td>
                        <td><input type="text" name="record[]"></td>
                        <td><input type="text" name="short_desc[]"></td>
                        <td><input type="text" name="capa_type[]"></td>
                        <td><input type="date" name="date_opened[]"></td>
                        <td><input type="text" name="site[]"></td>
                        <td><input type="date" name="date_due[]"></td>
                        <td><input type="text" name="current_status[]"></td>
                        <td> <select id="select-state" placeholder="Select..." name="responsible_person[]">
                                <option value="">Select a value</option>
                                @foreach ($users as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}
                                </option>
                                @endforeach
                            </select></td>
                        <td><input type="date" name="date_closed[]"></td>

                    </tbody>
                    </table>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="root-cause-analysis-details">
                Root Cause Analysis Details<button type="button" name="root-cause-analysis-details" id="analysis_detail">+</button>
            </label>
            <table class="table table-bordered" id="analysis_detail_details">
                <thead>
                    <tr>
                        <th>Row #</th>
                        <th>Record Number</th>
                        <th>Short Description</th>
                        <th>Date Opened</th>
                        <th>Site / Division</th>
                        <th>Date Due</th>
                        <th>Current Status</th>
                        <th>Person Responsible</th>
                        <th>Date Closed</th>
                    </tr>
                </thead>
                <tbody>
                    <td><input disabled type="text" name="serial_number[]" value="1">
                    </td>
                    <td><input type="text" name="record[]"></td>
                    <td><input type="text" name="short_desc[]"></td>
                    <td><input type="date" name="date_opened[]"></td>
                    <td><input type="text" name="site[]"></td>
                    <td><input type="date" name="date_due[]"></td>
                    <td><input type="text" name="current_status[]"></td>
                    <td> <select id="select-state" placeholder="Select..." name="responsible_person[]">
                            <option value="">Select a value</option>
                            @foreach ($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}
                            </option>
                            @endforeach
                        </select></td>
                    <td><input type="date" name="date_closed[]"></td>

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="lab-incident-details">
                Lab Incident Details<button type="button" name="lab-incident-details" id="incident_detail">+</button>
            </label>
            <table class="table table-bordered" id="incident_detail_details">
                <thead>
                    <tr>
                        <th>Row #</th>
                        <th>Record Number</th>
                        <th>Short Description</th>
                        <th>Date Opened</th>
                        <th>Site / Division</th>
                        <th>Date Due</th>
                        <th>Current Status</th>
                        <th>Person Responsible</th>
                        <th>Date Closed</th>
                    </tr>
                </thead>
                <tbody>
                    <td><input disabled type="text" name="serial_number[]" value="1">
                    </td>
                    <td><input type="text" name="record[]"></td>
                    <td><input type="text" name="short_desc[]"></td>
                    <td><input type="date" name="date_opened[]"></td>
                    <td><input type="text" name="site[]"></td>
                    <td><input type="date" name="date_due[]"></td>
                    <td><input type="text" name="current_status[]"></td>
                    <td> <select id="select-state" placeholder="Select..." name="responsible_person[]">
                            <option value="">Select a value</option>
                            @foreach ($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}
                            </option>
                            @endforeach
                        </select></td>
                    <td><input type="date" name="date_closed[]"></td>

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="risk-assessment-details">
                Risk Assessment Details<button type="button" name="risk-assessment-details" id="assessment_detail">+</button>
            </label>
            <table class="table table-bordered" id="assessment_detail_details">
                <thead>
                    <tr>
                        <th>Row #</th>
                        <th>Record Number</th>
                        <th>Short Description</th>
                        <th>Risk Category</th>
                        <th>Date Opened</th>
                        <th>Site / Division</th>
                        <th>Date Due</th>
                        <th>Current Status</th>
                        <th>Person Responsible</th>
                        <th>Date Closed</th>
                    </tr>
                </thead>
                <tbody>
                    <td><input disabled type="text" name="serial_number[]" value="1">
                    </td>
                    <td><input type="text" name="record[]"></td>
                    <td><input type="text" name="short_desc[]"></td>
                    <td><input type="text" name="risk_category[]"></td>
                    <td><input type="date" name="date_opened[]"></td>
                    <td><input type="text" name="site[]"></td>
                    <td><input type="date" name="date_due[]"></td>
                    <td><input type="text" name="current_status[]"></td>
                    <td> <select id="select-state" placeholder="Select..." name="responsible_person[]">
                            <option value="">Select a value</option>
                            @foreach ($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}
                            </option>
                            @endforeach
                        </select></td>
                    <td><input type="date" name="date_closed[]"></td>

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="change-control-details">
                Change Control Details<button type="button" name="change-control-details" id="control_detail">+</button>
            </label>
            <table class="table table-bordered" id="control_detail_details">
                <thead>
                    <tr>
                        <th>Row #</th>
                        <th>Record Number</th>
                        <th>Short Description</th>
                        <th>Change Type</th>
                        <th>Date Opened</th>
                        <th>Site / Division</th>
                        <th>Date Due</th>
                        <th>Current Status</th>
                        <th>Person Responsible</th>
                        <th>Date Closed</th>
                    </tr>
                </thead>
                <tbody>
                    <td><input disabled type="text" name="serial_number[]" value="1">
                    </td>
                    <td><input type="text" name="record[]"></td>
                    <td><input type="text" name="short_desc[]"></td>
                    <td><input type="text" name="change_type[]"></td>
                    <td><input type="date" name="date_opened[]"></td>
                    <td><input type="text" name="site[]"></td>
                    <td><input type="date" name="date_due[]"></td>
                    <td><input type="text" name="current_status[]"></td>
                    <td> <select id="select-state" placeholder="Select..." name="responsible_person[]">
                            <option value="">Select a value</option>
                            @foreach ($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}
                            </option>
                            @endforeach
                        </select></td>
                    <td><input type="date" name="date_closed[]"></td>

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="issue-other-than-audits">
                Issues other than Audits
                <button type="button" name="issue-other-than-audits" id="than_audit">+</button>
            </label>
            <table class="table table-bordered" id="than_audit_details">
                <thead>
                    <tr>
                        <th>Row #</th>
                        <th>Short Description</th>
                        <th>Severity (Critical / Major / Minor)</th>
                        <th>Site / Division</th>
                        <th>Issue Reporting Date</th>
                        <th>CAPA Details if any</th>
                        <th>Date Due</th>
                        <th>Current Status</th>
                        <th>Person Responsible</th>
                        <th>Date Closed</th>
                        <th>Related Documents</th>
                    </tr>
                </thead>
                <tbody>
                    <td><input disabled type="text" name="serial_number[]" value="1">
                    </td>
                    <td><input type="text" name="short_desc[]"></td>
                    <td><input type="text" name="severity[]"></td>
                    <td><input type="text" name="site[]"></td>
                    <td><input type="date" name="issue_reporting_date[]"></td>
                    <td><input type="text" name="capa_details[]"></td>
                    <td><input type="date" name="date_due[]"></td>
                    <td><input type="text" name="current_status[]"></td>
                    <td> <select id="select-state" placeholder="Select..." name="responsible_person[]">
                            <option value="">Select a value</option>
                            @foreach ($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}
                            </option>
                            @endforeach
                        </select></td>
                    <td><input type="date" name="date_closed[]"></td>
                    <td><input type="text" name="related_documents[]"></td>

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="customer-personnel-feedback">
                Customer/Personnel Feedback
                <button type="button" name="customer-personnel-feedback" id="personnel_feedback">+</button>
            </label>
            <table class="table table-bordered" id="personnel_feedback_details">
                <thead>
                    <tr>
                        <th>Row #</th>
                        <th>Feedback From (Customer / Personnel)</th>
                        <th>Feedback Reporting Date</th>
                        <th>Site / Division</th>
                        <th>Short Description</th>
                        <th>Date Due</th>
                        <th>Current Status</th>
                        <th>Person Responsible</th>
                        <th>Date Closed</th>
                        <th>Related Documents</th>
                    </tr>
                </thead>
                <tbody>
                    <td><input disabled type="text" name="serial_number[]" value="1">
                    </td>
                    <td><input type="text" name="feedback_from[]"></td>
                    <td><input type="text" name="feedback_reporting_date[]"></td>
                    <td><input type="text" name="site[]"></td>
                    <td><input type="text" name="short_description[]"></td>
                    <td><input type="date" name="date_due[]"></td>
                    <td><input type="text" name="current_status[]"></td>
                    <td> <select id="select-state" placeholder="Select..." name="responsible_person[]">
                            <option value="">Select a value</option>
                            @foreach ($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}
                            </option>
                            @endforeach
                        </select></td>
                    <td><input type="date" name="date_closed[]"></td>
                    <td><input type="text" name="related_documents[]"></td>

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="effectiveness-check-details">
                Effectiveness Check Details
                <button type="button" name="effectiveness-check-details" id="check_detail">+</button>
            </label>
            <table class="table table-bordered" id="check_detail_details">
                <thead>
                    <tr>
                        <th>Row #</th>
                        <th>Record Number</th>
                        <th>Short Description</th>
                        <th>Date Opened</th>
                        <th>Site / Division</th>
                        <th>Date Due</th>
                        <th>Current Status</th>
                        <th>Person Responsible</th>
                        <th>Date Closed</th>
                    </tr>
                </thead>
                <tbody>
                    <td><input disabled type="text" name="serial_number[]" value="1">
                    </td>
                    <td><input type="text" name="record[]"></td>
                    <td><input type="text" name="short_description[]"></td>
                    <td><input type="date" name="date_opened[]"></td>
                    <td><input type="text" name="site[]"></td>
                    <td><input type="date" name="date_due[]"></td>
                    <td><input type="text" name="current_status[]"></td>
                    <td> <select id="select-state" placeholder="Select..." name="responsible_person[]">
                            <option value="">Select a value</option>
                            @foreach ($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}
                            </option>
                            @endforeach
                        </select></td>
                    <td><input type="date" name="date_closed[]"></td>

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="comments">Comments</label>
            <textarea name="comments"></textarea>
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="psummary-recommendations">Summary & Recommendations</label>
            <textarea name="psummary-recommendations"></textarea>
        </div>
    </div>
</div> --}}



<div class="sub-head"> AQA Comments</div>
<div class="col-12">
    <div class="group-input">
        <label for="Description">AQA Review Comments</label>
        <textarea name="aqa_review_comments"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>{{$data->aqa_review_comments}}</textarea>
    </div>
</div>

<div class="col-12">
    <div class="group-input">
        <label for="Description">AQA Review Attachment</label>

        <div><small class="text-primary">Please Attach all relevant or supporting
            documents</small></div>
            <div class="file-attachment-field">
                <div class="file-attachment-list" id="file_attchment_if_any1[]"   {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>
                    @if ($data->file_attchment_if_any1)
                    @foreach (json_decode($data->file_attchment_if_any1) as $file)
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
                    <input type="file" id="file_attchment_if_any1[]" name="file_attchment_if_any1[]"
                        oninput="addMultipleFiles(this, 'file_attchment_if_any1[]')" multiple>
                </div>
            </div>
</div>
</div>
<!-- <div class="col-6">
    <div class="group-input">
        <label for="Description">AQA Reviewed By</label>
        <input type="text"></input>
    </div>
</div>



<div class="col-lg-6 new-date-data-field">
    <div class="group-input input-date">
        <label for="Scheduled Start Date">AQA Reviewed On</label>
        <div class="calenderauditee">
            <input type="text" id="start_date" readonly placeholder="DD-MM-YYYY" />
            <input type="date" id="start_date_checkdate" name="start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
        </div>
    </div>
</div> -->


<!-- <div class="group-input">
    <label for="Operations">
        Operations
        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#management-review-operations-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
            (Launch Instruction)
        </span>
    </label>
    <textarea name="Operations"></textarea>
</div>
<div class="group-input">
    <label for="requirement_products_services">
        Requirements for Products and Services
        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#management-review-requirement_products_services-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
            (Launch Instruction)
        </span>
    </label>
    <textarea name="requirement_products_services"></textarea>
</div>
<div class="group-input">
    <label for="design_development_product_services">
        Design and Development of Products and Services
        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#management-review-design_development_product_services-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
            (Launch Instruction)
        </span>
    </label>
    <textarea name="design_development_product_services"></textarea>
</div>
<div class="group-input">
    <label for="control_externally_provide_services">
        Control of Externally Provided Processes, Products and Services
        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#management-review-control_externally_provide_services-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
            (Launch Instruction)
        </span>
    </label>
    <textarea name="control_externally_provide_services"></textarea>
</div>
<div class="group-input">
    <label for="production_service_provision">
        Production and Service Provision
        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#management-review-production_service_provision-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
            (Launch Instruction)
        </span>
    </label>
    <textarea name="production_service_provision"></textarea>
</div>
<div class="group-input">
    <label for="release_product_services">
        Release of Products and Services
        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#management-review-release_product_services-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
            (Launch Instruction)
        </span>
    </label>
    <textarea name="release_product_services"></textarea>
</div>
<div class="group-input">
    <label for="control_nonconforming_outputs">
        Control of Non-conforming Outputs
        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#management-review-control_nonconforming_outputs-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
            (Launch Instruction)
        </span>
    </label>
    <textarea name="control_nonconforming_outputs"></textarea>
</div>
<div class="group-input">
    <label for="performance_evaluation">
        Performance Evaluation
        <button type="button" onclick="addPerformanceEvoluation('performance_evaluation')">+</button>
        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#management-review-performance_evaluation-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
            (Launch Instruction)
        </span>
    </label>
    <table class="table table-bordered" id="performance_evaluation">
        <thead>
            <tr>
                <th>Row #</th>
                <th>Monitoring</th>
                <th>Measurement</th>
                <th>Analysis</th>
                <th>Evalutaion</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input disabled type="text" name="serial_number[]" value="1"></td>
                {{-- ignore   --}}
                <td><input type="text" name="monitoring[]"></td>
                <td><input type="text" name="measurement[]"></td>
                <td><input type="text" name="analysis[]"></td>
                <td><input type="text" name="evaluation[]"></td>
            </tr>
        </tbody>

    </table>
</div> -->
<div class="button-block">
    <button type="submit" class="saveButton">Save</button>
    <button type="button" class="backButton" onclick="previousStep()">Back</button>
    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
    <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
</div>
</div>
</div>

<div id="CCForm3" class="inner-block cctabcontent">
    <div class="inner-block-content">
        <div class="sub-head">Action Execution Comments</div>

        <div class="col-12">
            <div class="group-input">
                <label for="Description">Summary of Rec.Actions</label>
                <textarea name="summary_of_recommended_actions"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} >{{$data->summary_of_recommended_actions}}</textarea>
            </div>
        </div>

        <div class="col-12">
            <div class="group-input">
                <label for="Description">Results & Conclusion</label>
                <textarea name="results_conclusion"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>{{$data->results_conclusion}}</textarea>
            </div>
        </div>

        <div class="group-input">
            <label for="Description">Execution Attachment</label>

            <div><small class="text-primary">Please Attach all relevant or supporting
                    documents</small></div>
                    <div class="file-attachment-field">
                        <div class="file-attachment-list" id="execution_attchment_if_any"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>
                            @if ($data->execution_attchment_if_any)
                            @foreach (json_decode($data->execution_attchment_if_any) as $file)
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
                            <input type="file" id="myfile" name="execution_attchment_if_any[]"
                                oninput="addMultipleFiles(this, 'execution_attchment_if_any')" multiple>
                        </div>
                    </div>
        </div>

        <div class="col-12">
            <div class="group-input">
                <label for="Description">Delay Justification</label>
                <textarea name="delay_justification"   {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>{{$data->delay_justification}}</textarea>
            </div>
        </div>


        <!-- <div class="col-6">
            <div class="group-input">
                <label for="Description">Complete By</label>
                <input type="text"></input>
            </div>
        </div>

        <div class="col-lg-6 new-date-data-field">
            <div class="group-input input-date">
                <label for="Scheduled Start Date">Complete On</label>
                <div class="calenderauditee">
                    <input type="text" id="start_date" readonly placeholder="DD-MM-YYYY" />
                    <input type="date" id="start_date_checkdate" name="start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                </div>
            </div>
        </div> -->


        <!-- <div class="group-input">
            <label for="risk_opportunities">Risk & Opportunities</label>
            <textarea name="risk_opportunities"></textarea>
        </div>
        <div class="group-input">
            <label for="external_supplier_performance">External Supplier Performance</label>
            <textarea name="external_supplier_performance"></textarea>
        </div>
        <div class="group-input">
            <label for="customer_satisfaction_level">Customer Satisfaction Level</label>
            <textarea name="customer_satisfaction_level"></textarea>
        </div>
        <div class="group-input">
            <label for="budget_estimates">Budget Estimates</label>
            <textarea name="budget_estimates"></textarea>
        </div> -->
        <!-- <div class="group-input">
            <label for="completion_of_previous_tasks">Completion of Previous Tasks</label>
            <textarea name="completion_of_previous_tasks"></textarea>
        </div>
        <div class="group-input">
            <label for="production">Production</label>
            <textarea name="production_new"></textarea>
        </div>
        <div class="group-input">
            <label for="plans">Plans</label>
            <textarea name="plans_new"></textarea>
        </div>
        <div class="group-input">
            <label for="forecast">Forecast</label>
            <textarea name="forecast_new"></textarea>
        </div>
        <div class="group-input">
            <label for="additional_suport_required">Any Additional Support Required</label>
            <textarea name="additional_suport_required"></textarea>
        </div>
        <div class="group-input">
            <label for="file_attchment_if_any">File Attachment, if any</label>
            <div><small class="text-primary">Please Attach all relevant or supporting
                    documents</small></div>
            <div class="file-attachment-field">
                <div class="file-attachment-list" id="file_attchment_if_any"></div>
                <div class="add-btn">
                    <div>Add</div>
                    <input type="file" id="myfile" name="file_attchment_if_any[]" {{-- ignore --}} oninput="addMultipleFiles(this, 'file_attchment_if_any')" multiple>
                </div>
            </div>
        </div>
        <div class="button-block">
            <button type="submit" class="saveButton">Save</button>
            <button type="button" class="backButton" onclick="previousStep()">Back</button>
            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
            {{-- <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button> --}}
        </div> -->
        <div class="button-block">
            <button type="submit" class="saveButton">Save</button>
            <button type="button" class="backButton" onclick="previousStep()">Back</button>
            {{-- <button type="submit">Submit1</button> --}}
            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white" href="{{ url('dashboard') }}"> Exit </a>
            </button>
        </div>
    </div>
</div>

<div id="CCForm4" class="inner-block cctabcontent">
    <div class="inner-block-content">

        <div class="sub-head">Review Comments</div>
        <div class="col-12">
            <div class="group-input">
                <label for="Description">Review Comments</label>
                <textarea name="review_comments"   {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}} >{{$data->review_comments}}</textarea>
            </div>
        </div>

        <div class="group-input">
            <label for="Description">File Attechment</label>

             <div><small class="text-primary">Please Attach all relevant or supporting
            documents</small></div>
            <div class="file-attachment-field">
                <div class="file-attachment-list" id="file_attchment_if1"  {{ $data->stage == 0 || $data -> stage == 5 ? 'disabled' : ''}}>
                    @if ($data->file_attchment_if1)
                    @foreach (json_decode($data->file_attchment_if1) as $file)
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
                    <input type="file" id="myfile" name="file_attchment_if1[]"
                        oninput="addMultipleFiles(this, 'file_attchment_if1')" multiple>
                </div>
            </div>
</div>
</div>


        <!-- <div class="group-input">
            <label for="action_item_details">
                Action Item Details<button type="button" name="action_item_details" id="action_item" onclick="addActionItemDetails('action_item_details')">+</button>
            </label>
            <table class="table table-bordered" id="action_item_details">
                <thead>
                    <tr>
                        <th>Row #</th>
                        <th>Short Description</th>
                        <th>Due Date</th>
                        <th>Site / Division</th>
                        <th>Person Responsible</th>
                        <th>Current Status</th>
                        <th>Date Closed</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <td><input disabled type="text" name="serial_number[]" value="1">
                    </td>
                    <td><input type="text" name="short_desc[]"></td>
                    <td>
                        <div class="group-input new-date-data-field mb-0">
                            <div class="input-date ">
                                <div class="calenderauditee">
                                    <input type="text" id="date_due0" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" name="date_due[]" id="date_due0_checkdate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, `date_due0`);checkDate('date_due0_checkdate','date_closed0_checkdate')" />
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><input type="text" name="site[]"></td>
                    <td>
                        <select id="select-state" placeholder="Select..." name="responsible_person[]">
                            <option value="">Select a value</option>
                            {{-- @foreach ($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}
                            </option>
                            @endforeach --}}
                        </select>
                    </td>
                    <td><input type="text" name="current_status[]"></td>
                    <td>
                        <div class="group-input new-date-data-field mb-0">
                            <div class="input-date ">
                                <div class="calenderauditee">
                                    <input type="text" id="date_closed0" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" name="date_closed[]" id="date_closed0_checkdate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, `date_closed0`);checkDate('date_due0_checkdate','date_closed0_checkdate')" />
                                </div>
                            </div>
                        </div>
                    </td>


                    <td><input type="text" name="remark[]"></td>
                    <!-- <td><input type="text" name="capa_type[]"></td>
                                        {{-- <td><input type="date" name="date_opened[]"></td> --}}
                                        <td><div class="group-input new-date-data-field mb-0">
                                            <div class="input-date "><div
                                             class="calenderauditee">
                                            <input type="text" id="date_due00' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="date_opened[]" class="hide-input"
                                            oninput="handleDateInput(this, `date_due00' + serialNumber +'`)" /></div></div></div></td> -->
        <!--
                </tbody>
            </table>
        </div>
        <div class="group-input">
            <label for="capa-details">
                CAPA Details<button type="button" name="capa-details" id="capa_detail">+</button>
            </label>
            <table class="table table-bordered" id="capa_detail_details">
                <thead>
                    <tr>
                        <th>Row #</th>
                        <th>CAPA Details</th>
                        <th>CAPA Type</th>
                        <th>Site / Division</th>
                        <th>Person Responsible</th>
                        <th>Current Status</th>
                        <th>Date Closed</th>
                        <th>Remark</th>

                    </tr>
                </thead>
                <tbody>
                    <td><input disabled type="text" name="serial_number[]" value="1">
                    </td>
                    <td><input type="text" name="Details[]"></td>
                    <td>
                        <select id="select-state" placeholder="Select..." name="capa_type[]">
                            <option value="">Select a value</option>
                            <option value="corrective">Corrective Action</option>
                            <option value="preventive">Preventive Action</option>
                            <option value="corrective_preventive">Corrective & Preventive Action</option>
                        </select>
                    </td>
                    <td><input type="text" name="site2[]"></td>
                    <td>
                        <select id="select-state" placeholder="Select..." name="responsible_person2[]">
                            <option value="">Select a value</option>
                            {{-- @foreach ($users as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}
                            </option>
                            @endforeach --}}
                        </select>
                    </td>
                    <td><input type="text" name="current_status2[]"></td>
                    <td>
                        <div class="group-input new-date-data-field mb-0">
                            <div class="input-date ">
                                <div class="calenderauditee">
                                    <input type="text" id="date_closed_capa1" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" name="date_closed2[]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, `date_closed_capa1`);" />
                                </div>
                            </div>
                        </div>
                    </td>


                    <td><input type="text" name="remark2[]"></td>
                </tbody>
            </table>
        </div>

        <div class="new-date-data-field">
            <div class="group-input input-date">
                <label for="next_managment_review_date">Next Management Review Date</label>
                <div class="calenderauditee">
                    <input type="text" id="next_managment_review_date" readonly placeholder="DD-MMM-YYYY" />
                    {{-- <input type="date" name="next_managment_review_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input {{ (isset($data->stage) and $data->stage == 0 )|| (isset($data->stage) and $data->stage == 3 )? 'disabled' : '' }}
                                         min=" {{ \Carbon\Carbon::now()->format('Y-m-d') }}" oninput="handleDateInput(this, 'next_managment_review_date')" /> --}}
                </div>
            </div>
        </div>
        <div class="group-input">
            <label for="summary_recommendation">Summary & Recommendation</label>
            <textarea name="summary_recommendation"></textarea>
        </div>
        <div class="group-input">
            <label for="conclusion">Conclusion</label>
            <textarea name="conclusion_new"></textarea>
        </div>
        <div class="group-input">
            <label for="closure-attachments">Closure Attachments</label>
            <div><small class="text-primary">Please Attach all relevant or supporting
                    documents</small></div>
            <div class="file-attachment-field">
                <div class="file-attachment-list" id="closure_attachments"></div>
                <div class="add-btn">
                    <div>Add</div>
                    <input type="file" id="myfile" name="closure_attachments[]" oninput="addMultipleFiles(this, 'closure_attachments')" multiple>
                </div>
            </div>
        </div>
        <div class="sub-head">
            Extension Justification
        </div>
        <div class="group-input">
            <label for="due_date_extension">Due Date Extension Justification</label>
            <div><small class="text-primary">Please Mention justification if due date is
                    crossed</small></div>
            <textarea name="due_date_extension"></textarea>
        </div>
        <div class="button-block">
            <button type="submit" class="saveButton">Save</button>
            <button type="button" class="backButton" onclick="previousStep()">Back</button>
            {{-- <button type="submit">Submit1</button> --}}
            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
            {{-- <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white" href="{{ url('dashboard') }}"> Exit </a> --}}
            </button>
        </div>  -->
        <div class="button-block">
            <button type="submit" class="saveButton">Save</button>
            <button type="button" class="backButton" onclick="previousStep()">Back</button>
            {{-- <button type="submit">Submit1</button> --}}
            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white" href="{{ url('dashboard') }}"> Exit </a>
            </button>
        </div>
    </div>
</div>





<div id="CCForm5" class="inner-block cctabcontent">
    <div class="inner-block-content">
        <div class="row">
            <div class="col-lg-6">
                <div class="group-input">
                    <label for="Completed By">Submit By :-</label>
                   <div class="static">{{$data->cancellation_request_by}}</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="group-input">
                    <label for="Completed On">Submit On :-</label>
                    <div class="static">{{$data->cancellation_request_on}}</div>
                </div>
            </div>
        </div>


        <div class="inner-block-content">
            <div class="row">
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Completed By">Cancellation Request
                            By :-</label>
                       <div class="static">{{$data->more_info_by}}</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Completed On">Cancellation Request On :-</label>
                        <div class="static">{{$data->more_info_on}}</div>
                    </div>
                </div>
            </div>

            <div class="inner-block-content">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Completed By">Cancellation Request
                                By :-</label>
                           <div class="static">{{$data->more_info_by}}</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Completed On">Cancellation Request On :-</label>
                            <div class="static">{{$data->more_info_on}}</div>
                        </div>
                    </div>
                </div>


        <div class="row">
            <div class="col-lg-6">
                <div class="group-input">
                    <label for="Completed By">Action Review by AQA Approver Complete By</label>
                    <div class="static">{{$data->approver_complete_by}}</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="group-input">
                    <label for="Completed On">Action Review by AQA Approver Complete On :-</label>
                    <div class="static">{{$data->approver_complete_on}}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="group-input">
                    <label for="Completed By">Action Execution Complete
                        Current Status By :-</label>
                        <div class="static">{{$data->action_execution_complete_by}}</div>
                    </div>
            </div>
            <div class="col-lg-6">
                <div class="group-input">
                    <label for="Completed On">Action Execution Complete
                        Current Status By On :-</label>
                        <div class="static">{{$data->action_execution_complete_on}}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="group-input">
                    <label for="Completed By">Action Execution Review Complete By :-</label>
                        <div class="static">{{$data->rec_action_execution_by}}</div>
                    </div>
            </div>
            <div class="col-lg-6">
                <div class="group-input">
                    <label for="Completed On">Action Execution Review Complete On :-</label>
                        <div class="static">{{$data->rec_action_execution_on}}</div>
                </div>
            </div>
        </div>


        <div class="button-block">
            <button type="submit" class="saveButton">Save</button>
            <button type="button" class="backButton" onclick="previousStep()">Back</button>
            <button type="submit">Submit</button>
            <button type="button"> <a class="text-white" href="{{ url('dashboard') }}"> Exit </a>
            </button>
        </div>
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

            <form action="{{ route('reccomend_send_stage', $data->id) }}" method="POST">
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
                        <label for="comment">Comment </label>
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
<div class="modal fade" id="signature2-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('reccomend_send_stage2', $data->id) }}" method="POST">
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
                        <label for="comment">Comment </label>
                        <input type="comment" class="input_width" name="comment" >
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
        ele: '#Facility, #Group, #Audit, #Auditee'
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
    }



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
    // JavaScript
    document.getElementById('initiator_group').addEventListener('change', function() {
        var selectedValue = this.value;
        document.getElementById('initiator_group_code').value = selectedValue;
    });
</script>

<script>
    function addActionItemDetails(tableId) {
        var users = @json($users);
        var table = document.getElementById(tableId);
        var currentRowCount = table.rows.length;
        var newRow = table.insertRow(currentRowCount);
        newRow.setAttribute("id", "row" + currentRowCount);
        var cell1 = newRow.insertCell(0);
        cell1.innerHTML = currentRowCount;

        var cell2 = newRow.insertCell(1);
        cell2.innerHTML = "<input type='text' name='short_desc[]'>";

        var cell3 = newRow.insertCell(2);
        cell3.innerHTML = '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="date_due' + currentRowCount + '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="date_due[]"   min="{{ \Carbon\Carbon::now()->format('
        Y - m - d ') }}" id="date_due' + currentRowCount + '_checkdate"  class="hide-input" oninput="handleDateInput(this, date_due' + currentRowCount + ');checkDate(date_due' + currentRowCount + '_checkdate,date_closed' + currentRowCount + '_checkdate)" /></div></div></div></td>';

        var cell4 = newRow.insertCell(3);
        cell4.innerHTML = "<input type='text' name='site[]'>";

        var cell5 = newRow.insertCell(4);
        var userHtml = '<select name="responsible_person[]"><option value="">-- Select --</option>';
        for (var i = 0; i < users.length; i++) {
            userHtml += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
        }
        userHtml += '</select>';

        cell5.innerHTML = userHtml;

        var cell6 = newRow.insertCell(5);
        cell6.innerHTML = "<input type='text' name='current_status[]'>";

        var cell7 = newRow.insertCell(6);
        cell7.innerHTML = '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="date_closed' + currentRowCount + '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="date_closed[]"  min="{{ \Carbon\Carbon::now()->format('
        Y - m - d ') }}"  id="date_closed' + currentRowCount + '_checkdate" class="hide-input" oninput="handleDateInput(this, date_closed' + currentRowCount + ');checkDate(date_due' + currentRowCount + '_checkdate,date_closed' + currentRowCount + '_checkdate)" /></div></div></div></td>';

        var cell8 = newRow.insertCell(7);
        cell8.innerHTML = "<input type='text' name='remark[]'>";
        for (var i = 1; i < currentRowCount; i++) {
            var row = table.rows[i];
            row.cells[0].innerHTML = i;
        }
    }

    $(document).ready(function() {

        $('#action_plan2').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);
                console.log(users);
                var html =
                    '<tr>' +
                    '<td><input type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="mitigation_steps[]"></td>' +
                    '<td><input type="date" name="deadline2[]"></td>' +
                    '<td><select name="responsible_person[]">' +
                    '<option value="">Select a value</option>';

                for (var i = 0; i < users.length; i++) {
                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }

                html += '</select></td>' +
                    '<td><input type="text" name="status[]"></td>' +
                    '<td><input type="text" name="remark[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#action_plan_details2 tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<script>


// let rowIndex = {{ count($rgrid->data) }}; // Initialize the row index based on the existing data

// function handleDateInput(dateInput, index) {
//     const dateValue = dateInput.value;
//     if (dateValue) {
//         const date = new Date(dateValue);
//         const day = date.getDate();
//         const month = date.getMonth() + 1; // Months are zero-based
//         const year = date.getFullYear();
//         const formattedDate = `${day}-${month}-${year}`; // Format as D-M-Y
//         document.getElementById(`mfg_date_text_${index}`).value = formattedDate;
//         document.getElementById(`expiry_date_text_${index}`).value = formattedDate;
//     } else {
//         document.getElementById(`mfg_date_text_${index}`).value = '';
//         document.getElementById(`expiry_date_text_${index}`).value = '';
//     }
// }

function addRow() {
    const tableBody = document.getElementById('table_body');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td><input disabled type="text" name="serial_number[]" value="${rowIndex + 1}"></td>
        <td><input type="text" name="parent_info_on_product_material[${rowIndex}][item_product_code]" required></td>
        <td><input type="text" name="parent_info_on_product_material[${rowIndex}][lot_batch_number]" required></td>
        <td><input type="text" name="parent_info_on_product_material[${rowIndex}][a_r_number]" required></td>
        <td>
            <div class="group-input new-date-data-field mb-0">
                <div class="input-date">
                    <div class="calenderauditee">
                        <input type="text" id="mfg_date_text_${rowIndex}" readonly placeholder="D-M-Y" />
                        <input type="date" name="parent_info_on_product_material[${rowIndex}][mfg_date]"
                            class="hide-input" id="mfg_date_input_${rowIndex}" onchange="handleDateInput(this, '${rowIndex}');" />
                    </div>
                </div>
            </div>
        </td>
        <td>
            <div class="group-input new-date-data-field mb-0">
                <div class="input-date">
                    <div class="calenderauditee">
                        <input type="text" id="expiry_date_text_${rowIndex}" readonly placeholder="D-M-Y" />
                        <input type="date" name="parent_info_on_product_material[${rowIndex}][expiry_date]"
                            class="hide-input" id="expiry_date_input_${rowIndex}" onchange="handleDateInput(this, '${rowIndex}');" />
                    </div>
                </div>
            </div>
        </td>
        <td><input type="text" name="parent_info_on_product_material[${rowIndex}][label_claim]" required></td>
        <td><input type="text" name="parent_info_on_product_material[${rowIndex}][pack_size]" required></td>


    `;
    tableBody.appendChild(newRow);
    rowIndex++;
}

document.getElementById('product_material').addEventListener('click', addRow);

// Initial call to add the first row if needed
// addRow();

</script>


<script>

   $(document).ready(function() {
    $('#product_material').click(function(e) {
        e.preventDefault();
            function generateTableRow(serialNumber) {
                var html =
                '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="parent_info_on_product_material[' + serialNumber + '][item_product_code]"></td>' +
                    '<td><input type="text" name="parent_info_on_product_material[' + serialNumber + '][lot_batch_number]"></td>' +
                    '<td><input type="text" name="parent_info_on_product_material[' + serialNumber + '][a_r_number]"></td>' +
                    '<td><input type="date" name="parent_info_on_product_material[' + serialNumber + '][mfg_date]"></td>' +
                    '<td><input type="date" name="parent_info_on_product_material[' + serialNumber + '][expiry_date]"></td>' +

                    // '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="date" id="mfg_date" readonly placeholder="DD-MM-YYYY" /><input type="date" name="parent_info_on_product_material[0][mfg_date]" min="{{ \Carbon\Carbon::now()->format('Y-m-d')}}" class="hide-input" oninput="handleDateInput(this, mfg_date);" /></div></div></div></td>' +
                    // '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="date" id="expiry_date" readonly placeholder="DD-MM-YYYY" /><input type="date" name="parent_info_on_product_material[0][expiry_date]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, expiry_date);" /></div></div></div></td>' +
                    '<td><input type="text" name="parent_info_on_product_material[' + serialNumber + '][label_claim]"></td>' +
                    '<td><input type="text" name="parent_info_on_product_material[' + serialNumber + '][pack_size]"></td>' +
                   ' <td><button type="button" class="removeRowBtn" >Remove</button></td>'

                    '</tr>';
                return html;
            }
            var tableBody = $('#product_material_body tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            // var newRow = generateTableRow(rowCount - 1);
            tableBody.append(newRow);


        });



        $(document).ready(function() {
    $('#oos_details').click(function(e) {
        e.preventDefault(); // Prevent default form submission behavior

        function generateTableRow(serialNumber) {
            var html =
                '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="parent_oos_details[' + serialNumber + '][ar_no]"></td>' +
                    '<td><input type="text" name="parent_oos_details[' + serialNumber + '][test_name_of_oos]"></td>' +
                    '<td><input type="text" name="parent_oos_details[' + serialNumber + '][results_obtained]"></td>' +
                    '<td><input type="text" name="parent_oos_details[' + serialNumber + '][specification_limit]"></td>' +
                    ' <td><button type="button" class="removeRowBtn" >Remove</button></td>'

                '</tr>';
            return html;
        }

        var tableBody = $('#oos_details_body2 tbody');
        var rowCount = tableBody.children('tr').length;
        var newRow = generateTableRow(rowCount + 1);
        tableBody.append(newRow);
    });
});


$('#oot_results').click(function(e) {
    function generateTableRow(serialNumber) {
        var html =
        '<tr>' +
            '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
            '<td><input type="text" name="parent_oot_results[' + serialNumber + '][ar_no]"></td>' +
            '<td><input type="text" name="parent_oot_results[' + serialNumber + '][test_name_of_oot]"></td>' +
            '<td><input type="text" name="parent_oot_results[' + serialNumber + '][results_obtained]"></td>' +
            '<td><input type="text" name="parent_oot_results[' + serialNumber + '][initial_intervel_details]"></td>' +
            '<td><input type="text" name="parent_oot_results[' + serialNumber + '][previous_interval_details]"></td>' +
            '<td><input type="text" name="parent_oot_results[' + serialNumber + '][difference_of_results]"></td>' +
            '<td><input type="text" name="parent_oot_results[' + serialNumber + '][initial_interview_details]"></td>' +
            '<td><input type="text" name="parent_oot_results[' + serialNumber + '][trend_limit]"></td>' +
            ' <td><button type="button" class="removeRowBtn" >Remove</button></td>'

        '</tr>';
        return html;
    }

    var tableBody = $('#oot_results_body3 tbody');
    var rowCount = tableBody.children('tr').length;
    var newRow = generateTableRow(rowCount + 1);
    tableBody.append(newRow);
});


$('#details_of_stability_study').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    // '<td><input type="date" name="date[]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[' + serialNumber + '][ar_no]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[' + serialNumber + '][condition_temperature_&_rh]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[' + serialNumber + '][interval]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[' + serialNumber + '][orientation]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[' + serialNumber + '][pack_details]"></td>' +
                    ' <td><button type="button" class="removeRowBtn" >Remove</button></td>'

                '</tr>';
                return html;
            }
            var tableBody = $('#details_of_stability_study_body4 tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });










        $('#check_detail ').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);
                console.log(users);
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber +
                    '"></td>' +
                    '<td><input type="text" name="record[]">' +
                    '<td><input type="text" name="short_description[]">' +
                    '<td><input type="date" name="date_opened[]">' +
                    '<td><input type="text" name="site[]">' +
                    '<td><input type="date" name="date_due[]">' +
                    '<td><input type="text" name="current_status[]">' +
                    '<td><select name="responsible_person[]">' +
                    '<option value="">Select a value</option>';

                for (var i = 0; i < users.length; i++) {
                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }

                html += '</select></td>' +
                    '<td><input type="date" name="date_closed[]"></td>' +
                    '</tr>';
                return html;
            }

            var tableBody = $('#check_detail_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
        $('#check_plan12').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);
                console.log(users);
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="mitigation_steps[]"></td>' +
                    '<td><input type="date" name="deadline2[]"></td>' +
                    '<td><select name="responsible_person[]">' +
                    '<option value="">Select a value</option>';

                for (var i = 0; i < users.length; i++) {
                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }

                html += '</select></td>' +
                    '<td><input type="text" name="status[]"></td>' +
                    '<td><input type="text" name="remark[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#check_plan_details12 tbody');
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
    function handleDateInput(dateInput, index) {
        const dateValue = dateInput.value;
        if (dateValue) {
            const date = new Date(dateValue);
            const day = date.getDate();
            const month = date.getMonth() + 1; // Months are zero-based
            const year = date.getFullYear();
            const formattedDate = `${day}-${month}-${year}`; // Format as D-M-Y
            document.getElementById(`mfg_date_text_${index}`).value = formattedDate;
        } else {
            document.getElementById(`mfg_date_text_${index}`).value = '';
        }
    }
    </script>
    <script>
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>

@endsection
