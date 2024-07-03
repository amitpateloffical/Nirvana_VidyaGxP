@extends('frontend.layout.main')
@section('container')
    {{-- <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
    </style> --}}
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
        {{-- <div class="pr-id">
            New Child
        </div> --}}
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            / Field Inquiry
        </div>
    </div>



    {{-- ! ========================================= --}}
    {{-- !               DATA FIELDS                 --}}
    {{-- ! ========================================= --}}
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
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                         <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/field_auditTrail', $field->id) }}"> {{-- add here url for auditTrail i.e. href="{{ url('CapaAuditTrial', $field->id) }}" --}}
                                Audit Trail </a> </button>

                        @if ($field->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal"  data-bs-target="#signature-modal">
                                Begin Review
                            </button>

                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($field->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Complete
                            </button>

                       @elseif($field->stage == 3 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Obsolete
                            </button> --}}
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>

                    </div>

                </div>

                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($field->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars">
                            @if ($field->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($field->stage >= 2)
                                <div class="active"> Supervisor Review</div>
                            @else
                                <div class=""> Supervisor Review</div>
                            @endif

                            @if ($field->stage >= 3)
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

    <div id="change-control-fields">

        <div class="container-fluid">
            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Field Inquiry</button>
                <button class="cctablinks " onclick="openCity(event, 'CCForm2')">Inquiry Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>
            </div>

            <script>
                $(document).ready(function() {
                    <?php if (in_array($field->stage, [3])): ?>
                        $("#target :input").prop("disabled", true);
                    <?php endif; ?>
                });
            </script>


            <form id="target" action="{{ route('field_update', $field->id) }}" method="POST" enctype="multipart/form-data">
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

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Originator"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/FI/{{ date('Y') }}/{{ $record_number }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Originator"><b>Initiator</b></label>

                                        <input disabled type="text" name="originator_id"
                                            value="{{ $lab->originator_id ?? Auth::user()->name }}">

                                        {{-- <input disabled type="text" name="Originator" value=""> --}}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span class="text-danger">*</span>
                                            <input id="short_description" type="text" name="short_description"
                                                value="{{ $field->short_description }}" maxlength="255" required>


                                            {{-- <label for="Short Description">Short Description</label>
                                    <input type="text" name="short_description" id="short_description" value=""> --}}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Date Of Initiation</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="initiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="initiation_date">

                                        {{-- <input  type="date" name="Date Opened" value=""> --}}

                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="If Others">Assigned To</label>
                                        <select name="assigned_to">
                                           <option value="">Select a value</option>
                                            <option value="">-- select --</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" {{ $user->id == $field->assigned_to ? 'selected' : ''}}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Due Date">Date Due</label>

                                        <div class="calenderauditee">
                                            @php
                                                $fieldDueDate = new \DateTime($field->due_date);
                                            @endphp
                                            {{-- Format the date as desired --}}
                                            <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                                value="{{ $fieldDueDate->format('j-F-Y') }}" />
                                            <input type="date" name="due_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                value="{{ $field->due_date }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Type">Customer Name</label>
                                        <input type="text" id="customer_name" name="customer_name" value="{{ $field->customer_name}}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Type">Submitted By</label>
                                        <select name="submitted_by">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="Mayank" @if ($field->submitted_by == 'Mayank') selected @endif>Mayank</option>
                                            <option value="Gaurav" @if ($field->submitted_by == 'Gaurav') selected @endif>Gaurav</option>
                                            <option value="Manish" @if ($field->submitted_by == 'Manish') selected @endif>Manish</option>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Type">Type</label>
                                        <select name="type">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="T-1" @if($field->type == 'T-1')selected @endif>T-1</option>
                                            <option value="T-2" @if($field->type == 'T-2')selected @endif>T-2</option>
                                            <option value="T-3" @if($field->type == 'T-3')selected @endif>T-3</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Type">Priority Level</label>
                                        <select name="priority_level">

                                            <option value="">Enter Your Selection Here</option>
                                            <option value="P-1" @if ($field->priority_level == 'P-1') selected @endif>P-1</option>
                                            <option value="P-1" @if ($field->priority_level == ' P-2') selected @endif>P-2</option>
                                            <option value="P-1" @if ($field->priority_level == ' P-3')selected @endif>P-3</option>


                                        </select>

                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label class="mt-4" for="Audit Comments"> Description</label>
                                        <textarea class="summernote" name="description" id="summernote-16">{{ old('description', $field->description) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <div class="why-why-chart">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%;">Sr.No.</th>
                                                        <th style="width: 30%;">Question</th>
                                                        <th>Response</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td style="background: #DCD8D8">
                                                            <textarea name="question_1" value="">{{ $field->question_1 }}</textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="response_1"value="">{{ $field->response_1 }}</textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="remark_1"value="">{{ $field->remark_1 }}</textarea>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td style="background: #DCD8D8">
                                                            <textarea name="question_2" value="">{{ $field->question_2 }}</textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="response_2"value="">{{ $field->response_2 }}</textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="remark_2"value="">{{ $field->remark_2 }}</textarea>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td style="background: #DCD8D8">
                                                            <textarea name="question_3" value="">{{ $field->question_3 }}</textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="response_3"value="">{{ $field->response_3 }}</textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="remark_3">{{ $field->remark_3 }}</textarea>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td style="background: #DCD8D8">
                                                            <textarea name="question_4" value="">{{ $field->question_4 }}</textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="response_4">{{ $field->response_4 }}</textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="remark_4">{{ $field->remark_4 }}</textarea>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td style="background: #DCD8D8">
                                                            <textarea name="question_5" value="">{{ $field->question_5 }}</textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="response_5">{{ $field->response_5 }}</textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="remark_5">{{ $field->remark_5 }}</textarea>
                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>




                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Type">Related URLs</label>
                                        <select name="related_urls">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="URL1"
                                            {{ old('related_urls', $field->related_urls) == 'URL1' ? 'selected' : '' }}>
                                            URL1</option>
                                            <option value="URL2"
                                            {{ old('related_urls', $field->related_urls) == 'URL2' ? 'selected' : '' }}>
                                            URL2</option>
                                            <option value="URL3"
                                            {{ old('related_urls', $field->related_urls) == 'URL3' ? 'selected' : '' }}>
                                            URL3</option>
                                        </select>
                                    </div>
                                </div>





                             {{-- <div class="col-6">
                                    <div class="group-input">
                                        <label for="Attached File">Attached File</label>
                                        <div>
                                            <small class="text-primary">
                                                Please Attach all relevant or supporting documents
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="File_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="HOD_Attachments" name="Attachment[]"
                                                    oninput="addMultipleFiles(this, 'Attachment')" multiple>


                                            </div>
                                        </div>
                                    </div>
                                </div>--}}


                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Attached File">Attached File</label>
                                        <div>
                                            <small class="text-primary">
                                                Please Attach all relevant or supporting documents
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">

                                            <div class="file-attachment-list" id="file_attachment">
                                                @if ($field->file_attachment)
                                                    @foreach (json_decode($field->file_attachment) as $file)
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
                                                <input type="file" id="HOD_Attachments"
                                                    name="file_attachment[]"value="{{ $field->file_attachment }}"
                                                    oninput="addMultipleFiles(this, 'file_attachment')" multiple>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label  for="type">Zone</label>
                                       <select name="zone_type" {{ $field->stage == 0 || $field->stage == 6 ? 'disabled' : '' }}>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="asia" @if ($field->zone_type == "asia") selected @endif>Asia</option>
                                            <option value="europe" @if ($field->zone_type == "europe") selected @endif>Europe</option>
                                            <option value="africa" @if ($field->zone_type == "africa") selected @endif>Africa</option>
                                            <option value="central-america" @if ($field->zone_type == "central-america") selected @endif>Central America</option>
                                            <option value="south-america" @if ($field->zone_type == "south-america") selected @endif>South America</option>
                                            <option value="oceania" @if ($field->zone_type == "oceania") selected @endif>Oceania</option>
                                            <option value="north-america" @if ($field->zone_type == "north-america") selected @endif>North America</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <p class="text-primary">Auto filter according to selected zone</p>
                                        <select name="country" class="form-select country" aria-label="Default select example" onchange="loadStates()" {{ $field->stage == 0 || $field->stage == 6 ? 'disabled' : '' }}>
                                            <option value="{{ $field->country }}" selected>{{ $field->country }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Responsible Department">State/District</label>
                                        <p class="text-primary">Auto selected according to country</p>
                                        <select name="state" class="form-select state" aria-label="Default select example" onchange="loadCities()" {{ $field->stage == 0 || $field->stage == 6 ? 'disabled' : '' }}>
                                            <option value="{{ $field->state }}" selected>{{ $field->state }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>City</b></label>
                                        <p class="text-primary">Auto filter according to selected state</p>
                                        <select name="city" class="form-select city" aria-label="Default select example" {{ $field->stage == 0 || $field->stage == 6 ? 'disabled' : '' }}>
                                            <option value="{{ $field->city }}" selected>{{ $field->city }}</option>
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
                                        <label for="Type">Account Type</label>
                                        <select name="account_type">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="AT-1"
                                            {{ old('account_type', $field->account_type) == 'AT-1' ? 'selected' : '' }}>
                                            AT-1</option>
                                            <option value="AT-2"
                                            {{ old('account_type', $field->account_type) == 'AT-2' ? 'selected' : '' }}>
                                            AT-2</option>
                                            <option value="AT-3"
                                            {{ old('account_type', $field->account_type) == 'AT-3' ? 'selected' : '' }}>
                                            AT-3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Business Area">Business Area</label>
                                        <select name="business_area">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="B-1"
                                            {{ old('business_area', $field->business_area) == 'B-1' ? 'selected' : '' }}>
                                            B-1</option>
                                            <option value="B-2"
                                            {{ old('business_area', $field->business_area) == 'B-2' ? 'selected' : '' }}>
                                            B-2</option>
                                            <option value="B-3"
                                            {{ old('business_area', $field->business_area) == 'B-3' ? 'selected' : '' }}>
                                            B-3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Type">Category</label>
                                        <select name="category">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="'C-1"
                                            {{ old('category', $field->category) == 'C-1' ? 'selected' : '' }}>
                                            C-1</option>
                                            <option value="'C-2"
                                            {{ old('category', $field->category) == 'C-1' ? 'selected' : '' }}>
                                            C-2</option>
                                            <option value="'C-3"
                                            {{ old('category', $field->category) == 'C-1' ? 'selected' : '' }}>
                                            C-3</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Type">Sub Category</label>
                                        <select name="sub_category">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value=" C-1"
                                            {{ old('sub_category', $field->sub_category) == 'C-1' ? 'selected' : '' }}>
                                            C-1</option>
                                            <option value=" C-2"
                                            {{ old('sub_category', $field->sub_category) == 'C-2' ? 'selected' : '' }}>
                                            C-2</option>
                                            <option value="C-3"
                                            {{ old('sub_category', $field->sub_category) == 'C-3' ? 'selected' : '' }}>
                                            C-3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="broker_id">Broker ID</label>
                                        <input type="text" name="broker_id" value="{{ $field->broker_id}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Type">Related Inquiries</label>
                                        <select name="related_inquiries">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="Pankaj"
                                            {{ old('related_inquiries', $field->related_inquiries) == 'Pankaj' ? 'selected' : '' }}>
                                            Pankaj</option>
                                            <option value="Gaurav"
                                            {{ old('related_inquiries', $field->related_inquiries) == 'Gaurav' ? 'selected' : '' }}>
                                            Gaurav</option>
                                            <option value="Mayank"
                                            {{ old('related_inquiries', $field->related_inquiries) == 'Mayank' ? 'selected' : '' }}>
                                            Mayank</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label class="mt-4" for="Audit Comments">Comments</label>
                                        <textarea class="summernote" name="comments" id="summernote-16" >{{ old('comments', $field->comments) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label class="mt-4" for="Audit Comments">Actions Taken</label>
                                        <textarea class="summernote" name="action_taken" id="summernote-16">{{ old('action_taken', $field->action_taken) }}</textarea>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>


                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">Exit
                                        </a> </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="submitted by">Begin Reviewed by</label>
                                        <div class="">{{ $field->begin_reviewed_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="submitted by">Begin Reviewed on</label>
                                        <div class="">{{ $field->begin_reviewed_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="submitted by">Comment</label>
                                        <div class="">{{ $field->reviewd_comment }}</div>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="submitted by">Cancel by</label>
                                        <div class="">{{ $field->cancel_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="submitted by">Cancel on</label>
                                        <div class="">{{ $field->cancel_on }}</div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="submitted by">Comment</label>
                                        <div class="">{{ $field->comment }}</div>
                                    </div>
                                </div>
                                </div>


                                <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="submitted by">Completed By</label>
                                        <div class="">{{ $field->completed_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed on">Completed On</label>
                                        <div class="">{{ $field->completed_on}}</div>
                                        <div class="Date"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Completed on">Comment</label>
                                        <div class="">{{ $field->completed_comment}}</div>
                                        <div class="Date"></div>
                                    </div>
                                </div>
                            </div>

                                <div class="button-block">
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">Exit
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
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
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




<div class="modal fade" id="more-info-required-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="" method="POST">
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


<!-- signature model -->

<div class="modal fade" id="more-info-required-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="" method="POST">
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

{{-- cancel model --}}

<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('field_Cancel', $field->id) }}" method="POST">
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


            <form action="" method="POST">
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

            <form action="" method="POST">
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

            <form action="" method="POST">
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

            <form action="" method="POST">
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



<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('field_sends_stage', $field->id) }}" method="POST">
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
            <form action="" method="POST">
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

{{-- modal 1 --}}


<div class="modal fade" id="modal1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST">
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
