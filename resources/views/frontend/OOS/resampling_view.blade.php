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

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / Resampling
        </div>
    </div>

    @php
        $users = DB::table('users')->get();
    @endphp
    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}
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
                            <button class="button_theme1"> <a class="text-white" href="{{ url('resamplingAuditTrail', $data->id) }}">
                                    Audit Trail </a> </button>            
                                    
    
                        @if ($data->stage == 1)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancellation Request
                            </button>
                        @elseif($data->stage == 2)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Sample Request Approval Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Info from Open
                            </button> 
                        @elseif($data->stage == 3)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Sample Received
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                More Info from Sample Request Approval
                            </button>      
                        @endif   
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>
                    </div>
    
                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars" style="font-size: 15px;">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif
    
                            @if ($data->stage >= 2)
                                <div class="active">Under Sample Request Approval</div>
                            @else
                                <div class="">Under Sample Request Approval</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">Pending Sample Receive</div>
                            @else
                                <div class="">Pending Sample Receive</div>
                            @endif
    
                            @if ($data->stage >= 4)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
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
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Under Sample Request Approval </button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Pending Sample Received</button>
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Closure</button> --}}
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Activity Log</button>
            </div>

            <form action="{{ route('resampling_update',$data->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div id="step-form">
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}/Resampling/{{ Helpers::year($data->created_at) }}/{{ $data->record }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input readonly type="text" name="division_code" />
                                            {{-- value="{{ Helpers::getDivisionName(session()->get('division')) }}" --}}
                                        {{-- <input type="hidden" name="division_id" value="{{ session()->get('division') }}"> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        {{-- <div class="static">{{ Auth::user()->name }}</div> --}}
                                        {{-- <input disabled type="text" value="{{ Auth::user()->name }}"> --}}
                                    <input readonly type="text" name="initiator_id" value="{{ Auth::user()->name }}" />

                                        {{-- <input disabled type="text" value=""> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date" >
                                        {{-- <div class="static">{{ date('d-M-Y') }}</div> --}}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="assign_to" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                            <option value="">Select a value</option>
                                            @foreach ($users as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    @if ($data->assign_to == $value->id) selected @endif>
                                                    {{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Due Date"> Due Date </label>
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                            value="{{ \Carbon\Carbon::parse($due_date)->format('d-M-Y') }}" />
                                        <input type="hidden" name="due_date" id="due_date_input"
                                            value="{{ $due_date }}" />

                                    </div>
    
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group"><b>Initiator Group</b></label>
                                        <select name="initiator_Group" id="initiator_group" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                            <option value="">-- Select --</option>
                                            <option value="CQA"  @if ($data->initiator_Group == 'CQA') selected @endif>
                                                Corporate Quality Assurance</option>
                                            <option value="QAB" @if ($data->initiator_Group == 'QAB') selected @endif>Quality
                                                Assurance Biopharma</option>
                                            <option value="CQC" @if ($data->initiator_Group == 'CQA') selected @endif>Central
                                                Quality Control</option>
                                            <option value="CQC" @if ($data->initiator_Group == 'MANU') selected @endif>
                                                Manufacturing</option>
                                            <option value="PSG" @if ($data->initiator_Group == 'PSG') selected @endif>Plasma
                                                Sourcing Group</option>
                                            <option value="CS" @if ($data->initiator_Group == 'CS') selected @endif>Central
                                                Stores</option>
                                            <option value="ITG" @if ($data->initiator_Group == 'ITG') selected @endif>
                                                Information Technology Group</option>
                                            <option value="MM" @if ($data->initiator_Group == 'MM') selected @endif>
                                                Molecular Medicine</option>
                                            <option value="CL" @if ($data->initiator_Group == 'CL') selected @endif>Central
                                                Laboratory</option>

                                            <option value="TT" @if ($data->initiator_Group == 'TT') selected @endif>Tech
                                                team</option>
                                            <option value="QA" @if ($data->initiator_Group == 'QA') selected @endif>
                                                Quality Assurance</option>
                                            <option value="QM" @if ($data->initiator_Group == 'QM') selected @endif>
                                                Quality Management</option>
                                            <option value="IA" @if ($data->initiator_Group == 'IA') selected @endif>IT
                                                Administration</option>
                                            <option value="ACC" @if ($data->initiator_Group == 'ACC') selected @endif>
                                                Accounting</option>
                                            <option value="LOG" @if ($data->initiator_Group == 'LOG') selected @endif>
                                                Logistics</option>
                                            <option value="SM" @if ($data->initiator_Group == 'SM') selected @endif>
                                                Senior Management</option>
                                            <option value="BA" @if ($data->initiator_Group == 'BA') selected @endif>
                                                Business Administration</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group Code"><b>Initiator Group Code</b></label>
                                        <input type="text" name="initiator_group_code" id="initiator_group_code"
                                            value="{{$data->initiator_Group}}" disabled>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                    <textarea name="short_description"   id="docname" type="text"    maxlength="255" required {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>{{ $data->short_description }}</textarea>
                                    {{-- <textarea name="short_description"   id="docname" type="text"    maxlength="255" required  {{ $data->stage == 0 || $data->stage == 6 ? "disabled" : "" }}>{{ $resampling->short_description }}</textarea> --}}

                                        {{-- <input id="docname" type="text" name="short_description" maxlength="255" required value="{{ $resampling->short_description }}"> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="cq_Approver"><b>CQ Approver</b></label>
                                        <input type="text" name="cq_Approver" value="{{$data->cq_Approver}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Supervisor"><b>Supervisor</b></label>
                                        <input type="text" name="supervisor"   value="{{$data->cq_Approver}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="api_Material_Product_Name"><b>API/Material/Drug Product Name</b></label>
                                        <input  type="text" name="api_Material_Product_Name"  value="{{$data->api_Material_Product_Name}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                    </div>
                                </div> <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="lot_Batch_Number"><b>Lot/Batch Number</b></label>
                                        <input type="text" name="lot_Batch_Number"  value="{{$data->lot_Batch_Number}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                    </div>
                                 </div>
                                  <div class="col-lg-6">
                                <div class="group-input">
                                    <label for=" AR Number"><b>AR Number</b></label>
                                    <input type="text" name="ar_Number_GI"  value="{{$data->ar_Number_GI}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Test Name"><b>Test Name</b></label>
                                    <input type="text" name="test_Name_GI"  value="{{$data->test_Name_GI}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="justification_for_resampling">Justification For Resampling</label>
                                    <textarea name="justification_for_resampling_GI" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>{{$data->justification_for_resampling_GI}}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Predetermined Sampling Strategies</label>
                                    <textarea name="predetermined_Sampling_Strategies_GI" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>{{$data->predetermined_Sampling_Strategies_GI}}</textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="supporting_attach">Supporting Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="supporting_attach">
                                        @if ($data->supporting_attach)
                                        @foreach(json_decode($data->supporting_attach) as $file)
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
                                            <input type="file" id="myfile" name="supporting_attach[]"
                                                oninput="addMultipleFiles(this, 'supporting_attach')" multiple {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">
                                Hidden Field
                               </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled end date">Parent-TCD(hid)</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="end_date" readonly placeholder="DD-MM-YYYY"  value="{{$data->parent_tcd_hid}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}/>
                                        <input type="date" id="end_date_checkdate" name="parent_tcd_hid" value="{{$data->parent_tcd_hid}}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                            oninput="handleDateInput(this, 'end_date');checkDate('start_date_checkdate','end_date_checkdate')" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}/>
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">
                                Parent Record Information
                               </div>
                               <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) OOS No.</b></label>
                                    <input type="text" name="parent_oos_no" value="{{$data->parent_oos_no}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) OOT No.</b></label>
                                    <input type="text" name="parent_oot_no"   value="{{$data->parent_oot_no}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) Lab Incident No.</b></label>
                                    <input type="text" name="parent_lab_incident_no"  value="{{$data->parent_lab_incident_no}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">(Parent)Date Opened</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date" readonly placeholder="DD-MM-YYYY" value="{{$data->parent_date_opened}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}/>
                                        <input type="date" id="start_date_checkdate"  name="parent_date_opened" value="{{$data->parent_date_opened}}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                            oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">(Parent)Short Description<span
                                            class="text-danger"></span></label><span id="rchars"></span>
                                    <input id="docname" type="text" name="parent_short_description" maxlength="255"  value="{{$data->parent_short_description}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) Product/Material Name</b></label>
                                    <input type="text" name="parent_product_material_name"  value="{{$data->parent_product_material_name}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">(Parent)Target Closure Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="end_date1" readonly placeholder="DD-MM-YYYY"  value="{{$data->parent_target_closure_date}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}/>
                                        <input type="date" id="end_date_checkdate"  name="parent_target_closure_date" value="{{$data->parent_target_closure_date}}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                            oninput="handleDateInput(this, 'end_date1');checkDate('end_date_checkdate','end_date_checkdate')" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}/>
                                    </div>
                                </div>
                            </div>


{{--
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
                                </div> --}}
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Priority Level">Priority Level</label>
                                        <select name="priority_level">
                                            <option value="">Select Priority Level</option>
                                            <option value="High">High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>
                                    </div>
                                </div> --}}

{{--
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Scheduled Start Date">Scheduled Start Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="start_date_checkdate"  name="start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')"/>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Scheduled end date">Scheduled End Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="end_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="end_date_checkdate" name="end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'end_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="agenda">
                                            Product/Material Information<button type="button" name="product_material_information" id="product_material" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>+</button>
                                        </label>
                                        <table class="table table-bordered" id="product_material_body">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>Product/Material Code</th>
                                                    <th>Batch No.</th>
                                                    <th>AR Number</th>
                                                    <th>Test Name</th>
                                                    <th>Instrument Name</th>
                                                    <th>Instrument No.</th>
                                                    <th>Instru. Caliberation Due Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($gridDatas01) && is_array($gridDatas01->data))
                                                    @foreach ($gridDatas01->data as $gridDatas01) 
                                                        <tr>
                                                            <td><input disabled type="text" name="product_material_information[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="product_material_information[{{ $loop->index }}][product_material]" value="{{ isset($gridDatas01['product_material']) ? $gridDatas01['product_material'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="product_material_information[{{ $loop->index }}][batch_no]" value="{{ isset($gridDatas01['batch_no']) ? $gridDatas01['batch_no'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="product_material_information[{{ $loop->index }}][ar_no]" value="{{ isset($gridDatas01['ar_no']) ? $gridDatas01['ar_no'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="product_material_information[{{ $loop->index }}][test_name]" value="{{ isset($gridDatas01['test_name']) ? $gridDatas01['test_name'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="product_material_information[{{ $loop->index }}][instrument_name]" value="{{ isset($gridDatas01['instrument_name']) ? $gridDatas01['instrument_name'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="product_material_information[{{ $loop->index }}][instrument_no]" value="{{ isset($gridDatas01['instrument_no']) ? $gridDatas01['instrument_no'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td>
                                                                <div class="new-date-data-field">
                                                                    <div class="new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input
                                                                                    class="click_date"
                                                                                    id="date_{{ $loop->index }}_date"
                                                                                    type="text"
                                                                                    name="product_material_information[{{ $loop->index }}][info_date]"
                                                                                    placeholder="DD-MM-YYYY"
                                                                                    {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}
                                                                                    value="{{ isset($gridDatas01['info_date']) ? $gridDatas01['info_date'] : '' }}"
                                                                                />
                                                                                <input
                                                                                    type="date"
                                                                                    name="product_material_information[{{ $loop->index }}][info_date]"
                                                                                    value="{{ isset($gridDatas01['info_date']) ? $gridDatas01['info_date'] : '' }}"
                                                                                    id="date_{{ $loop->index }}_date_picker"
                                                                                    class="hide-input show_date"
                                                                                    {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}
                                                                                    style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                                    onchange="handleDateInput(this, 'date_{{ $loop->index }}_date')"
                                                                                />
                                                                           </div>
                                                                        </div>
                                                            </td>
                                                            <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                            
                                        $('#product_material').click(function(e) {
                                        function generateTableRow(serialNumber) {
                                            var data = @json($gridDatas01);
                                            var html = '';
                                            html +=
                                                '<tr>' +
                                                '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                                                // '<td><input type="date" name="date[]"></td>' +
                                                '<td><input type="text" name="product_material_information[' + serialNumber + '][product_material]"></td>' +
                                                '<td><input type="text" name="product_material_information[' + serialNumber + '][batch_no]"></td>' +
                                                '<td><input type="text" name="product_material_information[' + serialNumber + '][ar_no]"></td>' +
                                                '<td><input type="text" name="product_material_information[' + serialNumber + '][test_name]"></td>' +
                                                '<td><input type="text" name="product_material_information[' + serialNumber + '][instrument_name]"></td>' +
                                                '<td><input type="text" name="product_material_information[' + serialNumber + '][instrument_no]"></td>'+
                                                '<td> <div class="new-date-data-field"><div class="group-input input-date"> <div class="calenderauditee"><input id="date_'+ serialNumber +'_date" type="text" name="financial_transection[' + serialNumber + '][info_date]" placeholder="DD-MM-YYYY" /> <input type="date" name="financial_transection[' + indexDetail + '][info_date]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" id="date_'+ indexDetail +'_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ indexDetail +'_date\')" /> </div> </div></div></td>' +
                                                '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                '</tr>';
                                                
                                            return html;
                                        }
                                        var tableBody = $('#product_material_body tbody');
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

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="agenda">
                                          Info. On Product/Material<button type="button" name="info_on_product_mat" id="info_on_product" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>+</button>
                                        </label>
                                        <table class="table table-bordered" id="info_on_product_body">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>Item/Product Code</th>
                                                    <th>Lot/Batch Number</th>
                                                    <th>A.R. Number</th>
                                                    <th>Mfg. Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Label Claim </th>
                                                    <th>Pack Size </th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($gridDatas02) && is_array($gridDatas02->data))
                                                    @foreach ($gridDatas02->data as $gridDatas02) 
                                                            <tr>
                                                                <td><input disabled type="text" name="info_on_product_mat[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                                <td><input type="text" name="info_on_product_mat[{{ $loop->index }}][item_product_code]" value="{{ isset($gridDatas02['item_product_code']) ? $gridDatas02['item_product_code'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                                <td><input type="text" name="info_on_product_mat[{{ $loop->index }}][lot_batch_no]" value="{{ isset($gridDatas02['lot_batch_no']) ? $gridDatas02['lot_batch_no'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                                <td><input type="text" name="info_on_product_mat[{{ $loop->index }}][ar_no]" value="{{ isset($gridDatas02['ar_no']) ? $gridDatas02['ar_no'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                                <td>
                                                                    <div class="new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input
                                                                                    class="click_date"
                                                                                    id="date_{{ $loop->index }}_mfg_date"
                                                                                    type="text"
                                                                                    name="info_on_product_mat[{{ $loop->index }}][info_mfg_date]"
                                                                                    placeholder="DD-MM-YYYY"
                                                                                    {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}
                                                                                    value="{{ isset($gridDatas02['info_mfg_date']) ? $gridDatas02['info_mfg_date'] : '' }}"
                                                                                />
                                                                                <input
                                                                                    type="date"
                                                                                    name="info_on_product_mat[{{ $loop->index }}][info_mfg_date]"
                                                                                    value="{{ isset($gridDatas02['info_mfg_date']) ? $gridDatas02['info_mfg_date'] : '' }}"
                                                                                    id="date_{{ $loop->index }}_mfg_date_picker"
                                                                                    class="hide-input show_date"
                                                                                    {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}
                                                                                    style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                                    onchange="handleDateInput(this, 'date_{{ $loop->index }}_mfg_date')"
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
                                                                                    id="date_{{ $loop->index }}_expiry_date"
                                                                                    type="text"
                                                                                    name="info_on_product_mat[{{ $loop->index }}][info_expiry_date]"
                                                                                    placeholder="DD-MM-YYYY"
                                                                                    {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}
                                                                                    value="{{ isset($gridDatas02['info_expiry_date']) ? $gridDatas02['info_expiry_date'] : '' }}"
                                                                                />
                                                                                <input
                                                                                    type="date"
                                                                                    name="info_on_product_mat[{{ $loop->index }}][info_expiry_date]"
                                                                                    value="{{ isset($gridDatas02['info_expiry_date']) ? $gridDatas02['info_expiry_date'] : '' }}"
                                                                                    id="date_{{ $loop->index }}_expiry_date_picker"
                                                                                    class="hide-input show_date"
                                                                                    {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}
                                                                                    style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                                    onchange="handleDateInput(this, 'date_{{ $loop->index }}_expiry_date')"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="text" name="info_on_product_mat[{{ $loop->index }}][label_claim]" value="{{ isset($gridDatas02['label_claim']) ? $gridDatas02['label_claim'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                                <td><input type="text" name="info_on_product_mat[{{ $loop->index }}][pack_size]" value="{{ isset($gridDatas02['pack_size']) ? $gridDatas02['pack_size'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                                <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                            </tr>
                                                    @endforeach
                                                @endif    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $('#info_on_product').click(function(e) {
                                            function generateTableRow(serialNumber) {
                                                var data = @json($gridDatas02);
                                                var html = '';
                                                html +=
                                                    '<tr>' +
                                                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                                                    // '<td><input type="date" name="date[]"></td>' +
                                                    '<td><input type="text" name="info_on_product_mat[' + serialNumber + '][item_product_code]"></td>' +
                                                    '<td><input type="text" name="info_on_product_mat[' + serialNumber + '][lot_batch_no]"></td>' +
                                                    '<td><input type="text" name="info_on_product_mat[' + serialNumber + '][ar_no]"></td>' +
                                                    '<td> <div class="new-date-data-field"><div class="group-input input-date"> <div class="calenderauditee"><input id="date_'+ serialNumber +'_mfg_date" type="text" name="serial_number_gi[' + serialNumber + '][info_mfg_date]" placeholder="DD-MM-YYYY" /> <input type="date" name="serial_number_gi[' + serialNumber + '][info_mfg_date]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" id="date_'+ serialNumber +'_mfg_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ serialNumber +'_mfg_date\')" /> </div> </div></div></td>' +
                                                '<td>  <div class="new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input id="date_'+ serialNumber +'_expiry_date" type="text" name="serial_number_gi[' + serialNumber + '][info_expiry_date]" placeholder="DD-MM-YYYY" /> <input type="date" name="serial_number_gi[' + serialNumber + '][info_expiry_date]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" id="date_'+ serialNumber +'_expiry_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ serialNumber +'_expiry_date\')" /> </div> </div></div></td>' +
                                                    '<td><input type="text" name="info_on_product_mat[' + serialNumber + '][label_claim]"></td>'+
                                                    '<td><input type="text" name="info_on_product_mat[' + serialNumber + '][pack_size]"></td>'+
                                                    '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                    '</tr>';
                                                return html;
                                            }
                                            var tableBody = $('#info_on_product_body tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                    });
                                </script>

                                {{-- 3 --}}

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="agenda">
                                          OOS Details<button type="button" name="oos_details" id="oos_details" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>+</button>
                                        </label>
                                        <table class="table table-bordered" id="oos_details_body">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>AR Number</th>
                                                    <th>Test Name of OOS</th>
                                                    <th>Results obtained</th>
                                                    <th>Specification Limit</th>
                                                    <th>Action</th>
                                                    {{-- <th>Instru. Caliberation Due Date</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($gridDatas03) && is_array($gridDatas03->data))
                                                    @foreach ($gridDatas03->data as $gridDatas03) 
                                                        <tr>
                                                            <td><input disabled type="text" name="oos_details[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="oos_details[{{ $loop->index }}][ar_no]" value="{{ isset($gridDatas03['ar_no']) ? $gridDatas03['ar_no'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="oos_details[{{ $loop->index }}][test_name_of_OOS]" value="{{ isset($gridDatas03['test_name_of_OOS']) ? $gridDatas03['test_name_of_OOS'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="oos_details[{{ $loop->index }}][results_obtained]" value="{{ isset($gridDatas03['results_obtained']) ? $gridDatas03['results_obtained'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="oos_details[{{ $loop->index }}][specification_limit]" value="{{ isset($gridDatas03['specification_limit']) ? $gridDatas03['specification_limit'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $('#oos_details').click(function(e) {
                                            function generateTableRow(serialNumber) {
                                                var data = @json($gridDatas03);
                                                var html = '';
                                                html +=
                                                    '<tr>' +
                                                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                                                    // '<td><input type="date" name="date[]"></td>' +
                                                    '<td><input type="text" name="oos_details[' + serialNumber + '][ar_no]"></td>' +
                                                    '<td><input type="text" name="oos_details[' + serialNumber + '][test_name_of_OOS]"></td>' +
                                                    '<td><input type="text" name="oos_details[' + serialNumber + '][results_obtained]"></td>' +
                                                    '<td><input type="text" name="oos_details[' + serialNumber + '][specification_limit]"></td>'+
                                                    '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                    '</tr>';
                                                return html;
                                            }
                                            var tableBody = $('#oos_details_body tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                    });
                                </script> 

                                {{-- 4 --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="agenda">
                                          OOT Results<button type="button" name="oot_detail" id="oot_detail" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>+</button>
                                        </label>
                                        <table class="table table-bordered" id="oot_detail_body">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>AR Number</th>
                                                    <th>Test Name of OOT</th>
                                                    <th>Results Obtained</th>
                                                    <th>Initial Interval Details</th>
                                                    <th>Previous Interval Details</th>
                                                    <th>%Difference of Results</th>
                                                    <th>Initial Interview Details</th>
                                                    <th>Trend Limit</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($gridDatas04) && is_array($gridDatas04->data))
                                                    @foreach ($gridDatas04->data as $gridDatas04)
                                                        <tr>
                                                            <td><input disabled type="text" name="oot_detail[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="oot_detail[{{ $loop->index }}][ar_no_oot]" value="{{ isset($gridDatas04['ar_no_oot']) ? $gridDatas04['ar_no_oot'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="oot_detail[{{ $loop->index }}][test_name_oot]" value="{{ isset($gridDatas04['test_name_oot']) ? $gridDatas04['test_name_oot'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="oot_detail[{{ $loop->index }}][results_obtained_oot]" value="{{ isset($gridDatas04['results_obtained_oot']) ? $gridDatas04['results_obtained_oot'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="oot_detail[{{ $loop->index }}][initial_Interval_Details_oot]" value="{{ isset($gridDatas04['initial_Interval_Details_oot']) ? $gridDatas04['initial_Interval_Details_oot'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="oot_detail[{{ $loop->index }}][previous_Interval_Details_oot]" value="{{ isset($gridDatas04['previous_Interval_Details_oot']) ? $gridDatas04['previous_Interval_Details_oot'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="oot_detail[{{ $loop->index }}][difference_of_Results_oot]" value="{{ isset($gridDatas04['difference_of_Results_oot']) ? $gridDatas04['difference_of_Results_oot'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="oot_detail[{{ $loop->index }}][initial_interview_Details_oot]" value="{{ isset($gridDatas04['initial_interview_Details_oot']) ? $gridDatas04['initial_interview_Details_oot'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="oot_detail[{{ $loop->index }}][trend_Limit_oot]" value="{{ isset($gridDatas04['trend_Limit_oot']) ? $gridDatas04['trend_Limit_oot'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $('#oot_detail').click(function(e) {
                                            function generateTableRow(serialNumber) {
                                                var data = @json($gridDatas04);
                                                var html = '';
                                                html +=
                                                    '<tr>' +
                                                    '<td><input disabled type="text" name="oot_detail[serial]" value="' + serialNumber + '"></td>' +
                                                    '<td><input type="text" name="oot_detail[' + serialNumber + '][ar_no_oot]"></td>' +
                                                    '<td><input type="text" name="oot_detail[' + serialNumber + '][test_name_oot]"></td>' +
                                                    '<td><input type="text" name="oot_detail[' + serialNumber + '][results_obtained_oot]"></td>' +
                                                    '<td><input type="text" name="oot_detail[' + serialNumber + '][initial_Interval_Details_oot]"></td>'+
                                                    '<td><input type="text" name="oot_detail[' + serialNumber + '][previous_Interval_Details_oot]"></td>'+
                                                    '<td><input type="text" name="oot_detail[' + serialNumber + '][difference_of_Results_oot]"></td>'+
                                                    '<td><input type="text" name="oot_detail[' + serialNumber + '][initial_interview_Details_oot]"></td>'+
                                                    '<td><input type="text" name="oot_detail[' + serialNumber + '][trend_Limit_oot]"></td>'+
                                                    '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                    '</tr>';
                                                return html;
                                            }
                                            var tableBody = $('#oot_detail_body tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                    });
                                </script>

                                {{-- 5 --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="agenda">
                                          Details of Stability Study<button type="button" name="stability_study[]" id="stability_study" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>+</button>
                                        </label>
                                        <table class="table table-bordered" id="stability_study_body">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>AR Number</th>
                                                    <th>Condition: Temperature & RH</th>
                                                    <th>Interval</th>
                                                    <th>Orientation</th>
                                                    <th>Pack Details(if any)</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($gridDatas05) && is_array($gridDatas05->data))
                                                    @foreach ($gridDatas05->data as $gridDatas05)
                                                        <tr>
                                                            <td><input disabled type="text" name="stability_study[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="stability_study[{{ $loop->index }}][ar_no_stability_stdy]" value="{{ isset($gridDatas05['ar_no_stability_stdy']) ? $gridDatas05['ar_no_stability_stdy'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="stability_study[{{ $loop->index }}][condition_temp_stability_stdy]" value="{{ isset($gridDatas05['condition_temp_stability_stdy']) ? $gridDatas05['condition_temp_stability_stdy'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="stability_study[{{ $loop->index }}][interval_stability_stdy]" value="{{ isset($gridDatas05['interval_stability_stdy']) ? $gridDatas05['interval_stability_stdy'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="stability_study[{{ $loop->index }}][orientation_stability_stdy]" value="{{ isset($gridDatas05['orientation_stability_stdy']) ? $gridDatas05['orientation_stability_stdy'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="stability_study[{{ $loop->index }}][pack_details_if_any_stability_stdy]" value="{{ isset($gridDatas05['pack_details_if_any_stability_stdy']) ? $gridDatas05['pack_details_if_any_stability_stdy'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $('#stability_study').click(function(e) {
                                            function generateTableRow(serialNumber) {
                                                var data = @json($gridDatas05);
                                                var html = '';
                                                html +=
                                                    '<tr>' +
                                                    '<td><input disabled type="text" name="stability_study[serial]" value="' + serialNumber + '"></td>' +
                                                    '<td><input type="text" name="stability_study[' + serialNumber + '][ar_no_stability_stdy]"></td>' +
                                                    '<td><input type="text" name="stability_study[' + serialNumber + '][condition_temp_stability_stdy]"></td>' +
                                                    '<td><input type="text" name="stability_study[' + serialNumber + '][interval_stability_stdy]"></td>' +
                                                    '<td><input type="text" name="stability_study[' + serialNumber + '][orientation_stability_stdy]"></td>'+
                                                    '<td><input type="text" name="stability_study[' + serialNumber + '][pack_details_if_any_stability_stdy]"></td>'+
                                                    '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                    '</tr>';
                                                return html;
                                            }
                                            var tableBody = $('#stability_study_body tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                    });
                                </script>


                                {{-- 5 --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="agenda">
                                          Details of Stability Study.<button type="button" name="stability_study2" id="stability_study2" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>+</button>
                                        </label>
                                        <table class="table table-bordered" id="stability_study2_body">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>AR Number</th>
                                                    <th>Stability Condition</th>
                                                    <th>Stability Interval</th>
                                                    <th>Pack Details(if any)</th>
                                                    <th>Orientation</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($gridDatas06) && is_array($gridDatas06->data))
                                                    @foreach ($gridDatas06->data as $gridDatas06)  
                                                        <tr>
                                                            <td><input disabled type="text" name="stability_study2[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="stability_study2[{{ $loop->index }}][ar_no_stability_stdy2]" value="{{ isset($gridDatas06['ar_no_stability_stdy2']) ? $gridDatas06['ar_no_stability_stdy2'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="stability_study2[{{ $loop->index }}][stability_condition_stability_stdy2]" value="{{ isset($gridDatas06['stability_condition_stability_stdy2']) ? $gridDatas06['stability_condition_stability_stdy2'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="stability_study2[{{ $loop->index }}][stability_interval_stability_stdy2]" value="{{ isset($gridDatas06['stability_interval_stability_stdy2']) ? $gridDatas06['stability_interval_stability_stdy2'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="stability_study2[{{ $loop->index }}][pack_details_if_any_stability_stdy2]" value="{{ isset($gridDatas06['pack_details_if_any_stability_stdy2']) ? $gridDatas06['pack_details_if_any_stability_stdy2'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><input type="text" name="stability_study2[{{ $loop->index }}][orientation_stability_stdy2]" value="{{ isset($gridDatas06['orientation_stability_stdy2']) ? $gridDatas06['orientation_stability_stdy2'] : '' }}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}></td>
                                                            <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $('#stability_study2').click(function(e) {
                                            function generateTableRow(serialNumber) {
                                                vvar data = @json($gridDatas06);
                                                var html = '';
                                                html +=
                                                    '<tr>' +
                                                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                                                    '<td><input type="text" name="stability_study2[' + serialNumber + '][ar_no_stability_stdy2]"></td>' +
                                                    '<td><input type="text" name="stability_study2[' + serialNumber + '][stability_condition_stability_stdy2]"></td>' +
                                                    '<td><input type="text" name="stability_study2[' + serialNumber + '][stability_interval_stability_stdy2]"></td>' +
                                                    '<td><input type="text" name="stability_study2[' + serialNumber + '][pack_details_if_any_stability_stdy2]"></td>'+
                                                    '<td><input type="text" name="stability_study2[' + serialNumber + '][orientation_stability_stdy2]"></td>'+
                                                    '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                    '</tr>';
                                                return html;
                                            }
                                            var tableBody = $('#stability_study2_body tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                    });
                                </script>


                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Description</label>
                                        <textarea name="description"></textarea>
                                    </div>
                                </div> --}}

                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">

                            <div class="group-input">
                                <label for="Operations">
                                    Sample Request Approval Comments
                                    <span class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#management-review-operations-instruction-modal"
                                        style="font-size: 0.8rem; font-weight: 400; cursor:pointer;">
                                    </span>
                                </label>
                                <textarea name="sample_Request_Approval_Comments" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>{{$data->sample_Request_Approval_Comments}}</textarea>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Inv Attachments">Sample Request Approval Attachment</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="inv_attachment">
                                            @if ($data->sample_Request_Approval_attachment)
                                            @foreach(json_decode($data->sample_Request_Approval_attachment) as $file)
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
                                            <input type="file" id="myfile" name="sample_Request_Approval_attachment[]"
                                                oninput="addMultipleFiles(this, 'inv_attachment')" multiple {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

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

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="audit type">Sample Received </label>
                                    <select  name="sample_Received" id="audit_type"  value="" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                        <option value=""  >Enter Your Selection Here</option>
                                        <option @if ($data->sample_Received == 'Facility') selected @endif
                                            value="Facility">Facility</option>
                                            {{-- <option @if ($data->audit_type == 'Equipment/Instrument') selected @endif
                                                value="Equipment/Instrument">Equipment/Instrument</option> --}}
                                                        <option @if ($data->sample_Received == 'Data integrity') selected @endif
                                                            value="Data integrity">Data integrity</option>
                                                            {{-- <option @if ($data->audit_type == 'Anyother(specify)') selected @endif
                                                                value="Anyother(specify)">Anyother(specify)</option> --}}
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Sample Quantity</b></label>
                                    <input type="text" name="sample_Quantity" value="{{$data->sample_Quantity}}" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                </div>
                            </div>


                            <div class="group-input">
                                <label for="customer_satisfaction_level">Sample Received Comments</label>
                                <textarea name="sample_Received_Comments" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>{{$data->sample_Received_Comments}}</textarea>
                            </div>
                            <div class="group-input">
                                <label for="budget_estimates">Delay Justification</label>
                                <textarea name="delay_Justification" {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>{{$data->delay_Justification}}</textarea>
                            </div>

                            <div class="group-input">
                                <label for="file_attchment_if_any">File Attachment, if any</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="file_attchment_if_any">

                                        @if ($data->file_attchment_pending_sample)
                                        @foreach(json_decode($data->file_attchment_pending_sample) as $file)
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
                                        <input type="file" id="myfile"
                                            name="file_attchment_pending_sample[]"{{-- ignore --}}
                                            oninput="addMultipleFiles(this, 'file_attchment_if_any')" multiple {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>



                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">General Information</div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed By">Submit By : </label>
                                        <div class="static">{{ $data->submitted_by }}</div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">Submit On :</label>
                                        <div class="static">{{ $data->submitted_on }}</div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="group-input">
                                        <label for="Completed On">Submit Comment :</label>
                                        <div class="static">{{ $data->submitted_comment }}</div>
                                    </div>
                                </div>
                                <div class="sub-head">Under Sample Request Approval</div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="HOD Review Complete By">Sample Req. Approval Done By :</label>
                                        <div class="static">{{ $data->approval_done_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="HOD Review Complete By">Sample Req. Approval Done On :</label>
                                        <div class="static">{{ $data->approval_done_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="group-input">
                                        <label for="HOD Review Complete By">Sample Req. Approval Done Comment :</label>
                                        <div class="static">{{ $data->approval_done_comment }}</div>
                                    </div>
                                </div>

                                <div class="sub-head">Pending Sample Received</div>
                                    <div class="col-lg-4">
                                        <div class="group-input">
                                            <label for="Completed On">Sample Received Completed By :</label>
                                            <div class="static">{{ $data->sample_received_by }}</div>
                                        </div>
                                    </div> 
                                    <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Completed On">Sample Received Completed On :</label>
                                                <div class="static">{{ $data->sample_received_on }}</div>
                                            </div>
                                    </div> 
                                    <div class="col-lg-3">
                                        <div class="group-input">
                                            <label for="Completed On">Sample Received Completed Comment :</label>
                                            <div class="static">{{ $data->sample_received_comment }}</div>
                                        </div>
                                    </div>
                                    

                                <div class="sub-head">Cancellation</div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">Cancel Request By :</label>
                                        <div class="static">{{ $data->cancelled_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed On">Cancel Request On :</label>
                                        <div class="static">{{ $data->cancelled_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="group-input">
                                        <label for="Completed On">Cancel Request Comment :</label>
                                        <div class="static">{{ $data->cancelled_comment }}</div>
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
                <form action="{{ route('resampling_send_stage', $data->id) }}" method="POST">
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
                    <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                        {{-- <button>Close</button> --}}
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
    
                <form action="{{ route('resampling_Cancle', $data->id) }}" method="POST">
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

    <div class="modal fade" id="rejection-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <form action="{{ route('resampling_reject', $data->id) }}" method="POST">
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

    {{--  <script>
        // Pass the users data to JavaScript using json_encode
        var users = @json($users);
        console.log(users);

        function add9Input(tableId, users) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input type='text'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input type='text'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<input type='date'>";

            var cell6 = newRow.insertCell(5);
            cell6.innerHTML = "<input type='text'>";

            var cell7 = newRow.insertCell(6);
            cell7.innerHTML = "<input type='date'>";

            var cell8 = newRow.insertCell(7);
            if (users && users.length > 0) {
                cell8.innerHTML = generateUserDropdown(users);
            } else {
                cell8.innerHTML = "No users available";
            }

            var cell9 = newRow.insertCell(8);
            cell9.innerHTML = "<input type='text'>";

            var cell10 = newRow.insertCell(9);
            cell10.innerHTML = "<input type='date'>";

            for (var i = 0; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i + 1;
            }
        }

        function generateUserDropdown(users) {
            var html = "<select name='user[]'>" +
                       "<option value=''>Select a value</option>";

            for (var i = 0; i < users.length; i++) {
                html += "<option value='" + users[i].id + "'>" + users[i].name + "</option>";
            }

            html += "</select>";

            return html;
        }
    </script>  --}}


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
            cell3.innerHTML = '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="date_due' + currentRowCount +'" readonly placeholder="DD-MM-YYYY" /><input type="date" name="date_due[]"   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="date_due' + currentRowCount +'_checkdate"  class="hide-input" oninput="handleDateInput(this, `date_due' + currentRowCount +'`);checkDate(`date_due' + currentRowCount +'_checkdate`,`date_closed' + currentRowCount +'_checkdate`)" /></div></div></div></td>';

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input type='text' name='site[]'>";

            var cell5 = newRow.insertCell(4);
            var userHtml = '<select name="responsible_person[]"><option value="">-- Select --</option>';
                    for (var i = 0; i < users.length; i++) {
                        userHtml += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }
                    userHtml +='</select>';

            cell5.innerHTML = userHtml;

            var cell6 = newRow.insertCell(5);
            cell6.innerHTML = "<input type='text' name='current_status[]'>";

            var cell7 = newRow.insertCell(6);
            cell7.innerHTML = '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="date_closed' + currentRowCount +'" readonly placeholder="DD-MM-YYYY" /><input type="date" name="date_closed[]"  min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  id="date_closed'+ currentRowCount +'_checkdate" class="hide-input" oninput="handleDateInput(this, `date_closed' + currentRowCount +'`);checkDate(`date_due' + currentRowCount +'_checkdate`,`date_closed' + currentRowCount +'_checkdate`)" /></div></div></div></td>';

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
    $(document).ready(function() {

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
                    $('#rchars').text(textlen);});
            </script>
@endsection
