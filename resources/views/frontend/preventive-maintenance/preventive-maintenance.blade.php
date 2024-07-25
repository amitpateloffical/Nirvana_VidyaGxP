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
        / Preventive Maintenance
    </div>
</div>

{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}

<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Preventive Maintenance</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Signatures</button>
        </div>

        <form action="{{ route('preventivemaintenance.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="Initiator"> Record Number </label>
                                    <input disabled type="text" name="record_number" value="{{ Helpers::getDivisionName(session()->get('division')) }}/Preventive Maintenance/{{ date('Y') }}/{{ $record_number }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Short Description">Initiator <span class="text-danger"></span></label>
                                    <input type="hidden" name="initiator_id" value="{{ Auth::user()->id }}">
                                    <input disabled type="text" name="initiator" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label disabled for="division_code">Division Code<span class="text-danger"></span></label>
                                    <input disabled type="text" name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                </div>
                            </div>

                            <div class="col-md-6 ">
                                <div class="group-input ">
                                    <label for="intiation-date"> Date Of Initiation<span class="text-danger"></span></label>
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    <input readonly type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="assign to"> Assigned To</label>
                                    <select name="assign_to">
                                        <option>Enter Your Selection Here</option>
                                        <option value="Major">User1</option>
                                        <option value="Minor">User2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 pt-3">
                                <div class="group-input">
                                  <input disabled type="text" name="Initiator" value="{{Auth::user()->name}}">
                                       <label for="Short Description">Short Description<span class="text-danger">*</span>
                                            <p>255 characters remaining </p>
                                        <input id="docname" type="text" name="short_description" maxlength="255" required>
                                 </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Date Due"> Due Date</label>
                                    <div><small class="text-primary">If revising Due Date, kindly mention revision
                                            reason in "Due Date Extension Justification" data field.</small></div>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">PM Details </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Additional Information"><b>Additional Information</b></label>
                                    <input type="text" name="additional_information" value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Related URLs"><b>Related URLs</b></label>
                                    <input type="text" name="related_urls" value="">
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
                                    <table class="table table-bordered" id="Action_plan_Details">
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
                                            <td><input disabled type="text" name="action_plan[0][serial]" value="1"></td>
                                            <td><input type="text" name="action_plan[0][action]" value=""></td>
                                            <td><input type="text" name="action_plan[0][responsible]" value=""></td>
                                            <td><input type="text" name="action_plan[0][deadline]" value=""></td>
                                            <td><input type="text" name="action_plan[0][item_status]" value=""></td>
                                            <td><input type="text" name="action_plan[0][remarks]" value=""></td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="PM_Frequency">PM Frequency</label>
                                    <select name="PM_frequency">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Site Name">(Parent) Site Name</label>
                                    <select name="parent_site_name">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Building">(Parent) Building</label>
                                    <select name="parent_building">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Floor">(Parent) Floor</label>
                                    <select name="parent_floor">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Room">(Parent) Room</label>
                                    <select name="parent_room">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Comments">Comments</label>
                                    <textarea name="comments" id="" cols="30" rows="3"></textarea>
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
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Completed by">Completed By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Completed on">Completed On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA Approved by">QA Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA Approved on">QA Approved On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Supervisor Approval by">Supervisor Approval By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Supervisor Approval on">Supervisor Approval On</label>
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
                    '<td><input disabled type="text" name="action_plan[' + serialNumber + '][serial]" value="' + serialNumber +
                    '"></td>' +
                    '<td><input type="text" name="action_plan[' + serialNumber + '][action]"></td>' +
                    '<td><input type="text" name="action_plan[' + serialNumber + '][responsible]"></td>' +
                    '<td><input type="text" name="action_plan[' + serialNumber + '][deadline]"></td>' +
                    '<td><input type="text" name="action_plan[' + serialNumber + '][item_status]"></td>' +
                    '<td><input type="text" name="action_plan[' + serialNumber + '][remarks]"></td>' +
                    '</tr>';
                return html;
            }

            var tableBody = $('#Action_plan_Details tbody');
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