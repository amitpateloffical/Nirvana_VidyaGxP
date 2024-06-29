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
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / CTA Submission
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">CTA Submission</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm2')">CTA Submission Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Root Cause Analysis</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signatures</button>
        </div>

        <form action="{{ route('cta_submission_store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                <!-- Tab-1 -->

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Record Number</b></label>
                                    <input readonly type="text" name="record_number" value="{{ Helpers::getDivisionName(session()->get('division')) }}/RCA/{{ date('Y') }}/{{ $record_number }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input type="text" readonly name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Initiator</b></label>
                                    <input disabled type="text" name="originator_id" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="initiation_date">Date of Initiation <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="initiation_date">
                                    <input type="hidden" value="{{ date('d-m-Y') }}" name="initiation_date">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="ShortDescription">Short Description<span class="text-danger">*</span></label>
                                    <input id="ShortDescription" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assigned_to">
                                        <option value="">Select a value</option>
                                        <option value="Pankaj Jat">Pankaj Jat</option>
                                        <option value="Gaurav">Gaurav</option>
                                        <option value="Manish">Manish</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due_date">Date Due <span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Type</label>
                                    <select name="type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="T-1">T-1</option>
                                        <option value="T-2">T-2</option>
                                        <option value="T-3">T-3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="other_type">Other Type</label>
                                    <input type="text" maxlength="255" name="other_type" id="other_type" value=""/>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="closure attachment">Attached Files </label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="attached_files"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="attached_files[]" oninput="addMultipleFiles(this, 'attached_files')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="description"> Description</label>
                                    <textarea class="summernote" name="description" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="sub-head">Location</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="zone">Zone</label>
                                    <select name="zone" id="zone">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="P-1">P-1</option>
                                        <option value="P-2">P-2</option>
                                        <option value="P-3">P-3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="country">Country</label>
                                    <select name="country" id="country">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="India">India</option>
                                        <option value="UK">UK</option>
                                        <option value="USA">USA</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="city">City</label>
                                    <select name="city" id="city">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Indore">Indore</option>
                                        <option value="Bhopal">Bhopal</option>
                                        <option value="Dewas">Dewas</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="state_district">State/District</label>
                                    <select name="state_district" id="state_district">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Dewas">Dewas</option>
                                        <option value="Harda">Harda</option>
                                        <option value="Sehore">Sehore</option>
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

                <!-- Tab-2 -->
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Submission Information</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="procedure_number">Procedure Number</label>
                                    <input type="text" maxlength="255" name="procedure_number" id="procedure_number" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="project_code">Project Code</label>
                                    <input type="text" maxlength="255" value="" id="project_code" name="project_code" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="authority_type">Authority Type </label>
                                    <select name="authority_type" id="authority_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="AT-1">AT-1</option>
                                        <option value="AT-2">AT-2</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="authority">Authority </label>
                                    <select name="authority" id="authority">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="AT-1">AT-1</option>
                                        <option value="AT-2">AT-2</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="registration_number">Registration Number</label>
                                    <input type="number" name="registration_number" id="registration_number"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="other_authority">Other Authority</label>
                                    <input type="text" maxlength="255" name="other_authority" id="other_authority" value="" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="year">Year </label>
                                    <select name="year" id="year">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="procedure_type">Procedure Type</label>
                                    <input type="text" maxlength="255" name="procedure_type" id="procedure_type" value=""/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="registration_status">Registration Status </label>
                                    <select name="registration_status" id="registration_type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Done">Done</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="outcome"> Outcome </label>
                                    <select name="outcome" id="outcome">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="O-1">O-1</option>
                                        <option value="O-2">O-2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="trade_name"> Trade Name </label>
                                    <select name="trade_name" id="trade_name">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="T-1">T-1</option>
                                        <option value="T-2">T-2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="comments">Comments</label>
                                    <textarea class="summernote" name="comments" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="sub-head">Product Information</div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="manufacturer">Manufacturer</label>
                                    <input type="text" maxlength="255" name="manufacturer" id="manufacturer"/>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Product/Material(0)
                                    <button type="button" name="audit-agenda-grid" id="productAdd">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="product-Table">
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
                                            <td><input type="text" maxlength="255" name="serial_number_gi[0][info_product_name]"></td>
                                            <td><input type="text" maxlength="255" name="serial_number_gi[0][info_batch_number]"></td>
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
                                            <td><input type="text" maxlength="255" name="serial_number_gi[0][info_disposition]"></td>
                                            <td><input type="text" maxlength="255" name="serial_number_gi[0][info_comments]"></td>
                                            <td><input type="text" maxlength="255" name="serial_number_gi[0][info_remarks]"></td>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#productAdd').click(function(e) {
                                        function generateTableRow(serialNumber) {
                                            var html =
                                                '<tr>' +
                                                '<td><input disabled type="text" name="serial_number_gi['+ serialNumber +'][serial]" value="' + serialNumber + '"></td>' +
                                                '<td><input type="text" maxlength="255" name="serial_number_gi['+ serialNumber +'][info_product_name]"></td>' +
                                                '<td><input type="text" maxlength="255" name="serial_number_gi['+ serialNumber +'][info_batch_number]"></td>' +
                                                // '<td><input type="date" name="ExpiryDate[]"></td>' +
                                                // '<td><input type="date" name="ManufacturedDate[]"></td>' +
                                                '<td><div class="col-md-6 new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input class="click_date" id="date_'+ serialNumber +'_mfg_date" type="text" name="serial_number_gi['+ serialNumber +'][info_mfg_date]" placeholder="DD-MMM-YYYY"/><input type="date" name="serial_number_gi['+ serialNumber +'][info_mfg_date]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="date_'+ serialNumber +'_mfg_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ serialNumber +'_mfg_date\')"/></div></div></div></td>' +
                                                '<td><div class="col-md-6 new-date-data-field"> <div class="group-input input-date"> <div class="calenderauditee"><input class="click_date" id="date_'+ serialNumber +'_expiry_date" type="text" name="serial_number_gi['+ serialNumber +'][info_expiry_date]" placeholder="DD-MMM-YYYY"/><input type="date" name="serial_number_gi['+ serialNumber +'][info_expiry_date]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="date_'+ serialNumber +'_expiry_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ serialNumber +'_expiry_date\')"/></div></div></div></td>' +
                                                '<td><input type="text" maxlength="255" name="serial_number_gi['+ serialNumber +'][info_disposition]"></td>' +
                                                '<td><input type="text" maxlength="255" name="serial_number_gi['+ serialNumber +'][info_comments]"></td>' +
                                                '<td><input type="text" maxlength="255" name="serial_number_gi['+ serialNumber +'][info_remarks]"></td>'+
                                                '</tr>';
                                            '</tr>';
                                            return html;
                                        }
                            
                                        var tableBody = $('#product-Table tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount + 1);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>

                            <div class="sub-head">Important Dates</div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="actual_submission_date">Actual Submission Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="actual_submission_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="actual_submission_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'actual_submission_date')" />
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="actual_rejection_date">Actual Rejection Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="actual_rejection_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="actual_rejection_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'actual_rejection_date')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="actual_withdrawn_date">Actual Withdrawn Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="actual_withdrawn_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="actual_withdrawn_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'actual_withdrawn_date')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="inquiry_date">Inquiry Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="inquiry_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="inquiry_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'inquiry_date')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="planned_submission_date">Planned Submission Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="planned_submission_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="planned_submission_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'planned_submission_date')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="planned_date_sent_to_affilate">Planned Date Sent To Affilate</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="planned_date_sent_to_affilate" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="planned_date_sent_to_affilate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'planned_date_sent_to_affilate')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="effective_date">Effective Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="effective_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="effective_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'effective_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">Persons Involved</div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="additional_assignees">Additional Assignees</label>
                                    <select name="additional_assignees" id="additional_assignees">
                                        <option value="">--Select---</option>
                                        <option value="Pankaj">Pankaj</option>
                                        <option value="Gaurav">Gaurav</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="additional_investigators">Additional Investigators</label>
                                    <select id="additional_investigators" name="additional_investigators">
                                        <option value="">--Select---</option>
                                        <option value="Pankaj">Pankaj</option>
                                        <option value="Gaurav">Gaurav</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="approvers">Approvers</label>
                                    <select id="approvers" name="approvers">
                                        <option value="">--Select---</option>
                                        <option value="Pankaj">Pankaj</option>
                                        <option value="Gaurav">Gaurav</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="negotiation_team">Negotiation Team</label>
                                    <select id="negotiation_team" name="negotiation_team">
                                        <option value="">--Select---</option>
                                        <option value="Pankaj">Pankaj</option>
                                        <option value="Gaurav">Gaurav</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="trainer">Trainer</label>
                                    <input type="text" maxlength="255" name="trainer" />
                                </div>
                            </div>

                            <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab-3 -->

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">


                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="root_cause_description">Root Cause Description</label>
                                    <textarea class="summernote" name="root_cause_description" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="reason_for_non_approval">Reason(s) For Non-Approval</label>
                                    <textarea class="summernote" name="reason_for_non_approval" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="reason_for_withdrawal">Reason(s) For Withdrawal</label>
                                    <textarea class="summernote" name="reason_for_withdrawal" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="justification_rationale">Justification/Rationale</label>
                                    <textarea class="summernote" name="justification_rationale" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="meeting_minutes">Meeting Minutes</label>
                                    <textarea class="summernote" name="meeting_minutes" id="summernote-16"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="rejection_reason">Rejection Reason</label>
                                    <textarea class="summernote" name="rejection_reason" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="effectiveness_check_summary">Effectiveness Check Summary</label>
                                    <textarea class="summernote" name="effectiveness_check_summary" id="summernote-16"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="decisions">Decisions</label>
                                    <textarea class="summernote" name="decisions" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="group-input">
                                    <label class="mt-4" for="summary"> Summary</label>
                                    <textarea class="summernote" name="summary" id="summernote-16"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="documents_affected">Documents Affected </label>
                                    <select id="documents_affected" name="documents_affected">
                                        <option value="">--Select---</option>
                                        <option value="Pankaj">Pankaj</option>
                                        <option value="Gaurav">Gaurav</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="actual_time_spent">Actual Time Spent</label>
                                    <input type="text" maxlength="255" name="actual_time_spent" id="actual_time_spent" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="documents">Documents</label>
                                    <input type="text" maxlength="255" name="documents" id="documents"/>
                                </div>
                            </div>

                            <div class="button-block">                                
                            <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab-4 -->

                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Submission By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Submission On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Submission Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Withdraw By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Withdraw On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Withdraw Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Finalize Dossier By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Finalize Dossier On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Finalize Dossier Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Notification By</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Notification On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Notification Comment</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Cancelled By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Cancelled On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Cancelled Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Not Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Not Approved On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Not Approved Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Approved with Conditions By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Approved with Conditions On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Approved with Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Approved On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Approved Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Conditions to Fulfill Before
                                        FPI By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Conditions to Fulfill Before
                                        FPI On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="approved_on">Conditions to Fulfill Before
                                        FPI Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">More Comments By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">More Comments On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">More Comments</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Submit response By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Submit response On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Submit response Comment</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Early Termination By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Early Termination On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">Early Termination Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">All Conditions
                                        are met By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">All Conditions
                                        are met On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <div class="group-input">
                                    <label for="approved_by">All Conditions
                                        are met - Comment</label>
                                    <div class="static"></div>
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
@endsection