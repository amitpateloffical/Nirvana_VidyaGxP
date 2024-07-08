
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
        / Subject Action Item
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
                            ->where(['user_id' => auth()->id(), 'q_m_s_divisions_id' => $item_data->division_id])
                            ->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp
                    <button class="button_theme1"> <a class="text-white"
                            href="{{ route('subject_action_item.audit_trail', $item_data->id) }}">
                            Audit Trail </a>
                    </button>

                    @if ($item_data->stage == 1 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Submit Trial Action Item
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                    @elseif($item_data->stage == 2 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Close
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
                @if ($item_data->stage == 0)
                    <div class="progress-bars">
                        <div  class="bg-danger canceled">Closed-Cancelled</div>
                    </div>
                @else
                    <div class="progress-bars d-flex" style="font-size: 15px;">
                        @if ($item_data->stage >= 1)
                            <div class="active">Opened</div>
                        @else
                            <div class="">Opened</div>
                        @endif
                        @if ($item_data->stage >= 2)
                            <div class="active">Pending Action Item Review</div>
                        @else
                            <div class="">Pending Action Item Review</div>
                        @endif

                        @if ($item_data->stage >= 3)
                            <div class="bg-danger">Closed Done</div>
                        @else
                            <div class="">Closed Done</div>
                        @endif

                    </div>
                @endif
            </div>
        </div>


{{--workflow end--}}


{{-- Workflow Model Open--}}
<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('subject_action_item.send_stage', $item_data->id) }}" method="POST">
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
{{-- Workflow Model Close--}}

