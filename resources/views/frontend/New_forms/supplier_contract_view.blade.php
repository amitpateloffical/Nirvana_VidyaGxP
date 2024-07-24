@extends('frontend.layout.main')
@section('container')

    {{-- {{ $contract_data->stage == 0 || $contract_data->stage == 6 ? 'disabled' : '' }} --}}
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
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
                        '<td><input type="text" name="financial_transaction[' + serialNumber +
                        '][Transaction]"></td>' +
                        '<td><input type="text" name="financial_transaction[' + serialNumber +
                        '][TransactionType]"></td>' +
                        '<td><input type="date" name="financial_transaction[' + serialNumber +
                        '][Date]"></td>' +
                        '<td><input type="number" name="financial_transaction[' + serialNumber +
                        '][Amount]"></td>' +
                        '<td><input type="text" name="financial_transaction[' + serialNumber +
                        '][CurrencyUsed]"></td>' +
                        '<td><input type="text" name="financial_transaction[' + serialNumber +
                        '][Remarks]"></td>' +
                        '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +

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


    <div class="form-field-head">
        {{-- <div class="pr-id">
        New Child
    </div> --}}
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            / Supplier Contract
        </div>
    </div>



    {{-- workflow css start --}}
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

        .new_style {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        #change-control-view>div.container-fluid>div.inner-block.state-block>div.status>div.progress-bars>div.canceled {
            border-radius: 20px;
        }

        /*element.style{
                border-radius:10px;
                }*/
    </style>

    {{-- workflow css end --}}

    {{-- workflow --}}

    <div id="change-control-view">
        <div class="container-fluid">
            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow</div>

                    <div class="d-flex" style="gap:20px;">
                        @php
                            $userRoles = DB::table('user_roles')
                                ->where([
                                    'user_id' => auth()->id(),
                                    'q_m_s_divisions_id' => $contract_data->division_id,
                                ])
                                ->get();
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        @endphp
                        <button class="button_theme1"> <a class="text-white"
                                href="{{ route('Supplier_contract.audit_trail', $contract_data->id) }}">
                                Audit Trail </a>
                        </button>

                        @if ($contract_data->stage == 1 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit Supplier Details
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($contract_data->stage == 2 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Qualification Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($contract_data->stage == 3 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal"
                                data-bs-target="#signature-modal_audit_passed">
                                Audit Passed
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Audit Failed
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($contract_data->stage == 4 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Supplier Obsolete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal"
                                data-bs-target="#reject_due_to_quality_issues">
                                Reject Due To Quality Issues
                            </button>
                        @elseif($contract_data->stage == 5 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Supplier Obsolete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal"
                                data-bs-target="#reject_due_to_quality_issues">
                                Re-Audit
                            </button>
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>
                    </div>

                </div>


                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($contract_data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger canceled">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex" style="font-size: 15px;">
                            @if ($contract_data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($contract_data->stage >= 2)
                                <div class="active">Qualification In Progress</div>
                            @else
                                <div class="">Qualification In Progress</div>
                            @endif

                            @if ($contract_data->stage >= 3)
                                <div class="active">Pending Supplier Audit</div>
                            @else
                                <div class="">Pending Supplier Audit</div>
                            @endif

                            @if ($contract_data->stage != 5)
                                @if ($contract_data->stage >= 4)
                                    <div class="active">Supplier Approved</div>
                                @else
                                    <div class="">Supplier Approved</div>
                                @endif
                            @endif

                            @if ($contract_data->stage != 4)
                                @if ($contract_data->stage >= 5)
                                    <div class="active">Pending Rejection</div>
                                @else
                                    <div class="">Pending Rejection</div>
                                @endif
                            @endif

                            @if ($contract_data->stage >= 6)
                                <div class="bg-danger">Obselete</div>
                            @else
                                <div class="">Obselete</div>
                            @endif

                        </div>
                    @endif
                </div>
            </div>


            {{-- workflow end --}}


            {{-- Submit Supplier Details button Model Open --}}
            <div class="modal fade" id="signature-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('Supplier_contract.send_stage', $contract_data->id) }}" method="POST">
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

            {{-- Submit audit passed button Model Open --}}


            {{-- Submit Supplier Details button Model Open --}}
            <div class="modal fade" id="signature-modal_audit_passed">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('Supplier_contract.send_stage', $contract_data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <input type="hidden" value="audit_passed" id="type" name="type">
                                <div class="group-input">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="new_style" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="new_style" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment</label>
                                    <input type="comment" class="new_style" name="comment">
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

            {{-- cancel button Model Open --}}
            <div class="modal fade" id="cancel-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('Supplier_contract.cancel', $contract_data->id) }}" method="POST">
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

            {{-- E-Signature cancel botton Model Close --}}

            {{-- Submit Reject Due To Quality Issues button Model Open --}}
            <div class="modal fade" id="reject_due_to_quality_issues">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('Supplier_contract.reject', $contract_data->id) }}" method="POST">
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
                                    <input type="text" class="new_style" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="new_style" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment</label>
                                    <input type="comment" class="new_style" name="comment">
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

            {{-- ------Reject Due To Quality Issues button Model Open------ --}}

            {{-- ---------Child Button Model Open--------- --}}

            <div class="modal fade" id="child-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('Supplier_contract.child', $contract_data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="group-input">
                                    <label style="display: flex;" for="major">
                                        <input type="radio" name="child_type" id="child_type">
                                        Supplier Audit
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
            {{-- ---------Child Button Model Open--------- --}}

            {{-- ! ========================================= --}}
            {{-- ! DATA FIELDS --}}
            {{-- ! ========================================= --}}
            <div id="change-control-fields">
                <div class="container-fluid">

                    <!-- Tab links -->
                    <div class="cctab">
                        <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Contract</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Contract Detail</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>
                    </div>

                    {{-- disabled field code start --}}

                    <?php if (in_array($contract_data->stage, [0, 6])) : ?>
                    <script>
                        $(document).ready(function() {
                            $("#target :input").prop("disabled", true);
                        });
                    </script>
                    <?php endif; ?>

                    {{-- disabled field code end --}}

                    <form id="target" action="{{ route('supplier_contract.update', $contract_data->id) }}"
                        method="POST" enctype="multipart/form-data">
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
                                                <label for="Initiator">Record Number </label>
                                                <input disabled type="text" name="record" value="{{ Helpers::getDivisionName(session()->get('division')) }}/Supplier-Contract/{{ date('Y') }}/{{ str_pad($contract_data->record, 4, '0', STR_PAD_LEFT) }}">
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
                                                <input type="text" disabled name="initiator_id" value="{{ auth()->user()->name }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Date of Initiation</b></label>
                                                <input readonly type="text" value="{{ date('d-M-Y', strtotime($contract_data->intiation_date)) }}" name="intiation_date">
                                                <input type="hidden" value="{{ date('Y-m-d', strtotime($contract_data->intiation_date)) }}" name="intiation_date">
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Short Description<span
                                                    class="text-danger">*</span>
                                                  <p>255 Characters remaining</p>
                                                  <input id="docname" type="text" name="short_description_gi" maxlength="255" required value="{{ $contract_data->short_description_gi }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="group-input">
                                                <label for="search">
                                                    Assigned To <span class="text-danger"></span>
                                                </label>

                                                <select id="select-state" placeholder="Select..." name="assign_to_gi">
                                                    <option value="">Select a value</option>
                                                    @if (!empty($users))
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                {{ $user->id == $contract_data->assign_to_gi ? 'selected' : '' }}>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <?php
                                        // Calculate the due date (30 days from the initiation date)
                                        $initiationDate = date('Y-m-d'); // Current date as initiation date
                                        $dueDate = date('Y-m-d', strtotime($initiationDate . '+30 days')); // Due date
                                        ?>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Due Date">Due Date</label>
                                                {{--<div><small class="text-primary">If revising Due Date, kindly mention
                                                        revision
                                                        reason in "Due Date Extension Justification" data field.</small>
                                                </div>--}}
                                                <div class="calenderauditee">
                                                    <input readonly type="text"
                                                        value="{{ Helpers::getdateFormat($contract_data->due_date) }}"
                                                        name="due_date" />
                                                    <input type="date" name="due_date" disabled
                                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            // Format the due date to DD-MM-YYYY

                                            var dueDateFormatted = new Date("{{ $dueDate }}").toLocaleDateString('en-GB', {
                                                day: '2-digit',
                                                month: '2-digit',
                                                year: 'numeric'
                                            }).split('/').join('-');

                                            // Set the formatted due date value to the input field
                                            document.getElementById('due_date').value = dueDateFormatted;
                                        </script>



                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Responsible Department">Supplier List</label>
                                                <select name="supplier_list_gi">
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="supplier-performance-metrics" @if ($contract_data->supplier_list_gi == 'supplier-performance-metrics') selected @endif>Supplier Performance Metrics</option>
                                                    <option value="contractual-terms-and-conditions" @if ($contract_data->supplier_list_gi == 'contractual-terms-and-conditions') selected @endif>Contractual Terms and Conditions</option>
                                                    <option value="supplier-risk-assessment" @if ($contract_data->supplier_list_gi == 'supplier-risk-assessment') selected @endif>Supplier Risk Assessment</option>
                                                    <option value="products/services-provided" @if ($contract_data->supplier_list_gi == 'products/services-provided') selected @endif>Products/Services Provided</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Actions">Distribution List<span
                                                        class="text-danger"></span></label>
                                                {{-- <textarea placeholder="" name="distribution_list_gi" {{
                                                $contract_data->stage == 0 || $contract_data->stage == 6 ? 'disabled' : '' }}>{{ $contract_data->distribution_list_gi }}</textarea> --}}
                                                <select name="distribution_list_gi">
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="internal-stakeholders" @if ($contract_data->distribution_list_gi == 'internal-stakeholders') selected @endif>Internal Stakeholders</option>
                                                    <option value="external-stakeholders" @if ($contract_data->distribution_list_gi == 'external-stakeholders') selected @endif>External Stakeholders</option>
                                                    <option value="project-specific-stakeholders" @if ($contract_data->distribution_list_gi == 'project-specific-stakeholders') selected @endif>Project-Specific Stakeholders</option>
                                                    <option value="miscellaneous" @if ($contract_data->distribution_list_gi == 'miscellaneous') selected @endif>Miscellaneous</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Description">Description<span class="text-danger"></span></label>
                                                <textarea name="description_gi">{{ $contract_data->description_gi }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>Manufacturer</b></label>
                                                <input type="text" name="manufacturer_gi" value="{{ $contract_data->manufacturer_gi }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Responsible Department">Priority level</label>
                                                <select name="priority_level_gi">
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="high-priority" @if ($contract_data->priority_level_gi == 'high-priority') selected @endif>High Priority</option>
                                                    <option value="medium-priority" @if ($contract_data->priority_level_gi == 'medium-priority') selected @endif>Medium Priority</option>
                                                    <option value="low-priority" @if ($contract_data->priority_level_gi == 'low-priority') selected @endif>Low Priority</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Responsible Department">Zone </label>
                                                <select name="zone_gi">
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="asia" @if ($contract_data->zone_gi == 'asia') selected @endif>Asia</option>
                                                    <option value="europe" @if ($contract_data->zone_gi == 'europe') selected @endif>Europe</option>
                                                    <option value="africa" @if ($contract_data->zone_gi == 'africa') selected @endif>Africa</option>
                                                    <option value="central-america" @if ($contract_data->zone_gi == 'central-america') selected @endif>Central America</option>
                                                    <option value="south-america" @if ($contract_data->zone_gi == 'south-america') selected @endif>South America</option>
                                                    <option value="oceania" @if ($contract_data->zone_gi == 'oceania') selected @endif>Oceania</option>
                                                    <option value="north-america" @if ($contract_data->zone_gi == 'north-america') selected @endif>North America</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>Country</b></label>
                                                <p class="text-primary">Auto filter according to selected zone</p>
                                                <select name="country" class="form-select country" aria-label="Default select example" onchange="loadStates()">
                                                    <option value="{{ $contract_data->country }}" selected>{{ $contract_data->country }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Responsible Department">State/District</label>
                                                <p class="text-primary">Auto selected according to country</p>
                                                <select name="state" class="form-select state" aria-label="Default select example" onchange="loadCities()">
                                                    <option value="{{ $contract_data->state }}" selected>{{ $contract_data->state }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>City</b></label>
                                                <p class="text-primary">Auto filter according to selected state</p>
                                                <select name="city" class="form-select city" aria-label="Default select example">
                                                    <option value="{{ $contract_data->city }}" selected>{{ $contract_data->city }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Responsible Department">Type</label>
                                                <select name="type_gi">
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="supplier-type" @if ($contract_data->type_gi == 'supplier-type') selected @endif>Supplier Type</option>
                                                    <option value="payment-type" @if ($contract_data->type_gi == 'payment-type') selected @endif>Payment Type</option>
                                                    <option value="risk-type" @if ($contract_data->type_gi == 'risk-type') selected @endif>Risk Type</option>
                                                    <option value="quality-assurance-type" @if ($contract_data->type_gi == 'quality-assurance-type') selected @endif>Quality Assurance Type</option>
                                                    <option value="relationship-type" @if ($contract_data->type_gi == 'relationship-type') selected @endif>Relationship Type</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>Other type</b></label>
                                                <p class="text-primary">If you choose "other" -please specify</p>
                                                <input type="text" name="other_type" value="{{ $contract_data->other_type }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="file_attach">File Attachments</label>
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="file_attach">
                                                        @if ($contract_data->file_attachments_gi)
                                                            @foreach ($contract_data->file_attachments_gi as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b><a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                    <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="add-btn">
                                                        <div>Add</div>
                                                        <input type="file" id="myfile" name="file_attachments_gi[]"
                                                            oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                                    </div>
                                                </div>
                                                {{-- <input type="file" name="file_attach[]" multiple> --}}
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

                            <!-- TAB 1 ENDS HERE -->

                            <div id="CCForm2" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="actual_start_date_cd">Actual start Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="actual_start_date_cd" value="{{ $contract_data->actual_start_date_cd }}" readonly placeholder="DD-MMM-YYYY" />
                                                    <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $contract_data->actual_start_date_cd }}" id="actual_start_date_cd" name="actual_start_date_cd" class="hide-input" oninput="handleDateInput(this, 'actual_start_date_cd');" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="actual_end_date_cd">Actual end Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="actual_end_date_cd" value="{{ $contract_data->actual_end_date_cd }}" readonly placeholder="DD-MMM-YYYY" />
                                                    <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $contract_data->actual_end_date_cd }}" id="actual_end_date_cd" name="actual_end_date_cd" class="hide-input" oninput="handleDateInput(this, 'actual_end_date_cd');" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Responsible Department">Suppplier List</label>
                                                <select name="suppplier_list_cd">
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="risk-and-compliance" @if ($contract_data->suppplier_list_cd == 'risk-and-compliance') selected @endif>Risk and Compliance</option>
                                                    <option value="contractual-details" @if ($contract_data->suppplier_list_cd == 'contractual-details') selected @endif>Contractual Details</option>
                                                    <option value="supplier-classification" @if ($contract_data->suppplier_list_cd == 'supplier-classification') selected @endif>Supplier Classification</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Actions">Negotiation Team<span class="text-danger"></span></label>
                                                <textarea name="negotiation_team_cd">{{ $contract_data->negotiation_team_cd }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                            Financial Transaction
                                            <button type="button" name="financial_transaction"
                                                id="ReferenceDocument">+</button>
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
                                                        <th style="width: 12%">Transaction</th>
                                                        <th style="width: 16%">Transaction Type</th>
                                                        <th style="width: 16%">Date</th>
                                                        <th style="width: 16%">Amount</th>
                                                        <th style="width: 16%">Currency Used</th>
                                                        <th style="width: 16%">Remarks</th>
                                                        <th style="width: 16%">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @php
                                                       $data = isset($grid_Data) && $grid_Data->data ? json_decode($grid_Data->data, true) : null;
                                                    @endphp

                                                    @if ($data && is_array($data))
                                                        @foreach ($data as $index => $item)
                                                            <tr>
                                                                <td><input disabled type="text" name="[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}"></td>
                                                                <td><input type="text" name="financial_transaction[{{ $loop->index }}][Transaction]" value="{{ isset($item['Transaction']) ? $item['Transaction'] : '' }}"></td>
                                                                <td><input type="text" name="financial_transaction[{{ $loop->index }}][TransactionType]" value="{{ isset($item['TransactionType']) ? $item['TransactionType'] : '' }}"></td>
                                                                <td><input type="date" name="financial_transaction[{{ $loop->index }}][Date]" value="{{ isset($item['Date']) ? $item['Date'] : '' }}"></td>
                                                                <td><input type="number" name="financial_transaction[{{ $loop->index }}][Amount]" value="{{ isset($item['Amount']) ? $item['Amount'] : '' }}"></td>
                                                                <td><input type="text" name="financial_transaction[{{ $loop->index }}][CurrencyUsed]" value="{{ isset($item['CurrencyUsed']) ? $item['CurrencyUsed'] : '' }}"></td>
                                                                <td><input type="text" name="financial_transaction[{{ $loop->index }}][Remarks]" value="{{ isset($item['Remarks']) ? $item['Remarks'] : '' }}"></td>
                                                                <td><button readonly type="text" class="removeRowBtn">Remove</button></td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Actions">Comments <span class="text-danger"></span></label>
                                                <textarea name="comments_cd">{{ $contract_data->comments_cd }}</textarea>
                                            </div>
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

                            {{-- Signatures start --}}

                            <div id="CCForm3" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="sub-head">Supplier Details</div>
                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Victim"><b>Supplier Details By :</b></label>
                                                <div class="">{{ $contract_data->supplier_details_submit_by }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Supplier Details On : </b></label>
                                                <div class="date">{{ $contract_data->supplier_details_submit_on }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Supplier Details Comments : </b></label>
                                                <div class="date">{{ $contract_data->supplier_details_submit_comment }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="sub-head">Supplier Cancel</div>
                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Victim"><b>Supplier Cancelled By :</b></label>
                                                <div class="">{{ $contract_data->open_cancel_by }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Supplier Cancelled On : </b></label>
                                                <div class="date">{{ $contract_data->open_cancel_on }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Supplier Cancelled Comments : </b></label>
                                                <div class="date">{{ $contract_data->open_cancel_comment }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="sub-head">Qualification Complete</div>
                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Victim"><b>Qualification Completed By :</b></label>
                                                <div class="">{{ $contract_data->qualification_complete_by }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Qualification Completed On : </b></label>
                                                <div class="date">{{ $contract_data->qualification_complete_on }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Qualification Completed Comments :</b></label>
                                                 <div class="date">{{ $contract_data->qualification_complete_comment }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="sub-head">Qualification Cancel</div>
                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Victim"><b>Qualification Cancelled By :</b></label>
                                                <div class="">{{ $contract_data->qualification_cancel_by }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Qualification Cancelled On : </b></label>
                                                <div class="date">{{ $contract_data->qualification_cancel_on }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Qualification Cancelled Comments :</b></label>
                                                 <div class="date">{{ $contract_data->qualification_cancel_comment }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="sub-head">Audit Passed</div>
                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Victim"><b>Audit Passed By :</b></label>
                                                <div class="">{{ $contract_data->audit_passed_by }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Audit Passed On : </b></label>
                                                <div class="date">{{ $contract_data->audit_passed_on }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Audit Passed Comments : </b></label>
                                                <div class="date">{{ $contract_data->audit_passed_comment }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="sub-head">Audit Failed</div>
                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Victim"><b>Audit Failed By :</b></label>
                                                <div class="">{{ $contract_data->audit_failed_by }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Audit Failed On : </b></label>
                                                <div class="date">{{ $contract_data->audit_failed_on }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Audit Failed Comments : </b></label>
                                                <div class="date">{{ $contract_data->audit_failed_comment }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="sub-head">Reject Due To Quality Issues</div>
                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Victim"><b>Quality Issues By :</b></label>
                                                <div class="">{{ $contract_data->quality_issues_by }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Quality Issues On : </b></label>
                                                <div class="date">{{ $contract_data->quality_issues_on }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Quality Issues Comments : </b></label>
                                                <div class="date">{{ $contract_data->quality_issues_comment }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="sub-head">Approved Supplier Obsolete</div>
                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Victim"><b>Supplier Obsoleted By :</b></label>
                                                <div class="">{{ $contract_data->approve_supplier_obsolete_by }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Supplier Obsoleted On : </b></label>
                                                <div class="date">{{ $contract_data->approve_supplier_obsolete_on }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">

                                                <label for="Division Code"><b>Supplier Obsoleted Comments : </b></label>
                                                <div class="date">
                                                    {{ $contract_data->approve_supplier_obsolete_comment }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="sub-head">Re-Audit</div>
                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Victim"><b>Re-Audited By :</b></label>
                                                <div class="">{{ $contract_data->re_audit_by }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Re-Audited On : </b></label>
                                                <div class="date">{{ $contract_data->re_audit_on }}</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Re-Audited Comments : </b></label>
                                                <div class="date">{{ $contract_data->re_audit_comment }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="sub-head">Pending Supplier Obsolete</div>
                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Victim"><b>Pending Supplier Obsoleted By :</b></label>
                                                <div class="">{{ $contract_data->reject_supplier_obsolete_by }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Pending Supplier Obsoleted On : </b></label>
                                                <div class="date">{{ $contract_data->reject_supplier_obsolete_on }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Pending Supplier Obsoleted Comments :
                                                    </b></label>
                                                <div class="date">{{ $contract_data->reject_supplier_obsolete_comment }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>

                                    <button type="button"> <a class="text-white"
                                            href="{{ url('rcms/qms-dashboard') }}">
                                            Exit </a> </button>
                                </div>
                            </div>
                        </div>

                        {{-- Signatures end --}}

                        <div id="CCForm4" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">Investigation summary</div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Actual_Amount ">Actual Amount of Damage</label>
                                            <input type="text" name="Actual_Amount" />
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Currency">Currency</label>
                                            <select name="Currency">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="investigation_summary">Investigation summary</label>
                                            <textarea name="investigation_summary" id="" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Conclusion">Conclusion</label>
                                            <textarea name="Conclusion" id="" cols="30" rows="5"></textarea>
                                        </div>
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

                        <div id="CCForm5" class="inner-block cctabcontent">
                            <div class="inner-block-content">
                                <div class="row">
                                    <div class="sub-head">Risk Factors</div>

                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Safety_Impact_Probability">Safety Impact Probability</label>
                                            <select name="Safety_Impact_Probability">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Safety_Impact_Severity">Safety Impact Severity</label>
                                            <select name="Safety_Impact_Severity">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Legal_Impact_Probability">Legal Impact Probability</label>
                                            <select name="Legal_Impact_Probability">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Legal_Impact_Severity">Legal Impact Severity</label>
                                            <select name="Legal_Impact_Severity">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Business_Impact_Probability">Business Impact Probability</label>
                                            <select name="Business_Impact_Probability">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Business_Impact_Severity">Business Impact Severity</label>
                                            <select name="Business_Impact_Severity">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Revenue_Impact_Probability">Revenue Impact Probability</label>
                                            <select name="Revenue_Impact_Probability">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Revenue_Impact_Severity">Revenue Impact Severity</label>
                                            <select name="Revenue_Impact_Severity">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Brand_Impact_Probability">Brand Impact Probability</label>
                                            <select name="Brand_Impact_Probability">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Brand_Impact_Severity">Brand Impact Severity</label>
                                            <select name="Brand_Impact_Severity">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
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
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Legal_Impact_Risk">Legal Impact Risk</label>
                                            <select name="Legal_Impact_Risk">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Business_Impact_Risk">Business Impact Risk</label>
                                            <select name="Business_Impact_Risk">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Revenue_Impact_Risk">Revenue Impact Risk</label>
                                            <select name="Revenue_Impact_Risk">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Brand_Impact_Risk">Brand Impact Risk</label>
                                            <select name="Brand_Impact_Risk">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
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
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Impact_Analysis">Impact Analysis</label>
                                            <textarea name="Impact_Analysis" id="" cols="30" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Recommended_Action">Recommended Action</label>
                                            <textarea name="Recommended_Action" id="" cols="30" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Comments">Comments</label>
                                            <textarea name="Comments" id="" cols="30" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Direct_Cause">Direct Cause</label>
                                            <select name="Direct_Cause">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Safeguarding">Safeguarding Measure Taken</label>
                                            <select name="Safeguarding">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="sub-head">
                                        Root Cause Analysis
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Permanent">Root cause Methodlogy</label>
                                            <select name="Permanent">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                            Root Cause(0)
                                            <button type="button" name="audit-agenda-grid" id="RootCause">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#RootCause-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <td><input disabled type="text" name="serial[]" value="1">
                                                    </td>
                                                    <td><input type="text" name="IDnumber[]"></td>
                                                    <td> <input type="text" name=""></td>
                                                    <td> <input type="text" name=""></td>
                                                    <td> <input type="text" name=""></td>
                                                    <td><input type="text" name="Remarks[]"></td>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Root_cause_Description">Root cause Description</label>
                                            <textarea name="Root_cause_Description" id="" cols="30" rows="3"></textarea>
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
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Occurrence">Occurrence</label>
                                            <select name="Occurrence">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Detection">Detection</label>
                                            <select name="Detection">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="RPN">RPN</label>
                                            <select name="RPN">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Risk_Analysis">Risk Analysis</label>
                                            <textarea name="Risk_Analysis" id="" cols="30" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Criticality">Criticality</label>
                                            <select name="Criticality">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Inform_Local_Authority">Inform Local Authority?</label>
                                            <select name="Inform_Local_Authority">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Authority_Type">Authority Type</label>
                                            <select name="Authority_Type">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="group-input">
                                            <label for="Authority(s)_Notified">Authority(s) Notified</label>
                                            <select name="Authority(s)_Notified">
                                                <option value="">--select--</option>
                                                <option value="">1</option>
                                                <option value="">2</option>
                                                <option value="">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Other_Authority">Other Authority</label>
                                        <input type="text" name="Other_Authority">
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
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="submitted by">Submitted By :</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="submitted on">Submitted On :</label>
                                <div class="Date"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="cancelled by">Plan Approved By :</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="cancelled on">Plan Approved On :</label>
                                <div class="Date"></div>
                            </div>
                        </div>

                        <!-- <div class="button-block">
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                            </a> </button>
                                    </div> -->
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
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>

    {{-- Country State City API --}}
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
                        option.value = city.name;
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
    {{-- Country State City API End --}}

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
