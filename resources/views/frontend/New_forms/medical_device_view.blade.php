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
<style>
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

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(7) {
        border-radius: 0px 20px 20px 0px;

    }
</style>

<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / Medical Device
    </div>
</div>



{{-- ! ========================================= --}}
{{-- !               medicalDevice FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">
        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head">Record Workflow </div>

                <div class="d-flex" style="gap:20px;">
                     @php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => 1])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();

                    @endphp
                    {{-- <button class="button_theme1" onclick="window.print();return false;"
                        class="new-doc-btn">Print</button> --}}
                     <button class="button_theme1"> <a class="text-white" href="{{ route('medialdevice_audittrail', $medicalDevice->id) }}">
                            Audit Trail </a> </button>

                    @if ($medicalDevice->stage == 1 )
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Start
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                            Cancel
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
                    @elseif($medicalDevice->stage == 2 )


                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                            Child
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                           Retire
                        </button>

                        @endif

                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>


                </div>

            </div>
            <div class="status">
                <div class="head">Current Status</div>
                 @if ($medicalDevice->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                        @else
                        <div class="progress-bars d-flex">
                            @if ($medicalDevice->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif
                             @if ($medicalDevice->stage >= 2)
                            <div class="active">In Progress</div>
                        @else
                            <div class="">In Progress</div>
                        @endif
                        @if ($medicalDevice->stage >= 3)
                        <div class="bg-danger">Retired</div>
                    @else
                        <div class="">Retired</div>
                    @endif
                    @endif
                        </div>


            {{-- ---------------------------------------------------------------------------------------- --}}
        </div>
    </div>
    <div class="control-list">
        @php
            $users = DB::table('users')->get();
        @endphp
        <div id="change-control-fields">
            <div class="container-fluid">
        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Medical Device</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Signatures</button>
        </div>

        <form action="{{ route('Update',$medicalDevice->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">General Information</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Originator"><b>Initiator</b></label>
                                    {{-- <input type="hidden" name="initiator"> --}}
                                        <input  type="hidden" value="{{ $medicalDevice->initiator }} ">
                                    <input disabled type="text" name="initiator" value="{{ Auth::user()->name }}">
                                </div>
                            </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Date of Initiation"><b>Date of Initiation</b></label>
                                            <input readonly type="text" value="{{ date('d-M-Y') }}" name="date_of_initiation">
                                        <input type="hidden" value="{{ date('d-m-Y') }}" name="date_of_initiation">
                                        </div>
                                    </div>


                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label>
                                    <input id="docname" type="text" name="short_description" value="{{ $medicalDevice->short_description}}" maxlength="255" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Record">Record no.</label>
                                    <input disabled type="text" name="record"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}MEDICAL/{{ date('Y') }}/{{ $medicalDevice->record }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Type</label>
                                    <select name="type">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $medicalDevice->type == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $medicalDevice->type == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $medicalDevice->type == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Other Type</label>
                                    <input name="other_type" value="{{$medicalDevice->other_type}}"/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="{{$medicalDevice->assign_to}}"> {{$medicalDevice->assign_to}}</option>
                                        <option value="Pankaj Jat">Pankaj Jat</option>
                                        <option value="Gaurav">Gaurav</option>
                                        <option value="Manish">Manish</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6 new-date-medicalDevice-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due <span class="text-danger"></span></label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                        <input readonly type="text" value="{{ Helpers::getdateFormat($medicalDevice->due_date) }}">
                                        <input type="hidden" value="{{$medicalDevice->due_date }}" id="due_date" name="due_date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Responsible Department">Related URLs</label>
                                    <select name="URLs">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="1"{{ $medicalDevice->URLs == '1' ? 'selected':''}}>1</option>
                                        <option value="2"{{ $medicalDevice->URLs == '2' ? 'selected':''}}>2</option>
                                        <option value="3"{{ $medicalDevice->URLs == '3' ? 'selected':''}}>3</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Inv Attachments"> Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="attachment">
                                            @if ($medicalDevice->attachment)
                                                @foreach(json_decode($medicalDevice->attachment) as $file)
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
                                            <input type="file" id="HOD_Attachments" name="attachment[]"
                                                oninput="addMultipleFiles(this, 'attachment')"
                                                multiple>
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
                            </script>
                            <div class="sub-head">Product Information</div>
<div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Trade Name</label>
                                    <input name="trade_name"value="{{$medicalDevice->trade_name}}"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Manufacturer</label>
                                    <select name="manufacturer" id="manufacturer" >
                                        <option value="">Select</option>
                                        <option value="Pankaj" @if($medicalDevice->manufacturer == "Pankaj") selected @endif>Pankaj</option>
                                        <option value="Gaurav" @if($medicalDevice->manufacturer == "Gaurav") selected @endif>Gaurav</option>
                                        <option value="Manish" @if($medicalDevice->manufacturer == "Manish") selected @endif>Manish</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">TheraPeutic Area</label>
                                    <select name="therapeutic_area" id="therapeutic_area">
                                        <option value="">Select</option>
                                        <option value="1" @if ($medicalDevice->therapeutic_area == "1") selected @endif>1</option>
                                        <option value="2" @if ($medicalDevice->therapeutic_area == "2") selected @endif>2</option>
                                        <option value="3" @if ($medicalDevice->therapeutic_area == "3") selected @endif>3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Prooduct Code</label>
                                    <select name="prooduct_code" id="prooduct_code">
                                        <option value="">Select</option>
                                        <option value="1" @if ($medicalDevice->prooduct_code == 1) selected @endif>P-1</option>
                                        <option value="2" @if ($medicalDevice->prooduct_code == 2) selected @endif>P-2</option>
                                        <option value="3" @if ($medicalDevice->prooduct_code == 3) selected @endif>P-3</option>
                                        {{-- <option value="">{{ $medicalDevice->product_code }}</option> --}}
                                        {{-- <option value="P-1">P-1</option>
                                        <option value="P-2">P-2</option>
                                        <option value="P-3">P-3</option> --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label class="mt-4" for="Audit Comments">Intended Use</label>
                                    <textarea class="summernote" name="intended_use" value="" id="summernote-16" >{{ $medicalDevice->intended_use }}</textarea>

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
                </div>

                {{-- --------------------------------------signature form--------------------------------- --}}
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="submitted by">Started By</label>
                                    <div class="static">{{ $medicalDevice->started_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Started on">Started On</label>
                                    <div class="Date">{{ $medicalDevice->started_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reviewed by">Retired By</label>
                                    <div class="static">{{ $medicalDevice->retired_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Retired on">Retired On</label>

                                    <div class="Date">{{ $medicalDevice->retired_on }}</div>
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


{{-- ---------------------------------------------signature modal ----------------------------------------------}}
<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('medicaldevice_stageChange', $medicalDevice->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-3 text-justify">
                        Please select a meaning and a outcome for this task and enter your username
                        and password for this task. You are performing an electronic signature,
                        which is legally binding equivalent of a hand written signature.
                    </div>
                    <div class="group-input">
                        <label for="username">Username</label>
                        <input type="text" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="group-input">
                        <label for="comment">Comment</label>
                        <input type="comment" name="comment">
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

{{-- ---------------------------------------------Child modal ----------------------------------------------}}

<div class="modal fade" id="child-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <form action="{{ route('medicaldevice_stageChange', $medicalDevice->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        @if ($medicalDevice->stage == 1)
                        <label style="display: flex;" for="major">
                            <input  type="radio" name="child_type" id="major" value="rca">
                             Dossier Document
                        </label>

                        <label for="major">
                            <input type="radio" name="child_type" id="major" value="extension">
                            Medical Device Registration
                        </label>
                        @endif

                        @if ($medicalDevice->stage == 2)
                        <label for="major">
                            <input type="radio" name="child_type" id="major" value="Dossier Document">
                            Dossier Document
                        </label>

                        <label for="major">
                            <input type="radio" name="child_type" id="major" value="Medical Device Registration">
                            Medical Device Registration
                        </label>
                        @endif
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

{{-- ---------------------------------------reject modal---------------------------------- --}}
<div class="modal fade" id="rejection-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('medicalDevice_cancel', $medicalDevice->id) }}" method="POST">
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
        newReference.classList.add('row', 'reference-medicalDevice-' + referenceCount);
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
        let referenceContainer = document.querySelector('.reference-medicalDevice');
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
