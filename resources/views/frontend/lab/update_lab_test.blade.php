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






    <div class="form-field-head">
        {{-- <div class="pr-id">
            New Child
        </div> --}}
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            / Lab Test
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $('#Equipment').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="ProductName[]"></td>' +
                        '<td><input type="number" name="BatchNumber[]"></td>' +
                        '<td><input type="date" name="ExpiryDate[]"></td>' +
                        '<td><input type="date" name="ManufacturedDate[]"></td>' +
                        '<td><input type="number" name="NumberOfItemsNeeded[]"></td>' +
                        '<td><input type="text" name="Exist[]"></td>' +
                        '<td><input type="text" name="Comment[]"></td>' +


                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' +

                    //     '</tr>';

                    return html;
                }

                var tableBody = $('#Equipment_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    @php
        $users = DB::table('users')->get();
    @endphp

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

                        <button class="button_theme1"> <a class="text-white" href="{{ url('lab_audit', $lab->id) }}">
                                Audit Trail </a> </button>

                        @if ($lab->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($lab->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Internal Product Test
                            </button>
                        @elseif($lab->stage == 3 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Not OK
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target=" #signature-modal">
                                OK Panel External Testing
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                OK External Testing
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                Demand Product Improvement
                            </button>
                        @elseif($lab->stage == 4 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                Demand Product Improvement
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Product Quality Validated
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Product Quality Not Validated
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                                Action Needed
                            </button>
                        @elseif($lab->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Conduct Product Conclusion
                            </button>
                        @elseif(
                            $lab->stage == 6 &&
                                (in_array(5, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))
                            <button class="button_theme1" data-bs-toggle="modal" name="widthrown"
                                data-bs-target="#signature-modal">
                                Review
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                Demand Product Improvement
                            </button>


                            {{-- @elseif($lab->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
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
                            {{-- @elseif($lab->stage == 6 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Document Completed
                            </button> --}}
                            <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                                                    Report Reject
                                                                    </button>
                                                                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qasend">
                                                                    Obsolete
                                                                    </button> -->

                            {{-- @elseif($lab->stage == 7 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
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
                        @elseif($lab->stage == 7 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
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
                    @if ($lab->stage == 0)
                        <div class="progress-bars ">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @elseif ($lab->stage == 8)
                        {{-- @if ($lab->stage == 6) --}}
                        <div class="progress-bars ">
                            <div class="bg-danger">Closed - Unsuccessful Products</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex" style="font-size: 15px;">

                            @if ($lab->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($lab->stage >= 2)
                                <div class="active"> Pending Internal Report</div>
                            @else
                                <div class=""> Pending Internal Report</div>
                            @endif

                            @if ($lab->stage >= 3)
                                <div class="active"> Draw Internal Test Conclusions</div>
                            @else
                                <div class=""> Draw Internal Test Conclusions</div>
                            @endif

                            @if ($lab->stage >= 4)
                                <div class="active"> Pending Conclusion</div>
                            @else
                                <div class=""> Pending Conclusion</div>
                            @endif



                            @if ($lab->stage >= 5)
                                <div class="active">Pending CEQ Action</div>
                            @else
                                <div class=""> Pending CEQ Action</div>
                            @endif
                            @if ($lab->stage >= 6)
                                <div class="active"> Pending Review</div>
                            @else
                                <div class=""> Pending Review</div>
                            @endif




                            @if ($lab->stage >= 7)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif
                            {{-- @endif --}}
                        </div>
                    @endif

                    {{-- ---------------------------------------------------------------------------------------- --}}
                </div>
            </div>




            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Lab Test</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Signature</button>

            </div>

            <script>
                $(document).ready(function() {
                    <?php if($lab->stage==7): ?>
                    $("#target :input").prop("disabled", true);
                    <?php  endif; ?>
                });
            </script>


            <script>
                $(document).ready(function() {
                    <?php if($lab->stage==8): ?>
                    $("#target :input").prop("disabled", true);
                    <?php  endif; ?>
                });
            </script>

            <form id="target" action="{{ route('lab.update', $lab->id) }}" method="POST"
                enctype="multipart/form-data">
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
                                        <label for="originator">Originator</label>
                                        <input disabled type="text" name="originator_id"
                                            value="{{ $lab->originator_id ?? Auth::user()->name }}">

                                        {{-- <input disabled type="text" name="originator_id" value="" >  --}}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date Opened</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Product">Product</label>
                                        <input type="text" name="product" id="product" value="{{ $lab->product }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/LT/{{ date('Y') }}/{{ $record_number }}">
                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                    </div>
                                </div>



                                {{--  {{  -- // <div class="col-lg-6">
                            //         <div class="group-input">
                            //             <label for="RLS Record Number"><b>Record Number</b></label>
                            //             <input disabled type="text" name="record_number"
                            //             value="{{ Helpers::getDivisionName($lab->division_id) }}/LT/{{ Helpers::year($lab->created_at) }}/{{ $lab->record }}">
                            //             {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div>
                            //         </div>
                            // </div> --}}


                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span class="text-danger">*</span>
                                            <input id="short_description" type="text" name="short_description"
                                                value="{{ $lab->short_description }}" maxlength="255" required>


                                            {{-- <label for="Short Description">Short Description</label>
                                    <input type="text" name="short_description" id="short_description" value=""> --}}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="If Others">Assigned To</label>
                                        <select name="assigned_to" onchange="">

                                            <option value="">Select a value</option>
                                            <option value="">-- select --</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        @if (isset($lab->assigned_to) && $lab->assigned_to == $user->id) selected @endif>
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
                                                $labDueDate = new \DateTime($lab->due_date);
                                            @endphp
                                            {{-- Format the date as desired --}}
                                            <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                                value="{{ $labDueDate->format('j-F-Y') }}" />
                                            <input type="date" name="due_date"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                value="{{ $lab->due_date }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>

                                {{-- ==============================================due date================================================== --}}


                                {{-- <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Due Date">Date Due</label>

                                    <div class="calenderauditee">

                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />

                                                 @php
                                                    $lab = new DateTime($lab->due_date);
                                                @endphp
                                                 Format the date as desired
                                                 <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                                    value="{{ $lab->format('j-F-Y') }}" />
                                                <input type="date" name="due_date"
                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    value="{{ $lab->due_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'due_date')" />

                                         <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                     </div>


                                </div>
                            </div> --}}




                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Priority Level">Priority Level</label>
                                        <select name="priority_level" onchange="">
                                            <option value="priority_level">-- select --</option>

                                            <option value="level1"
                                                {{ old('priority_level', $lab->priority_level) == 'level1' ? 'selected' : '' }}>
                                                level 1</option>
                                            <option value="level2"
                                                {{ old('priority_level', $lab->priority_level) == 'level2' ? 'selected' : '' }}>
                                                level 2</option>
                                            <option value="level3"
                                                {{ old('priority_level', $lab->priority_level) == 'level3' ? 'selected' : '' }}>
                                                level 3</option>
                                            {{-- <option value="level1">level 1</option>
                                        <option value="level2">level 2</option>
                                        <option value="level3">level 3</option> --}}

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Type of Product">Type of Product</label>
                                        <select name="type_of_product" onchange="">

                                            <option value="">-- select --</option>
                                            <option value="Product1"
                                                {{ old('type_of_product', $lab->type_of_product) == 'Product1' ? 'selected' : '' }}>
                                                Product 1</option>
                                            <option value="Product2"
                                                {{ old('type_of_product', $lab->type_of_product) == 'Product2' ? 'selected' : '' }}>
                                                Product 2</option>
                                            <option value="Product3"
                                                {{ old('type_of_product', $lab->type_of_product) == 'Product3' ? 'selected' : '' }}>
                                                Product 3</option>



                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Internal Product Test Info.">Internal Product Test Info</label>
                                        <textarea class="" name="internal_product_test_info" id="">{{ old('internal_product_test_info', $lab->internal_product_test_info) }}
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Comments">Comments</label>
                                        <textarea class="" name="comments" id="">{{ old('comments', $lab->comments) }}
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Internal Test Conclusion">Internal Test Conclusion</label>
                                        <textarea class="" name="internal_test_conclusion" id="">{{ old('internal_test_conclusion', $lab->internal_test_conclusion) }}
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Reviewer Comments">Reviewer Comments</label>
                                        <textarea class="" name="reviewer_comments" id="">{{ old('reviewer_comments', $lab->reviewer_comments) }}
                                    </textarea>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Action Summary">Action Summary</label>
                                        <textarea class="" name="action_summary" id="">{{ old('action_summary', $lab->action_summary) }}
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Lab Test Summary">Lab Test Summary</label>
                                        <textarea class="" name="lab_test_summary" id="">{{ old('lab_test_summary', $lab->lab_test_summary) }}
                                    </textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Attached File">Attached File</label>
                                        <div>
                                            <small class="text-primary">
                                                Please Attach all relevant or supporting documents
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">

                                            <div class="file-attachment-list" id="file_attachment">
                                                @if ($lab->file_attachment)
                                                    @foreach (json_decode($lab->file_attachment) as $file)
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
                                                    name="file_attachment[]"value="{{ $lab->file_attachment }}"
                                                    oninput="addMultipleFiles(this, 'file_attachment')" multiple>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Related URLs">Related URLs</label>
                                        <select name="related_urls" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="URL1"
                                                {{ old('related_urls', $lab->related_urls) == 'URL1' ? 'selected' : '' }}>
                                                URL 1</option>
                                            <option value="URL2"
                                                {{ old('related_urls', $lab->related_urls) == 'URL2' ? 'selected' : '' }}>
                                                URL 2</option>
                                            <option value="URL3"
                                                {{ old('related_urls', $lab->related_urls) == 'URL3' ? 'selected' : '' }}>
                                                URL 3</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Related Records">Related Records</label>
                                        <select name="related_records" onchange="">
                                            <option value="">-- select --</option>
                                            <option value="Record1"
                                                {{ old('related_records', $lab->related_records) == 'Record1' ? 'selected' : '' }}>
                                                Record 1</option>
                                            <option value="Record2"
                                                {{ old('related_records', $lab->related_records) == 'Record2' ? 'selected' : '' }}>
                                                Record 2</option>
                                            <option value="Record3"
                                                {{ old('related_records', $lab->related_records) == 'Record3' ? 'selected' : '' }}>
                                                Record 3</option>

                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">

                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white"
                                        href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>
                        </div>
                    </div>
                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Activity Log
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="submitted_by">Submitted by</label>

                                        <div class="">{{ $lab->submitted_by }}</div>
                                    </div>

                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="submitted_on">Submitted on</label>
                                        <div class="">{{ $lab->submitted_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="comment">Comment</label>
                                        <div class="">{{ $lab->comment }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="cancel_by">Cancel By</label>
                                        <div class="">{{ $lab->cancel_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="cancel_on">Cancel on</label>
                                        <div class="">{{ $lab->cancel_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="cancel_comment">Comment</label>
                                        <div class="">{{ $lab->cancel_comment }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="internal_product_test_submitted_by">Internal Product Test Submitted
                                            by</label>
                                        <div class="">{{ $lab->internal_product_test_submitted_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="internal_product_test_submitted_on">Internal Product Test Submitted
                                            on</label>
                                        <div class="">{{ $lab->internal_product_test_submitted_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="comment_internal_product">Comment</label>
                                        <div class="">{{ $lab->comment_internal_product }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="demand_product_improvement_rejected_by">Demand Product Improvement
                                            By</label>
                                        <div class="">{{ $lab->demand_product_improvement_rejected_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="demand_product_improvement_rejected_on">Demand Product Improvement
                                            on</label>
                                        <div class="">{{ $lab->demand_product_improvement_rejected_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="demand_improvement_comment">Comment</label>
                                        <div class="">{{ $lab->demand_improvement_comment }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="not_ok_cancel_by">Not OK by</label>
                                        <div class="">{{ $lab->not_ok_cancel_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="not_ok_cancel_on">Not OK on</label>
                                        <div class="">{{ $lab->not_ok_cancel_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="not_ok_cancel_comment">Comment</label>
                                        <div class="">{{ $lab->not_ok_cancel_comment }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="ok_external_testing_submitted_by">OK External Testing By</label>
                                        <div class="">{{ $lab->ok_external_testing_submitted_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="ok_external_testing_submitted_on">OK External Testing on</label>
                                        <div class="">{{ $lab->ok_external_testing_submitted_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="ok_external_testing_comment">Comment</label>
                                        <div class="">{{ $lab->ok_external_testing_comment }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="ok_panel_testing_submitted_by">OK Panel External Testing by</label>
                                        <div class="">{{ $lab->ok_panel_testing_submitted_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="ok_panel_testing_submitted_on">OK Panel External Testing on</label>
                                        <div class="">{{ $lab->ok_panel_testing_submitted_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="ok_panel_testing_comment">Comment</label>
                                        <div class="">{{ $lab->ok_panel_testing_comment }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="product_quality_validated_submitted_by">Product Quality Validated
                                            By</label>
                                        <div class="">{{ $lab->product_quality_validated_submitted_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="product_quality_validated_submitted_on">Product Quality Validated
                                            on</label>
                                        <div class="">{{ $lab->product_quality_validated_submitted_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="product_quality_validated_comment">Comment</label>
                                        <div class="">{{ $lab->product_quality_validated_comment }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="product_quality_not_validated_by">Product Quality Not Validated
                                            by</label>
                                        <div class="">{{ $lab->product_quality_not_validated_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="product_quality_not_validated_on">Product Quality Not Validated
                                            on</label>
                                        <div class="">{{ $lab->product_quality_not_validated_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="product_quality_not_validated_comment">Comment</label>
                                        <div class="">{{ $lab->product_quality_not_validated_comment }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="action_needed_submitted_by">Action Needed By</label>
                                        <div class="">{{ $lab->action_needed_submitted_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="action_needed_submitted_on">Action Needed on</label>
                                        <div class="">{{ $lab->action_needed_submitted_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="action_needed_comment">Comment</label>
                                        <div class="">{{ $lab->action_needed_comment }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="demand_product_improvement_rejected_by">Demand Product Improvement
                                            by</label>
                                        <div class="">{{ $lab->demand_product_improvement_rejected_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="demand_product_improvement_rejected_on">Demand Product Improvement
                                            on</label>
                                        <div class="">{{ $lab->demand_product_improvement_rejected_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="demand_product_improvement_comment">Comment</label>
                                        <div class="">{{ $lab->demand_product_improvement_comment }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="conduct_product_conclusion_submitted_by">Conduct Product Conclusion
                                            by</label>
                                        <div class="">{{ $lab->conduct_product_conclusion_submitted_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="conduct_product_conclusion_submitted_on">Conduct Product Conclusion
                                            on</label>
                                        <div class="">{{ $lab->conduct_product_conclusion_submitted_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="conduct_product_conclusion_comment">Comment</label>
                                        <div class="">{{ $lab->conduct_product_conclusion_comment }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="reviewed_closed_by">Reviewed By</label>
                                        <div class="">{{ $lab->reviewed_closed_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="reviewed_closed_on">Reviewed on</label>
                                        <div class="">{{ $lab->reviewed_closed_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="reviewed_closed_comment">Comment</label>
                                        <div class="">{{ $lab->reviewed_closed_comment }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="demand_product_improvement_rejected_by_2">Demand Product Improvement
                                            by</label>
                                        <div class="">{{ $lab->demand_product_improvement_rejected_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="demand_product_improvement_rejected_on_2">Demand Product Improvement
                                            on</label>
                                        <div class="">{{ $lab->demand_product_improvement_rejected_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="demand_product_comment">Comment</label>
                                        <div class="">{{ $lab->demand_product_comment }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button">
                                    <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="more-info-required-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('lab_test_reject', $lab->id) }}" method="POST">
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

                <form action="{{ route('lab_qa_more_info', $lab->id) }}" method="POST">
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

                <form action="{{ route('lab_Cancel', $lab->id) }}" method="POST">
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


                <form action="{{ url('deviationIsCFTRequired', $lab->id) }}" method="POST">
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

                <form action="{{ route('check', $lab->id) }}" method="POST">
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

                <form action="{{ route('check2', $lab->id) }}" method="POST">
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

                <form action="{{ route('check3', $lab->id) }}" method="POST">
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
            <form action="{{ route('np_child_1', $lab->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        @if ($national->stage == 2)
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
                            Correspondence
                        </label>
                        <label for="major">
                            <input type="radio" name="child_type" id="major" value="osur">
                            PSUR
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
</div> --}}


    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('lab_send_stage', $lab->id) }}" method="POST">
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
                <form action="{{ route('qanotreqired', $lab->id) }}" method="POST">
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
                <form action="{{ route('lab_qa_more_info', $lab->id) }}" method="POST">
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


@endsection
