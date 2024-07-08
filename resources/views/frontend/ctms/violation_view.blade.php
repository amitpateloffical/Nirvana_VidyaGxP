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
{{--{{ $violation_data->stage == 10 ? 'disabled' : '' }}--}}
<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / CTMS_Violation
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#Monitor_Information').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="date" name="date[]"></td>' +
                    ' <td><input type="text" name="Responsible[]"></td>' +
                    '<td><input type="text" name="ItemDescription[]"></td>' +
                    '<td><input type="date" name="SentDate[]"></td>' +
                    '<td><input type="date" name="ReturnDate[]"></td>' +
                    '<td><input type="text" name="Comment[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +


                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                //     '</tr>';

                return html;
            }

            var tableBody = $('#Monitor_Information_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#Product_Material').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                 '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="product_material[' + serialNumber + '][ProductName]"></td>' +
                    '<td><input type="number" name="product_material[' + serialNumber + '][BatchNumber]"></td>' +
                    '<td><input type="date" name="product_material[' + serialNumber + '][ExpiryDate]"></td>' +
                    '<td><input type="date" name="product_material[' + serialNumber + '][ManufacturedDate]"></td>' +
                    '<td><input type="text" name="product_material[' + serialNumber + '][Disposition]"></td>' +
                    '<td><input type="text" name="product_material[' + serialNumber + '][Comment]"></td>' +
                    '<td><input type="text" name="product_material[' + serialNumber + '][Remarks]"></td>' +
                    '<td><button type="text" class="removeRowBtn" ">Remove</button></td>' +
                 '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                //     '</tr>';

                return html;
            }

            var tableBody = $('#Product_Material_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#Equipment').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
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
                            ->where(['user_id' => auth()->id(), 'q_m_s_divisions_id' => $violation_data->division_id])
                            ->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp
                    <button class="button_theme1"> <a class="text-white"
                            href="{{ route('violation.audit_trail', $violation_data->id) }}">
                            Audit Trail </a>
                    </button>

                    @if ($violation_data->stage == 1 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Pending Completion
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                    @elseif($violation_data->stage == 2 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Close
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                    @endif
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                     </a> </button>
                </div>

            </div>


            <div class="status">
                <div class="head">Current Status</div>
                @if ($violation_data->stage == 0)
                    <div class="progress-bars ">
                        <div class="bg-danger canceled">Closed-Cancelled</div>
                    </div>
                @else
                    <div class="progress-bars d-flex" style="font-size: 15px;">
                        @if ($violation_data->stage >= 1)
                            <div class="active">Opened</div>
                        @else
                            <div class="">Opened</div>
                        @endif
                        @if ($violation_data->stage >= 2)
                            <div class="active">Pending Completion Activities</div>
                        @else
                            <div class="">Pending Completion Activities</div>
                        @endif
                        @if ($violation_data->stage >= 3)
                            <div class="bg-danger">Closed Done</div>
                        @else
                            <div class="">Closed Done</div>
                        @endif

                    </div>
                @endif
            </div>
        </div>


{{--workflow end--}}


{{--Initiate button Model Open--}}
<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('violation.send_stage', $violation_data->id) }}" method="POST">
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


{{--cancel button model start--}}
<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('violation.cancel', $violation_data->id) }}" method="POST">
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

{{-- cancel botton model end --}}




