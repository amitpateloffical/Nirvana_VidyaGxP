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

            <form action="{{ route('resampling_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="step-form">
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number">
                                            {{-- value="{{ Helpers::getDivisionName(session()->get('division')) }}/MR/{{ date('Y') }}/{{ $record_number }}" --}}
                                        <!-- {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}} -->
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
                                        <label for="Initiator"><b>Initiator</b></label>
                                        {{-- <div class="static">{{ Auth::user()->name }}</div> --}}
                                        {{-- <input disabled type="text" value="{{ Auth::user()->name }}"> --}}
                                    <input readonly type="text" name="initiator_id" value="" />

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
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="assign_to">
                                            <option value="assign_to">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach 
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
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
                                        <label for="cq_Approver"><b>CQ Approver</b></label>
                                        <input type="text" name="cq_Approver">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Supervisor"><b>Supervisor</b></label>
                                        <input type="text" name="supervisor">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="api_Material_Product_Name"><b>API/Material/Drug Product Name</b></label>
                                        <input  type="text" name="api_Material_Product_Name">
                                    </div>
                                </div> <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="lot_Batch_Number"><b>Lot/Batch Number</b></label>
                                        <input type="text" name="lot_Batch_Number">
                                    </div>
                                 </div>
                                  <div class="col-lg-6">
                                <div class="group-input">
                                    <label for=" AR Number"><b>AR Number</b></label>
                                    <input type="text" name="ar_Number_GI">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Test Name"><b>Test Name</b></label>
                                    <input type="text" name="test_Name_GI">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="justification_for_resampling">Justification For Resampling</label>
                                    <textarea name="justification_for_resampling_GI"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Predetermined Sampling Strategies</label>
                                    <textarea name="predetermined_Sampling_Strategies_GI"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="supporting_attach">Supporting Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="supporting_attach"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="supporting_attach[]"
                                                oninput="addMultipleFiles(this, 'supporting_attach')" multiple>
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
                                        <input type="text" id="end_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" id="end_date_checkdate" name="parent_tcd_hid" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                            oninput="handleDateInput(this, 'end_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">
                                Parent Record Information
                               </div>
                               <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) OOS No.</b></label>
                                    <input type="text" name="parent_oos_no">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) OOT No.</b></label>
                                    <input type="text" name="parent_oot_no">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) Lab Incident No.</b></label>
                                    <input type="text" name="parent_lab_incident_no">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">(Parent)Date Opened</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" id="start_date_checkdate"  name="parent_date_opened" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                            oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">(Parent)Short Description<span
                                            class="text-danger"></span></label><span id="rchars"></span>
                                    <input id="docname" type="text" name="parent_short_description" maxlength="255" >
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) Product/Material Name</b></label>
                                    <input type="text" name="parent_product_material_name">
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">(Parent)Target Closure Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="end_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" id="end_date_checkdate"  name="parent_target_closure_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                            oninput="handleDateInput(this, 'end_date');checkDate('end_date_checkdate','end_date_checkdate')"/>
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
                                            Product/Material Information<button type="button" name="product_material_information" id="product_material">+</button>
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
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td><input  type="text" name="serial_number[]" value="1"></td>
                                                    <td><input type="text" name="product_material_information[0][product_material]"></td>
                                                    <td><input type="text" name="product_material_information[0][batch_no]"></td>
                                                    <td><input type="text" name="product_material_information[0][ar_no]"></td>
                                                    <td><input type="text" name="product_material_information[0][test_name]"></td>
                                                    <td><input type="text" name="product_material_information[0][instrument_name]"></td>
                                                    <td><input type="text" name="product_material_information[0][instrument_no]"></td>
                                                    <td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee">
                                                        <input type="text" id="agenda_date0" readonly placeholder="DD-MMM-YYYY" />
                                                        <input type="date" name="product_material_information[0][date]"   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                        oninput="handleDateInput(this, `agenda_date0`);" /></div></div></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="agenda">
                                          Info. On Product/Material<button type="button" name="info_on_product_mat" id="info_on_product">+</button>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $serialNumber = 1;
                                            @endphp
                                                <tr>
                                                    <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                                    <td><input type="text" name="info_on_product_mat[0][item_product_code]"></td>
                                                    <td><input type="text" name="info_on_product_mat[0][lot_batch_no]"></td>
                                                    <td><input type="text" name="info_on_product_mat[0][ar_no]"></td>
                                                    <td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee">
                                                        <input type="text" id="agenda_date01" readonly placeholder="DD-MMM-YYYY" />
                                                        <input type="date" name="info_on_product_mat[0][date01]"   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                        oninput="handleDateInput(this, `agenda_date01`);" /></div></div></div></td>
                                                     <td><div class="group-input new-date-data-field mb-02"><div class="input-date "><div class="calenderauditee">
                                                     <input type="text" id="agenda_date02" readonly placeholder="DD-MMM-YYYY" />
                                                         <input type="date" name="info_on_product_mat[0][date02]"   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                        oninput="handleDateInput(this, `agenda_date0`);" /></div></div></div></td>
                                                    <td><input type="text" name="info_on_product_mat[0][label_claim]"></td>
                                                    <td><input type="text" name="info_on_product_mat[0][pack_size]"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- 3 --}}

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="agenda">
                                          OOS Details<button type="button" name="oos_details" id="oos_details">+</button>
                                        </label>
                                        <table class="table table-bordered" id="oos_details_body">
                                            <thead>
                                                <tr>
                                                    <th>Row #</th>
                                                    <th>AR Number</th>
                                                    <th>Test Name of OOS</th>
                                                    <th>Results obtained</th>
                                                    <th>Specification Limit</th>
                                                    {{-- <th>Instru. Caliberation Due Date</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                                    <td><input type="text" name="oos_details[0][ar_no]"></td>
                                                    <td><input type="text" name="oos_details[0][test_name_of_OOS]"></td>
                                                    <td><input type="text" name="oos_details[0][results_obtained]"></td>
                                                    <td><input type="text" name="oos_details[0][specification_limit]"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- 4 --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="agenda">
                                          OOT Results<button type="button" name="oot_detail" id="oot_detail">+</button>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                                    <td><input type="text" name="oot_detail[0][ar_no_oot]"></td>
                                                    <td><input type="text" name="oot_detail[0][test_name_oot]"></td>
                                                    <td><input type="text" name="oot_detail[0][results_obtained_oot]"></td>
                                                    <td><input type="text" name="oot_detail[0][initial_Interval_Details_oot]"></td>
                                                    <td><input type="text" name="oot_detail[0][previous_Interval_Details_oot]"></td>
                                                    <td><input type="text" name="oot_detail[0][difference_of_Results_oot]"></td>
                                                    <td><input type="text" name="oot_detail[0][initial_interview_Details_oot]"></td>
                                                    <td><input type="text" name="oot_detail[0][trend_Limit_oot]"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- 5 --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="agenda">
                                          Details of Stability Study<button type="button" name="stability_study[]" id="stability_study">+</button>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                                    <td><input type="text" name="stability_study[0][ar_no_stability_stdy]"></td>
                                                    <td><input type="text" name="stability_study[0][condition_temp_stability_stdy]"></td>
                                                    <td><input type="text" name="stability_study[0][interval_stability_stdy]"></td>
                                                    <td><input type="text" name="stability_study[0][orientation_stability_stdy]"></td>
                                                    <td><input type="text" name="stability_study[0][pack_details_if_any_stability_stdy]"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                {{-- 5 --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="agenda">
                                          Details of Stability Study.<button type="button" name="stability_study2" id="stability_study2">+</button>
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

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                                    <td><input type="text" name="stability_study2[0][ar_no_stability_stdy2]"></td>
                                                    <td><input type="text" name="stability_study2[0][stability_condition_stability_stdy2]"></td>
                                                    <td><input type="text" name="stability_study2[0][stability_interval_stability_stdy2]"></td>
                                                    <td><input type="text" name="stability_study2[0][pack_details_if_any_stability_stdy2]"></td>
                                                    <td><input type="text" name="stability_study2[0][orientation_stability_stdy2]"></td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


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
                                <textarea name="sample_Request_Approval_Comments"></textarea>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Inv Attachments">Sample Request Approval Attachment</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="inv_attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="sample_Request_Approval_attachment[]"
                                                oninput="addMultipleFiles(this, 'inv_attachment')" multiple>
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
                                    <select  name="sample_Received" id="audit_type"  value="">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Facility">Facility</option>
                                            {{-- <option @if ($data->audit_type == 'Equipment/Instrument') selected @endif
                                                value="Equipment/Instrument">Equipment/Instrument</option> --}}
                                                        <option  value="Data integrity">Data integrity</option>
                                                            {{-- <option @if ($data->audit_type == 'Anyother(specify)') selected @endif
                                                                value="Anyother(specify)">Anyother(specify)</option> --}}
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Sample Quantity</b></label>
                                    <input type="text" name="sample_Quantity">
                                </div>
                            </div>


                            <div class="group-input">
                                <label for="customer_satisfaction_level">Sample Received Comments</label>
                                <textarea name="sample_Received_Comments"></textarea>
                            </div>
                            <div class="group-input">
                                <label for="budget_estimates">Delay Justification</label>
                                <textarea name="delay_Justification"></textarea>
                            </div>

                            <div class="group-input">
                                <label for="file_attchment_if_any">File Attachment, if any</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="file_attchment_if_any"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile"
                                            name="file_attchment_pending_sample[]"{{-- ignore --}}
                                            oninput="addMultipleFiles(this, 'file_attchment_if_any')" multiple>
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
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Submit By : </label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Submit On :</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                                <div class="sub-head">Under Sample Request Approval</div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="HOD Review Complete By">Sample Req. Approval Done By :</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="HOD Review Complete By">Sample Req. Approval Done On :</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="sub-head">Pending Sample Received</div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Sample Received Completed By :</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div> <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Sample Received Completed On :</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>

                                <div class="sub-head">Cancellation</div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Cancel Request By :</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Cancel Request On :</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
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
            cell3.innerHTML = '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="date_due' + currentRowCount +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="date_due[]"   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="date_due' + currentRowCount +'_checkdate"  class="hide-input" oninput="handleDateInput(this, `date_due' + currentRowCount +'`);checkDate(`date_due' + currentRowCount +'_checkdate`,`date_closed' + currentRowCount +'_checkdate`)" /></div></div></div></td>';

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
            cell7.innerHTML = '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="date_closed' + currentRowCount +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="date_closed[]"  min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  id="date_closed'+ currentRowCount +'_checkdate" class="hide-input" oninput="handleDateInput(this, `date_closed' + currentRowCount +'`);checkDate(`date_due' + currentRowCount +'_checkdate`,`date_closed' + currentRowCount +'_checkdate`)" /></div></div></div></td>';

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

            $('#product_material').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    // '<td><input type="date" name="date[]"></td>' +
                    '<td><input type="text" name="product_material_information[0][product_material]"></td>' +
                    '<td><input type="text" name="product_material_information[0][batch_no]"></td>' +
                    '<td><input type="text" name="product_material_information[0][ar_no]"></td>' +
                    '<td><input type="text" name="product_material_information[0][test_name]"></td>' +
                    '<td><input type="text" name="product_material_information[0][instrument_name]"></td>' +
                    '<td><input type="text" name="product_material_information[0][instrument_no]"></td>'+
                    '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="agenda_date'+ serialNumber +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="product_material_information[0][date]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, `agenda_date' + serialNumber +'`)" /></div></div></div></td>'+
                    '</tr>';
                return html;
            }
            var tableBody = $('#product_material_body tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });

        $('#info_on_product').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    // '<td><input type="date" name="date[]"></td>' +
                    '<td><input type="text" name="info_on_product_mat[0][item_product_code]"></td>' +
                    '<td><input type="text" name="info_on_product_mat[0][lot_batch_no]"></td>' +
                    '<td><input type="text" name="info_on_product_mat[0][ar_no]"></td>' +
                    '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="agenda_date01" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="info_on_product_mat[0][date01]"   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, `agenda_date01`);" /></div></div></div></td>' +
                    '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="agenda_date02" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="info_on_product_mat[0][date02]"   min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, `agenda_date02`);" /></div></div></div></td>' +
                    '<td><input type="text" name="info_on_product_mat[0][label_claim]"></td>'+
                    '<td><input type="text" name="info_on_product_mat[0][pack_size]"></td>'+
                    '</tr>';
                return html;
            }
            var tableBody = $('#info_on_product_body tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });

// 3

$('#oos_details').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    // '<td><input type="date" name="date[]"></td>' +
                    '<td><input type="text" name="oos_details[0][ar_no]"></td>' +
                    '<td><input type="text" name="oos_details[0][test_name_of_OOS]"></td>' +
                    '<td><input type="text" name="oos_details[0][results_obtained]"></td>' +
                    '<td><input type="text" name="oos_details[0][specification_limit]"></td>'+
                    '</tr>';
                return html;
            }
            var tableBody = $('#oos_details_body tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });


        // 4

        $('#oot_detail').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="oot_detail[0][ar_no_oot]"></td>' +
                    '<td><input type="text" name="oot_detail[0][test_name_oot]"></td>' +
                    '<td><input type="text" name="oot_detail[0][results_obtained_oot]"></td>' +
                    '<td><input type="text" name="oot_detail[0][initial_Interval_Details_oot]"></td>'+
                    '<td><input type="text" name="oot_detail[0][previous_Interval_Details_oot]"></td>'+
                    '<td><input type="text" name="oot_detail[0][difference_of_Results_oot]"></td>'+
                    '<td><input type="text" name="oot_detail[0][initial_interview_Details_oot]"></td>'+
                    '<td><input type="text" name="oot_detail[0][trend_Limit_oot]"></td>'+
                    '</tr>';
                return html;
            }
            var tableBody = $('#oot_detail_body tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });


        // 5

        $('#stability_study').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="stability_study[0][ar_no_stability_stdy]"></td>' +
                    '<td><input type="text" name="stability_study[0][condition_temp_stability_stdy]"></td>' +
                    '<td><input type="text" name="stability_study[0][interval_stability_stdy]"></td>' +
                    '<td><input type="text" name="stability_study[0][orientation_stability_stdy]"></td>'+
                    '<td><input type="text" name="stability_study[0][pack_details_if_any_stability_stdy]"></td>'+
                    '</tr>';
                return html;
            }
            var tableBody = $('#stability_study_body tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });

    // 6

 $('#stability_study2').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="stability_study2[0][ar_no_stability_stdy2]"></td>' +
                    '<td><input type="text" name="stability_study2[0][stability_condition_stability_stdy2]"></td>' +
                    '<td><input type="text" name="stability_study2[0][stability_interval_stability_stdy2]"></td>' +
                    '<td><input type="text" name="stability_study2[0][pack_details_if_any_stability_stdy2]"></td>'+
                    '<td><input type="text" name="stability_study2[0][orientation_stability_stdy2]"></td>'+
                    '</tr>';
                return html;
            }
            var tableBody = $('#stability_study2_body tbody');
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
                    $('#rchars').text(textlen);});
            </script>
@endsection
