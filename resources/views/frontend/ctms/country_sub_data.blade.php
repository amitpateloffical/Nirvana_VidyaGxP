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
        {{ Helpers::getDivisionName(session()->get('division')) }} / Country Sumission Data
    </div>
</div>

@php
$users = DB::table('users')->get();
@endphp

{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Country Sumission Data</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Country Submission Data</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Important Dates and Persons</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Activity Log</button>
        </div>

        <form action="{{ route('country_store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
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
                                    <label for="RLS Record Number"><b>Record Number</b></label> 
                                    <input disabled type="text" name="record_number" id="record_number" value="{{ Helpers::getDivisionName(session()->get('division')) }}/CSD/{{ date('Y') }}/{{ $record_number }}">
                                    {{-- <input disabled type="text" name="record" id="record" 
                                        value="---/CSD/{{ date('y') }}/{{ $record }}"> --}}
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
                                    <input disabled type="text" name="originator_id" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Due">Date of Initiation</label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="">Select a value</option>
                                        @foreach ($users as $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('assign_to')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Due Date</label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>

                            

                            

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="type">Type</label>
                                    <select name="type">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">Type 1</option>
                                        <option value="2">Type 2</option>
                                        <option value="3">Type 3</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="other_type">Other Type</label>
                                    <input type="text" name="other_type" id="">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="short_description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="attached_files">Attached Files</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="attached_files"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="attached_files[]" oninput="addMultipleFiles(this, 'attached_files')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="related_urls">Related URLs</label>
                                    <select name="related_urls">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">Type 1</option>
                                        <option value="2">Type 2</option>
                                        <option value="3">Type 3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="descriptions">Descriptions</label>
                                    <textarea name="descriptions" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="sub-head">
                                Location
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="zone">Zone</label>
                                    <select name="zone">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="country">Country</label>
                                    <select name="country">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="city">City</label>
                                    <input type="city" name="city">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="state_district">State/District</label>
                                    <select name="state_district">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
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
                            <div class="sub-head">
                                Product Information
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="manufacturer">Manufacturer</label>
                                    <input type="text" name="manufacturer" id="">
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Product/Material(0)
                                    <button type="button" name="audit-agenda-grid" id="Product_Material_country_sub_data">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Product-Material_country_sub_data-field-instruction-modal">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Product Name</th>
                                                <th style="width: 16%">Batch Number</th>
                                                <th style="width: 16%">Manufactured Date</th>
                                                <th style="width: 16%">Expiry Date</th>
                                                <th style="width: 15%">Disposition</th>
                                                <th style="width: 15%">Comments</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial_number_gi[0][serial]" value="1"></td>
                                            <td><input type="text" name="serial_number_gi[0][info_product_name]"></td>
                                            <td><input type="text" name="serial_number_gi[0][info_batch_number]"></td>
                                            <td>
                                                <div class="new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input
                                                                class="click_date"
                                                                id="date_0_mfg_date"
                                                                type="text"
                                                                name="serial_number_gi[0][info_mfg_date]"
                                                                placeholder="DD-MMM-YYYY"
                                                            />
                                                            <input
                                                                type="date"
                                                                name="serial_number_gi[0][info_mfg_date]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                id="date_0_mfg_date"
                                                                class="hide-input show_date"
                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                oninput="handleDateInput(this, 'date_0_mfg_date')"
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
                                                                id="date_0_expiry_date"
                                                                type="text"
                                                                name="serial_number_gi[0][info_expiry_date]"
                                                                placeholder="DD-MMM-YYYY"
                                                            />
                                                            <input
                                                                type="date"
                                                                name="serial_number_gi[0][info_expiry_date]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                id="date_0_expiry_date"
                                                                class="hide-input show_date"
                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                oninput="handleDateInput(this, 'date_0_expiry_date')"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><input type="text" name="serial_number_gi[0][info_disposition]"></td>
                                            <td><input type="text" name="serial_number_gi[0][info_comments]"></td>
                                            <td><input type="text" name="serial_number_gi[0][info_remarks]"></td>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#Product_Material_country_sub_data').click(function(e) {
                                        function generateTableRow(serialNumber) {
                                            var html = '';
                                            html +=
                                                '<tr>' +
                                                '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + serialNumber + '][info_product_name]"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + serialNumber + '][info_batch_number]"></td>' +
                                                '<td> <div class="new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input id="date_'+ serialNumber +'_mfg_date" type="text" name="serial_number_gi[' + serialNumber + '][info_mfg_date]" placeholder="DD-MMM-YYYY" /> <input type="date" name="serial_number_gi[' + serialNumber + '][info_mfg_date]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" id="date_'+ serialNumber +'_mfg_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ serialNumber +'_mfg_date\')" /> </div></div></div></td>' +
                                                '<td> <div class="new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input id="date_'+ serialNumber +'_expiry_date" type="text" name="serial_number_gi[' + serialNumber + '][info_expiry_date]" placeholder="DD-MMM-YYYY" /> <input type="date" name="serial_number_gi[' + serialNumber + '][info_expiry_date]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" id="date_'+ serialNumber +'_expiry_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ serialNumber +'_expiry_date\')" /> </div></div></div></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + serialNumber + '][info_disposition]"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + serialNumber + '][info_comments]"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + serialNumber + '][info_remarks]"></td>' +
                                                '</tr>';
                            
                                            return html;
                                        }
                            
                                        var tableBody = $('#Product-Material_country_sub_data-field-instruction-modal tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount + 1);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>

                            <div class="sub-head">
                                Country Submission Information
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="number_id">Number (Id)</label>
                                    <input type="text" name="number_id" id="">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="project_code">Project Code</label>
                                    <input type="text" name="project_code" id="">
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="authority_type">Authority Type</label>
                                    <select name="authority_type">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="authority">Authority</label>
                                    <select name="authority">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="priority_level">Priority Level</label>
                                    <select name="priority_level">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="other_authority">Other Authority</label>
                                    <input type="text" name="other_authority" id="">
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="approval_status">Approval Status</label>
                                    <select name="approval_status">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Managed by Company">Managed by Company?</label>
                                    <select name="managed_by_company">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Managed by Company">Marketing Status</label>
                                    <select name="marketing_status">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Therapeutic Area">Therapeutic Area</label>
                                    <select name="therapeutic_area">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="End of Trial Date Status">End of Trial Date Status</label>
                                    <select name="end_of_trial_date_status">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Protocol Type">Protocol Type</label>
                                    <select name="protocol_type">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Registration Status">Registration Status</label>
                                    <select name="registration_status">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="unblinded_SUSAR_to_CEC">Unblinded SUSAR to CEC?</label>
                                    <select name="unblinded_SUSAR_to_CEC">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Trade Name">Trade Name</label>
                                    <select name="trade_name">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Dosage Form">Dosage Form</label>
                                    <select name="dosage_form">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Photocure Trade Name">Photocure Trade Name</label>
                                    <input type="text" name="photocure_trade_name" id="">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Currency">Currency</label>
                                    <input type="text" name="currency" id="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Attacehed Payments">Attacehed Payments</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="attacehed_payments"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="attacehed_payments[]" oninput="addMultipleFiles(this, 'attacehed_payments')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="follow_up_documents">Follow Up Documents</label>
                                    <select name="follow_up_documents">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Hospitals">Hospitals</label>
                                    <select id="hospitals" name="hospitals">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="vendors">Vendors</label>
                                    <select id="vendors" name="vendors">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="INN">INN(s)</label>
                                    <select id="INN" name="INN" id="">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Route of Administration">Route of Administration</label>
                                    <select id="route_of_administration" name="route_of_administration">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="first_IB_version">1st IB Version</label>
                                    <input type="text" name="first_IB_version" id="">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="first_protocol_version">1st Protocol Version</label>
                                    <input type="text" name="first_protocol_version" id="">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="eudraCT_numberr">EudraCT Number</label>
                                    <input type="text" name="eudraCT_number" id="">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="budget">Budget</label>
                                    <input type="text" name="budget" id="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="phase_of_study">Phase of Study</label>
                                    <select id="phase_of_study" name="phase_of_study">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="related_clinical_trials">Related Clinical Trials</label>
                                    <select name="related_clinical_trials">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Financial Transactions(0)
                                    <button type="button" name="audit-agenda-grid" id="Financial_Transactions_country_sub_data">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Financial_Transactions_country_sub_data-field-instruction-modal">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Transaction</th>
                                                <th style="width: 16%">Transaction Type</th>
                                                <th style="width: 16%">Date</th>
                                                <th style="width: 16%">Amount</th>
                                                <th style="width: 15%">Currency Used</th>
                                                <th style="width: 15%">Comments</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="financial_transection[0][serial]" value="1"></td>
                                            <td><input type="text" name="financial_transection[0][info_transaction]"></td>
                                            <td><input type="text" name="financial_transection[0][info_transaction_type]"></td>
                                            <td>
                                                <div class="new-date-data-field">
                                                    <div class="group-input input-date">
                                                        <div class="calenderauditee">
                                                            <input
                                                                class="click_date"
                                                                id="date_0_date"
                                                                type="text"
                                                                name="financial_transection[0][info_date]"
                                                                placeholder="DD-MMM-YYYY"
                                                            />
                                                            <input
                                                                type="date"
                                                                name="financial_transection[0][info_date]"
                                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                id="date_0_date"
                                                                class="hide-input show_date"
                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                oninput="handleDateInput(this, 'date_0_date')"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><input type="number" name="financial_transection[0][info_amount]"></td>
                                            <td><input type="text" name="financial_transection[0][info_currency_used]"></td>
                                            <td><input type="text" name="financial_transection[0][info_comments]"></td>
                                            <td><input type="text" name="financial_transection[0][info_remarks]"></td>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#Financial_Transactions_country_sub_data').click(function(e) {
                                        function generateTableRow(serialNumber) {
                                            var html = '';
                                            html +=
                                                '<tr>' +
                                                '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                                                '<td><input type="text" name="financial_transection[' + serialNumber + '][info_transaction]"></td>' +
                                                '<td><input type="text" name="financial_transection[' + serialNumber + '][info_transaction_type]"></td>' +
                                                '<td> <div class="new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input class="click_date" id="date_'+ serialNumber +'_date" type="text" name="financial_transection[' + serialNumber + '][info_date]" placeholder="DD-MMM-YYYY"/><input type="date" name="financial_transection[' + serialNumber + '][info_date]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="date_'+ serialNumber +'_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ serialNumber +'_date\')"/></div></div></div></td>' +
                                                '<td><input type="number" name="financial_transection[' + serialNumber + '][info_amount]"></td>' +
                                                '<td><input type="text" name="financial_transection[' + serialNumber + '][info_currency_used]"></td>' +
                                                '<td><input type="text" name="financial_transection[' + serialNumber + '][info_comments]"></td>' +
                                                '<td><input type="text" name="financial_transection[' + serialNumber + '][info_remarks]"></td>' +
                                                '</tr>';
                            
                                            return html;
                                        }
                            
                                        var tableBody = $('#Financial_Transactions_country_sub_data-field-instruction-modal tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount + 1);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Ingredients(0)
                                    <button type="button" name="audit-agenda-grid" id="Ingredients_country_sub_data">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Ingredients_country_sub_data-field-instruction-modal">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Ingredient Type</th>
                                                <th style="width: 16%">Ingredient Name</th>
                                                <th style="width: 16%">Ingredient Strength</th>
                                                <th style="width: 15%">Comments</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="ingredi[0][serial]" value="1"></td>
                                            <td><input type="text" name="ingredi[0][info_ingredient_type]"></td>
                                            <td><input type="text" name="ingredi[0][info_ingredient_name]"></td>
                                            <td><input type="text" name="ingredi[0][info_ingredient_strength]"></td>
                                            <td><input type="text" name="ingredi[0][info_comments]"></td>
                                            <td><input type="text" name="ingredi[0][info_remarks]"></td>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Data Safety Notes">Data Safety Notes</label>
                                    <select name="data_safety_notes">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="comments">Comments</label>
                                    <select name="comments">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
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

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Annual IB Due Date">Annual IB Update Date Due</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="annual_ib" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="annual_IB_update_date_due"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'annual_ib')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date of 1st IB">Date of 1st IB</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="first_IB" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="date_of_first_IB"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'first_IB')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date of 1st Protocol">Date of 1st Protocol</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="first_protocol" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="date_of_first_protocol"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'first_protocol')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date Safety Report">Date Safety Report</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="safety_report" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="date_safety_report"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'safety_report')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date Trial Active">Date Trial Active</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="trial_active" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="date_trial_active"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'trial_active')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="End of Study Report Date">End of Study Report Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="study_report_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="end_of_study_report_date"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'study_report_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="End of Study Synopsis Date">End of Study Synopsis Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="study_synopsis_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="end_of_study_synopsis_date"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'study_synopsis_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="End of Trial Date">End of Trial Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="end_of_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="end_of_trial_date"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'end_of_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Last Visit">Last Visit</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="visit_last" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="last_visit"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'visit_last')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Next Visit">Next Visit</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="visit_next" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="next_visit"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'visit_next')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Ethics Commitee Approval">Ethics Commitee Approval</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="commitee_approval" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="ethics_commitee_approval"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            class="hide-input" oninput="handleDateInput(this, 'commitee_approval')" />
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">
                                Persons Involved
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="safety_impact_risk">Safety Impact Risk</label>
                                    <div><small class="text-primary">Acceptable- Risks Nigligible, Further Effort not justified; consider product improvement</small></div>
                                    <select name="safety_impact_risk">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="CROM">CROM</label>
                                    <input type="text" name="CROM" id="" />
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="lead_investigator">Lead Investigator</label>
                                    <input type="text" name="lead_investigator" id="">

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="sponsor">Sponsor</label>
                                    <input type="text" name="sponsor" id="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="additional_investigators">Additional Investigators</label>
                                    <select id="additional_investigators" name="additional_investigators" id="">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="clinical_events_committee">Clinical Events Committee</label>
                                    <select id="clinical_events_committee" name="clinical_events_committee" id="">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="clinical_research_team">Clinical Research Team</label>
                                    <select id="clinical_research_team" name="clinical_research_team" id="">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="data_safety_monitoring_board">Data Safety Monitoring Board</label>
                                    <select id="data_safety_monitoring_board" name="data_safety_monitoring_board" id="">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Distribution List">Distribution List</label>
                                    <select id="distribution_list" name="distribution_list" id="">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
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

                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Closed by">Activate By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Closed on">Activate On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="Closed on">Activate Comment</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Closed by">Close By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Closed on">Close On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="Closed on">Close Comment</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Closed by">Cancel By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Closed on">Cancel On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="Closed on">Cancel Comment</label>
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
        if (currentStep < steps.length - 1) {
            steps[currentStep].style.display = "none";
            steps[currentStep + 1].style.display = "block";
            stepButtons[currentStep + 1].classList.add("active");
            stepButtons[currentStep].classList.remove("active");
            currentStep++;
        }
    }

    function previousStep() {
        if (currentStep > 0) {
            steps[currentStep].style.display = "none";
            steps[currentStep - 1].style.display = "block";
            stepButtons[currentStep - 1].classList.add("active");
            stepButtons[currentStep].classList.remove("active");
            currentStep--;
        }
    }
</script>

<script>
    $(document).ready(function() {
        $('#Ingredients_country_sub_data').click(function(e) {
            function generateTableRow(serialNumber) {
                var html = '';
                html =
                '<tr>' +
                '<td><input disabled type="text" name="ingredi[serial]" value="' + serialNumber + '"></td>' +
                '<td><input type="text" name="ingredi[' + serialNumber + '][info_ingredient_type]"></td>' +
                '<td><input type="text" name="ingredi[' + serialNumber + '][info_ingredient_name]"></td>' +
                '<td><input type="text" name="ingredi[' + serialNumber + '][info_ingredient_strength]"></td>' +
                '<td><input type="text" name="ingredi[' + serialNumber + '][info_comments]"></td>' +
                '<td><input type="text" name="ingredi[' + serialNumber + '][info_remarks]"></td>' +
                '</tr>';

                return html;
            }

            var tableBody = $('#Ingredients_country_sub_data-field-instruction-modal tbody');
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