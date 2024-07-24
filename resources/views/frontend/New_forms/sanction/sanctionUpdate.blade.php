@extends('frontend.layout.main')
@section('container')
<style>
    textarea.note-codable {
        display: none !important;
    }

    header {
        display: none;
    }


    .progress-bars div {
        flex: 1 1 auto;
        border: 1px solid grey;
        padding: 5px;
        text-align: center;
        position: relative;
        /* border-right: none; */
        background: white;
    }

    .state-block {
        padding: 20px;
        margin-bottom: 20px;
    }

    .progress-bars div.active {
        background: green;
        font-weight: bold;
    }

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(1) {
        border-radius: 20px 0px 0px 20px;
    }

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(9) {
        border-radius: 0px 20px 20px 0px;

    }
</style>

@php
$users = DB::table('users')->get();
@endphp
<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / EHS-sanction
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">


        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head">Record Workflow </div>

                <div class="d-flex" style="gap:20px;">
                    @php
                    $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => 7])->get();
                    $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp

                    <button class="button_theme1"> <a class="text-white" href="{{ url('audit_trail_sanction', $sanction->id) }}"> Audit Trail </a> </button>

                    @if ($sanction->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Send Translation
                    </button> -->
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Close
                    </button>
                    @elseif($sanction->stage == 2 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                    <!-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Obsolete
                    </button> -->

                    @endif
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>
                </div>
            </div>


            <div class="status">
                <div class="head">Current Status</div>
                @if ($sanction->stage == 0)
                <div class="progress-bars">
                    <div class="bg-danger">Closed-Cancelled</div>
                </div>

                @else
                <div class="progress-bars d-flex" style="font-size: 15px;">
                    @if ($sanction->stage >= 1)
                    <div class="active">Opened</div>
                    @else
                    <div class="">Opened</div>
                    @endif


                    @if ($sanction->stage >= 2)
                    <div class="bg-danger">Closed</div>
                    @else
                    <div class="">Closed</div>
                    @endif
                    {{-- @endif --}}
                </div>
                @endif
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>


        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Sanction</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button>
        </div>

        <script>
            $(document).ready(function() {
                <?php if ($sanction->stage == 2) : ?>
                    $("#target :input").prop("disabled", true);
                <?php endif; ?>
            });
        </script>
        <form id="target" action="{{ route('sanction.update', $sanction->id)}}" method="POST" enctype="multipart/form-data">
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
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">

                                    <label for="Originator"><b>Originator</b></label>
                                    <input disabled type="text" name="originator" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="originator" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="opened-date">Date Opened<span class="text-danger"></span></label>
                                    <div class="calenderauditee">
                                        <input disabled type="text" value="{{ date('d-M-Y', strtotime($sanction->initiation_date)) }}" name="initiation_date">
                                        <input type="hidden" value="{{ date('d-M-Y', strtotime($sanction->initiation_date)) }}" name="initiation_date">

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number">Record Number</label>
                                    <input disabled type="text" name="record" value="{{ Helpers::getDivisionName($sanction->division_id) }}/NP/{{ Helpers::year($sanction->created_at) }}/{{ $sanction->record }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="short_description">Short Description<span class="text-danger">*</span></label>
                                    <div><small class="text-primary">Sanction short description to be represented on desktop</small></div>
                                    <input id="docname" type="text" name="short_description" maxlength="255" value="{{$sanction->short_description}}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="assign_to">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <div><small class="text-primary">Person Responsible</small></div>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="assign_to">Select a value</option>
                                        @foreach ($users as $datas)
                                        @if(Helpers::checkUserRolesassign_to($datas))
                                        <option value="{{ $datas->name }}" {{ $sanction->assign_to == $datas->name ? 'selected' : '' }}>
                                            {{ $datas->name }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Due Date <span class="text-danger"></span></label>
                                    <div><small class="text-primary text-danger">date this sanction should be closed by</small></div>
                                    <div class="calenderauditee">

                                        <input type="hidden" value="{{$due_date}}" name="due_date">
                                        <input disabled type="text" value="{{Helpers::getdateFormat($sanction->due_date)}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="group-input">
                                    <label for="sanction_type">
                                        Type <span class="text-danger"></span>
                                    </label>
                                    <div><small class="text-primary">Type of Sanction</small></div>
                                    <select name="sanction_type" id="select-state" placeholder="Select...">
                                        <option value="">Enter your selection here</option>
                                        <option value="1" @if ($sanction->sanction_type == 1) selected @endif>1</option>
                                        <option value="2" @if ($sanction->sanction_type == 2) selected @endif>2</option>
                                        <option value="3" @if ($sanction->sanction_type == 3) selected @endif>3</option>
                                        <option value="4" @if ($sanction->sanction_type == 4) selected @endif>4</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="file_attach">File Attachments</label>
                                    <div><small class="text-primary">
                                        </small>
                                    </div>


                                    <!-- <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_attach[]" oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                        </div>
                                    </div> -->
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach">
                                            @if ($sanction->file_attach)
                                            @foreach(json_decode($sanction->file_attach) as $file)
                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                <b>{{ $file }}</b>
                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                <a type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                            </h6>
                                            @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_attach[]" value="{{$sanction->file_attach}}" oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="description"> Description<span class="text-danger"></span></label>
                                    <textarea name="description">{{$sanction->description}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="authority_type">
                                        Authority Type <span class="text-danger"></span>
                                    </label>
                                    <select name="authority_type" id="select-state" placeholder="Select...">
                                        <option value="">Select a value</option>
                                        <option value="1" @if ($sanction->authority_type == 1) selected @endif>1</option>
                                        <option value="2" @if ($sanction->authority_type == 2) selected @endif>2</option>
                                        <option value="3" @if ($sanction->authority_type == 3) selected @endif>3</option>
                                        <option value="4" @if ($sanction->authority_type == 4) selected @endif>4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Authority">
                                        Authority <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Enter your selection here" name="authority">
                                        <option value="">Select a value</option>
                                        <option value="1" @if ($sanction->authority == 1) selected @endif>1</option>
                                        <option value="2" @if ($sanction->authority == 2) selected @endif>2</option>
                                        <option value="3" @if ($sanction->authority == 3) selected @endif>3</option>
                                        <option value="4" @if ($sanction->authority == 4) selected @endif>4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <!-- @if (!empty($cc->id))
                                        <input type="hidden" name="ccId" value="{{ $cc->id }}">
                                    @endif -->
                                <div class="group-input">
                                    <label for="Fine">Fine</label>
                                    <input type="text" name="fine" value="{{$sanction->fine}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Currency">
                                        Currency <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Enter your selection here" name="currency">
                                        <option value="">Select a value</option>
                                        <option value="1" @if ($sanction->currency == 1) selected @endif>1</option>
                                        <option value="2" @if ($sanction->currency == 2) selected @endif>2</option>
                                        <option value="3" @if ($sanction->currency == 3) selected @endif>3</option>
                                        <option value="4" @if ($sanction->currency == 4) selected @endif>4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit </a> </button>
                        </div>
                    </div>
                </div>


                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closed_by">Closed By</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="closed_on">Closed On</label>
                                    <div class="Date"></div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit </a></button>
                            </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        const removeButtons = document.querySelectorAll('.remove-file');

        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const fileName = this.getAttribute('data-file-name');
                const fileContainer = this.closest('.file-container');

                // Hide the file container
                if (fileContainer) {
                    fileContainer.style.display = 'none';
                }
            });
        });
    });
</script>
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
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>


<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('sanctionCancel', $sanction->id) }}" method="POST">
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
@endsection