{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Protocol Violation</button>
            {{--<button class="cctablinks" onclick="openCity(event, 'CCForm2')">Parent Information</button>--}}
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Violation Information</button>
            {{--<button class="cctablinks" onclick="openCity(event, 'CCForm4')">Action Approval</button>--}}
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signatures</button>
        </div>

        {{--disabled field code start--}}

        <?php if (in_array($violation_data->stage, [0, 3])) : ?>
        <script>
            $(document).ready(function() {
                $("#target :input").prop("disabled", true);
            });
        </script>
        <?php endif; ?>

        {{--disabled field code start--}}

        <form id="target" action="{{ route('violation.update', $violation_data->id) }}" method="POST" enctype="multipart/form-data">
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
                            Monitor Visit
                        </div> <!-- RECORD NUMBER -->
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"> Record Number </label>
                                    <input disabled type="text" name="record"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/Violation/{{ date('Y') }}/{{ $record_number }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input readonly type="text" name="division_code"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    {{-- <div class="static">QMS-North America</div> --}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                @if (!empty($cc->id))
                                <input type="hidden" name="ccId" value="{{ $cc->id }}">
                                @endif
                                <div class="group-input">
                                    <label for="originator">Initiator</label>
                                    <input disabled type="text" name="initiator_id" value="{{ auth()->user()->name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Opened">Date of Initiation</label>
                                    <input readonly type="text" value="{{ date('d-M-Y', strtotime($violation_data->intiation_date)) }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d', strtotime($violation_data->intiation_date)) }}" name="intiation_date">
                                </div>
                            </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                characters remaining
                                <input id="short_description" type="text" name="short_description" value="{{ $violation_data->short_description }}" maxlength="255" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Assigned To <span class="text-danger"></span>
                                </label>
                                <select id="assign_to" placeholder="Select..." name="assign_to">
                                    <option value="">Select a value</option>
                                    @if($users->isNotEmpty())
                                        @foreach($users as $user)
                                        <option value='{{ $user->id }}' {{ $user->id == $violation_data->assign_to ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="due-date">Due Date <span class="text-danger"></span></label>
                                <p class="text-primary">Please mention expected date of completion</p>
                                  <div class="calenderauditee">
                                    <input  type="hidden" value="{{ $due_date }}" name="due_date">
                                    <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Type <span class="text-danger"></span>
                                </label>
                                <select id="type" placeholder="Select..." name="type">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="supplier-type" @if($violation_data->type == 'supplier-type') selected @endif>Supplier Type</option>
                                    <option value="payment-type" @if($violation_data->type == 'payment-type') selected @endif>Payment Type</option>
                                    <option value="risk-type" @if($violation_data->type == 'risk-type') selected @endif>Risk Type</option>
                                    <option value="quality-assurance-type" @if($violation_data->type == 'quality-assurance-type') selected @endif>Quality Assurance Type</option>
                                    <option value="relationship-type" @if($violation_data->type == 'relationship-type') selected @endif>Relationship Type</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Other Type <span class="text-danger"></span>
                                </label>
                                <select id="other_type" placeholder="Select..." name="other_type">
                                    <option value="">Select a value</option>
                                    <option value="good-manufacturing-practice" @if($violation_data->other_type == 'good-manufacturing-practice') selected @endif>Good Manufacturing Practice</option>
                                    <option value="good-clinical-practice" @if($violation_data->other_type == 'good-clinical-practice') selected @endif>Good Clinical Practice</option>
                                    <option value="good-laboratory-practice" @if($violation_data->other_type == 'good-laboratory-practice') selected @endif>Good Laboratory Practice</option>
                                    <option value="good-distribution-practice" @if($violation_data->other_type == 'good-distribution-practice') selected @endif>Good Distribution Practice </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="search">
                                    Related URL <span class="text-danger"></span>
                                </label>
                                <select id="related_url" placeholder="Select...">
                                    <option value="">Select a value</option>
                                    <option value="fda-gmp-guidelines" @if($violation_data->related_url == 'fda-gmp-guidelines') selected @endif>FDA GMP Guidelines</option>
                                    <option value="who-gmp-guidelines" @if($violation_data->related_url == 'who-gmp-guidelines') selected @endif>WHO GMP Guidelines</option>
                                    <option value="fda-gcp-guidelines" @if($violation_data->related_url == 'fda-gcp-guidelines') selected @endif>FDA GCP Guidelines</option>
                                    <option value="ich-gmp-guidelines" @if($violation_data->related_url == 'ich-gmp-guidelines') selected @endif>ICH GCP Guidelines</option>
                                    <option value="fda-glp-guidelines" @if($violation_data->related_url == 'fda-glp-guidelines') selected @endif>FDA GLP Regulations</option>
                                    <option value="oecd-glp-guidelines" @if($violation_data->related_url == 'oecd-glp-guidelines') selected @endif>OECD GLP Principles</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="closure attachment">File Attachments </label>
                                <div><small class="text-primary">
                                    </small>
                                </div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="file_attach">
                                        @if ($violation_data->file_attachments)
                                            @foreach($violation_data->file_attachments as $file)
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
                                        <input type="file" id="myfile" name="file_attachments[]" oninput="addMultipleFiles(this, 'file_attach')" multiple {{ $violation_data->stage == 0 || $violation_data->stage == 0 || $violation_data->stage == 3 ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Short Description">Description</label>
                                 <textarea name="description">{{ $violation_data->description }}</textarea>
                            </div>
                        </div>


                        <div class="sub-head">
                            Location
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Zone <span class="text-danger"></span>
                                </label>
                                <select id="select-state" placeholder="Select..." name="zone">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="asia" @if ($violation_data->zone == "asia") selected @endif>Asia</option>
                                    <option value="europe" @if ($violation_data->zone == "europe") selected @endif>Europe</option>
                                    <option value="africa" @if ($violation_data->zone == "africa") selected @endif>Africa</option>
                                    <option value="central-america" @if ($violation_data->zone == "central-america") selected @endif>Central America</option>
                                    <option value="south-america" @if ($violation_data->zone == "south-america") selected @endif>South America</option>
                                    <option value="oceania" @if ($violation_data->zone == "oceania") selected @endif>Oceania</option>
                                    <option value="north-america" @if ($violation_data->zone == "north-america") selected @endif>North America</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Country <span class="text-danger"></span>

                                </label>
                                <p class="text-primary">Auto filter according to selected zone</p>
                                <select name="country_id" class="form-select country" aria-label="Default select example" onchange="loadStates()">
                                    <option value="{{ $violation_data->country_id }}" selected>{{ $violation_data->country_id }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    State/District <span class="text-danger"></span>
                                </label>
                                <p class="text-primary">Auto selected according to City</p>
                                <select name="state_id" class="form-select state" aria-label="Default select example" onchange="loadCities()">
                                    <option value="{{ $violation_data->state_id }}" selected>{{ $violation_data->state_id }}</option>
                                  </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    City <span class="text-danger"></span>
                                </label>
                                <p class="text-primary">Auto filter according to selected country</p>
                                <select name="city_id" class="form-select city" aria-label="Default select example">
                                    <option value="{{ $violation_data->city_id }}" selected>{{ $violation_data->city_id }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Site Name <span class="text-danger"></span>
                                </label>

                                <select id="select-state" placeholder="Select..." name="site_name_id">
                                    <option value="">Select Site</option>
                                    <option value="site-A" @if ($violation_data->site_name_id == "site-A") selected @endif>Site A</option>
                                    <option value="site-B" @if ($violation_data->site_name_id == "site-B") selected @endif>Site B</option>
                                    <option value="site-C" @if ($violation_data->site_name_id == "site-C") selected @endif>Site C</option>
                                    <option value="site-D" @if ($violation_data->site_name_id == "site-D") selected @endif>Site D</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Building <span class="text-danger"></span>
                                </label>

                                <select id="select-state" placeholder="Select..." name="building_id">
                                    <option value="">Select Building</option>
                                    <option value="building-X" @if ($violation_data->building_id == "building-X") selected @endif>Building X</option>
                                    <option value="building-Y" @if ($violation_data->building_id == "building-Y") selected @endif>Building Y</option>
                                    <option value="building-Z" @if ($violation_data->building_id == "building-Z") selected @endif>Building Z</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Floor <span class="text-danger"></span>
                                </label>

                                <select id="select-state" placeholder="Select..." name="flore_id">
                                    <option value="">Select Floor</option>
                                    <option value="floor-1" @if ($violation_data->flore_id == "floor-1") selected @endif>Floor 1</option>
                                    <option value="floor-2" @if ($violation_data->flore_id == "floor-2") selected @endif>Floor 2</option>
                                    <option value="floor-3" @if ($violation_data->flore_id == "floor-3") selected @endif>Floor 3</option>
                                    <option value="floor-4" @if ($violation_data->flore_id == "floor-4") selected @endif>Floor 4</option>
                                    <option value="floor-5" @if ($violation_data->flore_id == "floor-5") selected @endif>Floor 5</option>
                                    <option value="floor-6" @if ($violation_data->flore_id == "floor-6") selected @endif>Floor 6</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Room <span class="text-danger"></span>
                                </label>

                                <select id="select-state" placeholder="Select..." name="room_id">
                                    <option value="">Select Room</option>
                                    <option value="room-101" @if ($violation_data->room_id == "room-101") selected @endif>Room 101</option>
                                    <option value="room-102" @if ($violation_data->room_id == "room-102") selected @endif>Room 102</option>
                                    <option value="room-201" @if ($violation_data->room_id == "room-201") selected @endif>Room 201</option>
                                    <option value="room-202" @if ($violation_data->room_id == "room-202") selected @endif>Room 202</option>
                                    <option value="room-301" @if ($violation_data->room_id == "room-301") selected @endif>Room 301</option>
                                    <option value="room-302" @if ($violation_data->room_id == "room-302") selected @endif>Room 302</option>
                                    <option value="room-401" @if ($violation_data->room_id == "room-401") selected @endif>Room 401</option>
                                    <option value="room-402" @if ($violation_data->room_id == "room-402") selected @endif>Room 402</option>
                                    <option value="room-501" @if ($violation_data->room_id == "room-501") selected @endif>Room 501</option>
                                    <option value="room-502" @if ($violation_data->room_id == "room-502") selected @endif>Room 502</option>
                                    <option value="room-601" @if ($violation_data->room_id == "room-601") selected @endif>Room 601</option>
                                    <option value="room-602" @if ($violation_data->room_id == "room-602") selected @endif>Room 602</option>
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

            <div id="CCForm3" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="sub-head col-12">Violation Information</div>

                        <div class="col-lg-6  new-date-data-field">
                            <div class="group-input input-date">
                                <label for="date_occured">Date Occured</lable>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $violation_data->date_occured }}" id="date_occured" name="date_occured" placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $violation_data->date_occured }}" id="end_date_checkdate" name="date_occured" class="hide-input" oninput="handleDateInput(this, 'date_occured');checkDate('start_date_checkdate','end_date_checkdate')"/>
                                    </div>
                              </div>
                        </div>

                        <div class="col-lg-6  new-date-data-field">
                            <div class="group-input input-date">
                                <label for="notification_date">Notification Date</lable>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $violation_data->notification_date }}" id="notification_date" placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $violation_data->notification_date }}" id="notification_date" name="notification_date" class="hide-input" oninput="handleDateInput(this, 'notification_date');checkDate('start_date_checkdate','end_date_checkdate')"/>
                                    </div>
                              </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Severity Rate <span class="text-danger"></span>
                                </label>
                                <select id="select-state" placeholder="Select..." name="severity_rate">
                                    <option value="">Select a value</option>
                                    <option value="critical" @if($violation_data->severity_rate == 'critical') selected @endif>Critical</option>
                                    <option value="major" @if($violation_data->severity_rate == 'major') selected @endif>Major</option>
                                    <option value="minor" @if($violation_data->severity_rate == 'minor') selected @endif>Minor</option>
                                    <option value="moderate" @if($violation_data->severity_rate == 'moderate') selected @endif>Moderate</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Occurance <span class="text-danger"></span>
                                </label>
                                <select id="select-state" placeholder="Select..." name="occurance">
                                    <option value="">Select a value</option>
                                    <option value="frequent" @if($violation_data->occurance == 'frequent') selected @endif>Frequent</option>
                                    <option value="occasional" @if($violation_data->occurance == 'occasional') selected @endif>Occasional</option>
                                    <option value="rare" @if($violation_data->occurance == 'rare') selected @endif>Rare</option>
                                    <option value="single-occurrence" @if($violation_data->occurance == 'single-occurrence') selected @endif>Single Occurrence</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    Detection <span class="text-danger"></span>
                                </label>
                                <select id="select-state" placeholder="Select..." name="detection">
                                    <option value="">Select a value</option>
                                    <option value="internal-audit" @if($violation_data->detection == 'internal-audit') selected @endif>Internal Audit</option>
                                    <option value="external-audit" @if($violation_data->detection == 'external-audit') selected @endif>External Audit</option>
                                    <option value="routine-monitoring" @if($violation_data->detection == 'routine-monitoring') selected @endif>Routine Monitoring</option>
                                    <option value="incident-reporting" @if($violation_data->detection == 'incident-reporting') selected @endif>Incident Reporting</option>
                                    <option value="customer-complaints" @if($violation_data->detection == 'customer-complaints') selected @endif>Customer Complaints</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="group-input">
                                <label for="search">
                                    RPN <span class="text-danger"></span>
                                </label>
                                <select id="select-state" placeholder="Select..." name="rpn">
                                    <option value="">Select a value</option>
                                    <option value="occurrence-scale" @if($violation_data->rpn == 'occurrence-scale') selected @endif>Occurrence(O)Scale</option>
                                    <option value="severity-scale" @if($violation_data->rpn == 'severity-scale') selected @endif>Severity(S)Scale</option>
                                    <option value="detection-scale" @if($violation_data->rpn == 'detection-scale') selected @endif>Detection(D)Scale</option>
                                </select>



                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="search">
                                    Manufacturer <span class="text-danger"></span>
                                </label>
                                <input type="text" name="manufacturer" value="{{ $violation_data->manufacturer }}">
                            </div>
                        </div>

                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                Product/Material
                                <button type="button" name="product_material" id="Product_Material">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="Product_Material_details" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 4%">Row#</th>
                                            <th style="width: 12%">Product Name</th>
                                            <th style="width: 16%">Batch Number</th>
                                            <th style="width: 16%">Expiry Date</th>
                                            <th style="width: 16%">Manufactured Date</th>
                                            <th style="width: 16%">Disposition</th>
                                            <th style="width: 10%">Comment</th>
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
                                            <td><input disabled type="text" name="[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}" value="1"></td>
                                            <td><input type="text" name="product_material[{{ $loop->index }}][ProductName]" value="{{ isset($item['ProductName']) ? $item['ProductName'] : '' }}"></td>
                                            <td><input type="number" name="product_material[{{ $loop->index }}][BatchNumber]" value="{{ isset($item['BatchNumber']) ? $item['BatchNumber'] : '' }}"></td>
                                            <td><input type="date" name="product_material[{{ $loop->index }}][ExpiryDate]" value="{{ isset($item['ExpiryDate']) ? $item['ExpiryDate'] : '' }}"></td>
                                            <td><input type="date" name="product_material[{{ $loop->index }}][ManufacturedDate]" value="{{ isset($item['ManufacturedDate']) ? $item['ManufacturedDate'] : '' }}"></td>
                                            <td><input type="text" name="product_material[{{ $loop->index }}][Disposition]" value="{{ isset($item['Disposition']) ? $item['Disposition'] : '' }}"></td>
                                            <td><input type="text" name="product_material[{{ $loop->index }}][Comment]" value="{{ isset($item['Comment']) ? $item['Comment'] : '' }}"></td>
                                            <td><input type="text" name="product_material[{{ $loop->index }}][Remarks]" value="{{ isset($item['Remarks']) ? $item['Remarks'] : '' }}"></td>
                                            <td><input readonly type="text"></td>
                                        </tr>
                                        @endforeach
                                       @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-6  new-date-data-field">
                            <div class="group-input input-date">
                                <label for="date_sent">Date Sent</lable>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $violation_data->date_sent }}" name="date_sent" id="date_sent" placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $violation_data->date_sent }}" id="date_sent" name="date_sent" class="hide-input" oninput="handleDateInput(this, 'date_sent');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>


                            </div>
                        </div>

                        <div class="col-lg-6  new-date-data-field">
                            <div class="group-input input-date">
                                <label for="date_returned">Date Returned</lable>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $violation_data->date_returned }}" id="date_returned" placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $violation_data->date_returned }}" id="date_returned" name="date_returned" class="hide-input" oninput="handleDateInput(this, 'date_returned');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="group-input">
                                <label for="followUp">Follow Up</label>
                                <textarea name="follow_up">{{ $violation_data->follow_up }}</textarea>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="group-input">
                                <label for="summary">Summary</label>
                                <textarea name="summary">{{ $violation_data->summary }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Comments">Comments</label>
                                <textarea name="Comments">{{ $violation_data->Comments }}</textarea>
                            </div>
                        </div>


                        {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Support_doc">Supporting Documents</label>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Support_doc"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Support_doc[]"
                                                    oninput="addMultipleFiles(this, 'Support_doc')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div> --}}
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
            <!--
            <div id="CCForm4" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="sub-head">Action Approval</div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="qa_comments">QA Review Comments</label>
                                <textarea name="qa_comments"></textarea>
                            </div>
                        </div>
                        {{--
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="file_attach">Final Attachments</label>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="final_attach"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="final_attach[]"
                                                    oninput="addMultipleFiles(this, 'final_attach')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div> --}}
                        <div class="col-12 sub-head">
                            Extension Justification
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="due-dateextension">Due Date Extension Justification</label>
                                <textarea name="due_date_extension"></textarea>
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
            </div> -->

                <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Pending Completion</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Pending Completed By :</b></label>
                                        <div class="">{{ $violation_data->pending_completion_by }}</div>

                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Pending Completed On : </b></label>
                                        <div class="date">{{ $violation_data->pending_completion_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Pending Completed Comments : </b></label>
                                        <div class="date">{{ $violation_data->pending_completion_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Initiator Cancel</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Initiator Cancelled By :</b></label>
                                        <div class="">{{ $violation_data->initiate_cancel_by }}</div>

                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Initiator Cancelled On : </b></label>
                                        <div class="date">{{ $violation_data->initiate_cancel_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Initiator Cancelled Comments : </b></label>
                                        <div class="date">{{ $violation_data->initiate_cancel_comment }}</div>
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
                                        <div class="">{{ $violation_data->close_by }}</div>

                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Closed On : </b></label>
                                        <div class="date">{{ $violation_data->close_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>Closed Comments : </b></label>
                                        <div class="date">{{ $violation_data->close_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Cancel</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>CS/CTM Cancelled By :</b></label>
                                        <div class="">{{ $violation_data->cs_ctm_cancel_by }}</div>

                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>CS/CTM Cancelled On : </b></label>
                                        <div class="date">{{ $violation_data->cs_ctm_cancel_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">

                                        <label for="Division Code"><b>CS/CTM Cancelled Comments : </b></label>
                                        <div class="date">{{ $violation_data->cs_ctm_cancel_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>

                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit </a> </button>
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


@endsection
