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
        / Contract testing Lab Audit
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">CTL Audit Preparation</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">CTL Audit Execution</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Audit Report Prep. & Approval</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">CTL Audit Report Issuance</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Pending CTL Response</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm7')">CTL Audit Compliance Accept</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm8')">CTL Audit Compliance Approval</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Audit Conclusion</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm10')">Signatures</button>
        </div>

        <form action="{{ route('actionItem.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">
                                Parent Record Information
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>(Parent) Date Opened</b></label>
                                    <input type="date" name="date_opened" value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiation"><b>(parent) Audit Scheduled for the year</b></label>
                                     <select name="audit_scheduled_for_the_year">
                                         <option value="2022">2022</option>
                                         <option value="2023">2023</option>
                                         <option value="2024">2024</option>
                                         <option value="2025">2025</option>
                                         <option value="2026">2026</option>
                                         <option value="2027">2027</option>
                                     </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="ctl_audit_schedule_no">(Parent) CTL Audit Schedule No.</label>
                                    <input type="number" name="ctl_audit_schedule_no">
                                </div>
                            </div>

                            <div class="sub-head">
                                Audit Information
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator">CTL Audit No.</label>
                                    <input disabled type="text" name="record">
                                    {{--value="{{ Helpers::getDivisionName(session()->get('division')) }}/Correspondence/{{ date('Y') }}/{{ $record_number }}"--}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input readonly type="text" name="division_code">
                                    {{--value="{{ Helpers::getDivisionName(session()->get('division')) }}"--}}
                                    <input type="hidden" name="division_id">
                                    {{--value="{{ session()->get('division') }}"--}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Originator</b></label>
                                    <input disabled type="text" name="Initiator" value="">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Date of Initiation</b></label>
                                    <input readonly type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span>
                                        <p>255 charaters remaining</p>
                                        <input id="docname" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="">Select a value</option>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due</label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Name of Contract Testing Lab</label>
                                     <input type="text" name="name_of_contract_testing_lab">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="How_Initiated">Laboratory Address</label>
                                      <textarea name="laboratory_address"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Customer_Name">Application Sites</label>
                                     <select multiple name="application_sites[]">
                                       <option value="ML00">ML00</option>
                                       <option value="ML01">ML01</option>
                                       <option value="ML02">ML02</option>
                                       <option value="ML03">ML03</option>
                                       <option value="ML04">ML04</option>
                                       <option value="ML05">ML05</option>
                                     </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Customer_organization">New Existing Laboratory</label>
                                    <select name="new_existing_laboratory">
                                        <option value="ML00">ML00</option>
                                        <option value="ML01">ML01</option>
                                        <option value="ML02">ML02</option>
                                        <option value="ML03">ML03</option>
                                        <option value="ML04">ML04</option>
                                        <option value="ML05">ML05</option>
                                      </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Outcome">Date of Last Audit</label>
                                    <input type="date" name="date_of_last_audit">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Patient_Involved">Audit Due On Month</label>
                                     <input type="date" name="audit_due_on_month">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reporter">TCD For Audit Completion.</label>
                                    <input type="date" name="tcd_for_audit_completion">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Planing_to_be_Done_On">Audit Planing to be Done On</label>
                                    <input type="date" name="audit_planing_to_be_done_on">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Request_Communicated_To">Audit Request Communicated To</label>
                                    <input type="text" name="audit_request_communicated_to">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Proposed_Audit_Start_Date">Proposed Audit Start Date</label>
                                    <input type="date" name="proposed_audit_start_date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Proposed_Audit_Completion">Proposed Audit Completion</label>
                                    <input type="date" name="proposed_audit_completion">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Name_of_Lead_Auditor">Name of Lead Auditor</label>
                                    <input type="text" name="name_of_lead_auditor">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Name_of_Co_Auditor">Name(s) of Co-Auditor</label>
                                    <textarea name="name_of_co_auditor"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="External_Auditor_if_Applicable">External Auditor, if Applicable</label>
                                    <input type="text" name="external_auditor_if_applicable">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Propose_of_Audit">Propose of Audit.</label>
                                    <select name="propose_of_audit">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Details_of_for_Cause_Audit">Details of for Cause Audit</label>
                                    <textarea name="details_of_for_cause_audit"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Other_Information">Other Information (If Any)</label>
                                    <textarea name="other_information"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA_Approver">QA Approver</label>
                                    <input type="text" name="qa_approver">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Proposal_Attachments">Proposal Attachments</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id=""></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="proposal_attachments" oninput="" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Proposal_By">CTL Audit Proposal By</label>
                                    <input type="text" name="ctl_audit_proposal_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Proposal_By">CTL Audit Proposal On</label>
                                    <input type="date" name="ctl_audit_proposal_on">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Remarks">Remarks</label>
                                    <textarea name="remarks"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancellation_Initiated_By">Cancellation Initiated By</label>
                                    <input type="text" name="cancellation_initiated_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancellation_Initiated_On">Cancellation Initiated On</label>
                                    <input type="date" name="cancellation_initiated_on">
                                </div>
                            </div>

                            {{--<div class="sub-head">
                                Location Information
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Event_Location">Event Location</label>
                                    <select name="Event_Location">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Other_Event_Location">Other Event Location</label>
                                    <input type="text" name="Other_Event_Location">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Zone">Zone</label>
                                    <select name="Zone">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Country">Country</label>
                                    <input type="text" name="Country">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="State_District">State/District</label>
                                    <input type="text" name="State_District">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="City">City</label>
                                    <select name="City">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Department">Department(s)</label>
                                    <select name="Department">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Countries">Countries</label>
                                    <select name="Countries">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sub-head">
                                Product Information
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Manufacturer">Manufacturer</label>
                                    <input type="text" name="Manufacturer">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reported_Manufacturer">Reported to Manufacturer</label>
                                    <select name="Reported_Manufacturer">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Product/Material(0)
                                    <button type="button" name="audit-agenda-grid" id="Product_Material">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Product-Material-field-instruction-modal">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Product Name</th>
                                                <th style="width: 16%">Batch Number</th>
                                                <th style="width: 16%">Expiry Date</th>
                                                <th style="width: 16%">ManuFactured Date</th>
                                                <th style="width: 15%">Disposition</th>
                                                <th style="width: 15%">Comment</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name="IDnumber[]"></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Related_Suppliers">Related Suppliers</label>
                                    <select name="Related_Suppliers">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Trade_name">Trade Name</label>
                                    <input type="text" name="Trade_name">
                                </div>
                            </div>

                            <div class="sub-head">
                                Additional Data
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Attached_Files">Attached Files</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id=""></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="Attached_Files" oninput="" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Attached_Pictures">Attached Pictures</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id=""></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="Attached_Pictures" oninput="" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Related_URLs">Related URLs</label>
                                    <select name="Related_URLs">
                                        <option value="">Enter Your Selection Here</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Web_Search">Web Search</label>
                                    <input type="text" name="Web_Search">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Related_Events">Related Events</label>
                                    <input type="text" name="Related_Events">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Similar_Complains">Similar Complains</label>
                                    <input type="text" name="Similar_Complains">
                                </div>
                            </div>--}}

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
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Audit_Agenda">Audit Agenda</label>
                                    <textarea name="audit_agenda"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Aenda_Sent_On">Audit Aenda Sent On</label>
                                    <input type="date" name="audit_agenda_sent_on">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Agenda_Sent_To">Audit Agenda Sent To</label>
                                    <input type="text" name="audit_agenda_sent_to">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Comments_Remarks">Comments / Remarks(If Any)</label>
                                    <textarea name="comments_remarks"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Communication_And_Others">Communication & Others</label>
                                    <select name="communication_and_others">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Preparation_By">CTL Audit Preparation By</label>
                                    <input type="text" name="ctl_audit_preparation_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Preparation_On">CTL Audit Preparation On</label>
                                    <input type="date" name="ctl_audit_preparation_on">
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
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Started_On">CTL Audit Started On</label>
                                    <input type="date" name="ctl_audit_started_on">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Completed_On">CTL Audit Completed On</label>
                                    <input type="date" name="ctl_audit_completed_on">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Audit_Execution_Comments">Audit Execution Comments</label>
                                    <textarea name="audit_execution_comments"></textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Audit_Enclosures">Audit Enclosures</label>
                                    <select name="audit_enclosures">
                                        <option value="">--select--</option>
                                        <option value="">1</option>
                                        <option value="">2</option>
                                        <option value="">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Delay_Justification_Deviation">Delay Justification/Deviation</label>
                                    <textarea name="delay_justification_deviation"></textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Details_Updated_By">CTL Audit Details Updated By</label>
                                    <input type="text" name="ctl_audit_details_updated_by">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Details_Updated_On">CTL Audit Details Updated On</label>
                                    <input type="date" name="ctl_audit_details_updated_on">
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

                            <div class="sub-head">
                                Audit Details
                            </div>

                             <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Auditee(s) (0)
                                    <button type="button" name="audit-agenda-grid" id="Auditee">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Auditee-instruction-modal">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Name</th>
                                                <th style="width: 16%">Designation/Position</th>
                                                <th style="width: 16%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Key Personnel Met During Audit(0)
                                    <button type="button" name="audit-agenda-grid" id="Key_Personnel_Met_During_Audit">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Key_Personnel_Met_During_Audit-field-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Name</th>
                                                <th style="width: 16%">Designation/Position</th>
                                                <th style="width: 16%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            <td><input type="text" name="IDnumber[]"></td>
                                            <td><input type="text" name=""></td>
                                            <td><input type="text" name=""></td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="sub-head">
                                Observation/Non-Confirmances
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Critical">Critical</label>
                                    <input type="text" name="critical" value="">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Major">Major</label>
                                    <input type="text" name="major" value="">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Conclusion">Minor</label>
                                    <input type="text" name="minor" value="">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Recomendations_Comments">Recomendations/Comments</label>
                                    <input type="text" name="recomendations_comments" value="">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="total">Total</label>
                                    <input type="text" name="total" value="">
                                </div>
                            </div>

                            <div class="sub-head">
                                Audit Summary
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="corrective_actions_agreed">Corrective Actions Agreed</label>
                                    <textarea name="Corrective_Actions_Agreed"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Executive_Summary">Executive Summary</label>
                                    <textarea name="executive_summary"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Laboratory_Acceptability">Laboratory Acceptability</label>
                                    <textarea name="laboratory_acceptability"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Remarks_Conclusion">Remarks & Conclusion</label>
                                    <textarea name="remarks_conclusion"></textarea>
                                </div>
                            </div>

                            <div class="sub-head">
                                Audit Report Details
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Report_Ref_No">Audit Report Ref. No.</label>
                                    <input type="text" name="audit_report_ref_no">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Report_Signed_On">Audit Report Signed On</label>
                                    <input type="date" name="audit_report_signed_on">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Report_Approved_On">Audit Report Approved On</label>
                                    <input type="date" name="audit_report_approved_on">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Report">CTL Audit Report</label>
                                    <select name="ctl_audit_report">
                                      <option value="">Enter Your Selection</option>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Delay_Justification">Delay Justification</label>
                                    <textarea name="delay_justification"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Supportive_Documents">Supportive Documents</label>
                                    <select name="supportive_documents">
                                      <option value="">Enter Your Selection</option>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Report_Prepared_By">CTL Audit Report Prepared By</label>
                                    <input type="text" name="ctl_audit_report_prepared_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Report_Prepared_By">CTL Audit Report Prepared On</label>
                                    <input type="date" name="ctl_audit_report_prepared_on">
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

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Report_Issue_Date">CTL Audit Report Issue Date</label>
                                    <input type="date" name="ctl_audit_report_issue_date">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Report_Sent_To_Ctl_On">Audit Report Sent To CTL On</label>
                                    <input type="date" name="audit_report_sent_to_ctl_on">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Report_Sent_To">Audit Report Sent To</label>
                                    <input type="text" name="audit_report_sent_to">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Report_Acknowledged_On">Report Acknowledged On</label>
                                    <input type="text" name="report_acknowledged_on">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="TCD_for_Receipt_of_Compliance">TCD for Receipt of Compliance</label>
                                    <input type="date" name="tcd_for_receipt_of_compliance">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Other_Information">Other Information (If Any)</label>
                                    <textarea name="other_information"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="File_Attachments_If_Any">File Attachments If Any</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id=""></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_attachments_if_any" oninput="" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Report_Issued_By">CTL Audit Report Issued By</label>
                                    <input type="text" name="ctl_audit_report_issued_by">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Report_Issued_On">CTL Audit Report Issued On</label>
                                    <input type="date" name="ctl_audit_report_issued_on">
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

                <div id="CCForm6" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="sub-head">
                                Response Details
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initial_Response_Received_On">Initial Response Received On</label>
                                    <input type="date" name="initial_response_received_on">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="final_Response_Received_On">Final Response Received On</label>
                                    <input type="date" name="final_Response_Received_On">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Response_Received_Within_TCD">Response Received Within TCD</label>
                                    <select name="response_received_within_tcd">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reason_for_Delayed_Response">Reason for Delayed Response</label>
                                    <textarea name="reason_for_delayed_response" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Comments">Comments</label>
                                    <textarea name="comments" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="CTL_Response_Report">CTL Response Report</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id=""></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="ctl_response_report" oninput="" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Response_Detail_Updated_By">CTL Response Detail Updated By</label>
                                    <input type="text" name="ctl_response_detail_updated_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Response_Detail_Updated_On">CTL Response Detail Updated On</label>
                                    <input type="text" name="ctl_response_detail_updated_on">
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


                <div id="CCForm7" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Response_Review_Comments">Response Review Comments</label>
                                    <textarea name="response_review_comments"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Task_Required">Audit Task Required?</label>
                                    <select name="audit_task_required">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Task_Ref_No">Audit Task Ref. No</label>
                                    <input type="number" name="audit_task_ref_no">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Follow_Up_Task_Required">Follow Up Task Required</label>
                                    <select name="follow_up_task_required">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Follow_Up_Task_Ref_No">Follow-Up Task Ref. No</label>
                                    <select name="follow_up_task_ref_no">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="TCD_for_Capa_Implementation">TCD for Capa Implementation</label>
                                    <input type="text" name="tcd_for_capa_implementation">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Response_Review">Response Review</label>
                                    <select name="response_review">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reason_For_Disqualification">Reason For Disqualification</label>
                                    <textarea name="reason_for_disqualification"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reason_For_Disqualification">Requalification Frequency</label>
                                    <input type="text" name="requalification_frequency">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Next_Audit_Due_Date">Next Audit Due Date</label>
                                    <input type="date" name="next_audit_due_date">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Audit_Closure_Report">Audit Closure Report</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id=""></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="audit_closure_report" oninput="" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Response_File_Attachments">Response File Attachments</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id=""></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="response_file_attachments" oninput="" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Response_Acceptance_By">CTL Response Acceptance By</label>
                                    <input type="text" name="ctl_response_acceptance_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Response_Acceptance_on">CTL Response Acceptance On</label>
                                    <input type="date" name="ctl_response_acceptance_on">
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


                <div id="CCForm8" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Approval_Attachments">Approval Attachments</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id=""></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="approval_attachments" oninput="" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Compliance_Approved_By">Audit Compliance Approved By</label>
                                    <input type="text" name="audit_compliance_approved_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Compliance_Approved_On">Audit Compliance Approved On</label>
                                    <input type="date" name="audit_compliance_approved_on">
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

                <div id="CCForm9" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="sub-head">
                               Capa Implementation Status
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="All_Observation_Closed">All Observation Closed</label>
                                    <select name="all_observation_closed">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Implementation_Review_Comments">Implementation Review Comments</label>
                                    <textarea name="implementation_review_comments"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Implementation_Completed_On">Implementation Completed On</label>
                                    <input type="date" name="implementation_completed_on">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Audit_Closure_Report_Issued_On">Audit Closure Report Issued On</label>
                                    <input type="date" name="audit_closure_report_issued_on">
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Audit_Closure_Attachments">Audit Closure Attachments</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id=""></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="audit_closure_attachments" oninput="" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Closure_Done_By">CTL Audit Closure Done By</label>
                                    <input type="date" name="ctl_audit_closure_done_by">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CTL_Audit_Closure_Done_On">CTL Audit Closure Done On</label>
                                    <input type="date" name="ctl_audit_closure_done_on">
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

                <div id="CCForm10" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">
                                Signatures
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted by">Submitted By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Submitted On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reviewed by">Reviewed By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reviewed on">Reviewed On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Plan_Approved_by">Plan Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Plan_Approved_on">Plan Approved On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Letter_by">Letter Sent By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Letter_on">Letter Sent On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="submit" class="saveButton">Save</button>
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
    document.getElementById('clearSelection').addEventListener('click', function() {
        var radios = document.querySelectorAll('input[type="radio"]');
        for (var i = 0; i < radios.length; i++) {
            radios[i].checked = false;
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#Auditee').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#Auditee-instruction-modal tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#Key_Personnel_Met_During_Audit').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#Key_Personnel_Met_During_Audit-field-table tbody');
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
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#Product-Material-field-instruction-modal tbody');
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
