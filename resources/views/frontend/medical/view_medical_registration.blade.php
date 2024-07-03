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
    <script>
        $(document).ready(function() {
            $('#ReferenceDocument').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +


                        '<td><input type="text" name="PrimaryPackaging[]"></td>' +
                        '<td><input type="text" name="Material[]"></td>' +
                        '<td><input type="number" name="PackSize[]"></td>' +
                        '<td><input type="text" name="SelfLife[]"></td>' +
                        '<td><input type="text" name="StorageCondition[]"></td>' +
                        '<td><input type="text" name="SecondaryPacking[]"></td>' +
                        '<td><input type="text" name="Remarks[]"></td>' +



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
    @php
        $users = DB::table('users')->get();
    @endphp

    <div class="form-field-head">
        {{-- <div class="pr-id">
            New Child
        </div> --}}
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            / Medical Device Registration
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
                            $userRoles = DB::table('user_roles')
                                ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => 7])
                                ->get();
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        @endphp

                        <button class="button_theme1"> <a class="text-white" href="{{ url('medical_audit', $data->id) }}">
                                Audit Trail </a> </button>

                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Assign Responsible
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Classify
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target=" #more-info-required-modal">
                                Reject
                            </button>
                            <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                        Cancel
                                    </button> -->
                        @elseif($data->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit To Regulator
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif(
                            $data->stage == 4 &&
                                (in_array(5, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))
                            <button class="button_theme1" data-bs-toggle="modal" name="Withdraw" data-bs-target="#cancel-modal">
                                Withdraw
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancelled">
                                Refused
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Approval Received
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>

                            {{-- @elseif($data->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Deviation Complete
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#hodsend">
                            Back to Testing
                        </button> --}}
                            <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qasend">
                                                Document Completed
                                            </button> -->
                            <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                                QA Final Review Complete
                                            </button>
                                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                                Child
                                            </button>  -->
                            {{-- @elseif($data->stage == 6 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Document Completed
                        </button> --}}
                            <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                            Report Reject
                                            </button>
                                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qasend">
                                            Obsolete
                                            </button> -->

                            {{-- @elseif($data->stage == 7 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Final Approval
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Report Reject
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Obsolete
                        </button> --}}
                            <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                                Initiator Updated Complete
                                            </button> -->

                        @elseif($data->stage == 5 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Withdraw
                        </button> --}}
                        @elseif($data->stage == 6 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                        {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Refused
                    </button> --}}
                    @elseif($data->stage == 7 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">
                        Child
                </button>

                        @endif

                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>
                    </div>
                </div>

{{-- ====================================================================================================================================== --}}
                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($data->stage == 0)
                        <div class="progress-bars ">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    {{-- @elseif ($data->stage == 6)
                        {{-- @if ($data->stage == 6)
                        <div class="progress-bars ">
                            <div class="bg-danger">Closed - Withdraw</div>
                        </div>
                    @elseif ($data->stage == 7)
                    <div class="progress-bars ">
                        <div class="bg-danger">Closed - Not Approved</div>
                    </div> --}}
                    @else
                        <div class="progress-bars d-flex" style="font-size: 15px;">

                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active">Device and Directive Classification </div>
                            @else
                                <div class="">Device and Directive Classification</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">Dossier Finalization</div>
                            @else
                                <div class="">Dossier Finalization</div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="active"> Pending Registration Approval</div>
                            @else
                                <div class=""> Pending Registration Approval</div>
                            @endif


                            @if($data->stage == 5)
                            <div class="bg-danger">Closed - Withdrawn</div>
                            @elseif ($data->stage == 6)
                            <div class="bg-danger">Closed – Not Approved</div>
                            @elseif ($data->stage == 7)
                            <div class="bg-danger"> Closed –Approved</div>
                            @else
                            <div class=""> Closed –Approved</div>
                            @endif

{{--
                            @if ($data->stage >= 5)
                            <div class="active">Closed - Withdrawn</div>
                           @else
                            <div class="">Closed - Withdrawn</div>
                           @endif

                           @if ($data->stage >= 6)
                           <div class="active"> Closed – Not Approved</div>
                          @else
                           <div class="">Closed – Not Approved</div>
                          @endif

                          @if ($data->stage >= 7)
                         <div class="bg-danger"> Closed –Approved
                          </div>
                           @else
                        <div class=""> Closed –Approved
                         </div>
                          @endif --}}

                        </div>
                    @endif

                </div>
            </div>

            <!-- Tab links -->


            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Registration</button>
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Local Information</button> --}}
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>

            </div>

            <form action="{{ route('medical.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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

                                        <label for="RLS Record Number"><b>Initiator</b></label>

                                        <input disabled="text" name="initiator_id"
                                            value="{{ $data->initiator_id ?? Auth::user()->name }}">

                                        {{-- <input type="text"  name="initiator_id" value="{{ $validation->initiator_id=Auth::user()->id }}">  --}}

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="date_of_initiation">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="date_of_initiation">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="division_id"><b>Division</b></label>
                                        <select name="division_id" id="division_id">
                                            <option value="">Select Division</option>
                                            @foreach ($division as $divData)
                                                <option value="{{ $divData->id }}"
                                                    {{ $divData->id == $data->division_id ? 'selected' : '' }}>
                                                    {{ $divData->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/MR/{{ date('Y') }}/{{$data->record_number }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span class="text-danger">*</span></label>
                                        <p>255 characters remaining</p>
                                        <input id="docname" type="text" name="short_description"
                                            value="{{ $data->short_description }}" maxlength="255" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="group-input">
                                            <label for="search">
                                                Assigned To <span class="text-danger"></span>
                                            </label>
                                            <p class="text-primary">Person responsible</p>
                                            <select id="select-state" placeholder="Select..." name="assign_to">
                                                <option value="">Select a value</option>
                                                @if ($users->isNotEmpty())
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            @if (isset($data->assign_to) && $data->assign_to == $user->id) selected @endif>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="due-date">Date Due</label>
                                            <div><small class="text-primary">Please mention expected date of
                                                    completion</small></div>
                                            <div class="calenderauditee">
                                                {{-- Parse the date string into a DateTime object --}}
                                                @php
                                                    $date = new DateTime($data->due_date_gi);
                                                @endphp
                                                {{-- Format the date as desired --}}
                                                <input type="text" id="due_date_gi" readonly placeholder="DD-MMM-YYYY"
                                                    value="{{ $date->format('j-F-Y') }}" />
                                                <input type="date" name="due_date_gi"
                                                    min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}"
                                                    value="{{ $data->due_date_gi }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'due_date_gi')" />
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="group-input">
                                            <label for="search">
                                                Type <span class="text-danger"></span>
                                            </label>
                                            <p class="text-primary">Registration Type</p>
                                            <select id="select-state" placeholder="Select..."
                                                name="registration_type_gi">
                                                <option value="">Select a value</option>
                                                <option value="1" @if ($data->registration_type_gi == 1) selected @endif>1
                                                </option>
                                                <option value="2" @if ($data->registration_type_gi == 2) selected @endif>2
                                                </option>
                                                <option value="3" @if ($data->registration_type_gi == 3) selected @endif>3
                                                </option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="Audit Attachments">File Attachments</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="Audit_file">
                                                    @if ($data->file_attachment_gi)
                                                        @foreach (json_decode($data->file_attachment_gi) as $file)
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
                                                    <input type="file" id="HOD_Attachments" name="Audit_file[]"
                                                        value="{{ $data->file_attachment_gi }}"
                                                        oninput="addMultipleFiles(this, 'Audit_file')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

{{-- regitration --}}

                         <div class="sub-head">Registration Information</div>
                                <div class="col-lg-6">
                                    <div class="group-input">

                                        <label for="RLS Record Number"><b>(Parent) Trade Name</b></label>

                                        <input type="text" name="parent_record_number"
                                            value="{{ $data->parent_record_number }}">


                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">

                                        <label class="" for="RLS Record Number"><b>Local Trade Name</b></label>

                                        <input type="text" name="local_record_number"
                                            value="{{ $data->local_record_number }}">


                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Responsible Department">Zone</label>
                                        <select name="zone_departments" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="asia" @if ($data->zone_departments == "asia") selected @endif>Asia</option>
                                            <option value="europe" @if ($data->zone_departments == "europe") selected @endif>Europe</option>
                                            <option value="africa" @if ($data->zone_departments == "africa") selected @endif>Africa</option>
                                            <option value="central-america" @if ($data->zone_departments == "central-america") selected @endif>Central America</option>
                                            <option value="south-america" @if ($data->zone_departments == "south-america") selected @endif>South America</option>
                                            <option value="oceania" @if ($data->zone_departments == "oceania") selected @endif>Oceania</option>
                                            <option value="north-america" @if ($data->zone_departments == "north-america") selected @endif>North America</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">

                                        <label for="RLS Record Number"><b>Country</b></label>
                                        <p class="text-primary">Auto filter according to selected zone</p>
                                        <select name="country_number" class="form-select country" aria-label="Default select example" onchange="loadStates()" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                            <option value="{{ $data->country_number }}" selected>{{ $data->country_number }}</option>
                                        </select>


                                        {{-- <select name="country_number">
                                            <option value="">Select Country</option>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="1" @if ($data->country_number == 1) selected @endif>1
                                            </option>
                                            <option value="2" @if ($data->country_number == 2) selected @endif>2
                                            </option>
                                            <option value="3" @if ($data->country_number == 3) selected @endif>3
                                            </option>

                                        </select> --}}



                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="regulatory_departments">Regulatory body</label>
                                        <p class="text-primary">Auto filter according to country (if selected)</p>
                                        <select name="regulatory_departments">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="1" @if ($data->regulatory_departments == 1) selected @endif>1
                                            </option>
                                            <option value="2" @if ($data->regulatory_departments== 2) selected @endif>2
                                            </option>
                                            <option value="3" @if ($data->regulatory_departments == 3) selected @endif>3
                                            </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">

                                        <label for="RLS Record Number"><b>Registration number</b></label>

                                        <input type="number" name="registration_number" value="{{ $data->registration_number }}">



                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Responsible Department">Class (Risk Based)</label>
                                        <p class="text-primary">auto filter according to country</p>
                                        <select name="risk_based_departments">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="1" @if ($data->risk_based_departments == 1) selected @endif>1
                                            </option>
                                            <option value="2" @if ($data->risk_based_departments== 2) selected @endif>2
                                            </option>
                                            <option value="3" @if ($data->risk_based_departments == 3) selected @endif>3
                                            </option>
                                        </select>
                                    </div>
                                </div>



                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Responsible Department">Device Approval Type</label>
                                        <p class="text-primary">auto filter according to country</p>
                                        <select name="device_approval_departments">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="1" @if ($data->device_approval_departments == 1) selected @endif>1
                                            </option>
                                            <option value="2" @if ($data->device_approval_departments== 2) selected @endif>2
                                            </option>
                                            <option value="3" @if ($data->device_approval_departments == 3) selected @endif>3
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Marketing Authorization Holder</b></label>
                                        <input type="number" name="marketing_auth_number" value="0" min="0"
                                            max="9" step="1">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">

                                        <label for="RLS Record Number"><b>Manufacturer</b></label>

                                        <input type="text" name="manufacturer_number"value="{{ $data->manufacturer_number }}">


                                    </div>
                                </div>

                                {{-- </div> --}}
                                <div class="group-input">
                                    <label for="audit-agenda-grid">
                                        Packaging Information (0)
                                        <button type="button" name="audit-agenda-grid" id="ReferenceDocument">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#document-details-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (open)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="ReferenceDocument_details"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 4%">Row#</th>

                                                    <th style="width: 16%">Primary Packaging</th>
                                                    <th style="width: 14%">Material</th>
                                                    <th style="width: 14%">Pack Size</th>
                                                    <th style="width: 14%">Self Life</th>
                                                    <th style="width: 14%">Storage Condition</th>
                                                    <th style="width: 14%">Secondary Packaging</th>
                                                    <th style="width: 16%">Remarks</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if ($gridMedical && is_array($gridMedical->data))
                                                    @foreach ($gridMedical->data as $gridData)
                                                        <tr>

                                                            <td>{{ $loop->index +1 }}</td>
                                                            {{-- <td>
                                                           <input type="text" class="numberDetail" name="packagedetail[][item_product_code]" value="{{ isset($gridData['item_product_code']) ? $gridData['item_product_code'] : '' }}">
                                                            </td> --}}
                                                            <td>
                                                                <input type="text" class="numberDetail" name="packagedetail[{{ $loop->index }}][PrimaryPackaging]" value="{{ isset($gridData['PrimaryPackaging']) ? $gridData['PrimaryPackaging'] : '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="numberDetail" name="packagedetail[{{ $loop->index }}][Material]"value="{{ isset($gridData['Material']) ? $gridData['Material'] : '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="numberDetail" name="packagedetail[{{ $loop->index }}][PackSize]"value="{{ isset($gridData['PackSize']) ? $gridData['PackSize'] : '' }}">
                                                            </td>

                                                            <td>
                                                                <input type="text" class="numberDetail" name="packagedetail[{{ $loop->index }}][SelfLife]" value="{{ isset($gridData['SelfLife']) ? $gridData['SelfLife'] : '' }}">
                                                            </td>

                                                            <td>
                                                                <input type="text" class="numberDetail" name="packagedetail[{{ $loop->index }}][StorageCondition]" value="{{ isset($gridData['StorageCondition']) ? $gridData['StorageCondition'] : '' }}">
                                                            </td>

                                                            <td>
                                                                <input type="text" class="numberDetail" name="packagedetail[{{ $loop->index }}][SecondaryPackaging]" value="{{ isset($gridData['SecondaryPackaging']) ? $gridData['SecondaryPackaging'] : '' }}">
                                                            </td>

                                                            <td>
                                                                <input type="text" class="numberDetail" name="packagedetail[{{ $loop->index }}][Remarks]" value="{{ isset($gridData['Remarks']) ? $gridData['Remarks'] : '' }}">
                                                            </td>


                                                        </tr>
                                                    @endforeach
                                                @else
                                                    {{-- <td>{{ $serialNumber }}</td> --}}

                                                    <td><input type="text" class="numberDetail"          name="packagedetail[0][PrimaryPackaging]"></td>
                                                    <td><input type="text" class="Document_Remarks"      name="packagedetail[0][Material]"></td>
                                                    <td><input type="text" class="Document_Remarks"      name="packagedetail[0][PackSize]"></td>
                                                    <td><input type="date"class="Document_Remarks"       name="packagedetail[0][StorageCondition]"></td>
                                                    <td><input type="date" class="Document_Remarks"      name="packagedetail[0][SecondaryPackaging]"></td>
                                                    <td><input type="text" class="Document_Remarks"      name="packagedetail[0][Remarks]"></td>
                                                    {{-- <td><button type="text" class="removeRowBtn">Remove</button></td> --}}
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>

                                </div>






                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Actions">Manufacturing Site<span
                                                    class="text-danger"></span></label>

                                            <textarea placeholder=""
                                                name="manufacturing_description"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->manufacturing_description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">

                                            <label for="RLS Record Number"><b>Dossier Parts</b></label>

                                            <input type="text" name="dossier_number"
                                                value="{{ $data->dossier_number }}">


                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="group-input">
                                            <label for="Responsible Department">Related Dossier Document</label>
                                            <select name="dossier_departments">
                                                <option value="">Enter Your Selection Here</option>
                                                <option value="1" @if ($data->dossier_departments == '1') selected @endif>1
                                                </option>
                                                <option value="2" @if ($data->dossier_departments == '2') selected @endif>2
                                                </option>
                                                <option value="3" @if ($data->dossier_departments == '3') selected @endif>3
                                                </option>
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Description<span class="text-danger">*</span>
                                                <p>255 characters remaining</p>
                                                <textarea placeholder="" name="description"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->description }}</textarea>
                                                {{-- <textarea placeholder="" name="Description" {{ $data->stage == 0 || $data->stage == 6 ? "disabled" : "" }}>{{ $data->Description }}</textarea> --}}
                                        </div>
                                    </div>
                                </div>
                                <p class="text-primary">Important Dates</p>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Date">Planned Submission Date</label>
                                        <input type="date" name="planned_submission_date"
                                            value="{{ $data->planned_submission_date }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date">Actual Submission Date</label>
                                        <input type="date" name="actual_submission_date"
                                            value="{{ $data->actual_submission_date }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date">Actual Approval Date</label>
                                        <input type="date" name="actual_approval_date"
                                            value="{{ $data->actual_approval_date }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Date">Actual Rejection Date</label>
                                        <input type="date" name="actual_rejection_date"
                                            value="{{ $data->actual_rejection_date }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Responsible Department">Renewal Rule</label>
                                        <select name="renewal_departments">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="1" @if ($data->renewal_departments == 1) selected @endif>1
                                            </option>
                                            <option value="2" @if ($data->renewal_departments == 2) selected @endif>2
                                            </option>
                                            <option value="3" @if ($data->renewal_departments == 3) selected @endif>3
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date">Next Renewal Date</label>
                                        <input type="date" name="next_renewal_date"
                                            value="{{ $data->next_renewal_date }}">
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

                    {{-- =====================================ccform3==================== --}}

                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="submitted by">Assign Responsible By :</label>
                                        <div class="">{{ $data->assign_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Assign Responsible On :</b></label>
                                        <div class="">{{ $data->assign_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Comment :</b></label>
                                        <div class="">{{ $data->comment }}</div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="submitted by">Cancel By :</label>
                                        <div class="">{{ $data->cancel_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Cancel On :</b></label>
                                        <div class="">{{ $data->cancel_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Comment :</b></label>
                                        <div class="">{{ $data->cancel_comment }}</div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="submitted by">Classify By :</label>
                                        <div class="">{{ $data->classify_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Classify On :</b></label>
                                        <div class="">{{ $data->classify_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Comment :</b></label>
                                        <div class="">{{ $data->classify_comment }}</div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="submitted by">Reject By :</label>
                                        <div class="">{{ $data->reject_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Reject On :</b></label>
                                        <div class="">{{ $data->reject_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Comment :</b></label>
                                        <div class="">{{ $data->reject_comment }}</div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="submitted by">Submit To Regulator By :</label>
                                        <div class="">{{ $data->submit_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Submit To Regulator On :</b></label>
                                        <div class="">{{ $data->submit_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Comment :</b></label>
                                        <div class="">{{ $data->submit_comment }}</div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="submitted by">Cancelled By :</label>
                                        <div class="">{{ $data->cancelled_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Cancelled On :</b></label>
                                        <div class="">{{ $data->cancelled_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Comment :</b></label>
                                        <div class="">{{ $data->cancelled_comment }}</div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="submitted by">Refused By :</label>
                                        <div class="">{{ $data->refused_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Refused On :</b></label>
                                        <div class="">{{ $data->refused_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Comment :</b></label>
                                        <div class="">{{ $data->refused_comment }}</div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="submitted by">Withdraw By :</label>
                                        <div class="">{{ $data->withdraw_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Withdraw On :</b></label>
                                        <div class="">{{ $data->withdraw_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Comment :</b></label>
                                        <div class="">{{ $data->withdraw_comment }}</div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="submitted by">Approval Received By :</label>
                                        <div class="">{{ $data->received_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Approval Received On :</b></label>
                                        <div class="">{{ $data->received_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Comment :</b></label>
                                        <div class="">{{ $data->received_comment }}</div>
                                    </div>
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
        let gridMedicalCount = {{ $gridMedical && is_array($gridMedical->data) ? count($gridMedical->data) : 0 }};

        $('#infoProAdd').click(function(e) {
            e.preventDefault();

            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="info_product[' + gridMedicalCount + '][PrimaryPackaging]"></td>' +
                    '<td><input type="date" name="info_product[' + gridMedicalCount + '][mfg_date]"></td>' +
                    '<td><input type="date" name="info_product[' + gridMedicalCount + '][exp_date]"></td>' +
                    '<td><input type="text" name="info_product[' + gridMedicalCount + '][ar_number]"></td>' +
                    '<td><input type="text" name="info_product[' + gridMedicalCount + '][pack_style]"></td>' +
                    '<td><input type="text" name="info_product[' + gridMedicalCount + '][frequency]"></td>' +
                    '<td><input type="text" name="info_product[' + gridMedicalCount + '][condition]"></td>' +
                    '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                    '</tr>';

                gridMedicalCount++;
                return html;
            }

            var serialNumber = $('table tbody tr').length + 1;
            $('table tbody').append(generateTableRow(serialNumber));
        });

        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        });
    });
</script>



    <script>
        $(document).ready(function() {
            $('#Witness_details').click(function(e) {
                function generateTableRow(serialNumber) {

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
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
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
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
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
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

<script>
    function loadStates() {
        let country = $('.country').val();
        $.ajax({
            url: '/get-states',
            method: 'GET',
            data: { country: country },
            success: function (data) {
                $('.state').html(data);
            }
        });
    }

    function loadCities() {
        let state = $('.state').val();
        $.ajax({
            url: '/get-cities',
            method: 'GET',
            data: { state: state },
            success: function (data) {
                $('.city').html(data);
            }
        });
    }
</script>

    {{--Country Statecity API--}}
<script>


    var config = {
        cUrl: 'https://api.countrystatecity.in/v1',
        ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
    };

    var countrySelect = document.querySelector('.country'),
        stateSelect = document.querySelector('.state'),
        citySelect = document.querySelector('.city');

    function loadCountries() {
        let apiEndPoint = `${config.cUrl}/countries`;

        $.ajax({
            url: apiEndPoint,
            headers: {
                "X-CSCAPI-KEY": config.ckey
            },
            success: function(data) {
                data.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.iso2;
                    option.textContent = country.name;
                    countrySelect.appendChild(option);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading countries:', error);
            }
        });
    }

    function loadStates() {
        stateSelect.disabled = false;
        stateSelect.innerHTML = '<option value="">Select State</option>';

        const selectedCountryCode = countrySelect.value;

        $.ajax({
            url: `${config.cUrl}/countries/${selectedCountryCode}/states`,
            headers: {
                "X-CSCAPI-KEY": config.ckey
            },
            success: function(data) {
                data.forEach(state => {
                    const option = document.createElement('option');
                    option.value = state.iso2;
                    option.textContent = state.name;
                    stateSelect.appendChild(option);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading states:', error);
            }
        });
    }

    function loadCities() {
        citySelect.disabled = false;
        citySelect.innerHTML = '<option value="">Select City</option>';

        const selectedCountryCode = countrySelect.value;
        const selectedStateCode = stateSelect.value;

        $.ajax({
            url: `${config.cUrl}/countries/${selectedCountryCode}/states/${selectedStateCode}/cities`,
            headers: {
                "X-CSCAPI-KEY": config.ckey
            },
            success: function(data) {
                data.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.id;
                    option.textContent = city.name;
                    citySelect.appendChild(option);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error loading cities:', error);
            }
        });
    }
    $(document).ready(function() {
        loadCountries();
    });


</script>
{{--Country Statecity API End--}}


    <script>
        // Function to calculate and populate the due date field with a date 30 days from now
        document.addEventListener("DOMContentLoaded", function() {
            // Get the current date
            var currentDate = new Date();
            // Add 30 days to the current date
            var dueDate = new Date(currentDate.setDate(currentDate.getDate() + 30));
            // Format the due date as 'DD-MMMM-YYYY'
            var formattedDueDate = formatDate(dueDate);

            // Populate the due date input field
            document.getElementById("due_date_gi").value = formattedDueDate;
        });

        // Function to format the date as 'DD-MMMM-YYYY'
        function formatDate(date) {
            var day = date.getDate();
            var monthIndex = date.getMonth();
            var year = date.getFullYear();

            // Array of month names
            var monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            // Pad single digit day with leading zero
            if (day < 10) {
                day = '0' + day;
            }

            return day + '-' + monthNames[monthIndex] + '-' + year;
        }
    </script>


 <div class="modal fade" id="child-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <form action="{{ route('Correspondence_show', $data ->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        @if ($data->stage == 2)
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
                            correspondence
                        </label>
                        <label style="display: flex;" for="major">
                            <input type="radio" name="child_type" id="major" value="variation">
                            Variation
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


    <!-- signature model -->

    <div class="modal fade" id="more-info-required-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('medical_device_reject', $data->id) }}" method="POST">
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


    {{-- -----------cancel modal---------- --}}

    <div class="modal fade" id="cancel-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('medical_deviceCancel', $data->id) }}" method="POST">
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


    {{-- new child  --}}
    <div class="modal fade" id="cancelled">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('canceltwo', $data->id) }}" method="POST">
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

                <form action="{{ url('deviationIsCFTRequired', $data->id) }}" method="POST">
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

                <form action="{{ route('check', $data->id) }}" method="POST">
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

                <form action="{{ route('check2', $data->id) }}" method="POST">
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

                <form action="{{ route('check3', $data->id) }}" method="POST">
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


    {{-- <div class="modal fade" id="child-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <form action="{{ route('data_child_1', $data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        @if ($data->stage == 5)
                        <label style="display: flex;" for="major">
                            <input  type="radio" name="child_type" id="major" value="pm">
                            Preventive Maintenance
                        </label>

                        <label style="display: flex;" for="major">
                            <input  type="radio" name="child_type" id="major" value="calibration">
                            Calibration
                        </label>

                        <label for="major">
                            <input type="radio" name="child_type" id="major" value="deviation">
                            Deviation
                        </label>
                        @endif

                    </div>

                </div> --}}

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
                <form action="{{ route('medical_registration_send_stage', $data->id) }}" method="POST">
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
                <form action="{{ route('cftnotreqired', $data->id) }}" method="POST">
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

         {{-- model1 --}}
    <div class="modal fade" id="modal1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('deviation_qa_more_info', $data->id) }}" method="POST">
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
