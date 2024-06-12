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


                    '<td><input type="date" name="Date[]"></td>' +



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
        / RT-Dossier Documents
    </div>
</div>

{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">
    @include('frontend.preventive-maintenance.stage')

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Preventive Maintenance</button>
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Local Information</button> -->
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signatures</button> -->

        </div>
        <form action="{{ route('preventivemaintenance.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                <!-- Dossier Documents-->
                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">
                            General Information
                        </div> <!-- RECORD NUMBER -->
                        <div class="row">
                        <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator"> Record Number </label>
                            <input disabled type="text" name="record_number"
                            value="{{ Helpers::getDivisionName($data->division_id) }}/Preventive Maintenance/{{ Helpers::year($data->created_at) }}/{{ $data->record_number ? str_pad($data->record_number, 4, "0", STR_PAD_LEFT ) : '1' }}">
                        </div>
                       </div>
                       <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Short Description">Initiator <span class="text-danger"></span></label>
                                <input type="hidden" name="initiator_id" value="{{ Auth::user()->id }}">
                                <input disabled type="text" name="initiator"
                                        value="{{ Auth::user()->name }}">
                            </div>
                        </div>
                       <div class="col-lg-6">
                            <div class="group-input">
                                <label disabled for="Division Code">Division Code<span class="text-danger"></span></label>
                                <input disabled type="text" name="division_code"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6 ">
                            <div class="group-input ">
                                <label for="due-date"> Date Of Initiation<span class="text-danger"></span></label>
                                <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="assign to"> Assigned To</label>
                                <select name="assign_to" >
                                    <option>Enter Your Selection Here</option>
                                    <option value="User1" {{ $data->assign_to == 'User1' ? 'selected' :
                                        '' }}>User1</option>
                                    <option value="User2" {{ $data->assign_to == 'User2' ? 'selected' :
                                        '' }}>User2</option>
                                    <option value="User3" {{ $data->assign_to == 'User3' ? 'selected' :
                                    '' }}>User3</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="group-input">
                                <label for="Short Description">Short Description<span class="text-danger">*</span>
                                    <p>255 characters remaining </p>
                                    <textarea id="docname" maxlength="255" name="short_description" required>{{ $data->short_description }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> Due Date
                                </label>
                                <small class="text-primary">
                                    Please mention expected date of completion
                                </small>
                                <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" 
                                class="hide-input" oninput="handleDateInput(this, 'due_date')" value="{{ $data->due_date ?? '' }}"/>
                            </div>
                        </div>
                        <div class="sub-head"> PM Details </div>
                        <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Additional Information"><b>Additional Information</b></label>
                                    <input type="text" name="additional_information" value="{{ $data->additional_information}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Related URLs"><b>Related URLs</b></label>
                                    <input type="text" name="related_urls" value="{{$data->related_urls}}">
                                </div>
                            </div>
                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Action Plan (0)
                                    <button type="button" name="audit-agenda-grid" id="Action_plan">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Action_plan_details">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Action</th>
                                                <th style="width: 16%">Responsible</th>
                                                <th style="width: 16%">Deadline</th>
                                                <th style="width: 16%">Item Status</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if ($action_plans && is_array($action_plans->data))
                                        @foreach ($action_plans->data as $action_plan)
                                            <tr>
                                                <td><input disabled type="text" name="action_plan[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}"></td>
                                                <td><input type="text" name="action_plan[{{ $loop->index }}][action]" value="{{ Helpers::getArrayKey($action_plan, 'action') }}"></td>
                                                <td><input type="text" name="action_plan[{{ $loop->index }}][responsible]" value="{{ Helpers::getArrayKey($action_plan, 'responsible') }}"></td>
                                                <td><input type="text" name="action_plan[{{ $loop->index }}][deadline]" value="{{ Helpers::getArrayKey($action_plan, 'deadline') }}"></td>
                                                <td><input type="text" name="action_plan[{{ $loop->index }}][item_status]" value="{{ Helpers::getArrayKey($action_plan, 'item_status') }}"></td>
                                                <td><input type="text" name="action_plan[{{ $loop->index }}][remarks]" value="{{ Helpers::getArrayKey($action_plan, 'remarks') }}"></td>
                                            </tr>
                                        @endforeach
                                        @endif  
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Reference Recores">PM Frequency</label>
                                <select id="PM_frequency" name="PM_frequency" id="">
                                    <option value="">--Select---</option>
                                    <option value="1" {{ $data->PM_frequency == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $data->PM_frequency == '2' ? 'selected' : '' }}>2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="RLS Record Number"><b>(Parent) Site Name</b></label>
                                <select id="parent_site_name" name="parent_site_name">
                                    <option value="">Select a value</option>
                                    <option value="1" {{ $data->parent_site_name == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $data->parent_site_name == '2' ? 'selected' : '' }}>2</option>
                                </select>
                            </div>
                        </div>
                            <div class="col-lg-6">
                            <div class="group-input">
                                <label for="RLS Record Number"><b> (Parent) Building</b></label>
                                <select id="parent_building" name="parent_building">
                                    <option value="">Select a value</option>
                                    <option value="1" {{ $data->parent_building == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $data->parent_building == '2' ? 'selected' : '' }}>2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Responsible Department">(Parent) Floor</label>
                                <select name="parent_floor">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="1" {{ $data->parent_floor == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $data->parent_floor == '2' ? 'selected' : '' }}>2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Responsible Department">(Parent) Room</label>
                                <select name="parent_room">
                                    <option value="">Enter Your Selection Here</option>
                                    <option value="1" {{ $data->parent_room == '1' ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $data->parent_room == '2' ? 'selected' : '' }}>2</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-12 pt-3">
                            <div class="group-input">
                                <label for="RLS Record Number"><b>Comments</b></label>
                                <input type="text" name="comments" value="{{$data->comments}}">
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
        <!-- Local Information -->
                  
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <!-- <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Scheduled start Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="start_date" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Scheduled end Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="start_date" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Assigned To</b></label>
                                    <p class="text-primary">Person responsible</p>
                                    <input type="text" name="record_number" value="">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label  for="RLS Record Number"><b>CRO/Vendor</b></label>

                                    <input type="text" name="record_number" value="">

                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="start_date">Date response due</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="start_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="start_date_checkdate" name="start_date" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div> -->




                       




                        <!-- <div class="group-input">
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

                                            <th style="width: 16%">Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input disabled type="text" name="serial[]" value="1"></td>

                                            <td><input type="date" name="Date[]"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Co-Auditors <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Distribution List <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Scope <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actions">Comments <span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>

                        </div> -->

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




                






                    <!-- --------Signatures---------- -->


                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Electronic Signatures
                            </div>
                            <div class="row">
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
                                        <label for="cancelled by">Plan Approved By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="cancelled on">Plan Approved On</label>
                                        <div class="Date"></div>
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
            $('#Action_plan').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +'"></td>' +
                        '<td><input type="text" name="action_plan[' + serialNumber + '][action]"></td>'+
                        '<td><input type="text" name="action_plan[' + serialNumber + '][responsible]"></td>'+
                        '<td><input type="text" name="action_plan[' + serialNumber + '][deadline]"></td>'+
                        '<td><input type="text" name="action_plan[' + serialNumber + '][item_status]"></td>'+
                        '<td><input type="text" name="action_plan[' + serialNumber + '][remarks]"></td>'+
                       '</tr>';
                    return html;
                }
                var tableBody = $('#Action_plan_details tbody');
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