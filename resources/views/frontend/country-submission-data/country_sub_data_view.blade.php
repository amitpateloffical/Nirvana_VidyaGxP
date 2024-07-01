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
        / Country Sumission Data
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
                        <button class="button_theme1"> <a class="text-white" href="{{ url('countryAuditTrail', $data->id) }}">
                                Audit Trail </a> </button>            
                                

                    @if ($data->stage == 1)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Activate
                        </button>
                    @elseif($data->stage == 2)
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Close
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
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
                            <div class="active">Country Record Created</div>
                        @else
                            <div class="">Country Record Created</div>
                        @endif

                        @if ($data->stage >= 3)
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

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Country Sumission Data</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Country Submission Data</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Important Dates and Persons</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signatures</button>
        </div>

        <form action="{{ route('country_update', $data->id) }}" method="POST" enctype="multipart/form-data">
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
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/CSD/{{ Helpers::year($data->created_at) }}/{{ $data->record }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input readonly type="text" name="division_code" />
                                        {{-- value="{{ Helpers::getDivisionName(session()->get('division')) }}" --}}
                                    {{-- <input type="hidden" name="division_id" value="{{ session()->get('division') }}"> --}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Initiator</b></label>
                                    <input disabled type="text" name="initiator_name" value="{{ $data->initiator_name }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Due">Date of Initiation</label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to"
                                        {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
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

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Due Date</label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($data->due_date) }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}/>
                                        <input type="date" name="due_date" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }} min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>

                            

                            

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="type">Type</label>
                                    <select name="type" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->type =='1') selected @endif>Type 1</option>
                                        <option value="2" @if ($data->type =='2') selected @endif>Type 2</option>
                                        <option value="3" @if ($data->type =='3') selected @endif>Type 3</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="other_type">Other Type</label>
                                    <input type="text" name="other_type" value="{{ $data->other_type }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="short_description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <textarea name="short_description"   id="docname" type="text"    maxlength="255" required {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>{{ $data->short_description }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="attached_files">Attached Files</label>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="attached_files">
                                            @if ($data->attached_files)
                                                @foreach (json_decode($data->attached_files) as $file)
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
                                            <input type="file" id="myfile" name="attached_files[]" oninput="addMultipleFiles(this, 'attached_files')" multiple {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="related_urls">Related URLs</label>
                                    <select name="related_urls" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->type =='1') selected @endif>Type 1</option>
                                        <option value="2" @if ($data->type =='2') selected @endif>Type 2</option>
                                        <option value="3" @if ($data->type =='3') selected @endif>Type 3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="descriptions">Descriptions</label>
                                    <textarea name="descriptions" id="" cols="30" rows="3" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>{{ $data->descriptions }}</textarea>
                                </div>
                            </div>

                            <div class="sub-head">
                                Location
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="zone">Zone</label>
                                    <select name="zone" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->type =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->type =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->type =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="country">Country</label>
                                    <select name="country" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->type =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->type =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->type =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="city">City</label>
                                    <input type="city" name="city" value="{{ $data->city }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="state_district">State/District</label>
                                    <select name="state_district" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->type =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->type =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->type =='3') selected @endif>3</option>
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
                                    <input type="text" name="manufacturer" id="" value="{{ $data->manufacturer }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Product/Material(0)
                                    <button type="button" name="audit-agenda-grid" id="Product_Material_country_sub_data" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                {{-- <div class="table-responsive"> --}}
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
                                            @if (!empty($grid_Data) && is_array($grid_Data->data))
                                            @foreach ($grid_Data->data as $grid_Data)  
                                                <tr>
                                                    <td><input disabled type="text" name="serial_number_gi[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                    <td><input type="text" name="serial_number_gi[{{ $loop->index }}][info_product_name]" value="{{ isset($grid_Data['info_product_name']) ? $grid_Data['info_product_name'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                    <td><input type="text" name="serial_number_gi[{{ $loop->index }}][info_batch_number]" value="{{ isset($grid_Data['info_batch_number']) ? $grid_Data['info_batch_number'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                    <td>
                                                        <div class="new-date-data-field">
                                                            <div class="group-input input-date">
                                                                <div class="calenderauditee">
                                                                    <input
                                                                        class="click_date"
                                                                        id="date_{{ $loop->index }}_mfg_date"
                                                                        type="text"
                                                                        name="serial_number_gi[{{ $loop->index }}][info_mfg_date]"
                                                                        placeholder="DD-MMM-YYYY"
                                                                        {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                                                        value="{{ isset($grid_Data['info_mfg_date']) ? $grid_Data['info_mfg_date'] : '' }}"
                                                                    />
                                                                    <input
                                                                        type="date"
                                                                        name="serial_number_gi[{{ $loop->index }}][info_mfg_date]"
                                                                        value="{{ isset($grid_Data['info_mfg_date']) ? $grid_Data['info_mfg_date'] : '' }}"
                                                                        id="date_{{ $loop->index }}_mfg_date_picker"
                                                                        class="hide-input show_date"
                                                                        {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                                                        style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                        onchange="handleDateInput(this, 'date_{{ $loop->index }}_mfg_date')"
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
                                                                        id="date_{{ $loop->index }}_expiry_date"
                                                                        type="text"
                                                                        name="serial_number_gi[{{ $loop->index }}][info_expiry_date]"
                                                                        placeholder="DD-MMM-YYYY"
                                                                        {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                                                        value="{{ isset($grid_Data['info_expiry_date']) ? $grid_Data['info_expiry_date'] : '' }}"
                                                                    />
                                                                    <input
                                                                        type="date"
                                                                        name="serial_number_gi[{{ $loop->index }}][info_expiry_date]"
                                                                        value="{{ isset($grid_Data['info_expiry_date']) ? $grid_Data['info_expiry_date'] : '' }}"
                                                                        id="date_{{ $loop->index }}_expiry_date_picker"
                                                                        class="hide-input show_date"
                                                                        {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                                                        style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                        onchange="handleDateInput(this, 'date_{{ $loop->index }}_expiry_date')"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><input type="text" name="serial_number_gi[{{ $loop->index }}][info_disposition]" value="{{ isset($grid_Data['info_disposition']) ? $grid_Data['info_disposition'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                    <td><input type="text" name="serial_number_gi[{{ $loop->index }}][info_comments]" value="{{ isset($grid_Data['info_comments']) ? $grid_Data['info_comments'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                    <td><input type="text" name="serial_number_gi[{{ $loop->index }}][info_remarks]" value="{{ isset($grid_Data['info_remarks']) ? $grid_Data['info_remarks'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>

                                    </table>
                                {{-- </div> --}}
                            </div>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#Product_Material_country_sub_data').click(function(e) {
                                        function generateTableRow(serialNumber) {
                                            var data = @json($grid_Data);
                                            var html = '';
                                            html +=
                                                '<tr>' +
                                                '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + serialNumber + '][info_product_name]"></td>' +
                                                '<td><input type="text" name="serial_number_gi[' + serialNumber + '][info_batch_number]"></td>' +
                                                '<td> <div class="new-date-data-field"><div class="group-input input-date"> <div class="calenderauditee"><input id="date_'+ serialNumber +'_mfg_date" type="text" name="serial_number_gi[' + serialNumber + '][info_mfg_date]" placeholder="DD-MMM-YYYY" /> <input type="date" name="serial_number_gi[' + serialNumber + '][info_mfg_date]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" id="date_'+ serialNumber +'_mfg_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ serialNumber +'_mfg_date\')" /> </div> </div></div></td>' +
                                                '<td>  <div class="new-date-data-field"><div class="group-input input-date"><div class="calenderauditee"><input id="date_'+ serialNumber +'_expiry_date" type="text" name="serial_number_gi[' + serialNumber + '][info_expiry_date]" placeholder="DD-MMM-YYYY" /> <input type="date" name="serial_number_gi[' + serialNumber + '][info_expiry_date]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" id="date_'+ serialNumber +'_expiry_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ serialNumber +'_expiry_date\')" /> </div> </div></div></td>' +
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
                                    <input type="text" name="number_id" id="" value="{{ $data->number_id }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="project_code">Project Code</label>
                                    <input type="text" name="project_code" id="" value="{{ $data->project_code }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="authority_type">Authority Type</label>
                                    <select name="authority_type" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->authority_type =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->authority_type =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->authority_type =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="authority">Authority</label>
                                    <select name="authority" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->authority =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->authority =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->authority =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="priority_level">Priority Level</label>
                                    <select name="priority_level" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->priority_level =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->priority_level =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->priority_level =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="other_authority">Other Authority</label>
                                    <input type="text" name="other_authority" id="" value="{{ $data->other_authority }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="approval_status">Approval Status</label>
                                    <select name="approval_status" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->approval_status =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->approval_status =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->approval_status =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Managed by Company">Managed by Company?</label>
                                    <select name="managed_by_company" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->managed_by_company =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->managed_by_company =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->managed_by_company =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Managed by Company">Marketing Status</label>
                                    <select name="marketing_status" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->marketing_status =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->marketing_status =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->marketing_status =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Therapeutic Area">Therapeutic Area</label>
                                    <select name="therapeutic_area" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->therapeutic_area =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->therapeutic_area =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->therapeutic_area =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="End of Trial Date Status">End of Trial Date Status</label>
                                    <select name="end_of_trial_date_status" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->end_of_trial_date_status =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->end_of_trial_date_status =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->end_of_trial_date_status =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Protocol Type">Protocol Type</label>
                                    <select name="protocol_type" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->protocol_type =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->protocol_type =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->protocol_type =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Registration Status">Registration Status</label>
                                    <select name="registration_status" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->registration_status =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->registration_status =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->registration_status =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="unblinded_SUSAR_to_CEC">Unblinded SUSAR to CEC?</label>
                                    <select name="unblinded_SUSAR_to_CEC" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->unblinded_SUSAR_to_CEC =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->unblinded_SUSAR_to_CEC =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->unblinded_SUSAR_to_CEC =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Trade Name">Trade Name</label>
                                    <select name="trade_name" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->trade_name =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->trade_name =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->trade_name =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Dosage Form">Dosage Form</label>
                                    <select name="dosage_form" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->dosage_form =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->dosage_form =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->dosage_form =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Photocure Trade Name">Photocure Trade Name</label>
                                    <input type="text" name="photocure_trade_name" id="" value="{{ $data->photocure_trade_name }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Currency">Currency</label>
                                    <input type="text" name="currency" id="" value="{{ $data->currency }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            {{-- <div class="col-12">
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
                            </div> --}}

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="attacehed_payments">Attacehed Payments</label>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="attacehed_payments">
                                            @if ($data->attacehed_payments)
                                                @foreach (json_decode($data->attacehed_payments) as $file)
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
                                            <input type="file" id="myfile" name="attacehed_payments[]" oninput="addMultipleFiles(this, 'attacehed_payments')" multiple {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Follow Up Documents">Follow Up Documents</label>
                                    <select name="follow_up_documents" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->follow_up_documents =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->follow_up_documents =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->follow_up_documents =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Hospitals">Hospitals</label>
                                    <select id="hospitals" name="hospitals" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->hospitals =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->hospitals =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->hospitals =='3') selected @endif>3</option>
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="vendors">Vendors</label>
                                    <select id="vendors" name="vendors" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->vendors =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->vendors =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->vendors =='3') selected @endif>3</option>
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="INN">INN(s)</label>
                                    <select id="INN" name="INN" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->INN =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->INN =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->INN =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Route of Administration">Route of Administration</label>
                                    <select id="route_of_administration" name="route_of_administration" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->route_of_administration =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->route_of_administration =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->route_of_administration =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="first_IB_version">1st IB Version</label>
                                    <input type="text" name="first_IB_version" id="" value="{{ $data->first_IB_version }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="first_protocol_version">1st Protocol Version</label>
                                    <input type="text" name="first_protocol_version" id="" value="{{ $data->first_protocol_version }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="eudraCT_numberr">EudraCT Number</label>
                                    <input type="text" name="eudraCT_number" id="" value="{{ $data->eudraCT_number }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="budget">Budget</label>
                                    <input type="text" name="budget" id="" value="{{ $data->budget }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="phase_of_study">Phase of Study</label>
                                    <select id="phase_of_study" name="phase_of_study" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->phase_of_study =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->phase_of_study =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->phase_of_study =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="related_clinical_trials">Related Clinical Trials</label>
                                    <select name="related_clinical_trials" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->related_clinical_trials =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->related_clinical_trials =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->related_clinical_trials =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Financial Transactions(0)
                                    <button type="button" name="audit-agenda-grid" id="Financial_Transactions_country_sub_data" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>+</button>
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
                                            @if (!empty($grid_two) && is_array($grid_two->data))
                                                @foreach ($grid_two->data as $grid_two)  
                                                    <tr>
                                                        <td><input disabled type="text" name="financial_transection[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="financial_transection[{{ $loop->index }}][info_transaction]" value="{{ isset($grid_two['info_transaction']) ? $grid_two['info_transaction'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="financial_transection[{{ $loop->index }}][info_transaction_type]" value="{{ isset($grid_two['info_transaction_type']) ? $grid_two['info_transaction_type'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                        <td>
                                                            <div class="new-date-data-field">
                                                                <div class="new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <div class="calenderauditee">
                                                                            <input
                                                                                class="click_date"
                                                                                id="date_{{ $loop->index }}_date"
                                                                                type="text"
                                                                                name="financial_transection[{{ $loop->index }}][info_date]"
                                                                                placeholder="DD-MMM-YYYY"
                                                                                {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                                                                value="{{ isset($grid_two['info_date']) ? $grid_two['info_date'] : '' }}"
                                                                            />
                                                                            <input
                                                                                type="date"
                                                                                name="financial_transection[{{ $loop->index }}][info_date]"
                                                                                value="{{ isset($grid_two['info_date']) ? $grid_two['info_date'] : '' }}"
                                                                                id="date_{{ $loop->index }}_date_picker"
                                                                                class="hide-input show_date"
                                                                                {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                                                                style="position: absolute; top: 0; left: 0; opacity: 0;"
                                                                                onchange="handleDateInput(this, 'date_{{ $loop->index }}_date')"
                                                                            />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><input type="number" name="financial_transection[{{ $loop->index }}][info_amount]" value="{{ isset($grid_two['info_amount']) ? $grid_two['info_amount'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="financial_transection[{{ $loop->index }}][info_currency_used]" value="{{ isset($grid_two['info_currency_used']) ? $grid_two['info_currency_used'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="financial_transection[{{ $loop->index }}][info_comments]" value="{{ isset($grid_two['info_comments']) ? $grid_two['info_comments'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="financial_transection[{{ $loop->index }}][info_remarks]" value="{{ isset($grid_two['info_remarks']) ? $grid_two['info_remarks'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                    </tr>
                                                @endforeach
                                            {{-- @else
                                                    <tr>
                                                        <td colspan="9">No Financial Transactions details found</td>
                                                    </tr> --}}
                                            @endif  
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#Financial_Transactions_country_sub_data').click(function(e) {
                                        function generateTableRow(serialNumber) {
                                            var data = @json($grid_two);
                                            var html = '';
                                            html +=
                                                '<tr>' +
                                                '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                                                '<td><input type="text" name="financial_transection[' + serialNumber + '][info_transaction]"></td>' +
                                                '<td><input type="text" name="financial_transection[' + serialNumber + '][info_transaction_type]"></td>' +
                                                '<td> <div class="new-date-data-field"><div class="group-input input-date"> <div class="calenderauditee"><input id="date_'+ serialNumber +'_date" type="text" name="financial_transection[' + serialNumber + '][info_date]" placeholder="DD-MMM-YYYY" /> <input type="date" name="financial_transection[' + indexDetail + '][info_date]" min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" value="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" id="date_'+ indexDetail +'_date" class="hide-input show_date" style="position: absolute; top: 0; left: 0; opacity: 0;" oninput="handleDateInput(this, \'date_'+ indexDetail +'_date\')" /> </div> </div></div></td>' +
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
                                    <button type="button" name="audit-agenda-grid" id="Ingredients_country_sub_data" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>+</button>
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
                                            @if (!empty($grid_three) && is_array($grid_three->data))
                                                @foreach ($grid_three->data as $grid_three)  
                                                    <tr>
                                                        <td><input disabled type="text" name="ingredi[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="ingredi[{{ $loop->index }}][info_ingredient_type]" value="{{ isset($grid_three['info_ingredient_type']) ? $grid_three['info_ingredient_type'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="ingredi[{{ $loop->index }}][info_ingredient_name]" value="{{ isset($grid_three['info_ingredient_name']) ? $grid_three['info_ingredient_name'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="ingredi[{{ $loop->index }}][info_ingredient_strength]" value="{{ isset($grid_three['info_ingredient_strength']) ? $grid_three['info_ingredient_strength'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="ingredi[{{ $loop->index }}][info_comments]" value="{{ isset($grid_three['info_comments']) ? $grid_three['info_comments'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                        <td><input type="text" name="ingredi[{{ $loop->index }}][info_remarks]" value="{{ isset($grid_three['info_remarks']) ? $grid_three['info_remarks'] : '' }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}></td>
                                                    </tr>
                                                @endforeach
                                            @endif   
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    $('#Ingredients_country_sub_data').click(function(e) {
                                        function generateTableRow(serialNumber) {
                                            var data = @json($grid_three);
                                            var html = '';
                                            html +=
                                            '<tr>' +
                                                '<td><input disabled type="text" name="ingredi[serial]" value="' + serialNumber + '"></td>' +
                                                '<td><input type="text" name="ingredi[' + serialNumber + '][info_ingredient_type]"></td>' +
                                                '<td><input type="text" name="ingredi[' + serialNumber + '][info_ingredient_name]"></td>' +
                                                '<td><input type="text" name="ingredi[' + serialNumber + '][info_ingredient_strength]"></td>' +
                                                '<td><input type="text" name="ingredi[' + serialNumber + '][info_comments]"></td>' +
                                                '<td><input type="text" name="ingredi[' + serialNumber + '][info_remarks]"></td>' +
                                                '</tr>';
                                                // indexDetail++;
                            
                                            return html;
                                        }
                            
                                        var tableBody = $('#Ingredients_country_sub_data-field-instruction-modal tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount + 1);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Data Safety Notes">Data Safety Notes</label>
                                    <select name="data_safety_notes" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->data_safety_notes =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->data_safety_notes =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->data_safety_notes =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="comments">Comments</label>
                                    <select name="comments" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->comments =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->comments =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->comments =='3') selected @endif>3</option>
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
                                        <input type="text" id="annual_IB_update_date_due" value="{{ $data->annual_IB_update_date_due }}" readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}/>
                                        <input type="date" name="annual_IB_update_date_due" value="{{ $data->annual_IB_update_date_due }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                            class="hide-input" oninput="handleDateInput(this, 'annual_IB_update_date_due')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date of 1st IB">Date of 1st IB</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="date_of_first_IB" value="{{ $data->date_of_first_IB }}" readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}/>
                                        <input type="date" name="date_of_first_IB" value="{{ $data->date_of_first_IB }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                            class="hide-input" oninput="handleDateInput(this, 'date_of_first_IB')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date of 1st Protocol">Date of 1st Protocol</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="date_of_first_protocol" value="{{ $data->date_of_first_protocol }}" readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}/>
                                        <input type="date" name="date_of_first_protocol" value="{{ $data->date_of_first_protocol }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                            class="hide-input" oninput="handleDateInput(this, 'date_of_first_protocol')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date Safety Report">Date Safety Report</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="date_safety_report" value="{{ $data->date_safety_report }}" readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}/>
                                        <input type="date" name="date_safety_report" value="{{ $data->date_safety_report }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                            class="hide-input" oninput="handleDateInput(this, 'date_safety_report')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date Trial Active">Date Trial Active</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="date_trial_active" value="{{ $data->date_trial_active }}" readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}/>
                                        <input type="date" name="date_trial_active" value="{{ $data->date_trial_active }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                            class="hide-input" oninput="handleDateInput(this, 'date_trial_active')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="End of Study Report Date">End of Study Report Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="end_of_study_report_date" value="{{ $data->end_of_study_report_date }}" readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}/>
                                        <input type="date" name="end_of_study_report_date" value="{{ $data->end_of_study_report_date }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                            class="hide-input" oninput="handleDateInput(this, 'end_of_study_report_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="End of Study Synopsis Date">End of Study Synopsis Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="end_of_study_synopsis_date" value="{{ $data->end_of_study_synopsis_date }}" readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}/>
                                        <input type="date" name="end_of_study_synopsis_date" value="{{ $data->end_of_study_synopsis_date }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                            class="hide-input" oninput="handleDateInput(this, 'end_of_study_synopsis_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="End of Trial Date">End of Trial Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="end_of_trial_date" value="{{ $data->end_of_trial_date }}" readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}/>
                                        <input type="date" name="end_of_trial_date" value="{{ $data->end_of_trial_date }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                            class="hide-input" oninput="handleDateInput(this, 'end_of_trial_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Last Visit">Last Visit</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="last_visit" value="{{ $data->last_visit }}" readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}/>
                                        <input type="date" name="last_visit" value="{{ $data->last_visit }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                            class="hide-input" oninput="handleDateInput(this, 'last_visit')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Next Visit">Next Visit</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="next_visit" value="{{ $data->next_visit }}" readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}/>
                                        <input type="date" name="next_visit" value="{{ $data->next_visit }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                            class="hide-input" oninput="handleDateInput(this, 'next_visit')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Ethics Commitee Approval">Ethics Commitee Approval</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="ethics_commitee_approval" value="{{ $data->ethics_commitee_approval }}" readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}/>
                                        <input type="date" name="ethics_commitee_approval" value="{{ $data->ethics_commitee_approval }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                            {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}
                                            class="hide-input" oninput="handleDateInput(this, 'ethics_commitee_approval')" />
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
                                    <select name="safety_impact_risk" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->safety_impact_risk =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->safety_impact_risk =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->safety_impact_risk =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="CROM">CROM</label>
                                    <input type="text" name="CROM" id="" value="{{ $data->CROM }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}/>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="lead_investigator">Lead Investigator</label>
                                    <input type="text" name="lead_investigator" id="" value="{{ $data->lead_investigator }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="sponsor">Sponsor</label>
                                    <input type="text" name="sponsor" id="" value="{{ $data->sponsor }}" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="additional_investigators">Additional Investigators</label>
                                    <select id="additional_investigators" name="additional_investigators" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->additional_investigators =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->additional_investigators =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->additional_investigators =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="clinical_events_committee">Clinical Events Committee</label>
                                    <select id="clinical_events_committee" name="clinical_events_committee" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->clinical_events_committee =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->clinical_events_committee =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->clinical_events_committee =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="clinical_research_team">Clinical Research Team</label>
                                    <select id="clinical_research_team" name="clinical_research_team" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->clinical_research_team =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->clinical_research_team =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->clinical_research_team =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="data_safety_monitoring_board">Data Safety Monitoring Board</label>
                                    <select id="data_safety_monitoring_board" name="data_safety_monitoring_board" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->data_safety_monitoring_board =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->data_safety_monitoring_board =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->data_safety_monitoring_board =='3') selected @endif>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Distribution List">Distribution List</label>
                                    <select id="distribution_list" name="distribution_list" {{ $data->stage == 0 || $data->stage == 3 ? 'disabled' : '' }}>
                                        <option value="0">Enter Your Selection Here</option>
                                        <option value="1" @if ($data->distribution_list =='1') selected @endif>1</option>
                                        <option value="2" @if ($data->distribution_list =='2') selected @endif>2</option>
                                        <option value="3" @if ($data->distribution_list =='3') selected @endif>3</option>
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
                                    <div class="static">{{ $data->activate_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Closed on">Activate On</label>
                                    <div class="Date">{{ $data->activate_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="Closed on">Activate Comment</label>
                                    <div class="Date">{{ $data->activate_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Closed by">Close By</label>
                                    <div class="static">{{ $data->close_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Closed on">Close On</label>
                                    <div class="Date">{{ $data->close_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="Closed on">Close Comment</label>
                                    <div class="Date">{{ $data->close_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Closed by">Cancel By</label>
                                    <div class="static">{{ $data->cancel_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Closed on">Cancel On</label>
                                    <div class="Date">{{ $data->cancel_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="group-input">
                                    <label for="Closed on">Cancel Comment</label>
                                    <div class="Date">{{ $data->cancel_comment }}</div>
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


<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('country_send_stage', $data->id) }}" method="POST">
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
                            CTA Submission
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

<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('country_Cancle', $data->id) }}" method="POST">
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