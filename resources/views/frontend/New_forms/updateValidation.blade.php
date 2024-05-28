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
            <strong>Site Validation/Project</strong> :
            {{ Helpers::getDivisionName($validation->demo_validation_id) }} / Validation
        </div>
    </div>

    {{-- ---------------------- --}}
   
    <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow </div>

                    <div class="d-flex" style="gap:20px;">
                        {{-- @php
                            $userRoles = DB::table('user_roles')
                                ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])
                                ->get();
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                            $cftRolesAssignUsers = collect($userRoleIds); //->contains(fn ($roleId) => $roleId >= 22 && $roleId <= 33);
                            $cftUsers = DB::table('deviationcfts')
                                ->where(['deviation_id' => $data->id])
                                ->first();




                            // Define the column names
                            $columns = [
                                'Production_person',
                                'Warehouse_notification',
                                'Quality_Control_Person',
                                'QualityAssurance_person',
                                'Engineering_person',
                                'Analytical_Development_person',
                                'Kilo_Lab_person',
                                'Technology_transfer_person',
                                'Environment_Health_Safety_person',
                                'Human_Resource_person',
                                'Information_Technology_person',
                                'Project_management_person',
                            ];

                            // Initialize an array to store the values
                            $valuesArray = [];

                            // Iterate over the columns and retrieve the values
                            foreach ($columns as $column) {
                                $value = $cftUsers->$column;
                                // Check if the value is not null and not equal to 0
                                if ($value !== null && $value != 0) {
                                    $valuesArray[] = $value;
                                }
                            }
                            $cftCompleteUser = DB::table('deviationcfts_response')
                                ->whereIn('status', ['In-progress', 'Completed'])
                                ->where('deviation_id', $data->id)
                                ->where('cft_user_id', Auth::user()->id)
                                ->whereNull('deleted_at')
                                ->first();
                            // dd($cftCompleteUser);
                        @endphp --}}
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                        <button class="button_theme1"> <a class="text-white" href="">
                                {{-- {{ url('DeviationAuditTrial', $data->id) }} --}}

                                {{-- add here url for auditTrail i.e. href="{{ url('CapaAuditTrial', $data->id) }}" --}}
                                Audit Trail </a> </button>

                        {{-- @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds))) --}}
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Submit
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                        {{-- @elseif($data->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds))) --}}
                        {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                            More Info Required
                        </button> --}}
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            HOD Review Complete
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                        {{-- @elseif($data->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds))) --}}
                        {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                            More Info Required
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            QA Initial Review Complete
                        </button>

                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
                        </button> --}}
                        {{-- @elseif(
                            $data->stage == 4 &&
                                (in_array(5, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))
                            @if (!$cftCompleteUser) --}}
                        {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                            More Info Required
                        </button> --}}

                        {{-- @elseif($data->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds))) --}}
                        {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#sendToInitiator">
                            Send to Initiator
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#hodsend">
                            Send to HOD
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qasend">
                            Send to QA Initial Review
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            QA Final Review Complete
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
                        </button> --}}
                        {{-- @elseif($data->stage == 6 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds))) --}}
                        {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                            More Info Required
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Approved
                        </button> --}}
                        {{-- @elseif($data->stage == 7 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds))) --}}
                        {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#sendToInitiator">
                            Send to Opened
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#hodsend">
                            Send to HOD Review
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qasend">
                            Send to QA Initial Review
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Initiator Updated Complete
                        </button> --}}
                        {{-- @elseif($data->stage == 8 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds))) --}}
                        {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#sendToInitiator">
                            Send to Opened
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#hodsend">
                            Send to HOD Review
                        </button> --}}
                        {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qasend">
                            Send to QA Initial Review
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#pending-initiator-update">
                            Send to Pending Initiator Update
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            QA Final Review Complete
                        </button> --}}
                        {{-- @endif --}}
                        {{-- <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button> --}}


                    </div>

                </div>


                <div class="status">
                    <div class="head">Current Status</div>
                    {{-- @if ($data->stage == 0) --}}
                    {{-- <div class="progress-bars ">
                        <div class="bg-danger">Closed-Cancelled</div>
                    </div> --}}
                    {{-- @else --}}
                    <div class="progress-bars d-flex" style="font-size: 15px;">
                        {{-- @if ($data->stage >= 1) --}}
                        <div class="active">Opened</div>
                        {{-- @else --}}
                        {{-- <div class="">Opened</div> --}}
                        {{-- @endif --}}

                        {{-- @if ($data->stage >= 2) --}}
                        {{-- <div class="active">HOD Review </div> --}}
                        {{-- @else --}}
                        <div class="">HOD Review</div>
                        {{-- @endif --}}

                        {{-- @if ($data->stage >= 3) --}}
                        {{-- <div class="active">QA Initial Review</div> --}}
                        {{-- @else --}}
                        <div class="">QA Initial Review</div>
                        {{-- @endif --}}

                        {{-- @if ($data->stage >= 4) --}}
                        {{-- <div class="active">CFT Review</div> --}}
                        {{-- @else --}}
                        <div class="">CFT Review</div>
                        {{-- @endif --}}


                        {{-- @if ($data->stage >= 5) --}}
                        {{-- <div class="active">QA Final Review</div> --}}
                        {{-- @else --}}
                        <div class="">QA Final Review</div>
                        {{-- @endif --}}
                        {{-- @if ($data->stage >= 6) --}}
                        {{-- <div class="active">QA Head/Manager Designee Approval</div> --}}
                        {{-- @else --}}
                        <div class="">QA Head/Manager Designee Approval</div>
                        {{-- @endif --}}
                        {{-- @if ($data->stage >= 7) --}}
                        {{-- <div class="active">Pending Initiator Update</div> --}}
                        {{-- @else --}}
                        <div class="">Pending Initiator Update</div>
                        {{-- @endif --}}
                        {{-- @if ($data->stage >= 8) --}}
                        {{-- <div class="active">QA Final Approval</div> --}}
                        {{-- @else --}}
                        <div class="">QA Final Approval</div>
                        {{-- @endif --}}
                        {{-- @if ($data->stage >= 9) --}}
                        {{-- <div class="bg-danger">Closed - Done</div> --}}
                        {{-- @else --}}
                        <div class="">Closed - Done</div>
                        {{-- @endif --}}
                        {{-- @endif --}}


                    </div>
                    {{-- @endif --}}
                    {{-- ---------------------------------------------------------------------------------------- --}}
                </div>
            </div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Validation Document</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Test Results</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>
        </div>

        <form action="{{ route('validation.update', $validation->id) }}" method="POST" enctype="multipart/form-data">
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

                            <div class="sub-head">General Information</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Originator"><b>Initiator</b></label>
                                    <input disabled type="text" name="validation" value="{{ $validation->validation }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date Of Initiation</b></label>
                                    <input type="date" name="initiation_date" value="{{ $validation->initiation_date }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" maxlength="255" value="{{ $validation->short_description }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assigned_user_id">
                                        <option value="">Select a value</option>
                                        @foreach ($users as $key => $value)
                                            <option value="{{ $value->id }}" @if ($validation->assigned_user_id == $value->id) selected @endif>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_user_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input type="text" id="assign_due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="assign_due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ \Helpers::getdateFormat($validation->assign_due_date) }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Validation Type</label>
                                    <select name="validation_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($validation->validation_type == 1) selected @endif>1</option>
                                        <option value="2" @if ($validation->validation_type == 2) selected @endif>2</option>
                                        <option value="3" @if ($validation->validation_type == 3) selected @endif>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="validation_due_date">Date Due <span class="text-danger"></span></label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="validation_due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ \Helpers::getdateFormat($validation->validation_due_date) }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="notify_type">Notify When Approved?</label>
                                    <select name="notify_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($validation->notify_type == 1) selected @endif>yes</option>
                                        <option value="2" @if ($validation->notify_type == 2) selected @endif>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="phase_type">Phase Level</label>
                                    <select name="Type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($validation->phase_type == 1) selected @endif>1</option>
                                        <option value="2" @if ($validation->phase_type == 2) selected @endif>2</option>
                                        <option value="3" @if ($validation->phase_type == 3) selected @endif>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sub-head">
                                Document Information
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Type">Document Reason</label>
                                    <select name="document_reason_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="yes" @if ($validation->document_reason_type == 'yes') selected @endif>yes</option>
                                        <option value="No" @if ($validation->document_reason_type == 'No') selected @endif>No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Purpose</label>
                                    <textarea class="summernote" name="purpose" id="summernote-16">{{ $validation->purpose }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Outcome">Validation Category</label>
                                    <select name="validation_category">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($validation->validation_category == 1) selected @endif>1</option>
                                        <option value="2" @if ($validation->validation_category == 2) selected @endif>2</option>
                                        <option value="3" @if ($validation->validation_category == 3) selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Patient_Involved">Validation Sub Category</label>
                                    <select name="validation_sub_category">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($validation->validation_sub_category == 1) selected @endif>1</option>
                                        <option value="2" @if ($validation->validation_sub_category == 2) selected @endif>2</option>
                                        <option value="3" @if ($validation->validation_sub_category == 3) selected @endif>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closure attachment">Download Templates </label>
                                    <div><small class="text-primary">
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="File_Attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_attechment" value="{{$validation->file_attechment }}" oninput="addMultipleFiles(this, 'Attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reference Recores"> Related Records</label>
                                    <select multiple id="reference_record" name="related_record" id="">
                                         <option value="">--Select---</option>
                                        <option value="1" @if ($validation->related_record==1 ) selected @endif>Pankaj</option>
                                        <option value="2" @if ($validation->related_record==2) selected @endif>Gourav</option>
                                       
                                        <!-- <option value="Pankaj">Pankaj</option>
                                        <option value="Gourav">Gourav</option> -->
                                    </select>
                                </div> 
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reporter">Document Link </label>
                                    <input type="text" name="document_link" value="{{$validation->document_link}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Tests Required</label>
                                    <select name="tests_required">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($validation->tests_required == 1) selected @endif>Yes</option>
                                        <option value="2" @if ($validation->tests_required == 2) selected @endif>Yes</option>
                                        <!-- <option value="Yes">Yes</option>
                                        <option value="No">No</option> -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Refrence Document</label>
                                    <select name="reference_document">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($validation->reference_document == 1) selected @endif>Yes</option>
                                        <option value="2" @if ($validation->reference_document == 2) selected @endif>Yes</option>
                                        <!-- <option value="Yes">yes</option>
                                        <option value="No">No</option> -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reporter">Refrence Link </label>
                                    <input type="text" name="reference_link" value="{{$validation->reference_link}}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Additional Refrences</label>
                                    <textarea class="summernote" name="additional_references" value="{{$validation->additional_references}}" id="summernote-16"></textarea>
                                </div>
                            </div>


                            <div class="sub-head">
                                Affected Items
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Affected Equipment(0)
                                    <button type="button" name="affected_equipments" id="Affected_equipment_add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Affected_equipment_Table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Equipment Name/Code</th>
                                                <th style="width: 16%">Equipment ID</th>
                                                <th style="width: 16%">Asset No</th>
                                                <th style="width: 16%">Remarks</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name="equipment_name_code[]" value="{{$validation->equipment_name_code }}"></td>
                                            <td><input type="text" name="equipment_id[]" value="{{$validation->equipment_id}}"></td>
                                            <td><input type="text" name="asset_no[]" value="{{$validation->asset_no}}"></td>
                                            <td><input type="text" name="remarks[]" value="{{$validation->remarks}}"></td>

                                        </tbody>

                                    </table>
                                </div>
                            </div>


                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Affected Item(0)
                                    <button type="button" name="affected_equipments" id="Affected_item_add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Affected_item_Table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Item Type</th>
                                                <th style="width: 16%">Item Name</th>
                                                <th style="width: 16%">Item No</th>
                                                <th style="width: 16%"> Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name="item_type[]" value="{{$validation->item_type}}"></td>
                                            <td><input type="text" name="item_name[]" value="{{$validation->item_name}}"></td>
                                            <td><input type="text" name="item_no[]" value="{{$validation->item_remarks}}"></td>
                                            <td><input type="text" name="item_remarks[]" value="{{$validation->item_remarks}}"></td>


                                        </tbody>

                                    </table>
                                </div>
                            </div>


                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Affected Facilities(0)
                                    <button type="button" name="affected_facilities" id="Affected_facilities_add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Affected_facilities_Table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Facility-Location</th>
                                                <th style="width: 16%">Facility-Type</th>
                                                <th style="width: 16%">Facility-Name</th>
                                                <th style="width: 16%">Remarks</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name="facility_location[]" value="{{$validation->facility_location}}"></td>
                                            <td><input type="text" name="facility_type[]" value="{{$validation->facility_type}}"></td>
                                            <td><input type="text" name="facility_name[]" value="{{$validation->facility_name}}"></td>
                                            <td><input type="text" name="facility_remarks[]" value="{{$validation->facility_remarks}}"></td>
                                        </tbody>

                                    </table>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closure attachment">Items Attachment </label>
                                    <div><small class="text-primary">
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="File_Attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="items_attachment" value="{{$validation->items_attachment}}" oninput="addMultipleFiles(this, 'Attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Additional Attachment Items</label>
                                    <textarea class="summernote" name="addition_attachment_items" value="{{$validation->addition_attachment_items}}" id="summernote-16"></textarea>
                                </div>
                            </div>


                            <div class="sub-head">
                                Document Decision
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Type">Data Successfully Closed?</label>
                                    <select name="data_successfully_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($validation->reference_document == 1) selected @endif>Yes</option>
                                        <option value="2" @if ($validation->reference_document == 2) selected @endif>Yes</option>
                                        <!-- <option value="Yes">yes</option>
                                        <option value="No">No</option> -->
                                    </select>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Document Summary</label>
                                    <textarea class="summernote" name="documents_summary" value="{{$validation->documents_summary}}" id="summernote-16"></textarea>
                                </div>
                            </div>


                            <div class="sub-head">
                                Document Comments
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Document Comments</label>
                                    <textarea class="summernote" name="document_comments" value="{{$validation->document_comments}}" id="summernote-16"></textarea>
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
                            <div>Test Information</div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Patient_Involved">Test Required?</label>
                                    <select name="test_required">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($validation->reference_document == 1) selected @endif>1</option>
                                        <option value="2" @if ($validation->reference_document == 2) selected @endif>2</option>
                                        <!-- <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option> -->
                                    </select>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_of_birth">Test Start Date</label>
                                    <input type="date" name="test_start_date" value="{{$validation->test_start_date}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_of_birth">Test End Date</label>
                                    <input type="date" name="test_end_date" value="{{$validation->test_end_date}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="gender">Test Responsible</label>
                                    <select name="test_responsible">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1" @if ($validation->reference_document == 1) selected @endif>pankaj</option>
                                        <option value="2" @if ($validation->reference_document == 2) selected @endif>Gourav</option>
                                        <option value="2" @if ($validation->reference_document == 2) selected @endif>Mayank</option>
                                        <!-- <option value="No">pankaj</option>
                                        <option value="Gourav">Gourav</option>
                                        <option value="Mayank">Mayank</option> -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closure attachment">Results Attachment </label>
                                    <div><small class="text-primary">
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="File_Attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="result_attachment" value="{{$validation->result_attachment}}" oninput="addMultipleFiles(this, 'Attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Summary Of Results(0)
                                    <button type="button" name="audit-agenda-grid" id="SummaryOfResults_add">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Open)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="SummaryOfResults_Table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Deviation Occured</th>
                                                <th style="width: 16%">Test-Name</th>
                                                <th style="width: 16%">Test-Number</th>
                                                <th style="width: 16%">Test-Method</th>
                                                <th style="width: 15%">Test-Result</th>
                                                <th style="width: 15%">Test-Accepted</th>
                                                <th style="width: 15%">Remarks</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name="DeviationOccured[]"></td>
                                            <td><input type="text" name="Test-Name[]"></td>
                                            <td><input type="text" name="Test-Number[]"></td>
                                            <td><input type="text" name="Test-Method[]"></td>
                                            <td><input type="text" name="Test-Result[]"></td>
                                            <td><input type="text" name="Test-Accepted[]"></td>
                                            <td><input type="text" name="Remarks[]"></td>

                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Test Actions & Comments</label>
                                    <textarea class="summernote" name="test_action" id="summernote-16"></textarea>
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



                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">
                                Record Type History
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted by">Submitted Protocol By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Submitted Protocol On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reviewed by">Cancelled By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancelled on">Cancelled On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>

                            <div class="sub-head">Review</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reviewed by">Review By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Review on">Review On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>

                            <div class="sub-head">Final Approval</div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Plan_Approved_by1">1st Final Approval By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Plan_Approved_on1">1st Final Approval On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Plan_Approved_by2">2nd Final Approval By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Plan_Approved_on2">2nd Final Approval On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Report_by">Report Reject By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Report_on">Report Reject On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Obsolete_by">Obsolete By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Obsolete_on">Obsolete On</label>
                                    <div class="Date"></div>
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
        $('#Treatment_of_Adverse_Reaction').click(function(e) {
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
                    '</tr>';

                return html;
            }

            var tableBody = $('#Treatment_of_Adverse_Reaction-instruction-modal tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
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
    $(document).ready(function() {
        $('#SummaryOfResults_add').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="DeviationOccured[]"></td>' +
                    '<td><input type="text" name="Test-Name[]"></td>' +
                    '<td><input type="text" name="Test-Number[]"></td>' +
                    '<td><input type="text" name="Test-Method[]"></td>' +
                    '<td><input type="text" name="Test-Result[]"></td>' +
                    '<td><input type="text" name="Test-Accepted[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>'+

                    '</tr>';

                return html;
            }

            var tableBody = $('#SummaryOfResults_Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#Affected_equipment_add').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="EquipmentName/Code[]"></td>' +
                    '<td><input type="text" name="EquipmentID[]"></td>' +
                    '<td><input type="text" name="AssetNo[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>'+

                    '</tr>';

                return html;
            }

            var tableBody = $('#Affected_equipment_Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#Affected_item_add').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="ItemType[]"></td>' +
                    '<td><input type="text" name="ItemName[]"></td>' +
                    '<td><input type="text" name="ItemNo[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>'+

                    '</tr>';

                return html;
            }

            var tableBody = $('#Affected_item_Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#Affected_facilities_add').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="Facility-Location[]"></td>' +
                    '<td><input type="text" name="Facility-Type[]"></td>' +
                    '<td><input type="text" name="Facility-Name[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>'+

                    '</tr>';

                return html;
            }

            var tableBody = $('#Affected_facilities_Table tbody');
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