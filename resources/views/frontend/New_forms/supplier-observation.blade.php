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
        {{ Helpers::getDivisionName(session()->get('division')) }} / Supplier Observation
        {{-- KSA / Root Cause Analysis   --}}
        {{-- EHS-North America --}}
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

        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Supplier Observation</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Impact Analysis</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Signatures</button>
        </div>

        <form action="{{ route('supplier_store') }}" method="POST" enctype="multipart/form-data">
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
                                General Information
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number" value="{{ Helpers::getDivisionName(session()->get('division')) }}/SO/{{ date('Y') }}">

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="originator">Initiator</label>
                                    <input disabled type="text" name="originator_id" value="{{ Auth::user()->name }}" />
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
                                    <input id="docname" type="text" name="short_description" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="assigned_to">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assigned_to">
                                        <option value="">Select a value</option>
                                        <option value="a">a</option>
                                        <option value="b">b</option>
                                        <option value="c">c</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Due Date</label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="criticality"><b>Criticality</b></label>
                                    <select name="criticality">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="e">e</option>
                                        <option value="f">f</option>
                                        <option value="g">g</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="priority_level"><b>Priority Level</b></label>
                                    <select name="priority_level">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="h">h</option>
                                        <option value="i">i</option>
                                        <option value="j">j</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="auditee">Auditee/Supplier</label>
                                    <input type="text" name="auditee">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="contact_person">Contact Person</label>
                                    <input type="text" name="contact_person">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="descriptions">Descriptions</label>
                                    <textarea name="descriptions" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="attached_file">Attached File</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="attached_file"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="attached_file[]" oninput="addMultipleFiles(this, 'attached_file')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="attached_picture">Attached Picture</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="attached_picture"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="attached_picture[]" oninput="addMultipleFiles(this, 'attached_picture')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="manufacturer">Manufacturer</label>
                                    <input type="text" name="manufacturer">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="type">Type</label>
                                    <select name="type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="aa">aa</option>
                                        <option value="bb">bb</option>
                                        <option value="cc">cc</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="product">Product/Materials(0)</label>
                                    <input type="text" name="product" id="">
                                </div>
                            </div>

                            <div class="sub-head">
                                Actions
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="proposed_actions">Proposed Actions</label>
                                    <textarea name="proposed_actions" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="comments">Comments</label>
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
                            <div class="sub-head col-12">Impact Analysis</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="impact">Impact</label>
                                    <select name="impact">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="aaa">aaa</option>
                                        <option value="bbb">bbb</option>
                                        <option value="ccc">ccc</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="impact_analysis">Impact Analysis </label>
                                    <textarea name="impact_analysis" id="" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="sub-head col-12">Risk Analysis</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="severity_rate">Severity Rate</label>
                                    <select name="severity_rate">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="qqq">qqq</option>
                                        <option value="www">www</option>
                                        <option value="ttt">ttt</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="occurence">Occurence</label>
                                    <select name="occurence">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="eee">eee</option>
                                        <option value="rrr">rrr</option>
                                        <option value="tttt">tttt</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="detection">Detection</label>
                                    <select name="detection">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="ooo">ooo</option>
                                        <option value="uuu">uuu</option>
                                        <option value="yyy">yyy</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="rpn">RPN</label>
                                    <select name="rpn">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="dd">dd</option>
                                        <option value="ff">ff</option>
                                        <option value="gg">gg</option>
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
                                Signatures
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted by">Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted on">Approved On</label>
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
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>
@endsection