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

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(9) {
            border-radius: 0px 20px 20px 0px;

        }
    </style>
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }

        .sub-main-head {
            display: flex;
            justify-content: space-evenly;
        }

        .Activity-type {
            margin-bottom: 7px;
        }

        /* .sub-head {
            margin-left: 280px;
            margin-right: 280px;
            color: #4274da;
            border-bottom: 2px solid #4274da;
            padding-bottom: 5px;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 1.2rem;

        } */
        .launch_extension {
            background: #4274da;
            color: white;
            border: 0;
            padding: 4px 15px;
            border: 1px solid #4274da;
            transition: all 0.3s linear;
        }
        .main_head_modal li {
            margin-bottom: 10px;
        }

        .extension_modal_signature {
            display: block;
            width: 100%;
            border: 1px solid #837f7f;
            border-radius: 5px;
        }

        .main_head_modal {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .create-entity {
            background: #323c50;
            padding: 10px 15px;
            color: white;
            margin-bottom: 20px;

        }

        .bottom-buttons {
            display: flex;
            justify-content: flex-end;
            margin-right: 300px;
            margin-top: 50px;
            gap: 20px;
        }

        .text-danger {
            margin-top: -22px;
            padding: 4px;
            margin-bottom: 3px;
        }

        /* .saveButton:disabled{
                background: black!important;
                border:  black!important;

            } */

        .main-danger-block {
            display: flex;
        }

        .swal-modal {
            scale: 0.7 !important;
        }

        .swal-icon {
            scale: 0.8 !important;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @if (Session::has('swal'))
        <script>
            swal("{{ Session::get('swal')['title'] }}", "{{ Session::get('swal')['message'] }}",
                "{{ Session::get('swal')['type'] }}")
        </script>
    @endif

<div class="form-field-head">
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / Product Recall
    </div>
</div>


<div id="change-control-fields">
    <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow </div>

                    <div class="d-flex" style="gap:20px;">
                        @php
                            $userRoles = DB::table('user_roles')
                                ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => 1])
                                ->get();
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        @endphp
                        
                            <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/product-recall-audit', $data->id) }}">Audit Trail </a> </button>

                        @if ($data->stage == 1 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif ($data->stage == 2 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#send-to-initiator">
                                More Info Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Acknowledge
                            </button>
                        @elseif ($data->stage == 3 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Memo Initation Complete
                            </button>
                        @elseif ($data->stage == 4 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Notification Complete
                            </button>
                        @elseif ($data->stage == 5 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Third Party Involved
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#send-to-pending-final-approval">
                                Recall Complete
                            </button>
                        @elseif ($data->stage == 6 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Feedback Complete
                            </button>
                        @elseif ($data->stage == 7 && (in_array(18, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#send-to-recall-inprogress">
                                More Info Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Final Approval
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#send-to-closerejected">
                                Reject Recall
                            </button>
                        @endif
                            <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                    </div>

                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex" style="font-size: 15px;">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active">Pending Review</div>
                            @else
                                <div class="">Pending Review</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">Memo Initiation In Progress</div>
                            @else
                                <div class="">Memo Initiation In Progress</div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="active">Notification In Progress</div>
                            @else
                                <div class="">Notification In Progress</div>
                            @endif

                            @if ($data->stage >= 5)
                                <div class="active">Recall In Progress</div>
                            @else
                                <div class="">Recall In Progress</div>
                            @endif

                            @if ($data->stage >= 6)
                                <div class="active">Awaiting Feedback</div>
                            @else
                                <div class="">Awaiting Feedback</div>
                            @endif

                            @if ($data->stage >= 7)
                                <div class="active">Pending Final Approval</div>
                            @else
                                <div class="">Pending Final Approval</div>
                            @endif

                            @if ($data->stage >= 8)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif

                            @if ($data->stage == 8)
                                <div class="bg-danger" style="display: none;">Closed - Rejected</div>
                            @elseif ($data->stage == 9)
                                <div class="bg-danger">Closed - Rejected</div>
                            @else
                                <div class="">Closed - Rejected</div>
                            @endif
                    @endif
                </div>
            </div>
            </div>


        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Recall</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm2')">Notification Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>
        </div>

        <form action="{{ route('update-product-recall', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" id="parent_id" value="{{ $data->parent_id }}">
                <input type="hidden" name="parent_type" id="parent_type" value="{{ $data->parent_type }}">
                @endif

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Originator"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number" value="{{$data->record}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Originator"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator_id" id="initiator_id" value="{{ $data->initiator_name }}">
                                </div>
                            </div>

                            @php
                                // Calculate the due date (30 days from the initiation date)
                                $initiationDate = date('Y-m-d'); // Current date as initiation date
                                $dueDate = date('Y-m-d', strtotime($initiationDate . '+30 days')); // Due date
                            @endphp

                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date Of Initiation</b></label>
                                    <input readonly type="text" value="{{ date('d-M-Y') }}"
                                            style="background-color: light-dark(rgba(239, 239, 239, 0.3), rgba(59, 59, 59, 0.3))">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="initiation_date_hidden">
                                </div>
                            </div> -->

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Product<span class="text-danger">*</span></label>
                                    <input id="docname" type="text" name="product_name" id="product_name" value="{{ $data->product_name }}" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label>
                                    <input id="docname" type="text" name="short_description" id="short_description" value="{{ $data->short_description }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search"> Assigned To <span class="text-danger"></span></label>
                                    <select id="select-state" name="assign_to" id="assign_to">
                                        <option value="">Select a value</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" @if( $user->id == $data->assign_to) selected @endif>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Due Date">Due Date</label>
                                    <div><small class="text-primary">If revising Due Date, kindly mention revision
                                            reason in "Due Date Extension Justification" data field.</small></div>
                                    <div class="calenderauditee">
                                        <input readonly type="text" value="{{ Helpers::getdateFormat($data->due_date) }}" name="due_date" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                            oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>

                                <script>
                                    var dueDate = "{{ $dueDate }}";
                                    var date = new Date(dueDate);

                                    // Array of month names
                                    var monthNames = [
                                        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                                    ];

                                    // Extracting day, month, and year from the date
                                    var day = date.getDate().toString().padStart(2, '0'); // Ensuring two digits
                                    var monthIndex = date.getMonth();
                                    var year = date.getFullYear();

                                    // Formatting the date in "dd-MMM-yyyy" format
                                    var dueDateFormatted = `${day}-${monthNames[monthIndex]}-${year}`;

                                    // Set the formatted due date value to the input field
                                    document.getElementById('due_date').value = dueDateFormatted;
                                </script>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="recalled_from">Recalled From</label>
                                  <input name="recalled_from" type="text" id="recalled_from" value="{{ $data->recalled_from }}" placeholder="Recalled From" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="priority_level">Priority Level</label>
                                    <select id="priority_level" name="priority_level">
                                        <option value="">Select Your Selection Here</option>
                                        <option value="Low" @if($data->priority_level == "Low") selected @endif>Low</option>
                                        <option value="Medium" @if($data->priority_level == "Medium") selected @endif>Medium</option>
                                        <option value="High" @if($data->priority_level == "High") selected @endif>High</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="recalled_by">Recalled By</label>
                                    <select name="recalled_by" id="recalled_by">
                                        <option value="">-- Select --</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" @if( $user->id == $data->recalled_by) selected @endif>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
        
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="contact_person">Contact Person</label>
                                    <select name="contact_person" id="contact_person">
                                        <option value="">-- Select --</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" @if( $user->id == $data->contact_person) selected @endif>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="related_product">Other Related Products</label>
                                    <select name="related_product" id="related_product">
                                        <option value="">-- Select --</option>
                                        <option value="1" @if($data->related_product == 1) selected @endif>P-1</option>
                                        <option value="2" @if($data->related_product == 2) selected @endif>P-2</option>
                                        <option value="3" @if($data->related_product == 3) selected @endif>P-3</option>
                                        <option value="4" @if($data->related_product == 4) selected @endif>P-4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments"> Reason For Recall</label>
                                    <textarea class="summernote" name="recall_reason" id="summernote-16" value="{{ $data-> recall_reason }}">{{ $data-> recall_reason }}</textarea>
                                </div>
                            </div>                            
                           
                            <div class="col-6 new-date-data-field mt-4">
                                <div class="group-input input-date">
                                    <label for="Initiator Group">Scheduled Start Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="schedule_start_date" readonly placeholder="DD-MMM-YYYY"
                                            value="{{ Helpers::getdateFormat($data->schedule_start_date) }}" />
                                        <input type="date" name="schedule_start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="{{ $data->schedule_start_date }}" class="hide-input" oninput="handleDateInput(this, 'schedule_start_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 new-date-data-field mt-4">
                                <div class="group-input input-date">
                                    <label for="schedule_end_date">Scheduled End Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="schedule_end_date" readonly placeholder="DD-MMM-YYYY"
                                            value="{{ Helpers::getdateFormat($data->schedule_end_date) }}" />
                                        <input type="date" name="schedule_end_date" value="{{ $data->schedule_end_date }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                            oninput="handleDateInput(this, 'schedule_end_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="department_code">Departments</label>
                                    <select multiple id="department_code" name="department_code[]" >
                                        <option value="">--Select---</option>
                                        <option value="Department-1" {{ strpos($data->department_code, 'Department-1') !== false ? 'selected' : '' }}>Department 1</option>
                                        <option value="Department-2" {{ strpos($data->department_code, 'Department-2') !== false ? 'selected' : '' }}>Department 2</option>
                                        <option value="Department-3" {{ strpos($data->department_code, 'Department-3') !== false ? 'selected' : '' }}>Department 3</option>
                                        <option value="Department-4" {{ strpos($data->department_code, 'Department-4') !== false ? 'selected' : '' }}>Department 4</option>
                                    </select> 
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="team_members">Team Members</label>
                                    <select multiple id="team_members" name="team_members[]">
                                        <option value="">--Select---</option>                                        
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ strpos($data->team_members, $user->id) !== false ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="bussiness_area">Business Area</label>
                                    <select name="bussiness_area" id="bussiness_area">
                                        <option value="">-- Select --</option>
                                        <option value="Area-1" @if($data->bussiness_area == "Area-1") selected @endif>Area-1</option>
                                        <option value="Area-2" @if($data->bussiness_area == "Area-2") selected @endif>Area-2</option>
                                        <option value="Area-3" @if($data->bussiness_area == "Area-3") selected @endif>Area-3</option>
                                        <option value="Area-4" @if($data->bussiness_area == "Area-4") selected @endif>Area-4</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="estimate_man_hours">Estimated Man-Hours</label>
                                    <select name="estimate_man_hours" id="estimate_man_hours">
                                        <option value="">-- Select --</option>
                                        <option value="1" @if($data->estimate_man_hours == 1) selected @endif>Hour 1</option>
                                        <option value="2" @if($data->estimate_man_hours == 2) selected @endif>Hour 2</option>
                                        <option value="3" @if($data->estimate_man_hours == 3) selected @endif>Hour 3</option>
                                        <option value="4" @if($data->estimate_man_hours == 4) selected @endif>Hour 4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Attachments">Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Attachment">
                                            @if ($data->Attachment)
                                                @foreach (json_decode($data->Attachment) as $file)
                                                    <h6 class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a class="remove-file" data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="Attachment" name="Attachment[]" oninput="addMultipleFiles(this, 'Attachment')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="related_urls">Related URLs</label>
                                    <input type="text" name="related_urls"  id="related_urls" placeholder="Enter URL Here">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Reference Recores"> Related Records</label>
                                    <select multiple id="reference_record" name="reference_record[]">
                                        <option value="">--Select---</option>
                                        <option value="1" {{ strpos($data->reference_record, '1') !== false ? 'selected' : '' }}>Record 1</option>
                                        <option value="2" {{ strpos($data->reference_record, '2') !== false ? 'selected' : '' }}>Record 2</option>
                                        <option value="3" {{ strpos($data->reference_record, '3') !== false ? 'selected' : '' }}>Record 3</option>
                                        <option value="4" {{ strpos($data->reference_record, '4') !== false ? 'selected' : '' }}>Record 4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Comments"> Comments</label>
                                    <textarea class="summernote" name="comments" id="summernote-16" value="{{ $data->comments }}">{{ $data->comments }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                           
                        <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="franchise_store_manager">Franchise Store Manager</label>
                                    <select name="franchise_store_manager" id="franchise_store_manager">
                                        <option value="">-- Select --</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" @if( $user->id == $data->franchise_store_manager) selected @endif>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Warehouse Manager">Warehouse Manager</label>
                                    <select name="warehouse_manager" id="warehouse_manager">
                                        <option value="">-- Select --</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" @if( $user->id == $data->warehouse_manager) selected @endif>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="ena_store_manager">ENA Store Manager</label>
                                    <select name="ena_store_manager"  id="ena_store_manager">
                                        <option value="">-- Select --</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" @if( $user->id == $data->ena_store_manager) selected @endif>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="ab_store_manager">AB Store Manager</label>
                                    <select name="ab_store_manager" id="ab_store_manager">
                                        <option value="">-- Select --</option>
                                        @if(!empty($users))
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" @if( $user->id == $data->ab_store_manager) selected @endif>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>


                            <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>                            
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit </a> </button>
                            </div>
                        </div>
                    </div>
                </div>
            

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted by">Submitted By</label>
                                    <div class="static">@if($data->submitted_by) {{ $data->submitted_by }} @else Not Applicable @endif</div>
                                </div>  
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Submitted On</label>
                                    <div class="Date">@if($data->submitted_on) {{ $data->submitted_on }} @else Not Applicable @endif</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Submitted Comment</label>
                                    <div class="Date">@if($data->submitted_comment) {{ $data->submitted_comment }} @else Not Applicable @endif</div>
                                </div>
                            </div>

                            <!-- Pending Review By -->
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted by">Pending Review By</label>
                                    <div class="static">@if($data->pending_review_by) {{ $data->pending_review_by }} @else Not Applicable @endif</div>
                                </div>  
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Pending Review On</label>
                                    <div class="Date">@if($data->pending_review_on) {{ $data->pending_review_on }} @else Not Applicable @endif</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Comment</label>
                                    <div class="Date">@if($data->pending_review_comment) {{ $data->pending_review_comment }} @else Not Applicable @endif</div>
                                </div>
                            </div>

                            <!-- Memo Initiattion  -->
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted by">Memo Initiation By</label>
                                    <div class="static">@if($data->memo_initiation_by) {{ $data->memo_initiation_by }} @else Not Applicable @endif</div>
                                </div>  
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Memo Initation On</label>
                                    <div class="Date">@if($data->memo_initiation_on) {{ $data->memo_initiation_on }} @else Not Applicable @endif</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Comment</label>
                                    <div class="Date">@if($data->memo_initiation_comment) {{ $data->memo_initiation_comment }} @else Not Applicable @endif</div>
                                </div>
                            </div>

                            <!-- Notification info -->
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted by">Notification By</label>
                                    <div class="static">@if($data->notification_by) {{ $data->notification_by }} @else Not Applicable @endif</div>
                                </div>  
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Notification On</label>
                                    <div class="Date">@if($data->notification_on) {{ $data->notification_on }} @else Not Applicable @endif</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Comment</label>
                                    <div class="Date">@if($data->notification_comment) {{ $data->notification_comment }} @else Not Applicable @endif</div>
                                </div>
                            </div>


                            <!-- recall Inprogress -->
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted by">Recall By</label>
                                    <div class="static">@if($data->recall_inprogress_by) {{ $data->recall_inprogress_by }} @else Not Applicable @endif</div>
                                </div>  
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Recall On</label>
                                    <div class="Date">@if($data->recall_inprogress_on) {{ $data->recall_inprogress_on }} @else Not Applicable @endif</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Comment</label>
                                    <div class="Date">@if($data->recall_inprogress_comment) {{ $data->recall_inprogress_comment }} @else Not Applicable @endif</div>
                                </div>
                            </div>


                            <!-- Awaiting Feedback -->
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted by">Feedback By</label>
                                    <div class="static">@if($data->awaiting_feedback_by) {{ $data->awaiting_feedback_by }} @else Not Applicable @endif</div>
                                </div>  
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Feedback On</label>
                                    <div class="Date">@if($data->awaiting_feedback_on) {{ $data->awaiting_feedback_on }} @else Not Applicable @endif</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Comment</label>
                                    <div class="Date">@if($data->awaiting_feedback_comment) {{ $data->awaiting_feedback_comment }} @else Not Applicable @endif</div>
                                </div>
                            </div>


                            <!-- Pending Final Approval -->
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted by">Final Approval By</label>
                                    <div class="static">@if($data->pending_final_approval_by) {{ $data->pending_final_approval_by }} @else Not Applicable @endif</div>
                                </div>  
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Final Approval On</label>
                                    <div class="Date">@if($data->pending_final_approval_on) {{ $data->pending_final_approval_on }} @else Not Applicable @endif</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Comment</label>
                                    <div class="Date">@if($data->pending_final_approval_comment) {{ $data->pending_final_approval_comment }} @else Not Applicable @endif</div>
                                </div>
                            </div>


                            <!-- Reject Recall -->
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted by">Reject Recall By</label>
                                    <div class="static">@if($data->reject_recall_by) {{ $data->reject_recall_by }} @else Not Applicable @endif</div>
                                </div>  
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Reject Recall On</label>
                                    <div class="Date">@if($data->reject_recall_on) {{ $data->reject_recall_on }} @else Not Applicable @endif</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Comment</label>
                                    <div class="Date">@if($data->reject_recall_comment) {{ $data->reject_recall_comment }} @else Not Applicable @endif</div>
                                </div>
                            </div>


                            <!-- Initiator -->
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted by">Opened By</label>
                                    <div class="static">@if($data->send_to_initator_by) {{ $data->send_to_initator_by }} @else Not Applicable @endif</div>
                                </div>  
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Opened On</label>
                                    <div class="Date">@if($data->send_to_initator_on) {{ $data->send_to_initator_on }} @else Not Applicable @endif</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Comment</label>
                                    <div class="Date">@if($data->send_to_initator_comment) {{ $data->send_to_initator_comment }} @else Not Applicable @endif</div>
                                </div>
                            </div>


                            <!-- Recall Completed -->
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted by">Recall Completed By</label>
                                    <div class="static">@if($data->recall_completed_by) {{ $data->recall_completed_by }} @else Not Applicable @endif</div>
                                </div>  
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Recall Completed On</label>
                                    <div class="Date">@if($data->recall_completed_on) {{ $data->recall_completed_on }} @else Not Applicable @endif</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Comment</label>
                                    <div class="Date">@if($data->recall_completed_comment) {{ $data->recall_completed_comment }} @else Not Applicable @endif</div>
                                </div>
                            </div>


                            <div class="button-block mt-4">
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a></button>
                            </div>
                        </div>
                    </div>
                </div>
        </form>

        <div class="modal fade" id="signature-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ url('rcms/product-recall-stage', $data->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3 text-justify">
                                Please select a meaning and a outcome for this task and enter your username
                                and password for this task. You are performing an electronic signature,
                                which is legally binding equivalent of a hand written signature.
                            </div>
                            <div class="group-input mt-3">
                                <label for="username">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control">
                            </div>
                            <div class="group-input mt-3">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="group-input mt-3">
                                <label for="comment">Comment</label>
                                <input type="comment" name="comments" class="form-control">
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="send-to-initiator">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ url('rcms/send-to-intiator', $data->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3 text-justify">
                                Please select a meaning and a outcome for this task and enter your username
                                and password for this task. You are performing an electronic signature,
                                which is legally binding equivalent of a hand written signature.
                            </div>
                            <div class="group-input mt-3">
                                <label for="username">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control">
                            </div>
                            <div class="group-input mt-3">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="group-input mt-3">
                                <label for="comment">Comment</label>
                                <input type="comment" name="comments" class="form-control">
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="send-to-recall-inprogress">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ url('rcms/send-to-recall-inprogress', $data->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3 text-justify">
                                Please select a meaning and a outcome for this task and enter your username
                                and password for this task. You are performing an electronic signature,
                                which is legally binding equivalent of a hand written signature.
                            </div>
                            <div class="group-input mt-3">
                                <label for="username">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control">
                            </div>
                            <div class="group-input mt-3">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="group-input mt-3">
                                <label for="comment">Comment</label>
                                <input type="comment" name="comments" class="form-control">
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        <div class="modal fade" id="send-to-closerejected">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ url('rcms/send-to-closerejected', $data->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3 text-justify">
                                Please select a meaning and a outcome for this task and enter your username
                                and password for this task. You are performing an electronic signature,
                                which is legally binding equivalent of a hand written signature.
                            </div>
                            <div class="group-input">
                                <label for="username">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username">
                            </div>
                            <div class="group-input">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password">
                            </div>
                            <div class="group-input">
                                <label for="comment">Comment</label>
                                <input type="comment" name="comments">
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="send-to-pending-final-approval">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ url('rcms/send-to-pending-final-approval', $data->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3 text-justify">
                                Please select a meaning and a outcome for this task and enter your username
                                and password for this task. You are performing an electronic signature,
                                which is legally binding equivalent of a hand written signature.
                            </div>
                            <div class="group-input mt-3">
                                <label for="username">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control">
                            </div>
                            <div class="group-input mt-3">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="group-input mt-3">
                                <label for="comment">Comment</label>
                                <input type="comment" name="comments" class="form-control">
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
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
            /* Check if there is a next step */
        if (currentStep < steps.length - 1) {

            /* Hide current step  */
            steps[currentStep].style.display = "none";

            /* Show next step */
            steps[currentStep + 1].style.display = "block";

            /* Add active class to next button */
            stepButtons[currentStep + 1].classList.add("active");

            /* Remove active class from current button */
            stepButtons[currentStep].classList.remove("active");

            /* Update current step */
            currentStep++;
        }
    }

    function previousStep() {
            /* Check if there is a previous step */
        if (currentStep > 0) {

            /* Hide current step */
            steps[currentStep].style.display = "none";

            /* Show previous step */
            steps[currentStep - 1].style.display = "block";

            /* Add active class to previous button */
            stepButtons[currentStep - 1].classList.add("active");

            /* Remove active class from current button */
            stepButtons[currentStep].classList.remove("active");

            /* Update current step */
            currentStep--;
        }
    }
</script>

<script>
    VirtualSelect.init({
        ele: '#reference_record, #notify_to, #department_code, #team_members'
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
@endsection