{{-- Workflow Model Open--}}
<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('subject_action_item.cancel', $item_data->id) }}" method="POST">
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
{{-- Workflow Model Close--}}
<div class="modal fade" id="child-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <form action="{{ route('subjec_action_item.child', $item_data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        <label style="display: flex;" for="major">
                            <input type="radio" name="child_type" id="child_type" value="violation">
                              Violation
                        </label>

                        <label style="display: flex;" for="major">
                            <input type="radio" name="child_type" id="major">
                             SAE
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
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Treatment Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button>

        </div>

        {{--disabled field code start--}}

        <?php if (in_array($item_data->stage, [0, 3])) : ?>
        <script>
            $(document).ready(function() {
                $("#target :input").prop("disabled", true);
            });
        </script>
        <?php endif; ?>

        {{--disabled field code start--}}

        <form action="{{ route('subject_action_item.update', $item_data->id) }}" method="POST" id="target" enctype="multipart/form-data">
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
                                    <label for="Initiator"> Record Number </label>
                                    <input disabled type="text" name="record"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/Subject_Action_Item/{{ date('Y') }}/{{ $record_number }}">
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
                                    <input disabled type="text" disabled name="initiation_id" value="{{ auth()->user()->name }}">

                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="intiation_date">Date of Initiation<span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input readonly type="text" value="{{ date('d-M-Y', strtotime($item_data->intiation_date)) }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d', strtotime($item_data->intiation_date)) }}" name="intiation_date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="cancelled by">Short Description<span class="text-danger">*</span>
                                    <input type="text" name="short_description_ti" value="{{ $item_data->short_description_ti }}" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Assigned To</b></label>
                                    <select name="assign_to_gi">
                                        <option value="">Select a value</option>
                                            @if(!empty($users))
                                                @foreach ($users as $user)
                                                  <option value="{{ $user->id }}" {{ $user->id == $item_data->assign_to_gi ? 'selected' : '' }}>{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date"> Date Due <span class="text-danger"></span></label>
                                    <p class="text-primary">Please mention expected date of completion</p>
                                    <div class="calenderauditee">
                                        <input  type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}">
                                    </div>
                                </div>
                            </div>


                            <div class="sub-head">Study Details</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Root Parent) Trade Name</b></label>
                                    <input  type="text" name="trade_name_sd" value="{{ $item_data->trade_name_sd }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Root Parent) Assigned To</b></label>
                                    <select name="assign_to_sd">
                                        <option value="">--Select--</option>
                                        <option value="manish" @if($item_data->assign_to_sd == 'manish') selected @endif>Manish</option>
                                        <option value="pankaj" @if($item_data->assign_to_sd == 'pankaj') selected @endif>Pankaj</option>

                                    </select>
                                </div>
                            </div>


                            <div class="sub-head">Subject Details</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>( Parent) Subject Name</b></label>
                                    <input  type="text" name="subject_name_sd" value="{{ $item_data->subject_name_sd }}">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) Gender</b></label>
                                    <select name="gender_sd">
                                        <option value="">--Select--</option>
                                        <option value="male" @if($item_data->gender_sd == 'male') selected @endif>Male</option>
                                        <option value="female" @if($item_data->gender_sd == 'female') selected @endif>Female</option>
                                        <option value="others" @if($item_data->gender_sd == 'others') selected @endif>Others</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) Date Of Birth</b></label>
                                    <input  type="date" name="date_of_birth_sd" value="{{ $item_data->date_of_birth_sd }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) Race</b></label>
                                    <select name="race_sd">
                                        <option value="">--Select--</option>
                                        <option value="23" @if($item_data->race_sd == 23) selected @endif>23</option>
                                        <option value="24" @if($item_data->race_sd == 24) selected @endif>24</option>
                                        <option value="25" @if($item_data->race_sd == 25) selected @endif>25</option>
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

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Clinical Efficacy</b></label>
                                    <select name="clinical_efficacy_ti">
                                        <option value="">--Select--</option>
                                        <option value="efficacy-analysis" @if($item_data->clinical_efficacy_ti == "efficacy-analysis") selected @endif>Efficacy Analysis</option>
                                        <option value="interim-efficacy-assessment" @if($item_data->clinical_efficacy_ti == "interim-efficacy-assessment") selected @endif>Interim Efficacy Assessment</option>
                                        <option value="efficacy-monitoring" @if($item_data->clinical_efficacy_ti == "efficacy-monitoring") selected @endif>Efficacy Monitoring</option>
                                        <option value="efficacy-data-collection" @if($item_data->clinical_efficacy_ti == "efficacy-data-collection") selected @endif>Efficacy Data Collection</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Carry Over Effect</b></label>
                                    <select name="carry_over_effect_ti">
                                        <option value="">--Select--</option>
                                        <option value="data-collection-protocols" @if($item_data->carry_over_effect_ti == "data-collection-protocols") selected @endif>Data Collection Protocols</option>
                                        <option value="statistical-analysis" @if($item_data->carry_over_effect_ti == "statistical-analysis") selected @endif>Statistical Analysis</option>
                                        <option value="regulatory-compliance" @if($item_data->carry_over_effect_ti == "regulatory-compliance") selected @endif>Regulatory Compliance</option>
                                        <option value="pilot-studies" @if($item_data->carry_over_effect_ti == "pilot-studies") selected @endif>Pilot Studies</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Last Monitered (Days)</b></label>
                                    <select name="last_monitered_ti">
                                        <option value="">--Select--</option>
                                        <option value="1Days" @if($item_data->last_monitered_ti == '1Days') selected @endif>1Days</option>
                                        <option value="2Days" @if($item_data->last_monitered_ti == '2Days') selected @endif>2Days</option>
                                        <option value="3Days" @if($item_data->last_monitered_ti == '3Days') selected @endif>3Days</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="cancelled by">Total Doses Recieved</label>
                                    <input name="total_doses_recieved_ti" value="{{ $item_data->total_doses_recieved_ti }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="cancelled by">Treatment Effect</label>
                                    <input name="treatment_effect_ti" value="{{ $item_data->treatment_effect_ti }}">
                                </div>
                            </div>


                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    DCF
                                    <button type="button" name="dfc_grid" id="DCFadd">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="DCF">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Number</th>
                                                <th style="width: 16%"> Date</th>
                                                <th style="width: 15%">Sent Date</th>
                                                <th style="width: 15%">Returned Date</th>
                                                <th style="width: 15%">Data Collection Method </th>
                                                <th style="width: 15%">Comment</th>
                                                <th style="width: 15%">Remarks</th>
                                                <th style="width: 15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @php
                                            $data = isset($grid_DataD) && $grid_DataD->data ? json_decode($grid_DataD->data, true) : null;
                                         @endphp

                                      @if ($data && is_array($data))
                                        @foreach ($data as $index => $item)
                                            <tr>
                                                <td><input disabled type="text" name="[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}" value="1"></td>

                                                <td><input type="text" name="dfc_grid[{{ $loop->index }}][Number]" value="{{ isset($item['Number']) ? $item['Number'] : '' }}"></td>
                                                <td><input type="date" name="dfc_grid[{{ $loop->index }}][Date]" value="{{ isset($item['Date']) ? $item['Date'] : '' }}"></td>
                                                <td><input type="date" name="dfc_grid[{{ $loop->index }}][SentDate]" value="{{ isset($item['SentDate']) ? $item['SentDate'] : '' }}"></td>
                                                <td><input type="date" name="dfc_grid[{{ $loop->index }}][ReturnedDate]" value="{{ isset($item['ReturnedDate']) ? $item['ReturnedDate'] : '' }}"></td>
                                                <td><input type="text" name="dfc_grid[{{ $loop->index }}][DataCollectionMethod]" value="{{ isset($item['DataCollectionMethod']) ? $item['DataCollectionMethod'] : '' }}"></td>
                                                <td><input type="text" name="dfc_grid[{{ $loop->index }}][Comment]" value="{{ isset($item['Comment']) ? $item['Comment'] : '' }}"></td>
                                                <td><input type="text" name="dfc_grid[{{ $loop->index }}][Remarks]" value="{{ isset($item['Remarks']) ? $item['Remarks'] : '' }}"></td>
                                                <td><button readonly type="text" class="removeRowBtn">Remove</button></td>
                                                {{--<td><input readonly type="text"></td>--}}
                                            </tr>
                                           @endforeach
                                         @endif
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Minor Protocol Voilation
                                    <button type="button" name="minor_protocol_voilation" id="ObservationAdd">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="minor-protocol-voilation">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Item Description</th>
                                                <th style="width: 16%"> Date</th>
                                                <th style="width: 15%">Sent Date</th>
                                                <th style="width: 15%">Returned Date</th>
                                                <th style="width: 15%">Comment</th>
                                                <th style="width: 15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @php
                                            $data = isset($grid_DataM) && $grid_DataM->data ? json_decode($grid_DataM->data, true) : null;
                                         @endphp

                                          @if ($data && is_array($data))
                                             @foreach ($data as $index => $item)
                                                <tr>
                                                    <td><input disabled type="text" name="[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}" value="1"></td>
                                                    <td><input type="text" name="minor_protocol_voilation[{{ $loop->index }}][ItemDescription]" value="{{ isset($item['ItemDescription']) ? $item['ItemDescription'] : '' }}"></td>
                                                    <td><input type="date" name="minor_protocol_voilation[{{ $loop->index }}][Date]" value="{{ isset($item['Date']) ? $item['Date'] : '' }}"></td>
                                                    <td><input type="date" name="minor_protocol_voilation[{{ $loop->index }}][SentDate]" value="{{ isset($item['SentDate']) ? $item['SentDate'] : '' }}"></td>
                                                    <td><input type="date" name="minor_protocol_voilation[{{ $loop->index }}][ReturnedDate]" value="{{ isset($item['ReturnedDate']) ? $item['ReturnedDate'] : '' }}"></td>
                                                    <td><input type="text" name="minor_protocol_voilation[{{ $loop->index }}][Comment]" value="{{ isset($item['Comment']) ? $item['Comment'] : '' }}"></td>
                                                    <td><button readonly type="text" class="removeRowBtn">Remove</button></td>
                                                    {{--<td><input readonly type="text"></td>--}}
                                                </tr>
                                              @endforeach
                                             @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <Label>Comments</Label>
                                    <textarea name="comments_ti">{{ $item_data->comments_ti }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <Label>Summary </Label>
                                    <textarea name="summary_ti">{{ $item_data->summary_ti }}</textarea>
                                </div>
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


                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Submit Trial Action Item</div>
                            <div class="col-4">
                                <div class="group-input">
                                    <label for="Victim"><b>Submitted By :</b></label>
                                    <div class="">{{ $item_data->submit_by }}</div>

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="group-input">

                                    <label for="Division Code"><b>Submitted On : </b></label>
                                    <div class="date">{{ $item_data->submit_on }}</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="group-input">

                                    <label for="Division Code"><b>Submitted Comments : </b></label>
                                    <div class="date">{{ $item_data->submit_comment }}</div>
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
                                    <div class="">{{ $item_data->cancel_by }}</div>

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="group-input">

                                    <label for="Division Code"><b>Cancelled On : </b></label>
                                    <div class="date">{{ $item_data->cancel_on }}</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="group-input">

                                    <label for="Division Code"><b>Cancelled Comments : </b></label>
                                    <div class="date">{{ $item_data->cancel_comment }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Close</div>
                            <div class="col-4">
                                <div class="group-input">
                                    <label for="Victim"><b>Closed By :</b></label>
                                    <div class="">{{ $item_data->close_by }}</div>

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="group-input">

                                    <label for="Division Code"><b>Closed On : </b></label>
                                    <div class="date">{{ $item_data->close_on }}</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="group-input">

                                    <label for="Division Code"><b>Closed Comments : </b></label>
                                    <div class="date">{{ $item_data->close_comment }}</div>
                                </div>
                            </div>
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
    $(document).ready(function() {
        $('#DCFadd').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="dfc_grid[' + serialNumber + '][Number]"></td>' +
                    '<td><input type="date" name="dfc_grid[' + serialNumber + '][Date]"></td>' +
                    '<td><input type="date" name="dfc_grid[' + serialNumber + '][SentDate]"></td>' +
                    '<td><input type="date" name="dfc_grid[' + serialNumber + '][ReturnedDate]"></td>' +
                    '<td><input type="text" name="dfc_grid[' + serialNumber + '][DataCollectionMethod]"></td>' +
                    '<td><input type="text" name="dfc_grid[' + serialNumber + '][Comment]"></td>' +
                    '<td><input type="text" name="dfc_grid[' + serialNumber + '][Remarks]"></td>' +
                    '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +
                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                '</tr>';

                return html;
            }


            var tableBody = $('#DCF tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#ObservationAdd').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="minor_protocol_voilation[' + serialNumber + '][ItemDescription]"></td>' +
                    '<td><input type="date" name="minor_protocol_voilation[' + serialNumber + '][Date]"></td>' +
                    '<td><input type="date" name="minor_protocol_voilation[' + serialNumber + '][SentDate]"></td>' +
                    '<td><input type="date" name="minor_protocol_voilation[' + serialNumber + '][ReturnedDate]"></td>' +
                    '<td><input type="text" name="minor_protocol_voilation[' + serialNumber + '][Comment]"></td>' +
                    '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +

                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                '</tr>';

                return html;
            }

            var tableBody = $('#minor-protocol-voilation tbody');
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
