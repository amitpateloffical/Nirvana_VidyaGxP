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
<script>
    $(document).ready(function() {
        $('#ReferenceDocument').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +

                    '<td><input type="text" name="Transaction[]"></td>' +
                    '<td><input type="text" name="TransactionType[]"></td>' +
                    '<td><input type="date" name="Date[]"></td>' +
                    '<td><input type="number" name="Amount[]"></td>' +
                    '<td><input type="text" name="Currencyused[]"></td>' +
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
<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        {{ Helpers::getDivisionName($data->division_id) }} / Supplier Contract
    </div>
</div>

    @php
        $users = DB::table('users')->get();
    @endphp


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

                        <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button>
                        <button class="button_theme1"> <a class="text-white" href="{{ url('supplierContractAuditTrail', $data->id) }}">
                                Audit Trail </a> </button>            
                                

                    @if ($data->stage == 1)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Submit Supplier Details
                        </button>
                    @elseif($data->stage == 2)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Qualification Complete
                        </button>
                    @elseif($data->stage == 3)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Audit Passed
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#failed-modal">
                            Audit Failed
                        </button>   
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
                        </button> 
                    @elseif($data->stage == 4)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                            Reject Due To Quality Issues
                        </button>   
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Supplier Obsolete
                        </button> 
                    @elseif($data->stage == 5)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                            Re Audit
                        </button>   
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Supplier Obsolete
                        </button>             
                    @endif   
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                    </a> </button>
                </div>

            </div>
            <div class="status">
                <div class="head">Current Status</div>
                @if ($data->stage == 0)
                    <div class="progress-bars">
                        <div class="bg-danger">Closed-Cancelled</div>
                    </div>
                @else
                    <div class="progress-bars" style="font-size: 15px;">
                        @if ($data->stage >= 1)
                            <div class="active">Opened</div>
                        @else
                            <div class="">Opened</div>
                        @endif

                        @if ($data->stage >= 2)
                            <div class="active">Qualification In Progress </div>
                        @else
                            <div class="">Qualification In Progress</div>
                        @endif

                        @if ($data->stage >= 3)
                            <div class="active">Pending Supplier Audit</div>
                        @else
                            <div class="">Pending Supplier Audit</div>
                        @endif

                        @if ($data->stage >= 4)
                            <div class="active">Supplier Approved</div>
                        @else
                            <div class="">Supplier Approved</div>
                        @endif

                        @if ($data->stage >= 5)
                            <div class="active">Pending Rejction</div>
                        @else
                            <div class="">Pending Rejction</div>
                        @endif

                        @if ($data->stage >= 6)
                            <div class="bg-danger">Obselete</div>
                        @else
                            <div class="">Obselete</div>
                        @endif
                    </div>
                @endif

            {{-- @endif --}}
            {{-- ---------------------------------------------------------------------------------------- --}}
        </div>
    </div>
</div>            




<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Contract</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Contract Detail</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>

        </div>

        <form action="{{ route('supplier_contract_update', $data->id) }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number" value="{{ Helpers::getDivisionName(session()->get('division')) }}/SO/{{ Helpers::year($data->created_at) }}/{{ $data->record }}">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">

                                    <label for="originator_id"><b>Initiator</b></label>

                                    <input type="text" disabled name="originator_id" value="{{ Auth::user()->name }}">


                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Due"><b>Date of Initiation</b></label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span>
                                        <p>255 Characters remaining</p>
                                        <textarea name="short_description"   id="docname" type="text"    maxlength="255" required {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->short_description }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assigned_to" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                        <option value="0">Select a value</option>
                                        <option value="a" @if ($data->assigned_to =='a') selected @endif>a</option>
                                        <option value="b" @if ($data->assigned_to =='b') selected @endif>b</option>
                                        <option value="c" @if ($data->assigned_to =='c') selected @endif>c</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Due Date<span class="text-danger"></span></label>
                                    <p class="text-primary">Please mention expected date of completion</p>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" name="due_date" 
                                                placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->due_date) }}" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Supplier List</label>
                                    <select name="supplier_list" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="a" @if ($data->supplier_list =='a') selected @endif>a</option>
                                        <option value="b" @if ($data->supplier_list =='b') selected @endif>b</option>
                                        <option value="c" @if ($data->supplier_list =='c') selected @endif>c</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Distribution List<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="distribution_list" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->distribution_list }}</textarea>
                                </div>
                            </div>



                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Actions">Description<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="description" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->description }}</textarea>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="manufacturer"><b>Manufacturer</b></label>
                                    <input type="text" name="manufacturer" value="{{ $data->manufacturer }}" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="priority_level">Priority level</label>
                                    <select name="priority_level" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="a" @if ($data->priority_level =='a') selected @endif>a</option>
                                        <option value="b" @if ($data->priority_level =='b') selected @endif>b</option>
                                        <option value="c" @if ($data->priority_level =='c') selected @endif>c</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label  for="Responsible Department">Zone </label>
                                    <select name="zone" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="a" @if ($data->zone =='a') selected @endif>a</option>
                                        <option value="b" @if ($data->zone =='b') selected @endif>b</option>
                                        <option value="c" @if ($data->zone =='c') selected @endif>c</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="country"><b>Country</b></label>
                                    <p class="text-primary">Auto filter according to selected zone</p>
                                    <input type="text" name="country" value="{{ $data->country }}" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="city"><b>City</b></label>
                                    <p class="text-primary">Auto filter according to selected country</p>
                                    <input type="text" name="city" value="{{ $data->city }}" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label  for="state_district">State/District</label>
                                    <p class="text-primary">Auto selected according to City</p>
                                    <select name="state_district" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="a" @if ($data->state_district =='a') selected @endif>a</option>
                                        <option value="b" @if ($data->state_district =='b') selected @endif>b</option>
                                        <option value="c" @if ($data->state_district =='c') selected @endif>c</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label  for="type">Type </label>
                                    <select name="type" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="a" @if ($data->type =='a') selected @endif>a</option>
                                        <option value="b" @if ($data->type =='b') selected @endif>b</option>
                                        <option value="c" @if ($data->type =='c') selected @endif>c</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="other_type"><b>Other type</b></label>
                                    <p class="text-primary">If you choose "other" -please specify</p>
                                    <input type="text" name="other_type" value="{{ $data->other_type }}" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>

                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="file_attachments">File Attachments</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attachments">
                                                @if ($data->file_attachments)
                                                    @foreach (json_decode($data->file_attachments) as $file)
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
                                            <input type="file" id="myfile" name="file_attachments[]" oninput="addMultipleFiles(this, 'file_attachments')" multiple {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                        </div>
                                    </div>
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

                <!-- TAB 1 ENDS HERE -->

                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="actual_start_date">Actual Start Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="actual_start_date" readonly
                                            placeholder="DD-MMM-YYYY"value="{{ Helpers::getdateFormat($data->actual_start_date) }}" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $data->actual_start_date }}"  id="actual_start_date_checkdate" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="actual_start_date" class="hide-input"
                                            oninput="handleDateInput(this, 'actual_start_date');checkDate('actual_start_date_checkdate','actual_end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-6  new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="actual_end_date">Actual End Date</lable>
                                    <div class="calenderauditee">
                                    <input type="text" id="actual_end_date"                             
                                            placeholder="DD-MMM-YYYY"value="{{ Helpers::getdateFormat($data->actual_end_date) }}" />
                                         <input type="date"  min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $data->actual_end_date }}" id="actual_end_date_checkdate" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="actual_end_date" class="hide-input"
                                            oninput="handleDateInput(this, 'actual_end_date');checkDate('actual_start_date_checkdate','actual_end_date_checkdate')" />
                                    </div>
                               
                                    
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Suppplier List</label>
                                    <select name="departments">
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="a">a</option>
                                        <option value="b">b</option>
                                        <option value="c">c</option>
                                    </select>
                                </div>
                            </div> --}}

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="negotiation_team">Negotiation Team<span class="text-danger"></span></label>
                                    <textarea placeholder="" name="negotiation_team" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->negotiation_team }}</textarea>
                                </div>
                            </div>

                        </div>




                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                Financial Transaction (0)
                                <button type="button" name="audit-agenda-grid" id="ReferenceDocument">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (open)
                                </span>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="ReferenceDocument_details" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 4%">Row#</th>
                                            <th style="width: 12%">Transaction</th>
                                            <th style="width: 16%">Transaction Type</th>
                                            <th style="width: 16%">Date</th>
                                            <th style="width: 16%">Amount</th>
                                            <th style="width: 16%">Currency used</th>
                                            <th style="width: 16%">Remarks</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if (!empty($data->transaction))
                                            @foreach (unserialize($data->transaction) as $key => $transaction)
                                            <tr>
                                                <td><input disabled type="text" name="serial[]" value="1"></td>
                                                <td><input type="text" name="transaction[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->transaction)[$key] ? unserialize($data->transaction)[$key] : ' ' }}"></td>
                                                <td><input type="text" name="transaction_type[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->transaction_type)[$key] ? unserialize($data->transaction_type)[$key] : ' ' }}"></td>
                                                <td><input type="date" name="date[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->date)[$key] ? unserialize($data->date)[$key] : ' ' }}"></td>
                                                <td><input type="number" name="amount[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->amount)[$key] ? unserialize($data->amount)[$key] : ' ' }}"></td>
                                                <td><input type="text" name="currency_used[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->currency_used)[$key] ? unserialize($data->currency_used)[$key] : ' ' }}"></td>
                                                <td><input type="text" name="remarks[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($data->remarks)[$key] ? unserialize($data->remarks)[$key] : ' ' }}"></td>
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
                                    <label for="comments">Comments <span class="text-danger"></span></label>
                                    <textarea name="comments" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->comments }}</textarea>
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

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">Activity Log</div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="submit">Submitted Supplier Details By :</label>
                                    <div class="static">{{ $data->submit_supplier_details_by }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Submitted Supplier Details On :</b></label>
                                    <div class="static">{{ $data->submit_supplier_details_on }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="submit">Qualification Complete By :</label>
                                    <div class="static">{{ $data->qualification_complete_by }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Qualification Complete On :</b></label>
                                    <div class="static">{{ $data->qualification_complete_on }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="submit">Audit Passed By :</label>
                                    <div class="static">{{ $data->audit_passed_by }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Audit Passed On :</b></label>
                                    <div class="static">{{ $data->audit_passed_on }}</div>
                                </div>
                            </div>
                            <div>    
                                <div class="group-input">
                                    <label for="submit">Audit Failed By :</label>
                                    <div class="static">{{ $data->audit_failed_by }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Audit Failed On :</b></label>
                                    <div class="static">{{ $data->audit_failed_on }}</div>
                                </div>
                            </div>
                            <div>    
                                <div class="group-input">
                                    <label for="submit">Supplier Obsolete By :</label>
                                    <div class="static">{{ $data->supplier_obsolete_by }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Supplier Obsolete On :</b></label>
                                    <div class="static">{{ $data->supplier_obsolete_on }}</div>
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
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
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
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#RootCause-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
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
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
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
                        Activity Log
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

<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('supplier_contract_send_stage', $data->id) }}" method="POST">
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
                <div class="modal-footer">
                    <button type="submit" data-bs-dismiss="modal">Submit</button>
                    <button type="button" data-bs-dismiss="modal">Close</button>
                    {{-- <button>Close</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="failed-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('supplier_audit_failed', $data->id) }}" method="POST">
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
                <div class="modal-footer">
                    <button type="submit" data-bs-dismiss="modal">Submit</button>
                    <button type="button" data-bs-dismiss="modal">Close</button>
                    {{-- <button>Close</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="child-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <form action="" method="">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        <label for="major">
                            <input type="hidden" name="parent_name" value="Capa">
                            <input type="hidden" name="due_date" value="{{ $data->due_date }}">
                            <input type="radio" name="child_type" value="capa">
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

<div class="modal fade" id="rejection-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('supplier_contract_reject', $data->id) }}" method="POST">
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

<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('supplier_contract_Cancle', $data->id) }}" method="POST">
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
                <div class="modal-footer">
                    <button type="submit" data-bs-dismiss="modal">Submit</button>
                    <button type="button" data-bs-dismiss="modal">Close</button>
                    {{-- <button>Close</button> --}}
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
    $(document).ready(function() {
        $('#Witness_details').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
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
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
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
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
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
@endsection