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
        {{ Helpers::getDivisionName(session()->get('division')) }} / Supplier Observation
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
                        <button class="button_theme1"> <a class="text-white" href="{{ url('supplierAuditTrail', $data->id) }}">
                                Audit Trail </a> </button>            
                                

                    @if ($data->stage == 1)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Report Issued
                        </button>
                    @elseif($data->stage == 2)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Approval received
                        </button>
                    @elseif($data->stage == 3)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            All CAPA Closed
                        </button>
                    @elseif($data->stage == 4)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Approve
                        </button>   
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                            Reject
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
                            <div class="active">Pending Response/CAPA Plan </div>
                        @else
                            <div class="">Pending Response/CAPA Plan</div>
                        @endif

                        @if ($data->stage >= 3)
                            <div class="active">Work in Progress</div>
                        @else
                            <div class="">Work in Progress</div>
                        @endif

                        @if ($data->stage >= 4)
                            <div class="active">Pending Approval</div>
                        @else
                            <div class="">Pending Approval</div>
                        @endif
                        @if ($data->stage >= 5)
                            <div class="bg-danger">Closed - Done</div>
                        @else
                            <div class="">Closed - Done</div>
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

        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Supplier Observation</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Impact Analysis</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Activity Log</button>
        </div>

        <form action="{{ route('supplier_update', $data->id) }}" method="POST" enctype="multipart/form-data">
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
                            <div class="sub-head">
                                General Information
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/SO/{{ Helpers::year($data->created_at) }}/{{ $data->record }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input disabled type="text" name="division_code"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id"
                                        value="{{ session()->get('division') }}">
                                    {{-- <div class="static">QMS-North America</div> --}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator">Initiator</label>
                                    <input disabled type="text" name="initiator_id" value="{{ Auth::user()->name }}" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Due">Date of Initiation</label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="short_description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <textarea name="short_description"   id="docname" type="text"    maxlength="255" required {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>{{ $data->short_description }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to"
                                        {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                        <option value="">Select a value</option>
                                        @foreach ($users as $key => $value)
                                            <option value="{{ $value->id }}"
                                                @if ($data->assign_to == $value->id) selected @endif>
                                                {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('assign_to')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Due Date"> Due Date </label>
                                    <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                        value="{{ \Carbon\Carbon::parse($due_date)->format('d-M-Y') }}" />
                                    <input type="hidden" name="due_date" id="due_date_input"
                                        value="{{ $due_date }}" />

                                    {{-- <input type="hidden" value="{{ $due_date }}" name="due_date">
                                    <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}"> --}}
                                    {{-- <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                        value="" name="due_date"> --}}
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="criticality"><b>Criticality</b></label>
                                    <select name="criticality" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="e" @if ($data->criticality =='e') selected @endif>e</option>
                                        <option value="f" @if ($data->criticality =='f') selected @endif>f</option>
                                        <option value="g" @if ($data->criticality =='g') selected @endif>g</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="priority_level">Priority Level</label>
                                    <div><small class="text-primary">Choose high if Immidiate actions are
                                            required</small></div>
                                   
                                    <select {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} name="priority_level">
                                        <option value="0">-- Select --</option>
                                        <option @if ($data->priority_level == 'Low') selected @endif
                                         value="Low">Low</option>
                                        <option  @if ($data->priority_level == 'Medium') selected @endif 
                                        value="Medium">Medium</option>
                                        <option @if ($data->priority_level == 'High') selected @endif
                                        value="High">High</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="auditee">Auditee/Supplier</label>
                                    <input type="text" name="auditee" value="{{ $data->auditee }}" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="contact_person">Contact Person</label>
                                    <input type="text" name="contact_person" value="{{ $data->contact_person }}" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="descriptions">Descriptions</label>
                                    <textarea name="descriptions" id="" cols="30" rows="3" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>{{ $data->descriptions }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="attached_file">Attached File</label>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="attached_file">
                                            @if ($data->attached_file)
                                                @foreach (json_decode($data->attached_file) as $file)
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
                                            <input type="file" id="myfile" name="attached_file[]" oninput="addMultipleFiles(this, 'attached_file')" multiple {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="attached_picture">Attached Picture</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="attached_picture">
                                                @if ($data->attached_picture)
                                                    @foreach (json_decode($data->attached_picture) as $file)
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
                                            <input type="file" id="myfile" name="attached_picture[]" oninput="addMultipleFiles(this, 'attached_picture')" multiple {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>


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

                                function addMultipleFiles(input, id) {
                                    const fileListContainer = document.getElementById(id);
                                    const files = input.files;

                                    for (let i = 0; i < files.length; i++) {
                                        const file = files[i];
                                        const fileName = file.name;
                                        const fileContainer = document.createElement('h6');
                                        fileContainer.classList.add('file-container', 'text-dark');
                                        fileContainer.style.backgroundColor = 'rgb(243, 242, 240)';

                                        const fileText = document.createElement('b');
                                        fileText.textContent = fileName;

                                        const viewLink = document.createElement('a');
                                        viewLink.href = '#'; // You might need to adjust this to handle local previews
                                        viewLink.target = '_blank';
                                        viewLink.innerHTML = '<i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>';

                                        const removeLink = document.createElement('a');
                                        removeLink.classList.add('remove-file');
                                        removeLink.dataset.fileName = fileName;
                                        removeLink.innerHTML = '<i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>';
                                        removeLink.addEventListener('click', function () {
                                            fileContainer.style.display = 'none';
                                        });

                                        fileContainer.appendChild(fileText);
                                        fileContainer.appendChild(viewLink);
                                        fileContainer.appendChild(removeLink);

                                        fileListContainer.appendChild(fileContainer);
                                    }
                                }
                            </script>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="manufacturer">Manufacturer</label>
                                    <input type="text" name="manufacturer" value="{{ $data->manufacturer }}" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="type">Type</label>
                                    <select name="type" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option @if ($data->type =='aa') selected @endif value="aa">aa</option>
                                        <option @if ($data->type =='bb') selected @endif value="bb">bb</option>
                                        <option @if ($data->type =='cc') selected @endif value="cc">cc</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="product">Product/Materials(0)</label>
                                    <input type="text" name="product" id="" value="{{ $data->product }}" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                </div>
                            </div>

                            <div class="sub-head">
                                Actions
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="proposed_actions">Proposed Actions</label>
                                    <textarea name="proposed_actions" id="" cols="30" rows="3" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>{{ $data->proposed_actions }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="comments">Comments</label>
                                    <textarea name="comments" id="" cols="30" rows="3" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>{{ $data->comments }}</textarea>
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
                            <div class="sub-head col-12">Impact Analysis</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="impact">Impact</label>
                                    <select name="impact" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option @if ($data->impact =='aaa') selected @endif value="aaa">aaa</option>
                                        <option @if ($data->impact =='bbb') selected @endif value="bbb">bbb</option>
                                        <option @if ($data->impact =='ccc') selected @endif value="ccc">ccc</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="impact_analysis">Impact Analysis </label>
                                    <textarea name="impact_analysis" id="" cols="30" rows="3" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>{{ $data->impact_analysis }}</textarea>
                                </div>
                            </div>
                            <div class="sub-head col-12">Risk Analysis</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="severity_rate">Severity Rate</label>
                                    <select name="severity_rate" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option @if ($data->severity_rate =='qqq') selected @endif value="qqq">qqq</option>
                                        <option @if ($data->severity_rate =='www') selected @endif value="www">www</option>
                                        <option @if ($data->severity_rate =='ttt') selected @endif value="ttt">ttt</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="occurence">Occurence</label>
                                    <select name="occurence" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option @if ($data->occurence =='eee') selected @endif value="eee">eee</option>
                                        <option @if ($data->occurence =='rrr') selected @endif value="rrr">rrr</option>
                                        <option @if ($data->occurence =='tttt') selected @endif value="tttt">tttt</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="detection">Detection</label>
                                    <select name="detection" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option @if ($data->detection =='ooo') selected @endif value="ooo">ooo</option>
                                        <option @if ($data->detection =='uuu') selected @endif value="uuu">uuu</option>
                                        <option @if ($data->detection =='yyy') selected @endif value="yyy">yyy</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="rpn">RPN</label>
                                    <select name="rpn" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option @if ($data->rpn =='dd') selected @endif value="dd">dd</option>
                                        <option @if ($data->rpn =='ff') selected @endif value="ff">ff</option>
                                        <option @if ($data->rpn =='gg') selected @endif value="gg">gg</option>
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
                            <div class="sub-head">
                                Activity Log
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="submitted by">Report Issued By :</label>
                                    <div class="static">{{ $data->report_issued_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="submitted on">Report Issued On :</label>
                                    <div class="static">{{ $data->report_issued_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Report Issued Comment :</label>
                                    <div class="static">{{ $data->report_issued_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="submitted by">Approval received By :</label>
                                    <div class="static">{{ $data->approval_received_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="submitted on">Approval received On :</label>
                                    <div class="static">{{ $data->approval_received_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Approval received Comment :</label>
                                    <div class="static">{{ $data->approval_received_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="submitted by">All CAPA Clossed By :</label>
                                    <div class="static">{{ $data->all_capa_closed_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="submitted on">All CAPA Clossed On :</label>
                                    <div class="static">{{ $data->all_capa_closed_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">All CAPA Clossed Comment :</label>
                                    <div class="static">{{ $data->all_capa_closed_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="submitted by">Approve By :</label>
                                    <div class="static">{{ $data->approve_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="submitted on">Approve On :</label>
                                    <div class="static">{{ $data->approve_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Approve Comment :</label>
                                    <div class="static">{{ $data->approve_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="submitted by">Reject By :</label>
                                    <div class="static">{{ $data->reject_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="submitted on">Reject On :</label>
                                    <div class="static">{{ $data->reject_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Reject Comment :</label>
                                    <div class="static">{{ $data->reject_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="submitted by">Cancel By :</label>
                                    <div class="static">{{ $data->cancelled_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="submitted on">Cancel On :</label>
                                    <div class="static">{{ $data->cancelled_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="submitted on">Cancel Comment :</label>
                                    <div class="static">{{ $data->cancelled_comment }}</div>
                                </div>
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

            <form action="{{ route('supplier_Cancle', $data->id) }}" method="POST">
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

<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('supplier_send_stage', $data->id) }}" method="POST">
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
            <form action="capa" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        <label for="major">
                            <input type="hidden" name="parent_name" value="Capa">
                            <input type="hidden" name="due_date" value="{{ $data->due_date }}">
                            <input type="radio" name="child_type" value="capa">
                            CAPA
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

            <form action="{{ route('supplier_reject', $data->id) }}" method="POST">
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
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>
@endsection