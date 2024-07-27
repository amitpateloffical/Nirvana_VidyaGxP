@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
        .input_width{
            width:100%;
            border-radius: 5px;
            margin-bottom: 11px;
        }
    </style>


    <!-- --------------------------------------button--------------------- -->

    {{-- <script>
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
    </script> --}}
{{-- dateformat jquery links --}}
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>




    <script>
        // Initialize VirtualSelect
        VirtualSelect.init({
            ele: '#related_records, #hod'
        });

        // Function to handle tab switching
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

        // Function to move to the next step
        function nextStep() {
            const steps = document.querySelectorAll(".cctabcontent");
            const stepButtons = document.querySelectorAll(".cctablinks");

            // Check if there is a next step
            if (currentStep < steps.length - 1) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show next step
                steps[currentStep + 1].style.display = "block";

                // Update active class
                stepButtons[currentStep].classList.remove("active");
                stepButtons[currentStep + 1].classList.add("active");

                // Update current step
                currentStep++;
            }
        }

        // Function to move to the previous step
        function previousStep() {
            const steps = document.querySelectorAll(".cctabcontent");
            const stepButtons = document.querySelectorAll(".cctablinks");

            // Check if there is a previous step
            if (currentStep > 0) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show previous step
                steps[currentStep - 1].style.display = "block";

                // Update active class
                stepButtons[currentStep].classList.remove("active");
                stepButtons[currentStep - 1].classList.add("active");

                // Update current step
                currentStep--;
            }
        }

        // Initialize the first step to be visible
        document.addEventListener("DOMContentLoaded", function() {
            const steps = document.querySelectorAll(".cctabcontent");
            const stepButtons = document.querySelectorAll(".cctablinks");

            if (steps.length > 0) {
                steps[0].style.display = "block";
                stepButtons[0].classList.add("active");
            }
        });

        // Set initial step
        let currentStep = 0;
    </script>


    <!-- -----------------------------grid-1----------------------------script -->




    <script>
        $(document).ready(function() {
            let productMaterialIndex = {{ $gridDatas01 && is_array($gridDatas01->data) ? count($gridDatas01->data) : 0 }};

            $('#Product_Material').click(function(e) {
                e.preventDefault();

                function generateTableRowP(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="parent_info_no_product_material[]" value="' + serialNumber + '"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material[' + productMaterialIndex + '][product_code]"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material[' + productMaterialIndex + '][ar_number]"></td>' +
                        '<td><input type="date" name="parent_info_no_product_material[' + productMaterialIndex + '][mfg_date]"></td>' +
                        '<td><input type="date" name="parent_info_no_product_material[' + productMaterialIndex + '][expiry_date]"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material[' + productMaterialIndex + '][name]"></td>' +
                        '<td><button type="button" class="removeRowBtn">Remove</button></td>'+
                        '</tr>';

                    productMaterialIndex++;
                    return html;
                }

                var tableBody = $('#Product_Material_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRowP(rowCount + 1);
                tableBody.append(newRow);
            });

            // Event delegation for dynamically added remove buttons
            $('#Product_Material_details').on('click', '.removeRowBtn', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>

    <!-- -----------------------------grid-2----------------------------script -->


    <script>
        $(document).ready(function() {
            let productMaterialIndex2 = {{ $gridDatas02 && is_array($gridDatas02->data) ? count($gridDatas02->data) : 0 }};

            $('#Product_Material1').click(function(e) {
                e.preventDefault();

                function generateTableRowP(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="parent_info_no_product_material1[]" value="' + serialNumber + '"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material1[' + productMaterialIndex2 + '][product_code]"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material1[' + productMaterialIndex2 + '][batch_no]"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material1[' + productMaterialIndex2 + '][ar_number]"></td>' +
                        '<td><input type="date" name="parent_info_no_product_material1[' + productMaterialIndex2 + '][mfg_date]"></td>' +
                        '<td><input type="date" name="parent_info_no_product_material1[' + productMaterialIndex2 + '][expiry_date]"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material1[' + productMaterialIndex2 + '][label]"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material1[' + productMaterialIndex2 + '][pack_size]"></td>' +
                        '<td><button type="button" class="removeRowBtn">Remove</button></td>'+
                        '</tr>';

                    productMaterialIndex2++;
                    return html;
                }

                var tableBody = $('#Product_Material1_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRowP(rowCount + 1);
                tableBody.append(newRow);
            });

            // Event delegation for dynamically added remove buttons
            $('#Product_Material1_details').on('click', '.removeRowBtn', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>

    <!-- ------------------------------grid-3-------------------------script -->


    <script>
        $(document).ready(function() {
            let productMaterialIndex3 = {{ $gridDatas03 && is_array($gridDatas03->data) ? count($gridDatas03->data) : 0 }};
            $('#OOS_Details').click(function(e) {
                e.preventDefault();

                function generateTableRowP(serialNumber) {
                    var html =
                        '<tr>' +
                             '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                            '<td><input type="text" name="parent_oos_details['+ productMaterialIndex3 +'][ar_number]"></td>' +
                            '<td><input type="text" name="parent_oos_details['+ productMaterialIndex3 +'][test_name_of_oos]"></td>' +
                            '<td><input type="text" name="parent_oos_details['+ productMaterialIndex3 +'][result_obtained]"></td>' +
                            '<td><input type="text" name="parent_oos_details['+ productMaterialIndex3 +'][specification_limit]"></td>' +
                            '<td><button type="button" class="removeRowBtn">Remove</button></td>'+
                   '</tr>';
                    productMaterialIndex3++;
                    return html;
                }

                var tableBody = $('#OOS_Details_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRowP(rowCount + 1);
                tableBody.append(newRow);
            });

            // Event delegation for dynamically added remove buttons
            $('#OOS_Details_details').on('click', '.removeRowBtn', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>


    <!-- ---------------------------grid-4 -------------------------------- -->
<script>
    $(document).ready(function() {
        let productMaterialIndex4 = {{ $gridDatas04 && is_array($gridDatas04->data) ? count($gridDatas04->data) : 0 }};

        $('#OOT_Results4').click(function(e) {
            e.preventDefault();

            function generateTableRowP(serialNumber) {
                var html =
                    '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                        '<td><input type="text" name="OOT_Results['+ productMaterialIndex4 +'][AR_Number]"></td>' +
                        '<td><input type="text" name="OOT_Results['+ productMaterialIndex4 +'][Test_Name_Of_OOT]"></td>' +
                        '<td><input type="text" name="OOT_Results['+ productMaterialIndex4 +'][Result_Obtained]"></td>' +
                        '<td><input type="text" name="OOT_Results['+ productMaterialIndex4 +'][Initial_Interval_Details]"></td>' +
                        '<td><input type="text" name="OOT_Results['+ productMaterialIndex4 +'][Previous_Interval_Details]"></td>' +
                        '<td><input type="text" name="OOT_Results['+ productMaterialIndex4 +'][Difference_Of_Results]"></td>' +
                        '<td><input type="text" name="OOT_Results['+ productMaterialIndex4 +'][Trend_Limit]"></td>' +
                        '<td><button type="button" class="removeRowBtn">Remove</button></td>'+
                     '</tr>';

                productMaterialIndex4++;
                return html;
            }

            var tableBody = $('#OOT_Results4_Details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRowP(rowCount + 1);
            tableBody.append(newRow);
        });

        // Event delegation for dynamically added remove buttons
        $('#OOT_Results4_Details').on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        });
    });
</script>




<!-- --------------------------------grid-5--------------------------script -->

<script>
    $(document).ready(function() {
        let productMaterialIndex5 = {{ $gridDatas05 && is_array($gridDatas05->data) ? count($gridDatas05->data) : 0 }};

        $('#Details_Stability').click(function(e) {
            e.preventDefault();

            function generateTableRowP(serialNumber) {
                var html =
                    '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                        '<td><input type="text" name="parent_details_of_stability_study['+ productMaterialIndex5 +'][ar_number]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study['+ productMaterialIndex5 +'][temperature_rh]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study['+ productMaterialIndex5 +'][interval]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study['+ productMaterialIndex5 +'][orientation]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study['+ productMaterialIndex5 +'][pack_details]"></td>' +
                    '<td><button type="button" class="removeRowBtn">Remove</button></td>'+
                '</tr>';
                productMaterialIndex5++;
                return html;
            }

            var tableBody = $('#Details_Stability_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRowP(rowCount + 1);
            tableBody.append(newRow);
        });

        // Event delegation for dynamically added remove buttons
        $('#Details_Stability_details').on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
<script>
    $(document).on('click', '.removeRowBtn', function() {
        $(this).closest('tr').remove();
    })
</script>

    <div class="form-field-head">
        <!-- <div class="pr-id">
                New Document
            </div> -->
        <div class="division-bar pt-3">
            <strong>Site Division/Project</strong> :
            QMS-North America / Verification
        </div>
        <!-- <div class="button-bar">
                    <button type="button">Save</button>
                    <button type="button">Cancel</button>
                    <button type="button">New</button>
                    <button type="button">Copy</button>
                    <button type="button">Child</button>
                    <button type="button">Check Spelling</button>
                    <button type="button">Change Project</button>
                </div> -->
    </div>



    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}


    <div id="change-control-view">
        <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow </div>

                    <div class="d-flex" style="gap:20px;">
                        @php
                            $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $verification->division_id])->get();
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                            // $cftRolesAssignUsers = collect($userRoleIds); //->contains(fn ($roleId) => $roleId >= 22 && $roleId <= 33);
                            // $cftUsers = DB::table('verifications')->where(['verification_id' => $verification->id])->first();

                            // Define the column names
                            // $columns = ['Production_person', 'Warehouse_notification', 'Quality_Control_Person', 'QualityAssurance_person', 'Engineering_person', 'Analytical_Development_person', 'Kilo_Lab_person', 'Technology_transfer_person', 'Environment_Health_Safety_person', 'Human_Resource_person', 'Information_Technology_person', 'Project_management_person'];

                            // Initialize an array to store the values
                            $valuesArray = [];

                            // Iterate over the columns and retrieve the values
                            // foreach ($columns as $column) {
                            //     $value = $cftUsers->$column;
                            //     // Check if the value is not null and not equal to 0
                            //     if ($value !== null && $value != 0) {
                            //         $valuesArray[] = $value;
                            //     }
                            // }
                            // $cftCompleteUser = DB::table('deviationcfts_response')
                            // ->whereIn('status', ['In-progress', 'Completed'])
                            //     ->where('deviation_id',$verification->id)
                            //     ->where('cft_user_id', Auth::user()->id)
                            //     ->whereNull('deleted_at')
                            //     ->first();
                            // dd($cftCompleteUser);
                        @endphp
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                         <button class="button_theme1"> <a class="text-white" href="{{ route('Vaudit_trial', $verification->id) }}"> {{-- add here url for auditTrail i.e. href="{{ url('CapaAuditTrial', $verification->id) }}" --}}
                                Audit Trail </a> </button>

                        @if ($verification->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>

                        @elseif($verification->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info from Open
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Analysis Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($verification->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                               <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                              Return to Analysis in Progress
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QC Verification Complete
                            </button>
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cft-not-reqired">
                                CFT Review Not Required
                            </button> --}}
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button> --}}
                        @elseif($verification->stage == 4 && (in_array(5, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))
                        {{-- @if(!$cftCompleteUser) --}}
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                            Return to QC Verification
                          </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal02">
                            Return to Analysis in Progress
                        </button>
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                            More Info Required
                            </button> --}}
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    AQA Verification Complete
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    Approved
                                </button>
                            {{-- @endif --}}
                        {{-- @elseif($verification->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#sendToInitiator">
                                Send to Initiator
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#hodsend">
                                Send to HOD
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qasend">
                                Send to QA Initial Review
                            </button>
                             <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QA Final Review Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button> --}}
                        {{-- @elseif($verification->stage == 6 && (in_array(9, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info Required
                                </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Approved
                            </button> --}}
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>


                    </div>

                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($verification->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars">
                            @if ($verification->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($verification->stage >= 2)
                                <div class="active">Analysis in Progress </div>
                            @else
                                <div class="">Analysis in Progress</div>
                            @endif

                            @if ($verification->stage >= 3)
                                <div class="active">Under QC Verification</div>
                            @else
                                <div class="">Under QC Verification</div>
                            @endif

                            @if ($verification->stage >= 4)
                                <div class="active">Under AQA Verification</div>
                            @else
                                <div class="">Under AQA Verification</div>
                            @endif


                            {{-- @if ($verification->stage >= 5)
                                <div class="active">QA Final Review</div>
                            @else
                                <div class="">QA Final Review</div>
                            @endif
                            @if ($verification->stage >= 6)
                                <div class="active">QA Head/Manager Designee</div>
                            @else
                                <div class="">Approval</div>
                            @endif --}}
                            @if ($verification->stage >= 5)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif
                    @endif


                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>

    <div style="background: #e0903230;" id="change-control-fields">
        <div class="container-fluid">


            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Analysis In Progress</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Under QC Verification</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Under AQA Verification</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Activity Log</button>
            </div>

            <!-- Parent Record Information -->
            <form action="{{ route('verification_update',$verification->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="step-form">
            <div id="CCForm1" class="inner-block cctabcontent">
                <div class="inner-block-content">

                    <div class="sub-head">Parent Record Information</div>
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> (Parent) OOS No. </label>
                                <input type="number" name="parent_oos_no" value="{{$verification->parent_oos_no}}">
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator Group"> (Parent) OOT No.</label>
                                <input type="number" name="parent_oot_no" value ="{{$verification->parent_oot_no}}">
                            </div>
                        </div>





                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="parent_date_opened">(Parent) Date Opened</label>
                                <div class="calenderauditee">
                                    <input type="text" id="parent_date_opened" readonly placeholder="DD-MMM-YYYY"  value="{{$verification->parent_date_opened}}"/>
                                    <input type="date" id="end_date_checkdate_1" name="parent_date_opened"
                                        min="yyyy-mm-dd"  class="hide-input" oninput="handleDateInput(this, 'parent_date_opened');checkDate('start_date_checkdate_1','end_date_checkdate_1')" />
                                                      </div>
                                                    </div>
                                                </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Short Description">(Parent) Short Description</label>
                                <textarea name="parent_short_description">{{$verification->parent_short_description}}</textarea>
                            </div>
                        </div>



                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="parent_target_closure_date">(Parent) Target Closure Date</label>
                                <div class="calenderauditee">
                                    <input type="text" id="end_date_2" readonly placeholder="DD-MMM-YYYY" value="{{$verification->parent_target_closure_date}}" />
                                    <input type="date" id="end_date_checkdate_2" name="parent_target_closure_date"
                                        min="yyyy-mm-dd"
                                        class="hide-input"
                                        data-display-id="end_date_2" data-start-id="start_date_checkdate_2"
                                        oninput="handleDateInput(this, 'end_date_2'); checkDate('start_date_checkdate_2', 'end_date_checkdate_2')" />
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Scheduled end date">(Parent) Target Closure Date</label>
                                <div class="calenderauditee">
                                    <input type="text" id="end_date_target" value="{{$verification->parent_target_closure_date}}" />
                                    <input type="date" id="end_date_checkdate_target"
                                        name="parent_target_closure_date" value="{{$verification->parent_target_closure_date}}"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                        oninput="handleDateInput(this, 'end_date_target');checkDate('start_date_checkdate','end_date_checkdate_target')" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="parent_product_material">(Parent) Product/Material Name</label>
                                <input type="text" id="text" name="parent_product_material_name"  value="{{$verification->parent_product_material_name}}">

                            </div>
                        </div>

    <!-- ---------------------------grid-1 -------------------------------- -->

                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                (Parent) Info. On Product/ Material
                                <button type="button" name="parent_info_no_product_material" id="Product_Material">+</button>
                                <span class="text-primary" data-bs-toggle="modal"
                                    data-bs-target="#document-details-field-instruction-modal"
                                    style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="Product_Material_details" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 4%">Row#</th>
                                            <th style="width: 10%">Item/Product Code</th>
                                            <th style="width: 8%"> A.R.Number</th>
                                            <th style="width: 8%"> Mfg.Date</th>
                                            <th style="width: 8%">Expiry Date</th>
                                            <th style="width: 8%"> Label Claim.</th>
                                             <th style="width: 5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($gridDatas01->data as $datas)
                                    <tr>
                                        <td><input disabled type="text" name="parent_info_no_product_material[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}"></td>
                                        <td><input type="text" name="parent_info_no_product_material[{{$loop->index}}][product_code]" value="{{ isset($datas['product_code']) ? $datas['product_code'] : '' }}"></td>
                                        <td><input type="text" name="parent_info_no_product_material[{{$loop->index}}][ar_number]" value="{{ isset($datas['ar_number']) ? $datas['ar_number'] : '' }}"></td>
                                        <td><input type="date" name="parent_info_no_product_material[{{$loop->index}}][mfg_date]" value="{{ isset($datas['mfg_date']) ? $datas['mfg_date'] : '' }}"></td>
                                        <td><input type="date" name="parent_info_no_product_material[{{$loop->index}}][expiry_date]" value="{{ isset($datas['expiry_date']) ? $datas['expiry_date'] : '' }}"></td>
                                        <td><input type="text" name="parent_info_no_product_material[{{$loop->index}}][name]" value="{{ isset($datas['name']) ? $datas['name'] : '' }}"></td>
                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                        </div>

    <!-- ---------------------------grid-2 -------------------------------- -->

                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                (Parent) Info. On Product/ Material
                                <button type="button" name="parent_info_no_product_material1" id="Product_Material1">+</button>
                                <span class="text-primary" data-bs-toggle="modal"
                                    data-bs-target="#document-details-field-instruction-modal"
                                    style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="Product_Material1_details" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 4%">Row#</th>
                                            <th style="width: 10%">Item/Product Code</th>
                                            <th style="width: 8%"> Batch No*.</th>
                                            <th style="width: 8%"> A.R.Number</th>
                                            <th style="width: 8%"> Mfg.Date</th>
                                            <th style="width: 8%">Expiry Date</th>
                                            <th style="width: 8%"> Label Claim.</th>
                                            <th style="width: 8%">Pack Size</th>
                                            <th style="width: 5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($gridDatas02->data as $datas)
                                        <tr>
                                        <td><input disabled type="text" name="parent_info_no_product_material1[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}"></td>
                                        <td><input type="text" name="parent_info_no_product_material1[{{$loop->index}}][product_code]" value="{{ isset($datas['product_code']) ? $datas['product_code'] : '' }}"></td>
                                        <td><input type="text" name="parent_info_no_product_material1[{{$loop->index}}][batch_no]" value="{{ isset($datas['batch_no']) ? $datas['batch_no'] : '' }}"></td>
                                        <td><input type="text" name="parent_info_no_product_material1[{{$loop->index}}][ar_number]" value="{{ isset($datas['ar_number']) ? $datas['ar_number'] : '' }}"></td>
                                        <td><input type="date" name="parent_info_no_product_material1[{{$loop->index}}][mfg_date]" value="{{ isset($datas['mfg_date']) ? $datas['mfg_date'] : '' }}"></td>
                                        <td><input type="date" name="parent_info_no_product_material1[{{$loop->index}}][expiry_date]" value="{{ isset($datas['expiry_date']) ? $datas['expiry_date'] : '' }}"></td>
                                        <td><input type="text" name="parent_info_no_product_material1[{{$loop->index}}][label]" value="{{ isset($datas['label']) ? $datas['label'] : '' }}"></td>
                                        <td><input type="text" name="parent_info_no_product_material1[{{$loop->index}}][pack_size]" value="{{ isset($datas['pack_size']) ? $datas['pack_size'] : '' }}"></td>
                                        {{-- <td><input type="text" name="parent_info_no_product_material1[{{$loop->index}}][lot_batch_no]" value="{{ isset($datas['lot_batch_no']) ? $datas['lot_batch_no'] : '' }}"></td> --}}
                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                        </div>

    <!-- ---------------------------grid-3 ----------------------------------->

    <div class="group-input">
        <label for="audit-agenda-grid">
            (Parent) OOS Details
            <button type="button" name="parent_oos_details" id="OOS_Details">+</button>
            <span class="text-primary" data-bs-toggle="modal"
                data-bs-target="#document-details-field-instruction-modal"
                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                (Launch Instruction)
            </span>
        </label>
        <div class="table-responsive">
            <table class="table table-bordered" id="OOS_Details_details" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 4%">Row#</th>
                        <th style="width: 8%"> A.R.Number</th>
                        <th style="width: 8%"> Test Name Of OOS</th>
                        <th style="width: 8%">Result Obtained</th>
                        <th style="width: 8%">Specification Limit</th>
                        <th style="width: 5%">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($gridDatas03->data as $datas)
                    <tr>
                    <td><input disabled type="text" name="parent_oos_details[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}"></td>
                    <td><input type="text" name="parent_oos_details[{{$loop->index}}][ar_number]"  value="{{$datas['ar_number']}}" ></td>
                    <td><input type="text" name="parent_oos_details[{{$loop->index}}][test_name_of_oos]"  value="{{$datas['test_name_of_oos']}}" ></td>
                    <td><input type="text" name="parent_oos_details[{{$loop->index}}][result_obtained]"  value="{{$datas['result_obtained']}}" ></td>
                    <td><input type="text" name="parent_oos_details[{{$loop->index}}][specification_limit]"  value="{{$datas['specification_limit']}}" ></td>
                    <td><button type="button" class="removeRowBtn">Remove</button></td>
                    </tr>
                @endforeach
            </tbody>

            </table>
        </div>
    </div>
    <!-- ---------------------------grid-4 -------------------------------- -->

                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                (Parent) OOT Results
                                <button type="button" name="OOT_Results" id="OOT_Results4">+</button>
                                <span class="text-primary" data-bs-toggle="modal"
                                    data-bs-target="#document-details-field-instruction-modal"
                                    style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="OOT_Results4_Details" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 4%">Row#</th>
                                            <th style="width: 8%"> A.R.Number</th>
                                            <th style="width: 8%"> Test Name Of OOT</th>
                                            <th style="width: 8%">Result Obtained</th>
                                            <th style="width: 8%">Initial Interval Details</th>
                                            <th style="width: 8%">Previous Interval Details</th>
                                            <th style="width: 8%">%Difference Of Results</th>
                                            <th style="width: 8%">Trend Limit</th>
                                            <th style="width: 5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($gridDatas04->data as $datas)
                                        <tr>
                                        <td><input disabled type="text" name="serial[]" value="{{$loop->index+1}}"></td>
                                        <td><input type="text" name="OOT_Results[{{$loop->index}}][AR_Number]" value="{{$datas['AR_Number']}}" ></td>
                                        <td><input type="text" name="OOT_Results[{{$loop->index}}][Test_Name_Of_OOT]" value="{{$datas['Test_Name_Of_OOT']}}" ></td>
                                        <td><input type="text" name="OOT_Results[{{$loop->index}}][Result_Obtained]" value="{{$datas['Result_Obtained']}}" ></td>
                                        <td><input type="text" name="OOT_Results[{{$loop->index}}][Initial_Interval_Details]" value="{{$datas['Initial_Interval_Details']}}" ></td>
                                        <td><input type="text" name="OOT_Results[{{$loop->index}}][Previous_Interval_Details]" value="{{$datas['Previous_Interval_Details']}}" ></td>
                                        <td><input type="text" name="OOT_Results[{{$loop->index}}][Difference_Of_Results]" value="{{$datas['Difference_Of_Results']}}" ></td>
                                        <td><input type="text" name="OOT_Results[{{$loop->index}}][Trend_Limit]" value="{{$datas['Trend_Limit']}}" ></td>
                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                </table>
                            </div>
                        </div>

    <!-- ---------------------------grid-5 -------------------------------- -->

                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                (Parent)Details of Stability Study
                                <button type="button" name="parent_details_of_stability_study" id="Details_Stability">+</button>
                                <span class="text-primary" data-bs-toggle="modal"
                                    data-bs-target="#document-details-field-instruction-modal"
                                    style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="Details_Stability_details" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 4%">Row#</th>
                                            <th style="width: 8%">AR Number</th>
                                            <th style="width: 12%">Condition: Temperature & RH</th>
                                            <th style="width: 12%">Interval</th>
                                            <th style="width: 16%">Orientation</th>
                                            <th style="width: 16%">Pack Details (if any)</th>
                                            <th style="width: 5%">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($gridDatas05->data as $datas)
                                        <tr>
                                        <td><input disabled type="text" name="serial[]" value="{{$loop->index+1}}"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[{{$loop->index}}][ar_number]" value="{{$datas['ar_number']}}" ></td>
                                        <td><input type="text" name="parent_details_of_stability_study[{{$loop->index}}][temperature_rh]" value="{{$datas['temperature_rh']}}"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[{{$loop->index}}][interval]" value="{{$datas['interval']}}" ></td>
                                        <td><input type="text" name="parent_details_of_stability_study[{{$loop->index}}][orientation]" value="{{$datas['orientation']}}"  ></td>
                                        <td><input type="text" name="parent_details_of_stability_study[{{$loop->index}}][pack_details]" value="{{$datas['pack_details']}}"  ></td>
                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                        </tr>
                                        @endforeach
                                     </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- General Information -->

                    <div class="sub-head">General Information</div>
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="RLS Record Number"><b>Record Number</b></label>
                                <input disabled type="text" name="record_number"  value="{{ Helpers::getDivisionName($verification->division_id) }}/DEV/{{ Helpers::year($verification->created_at) }}/{{ $verification->record }}" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Division Code"><b>Site/Division Code</b></label>
                                <input readonly type="text" name="division_code"   value="{{ $divisionName }}" />
                            <input type="hidden" name="division_id"
                            value="{{ session()->get('division') }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator"> Initiator </label>
                            <input type="text" disabled name="initiator" value="{{ Auth::user()->name }}" >
                        </div>
                    </div>


                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Scheduled end date">Date Opened</label>
                                <div class="calenderauditee">
                                    <input type="text" id="date_opened1" readonly placeholder="DD-MMM-YYYY"  value="{{ date('d-M-Y') }}" />
                                    <input type="date" id="date_opened1_checkdate"
                                        name="date_opened_gi" value="{{$verification->date_opened_gi}}"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                        oninput="handleDateInput(this, 'date_opened1');checkDate('start_date_checkdate','date_opened1_checkdate')" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Scheduled end date">Target Closure Date</label>
                                <div class="calenderauditee">
                                    <input type="text" id="closure_date" readonly placeholder="DD-MMM-YYYY" value="{{$verification->target_closure_date_gi}}"/>
                                    <input type="date" id="closure_date_checkdate"
                                        name="target_closure_date_gi" value="{{$verification->target_closure_date_gi}}"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                        oninput="handleDateInput(this, 'closure_date');checkDate('start_date_checkdate','closure_date_checkdate')" />
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Initiator Group Code"> Short description <span
                                    class="text-danger">*</span></label>
                                <input id="docname" type="text" name="short_description" maxlength="255" value="{{$verification->short_description}}" required>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> Assignee </label>
                                <input type="text" id="text" name="assignee" value="{{$verification->assignee}}" >
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> Supervisor</label>
                                <input type="text" id="text" name="supervisor" value="{{$verification->supervisor}}" >
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> AQA Reviewer</label>
                                <input type="text" id="text" name="aqa_reviewer" value="{{$verification->aqa_reviewer}}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                        </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Reference Recores">Recommended Actions </label>
                                <select multiple id="reference_record" name="recommended_actions" value = "{{$verification->recommended_actions}}">
                                    <option  @if ($verification->recommended_actions == 'recalculation_of_results') selected @endif value="recalculation_of_results">Re-Calculation Of Results By Omiting The Error</option>
                                    <option @if ($verification->recommended_actions == 're_injection') selected @endif value="re_injection">Re-Injection Of Original Vials of Sample</option>
                                    <option @if ($verification->recommended_actions == 'injection') selected @endif value="injection">Injection Of Re-Filled Sample Solution</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Initiator Group Code">Specify If Any Other Action</label>
                                <textarea type="text" name="specify_if_any_action">{{$verification->specify_if_any_action}}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Initiator Group Code">Justification For Actions</label>
                                <textarea type="text" name="justification_for_actions" >{{$verification->specify_if_any_action}}</textarea>
                            </div>
                        </div>

                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                    Exit </a>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>


            <!-- Analysis in Progress -->
            <div id="CCForm2" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="sub-head">Analysis in Progress</div>
                    <div class="row">

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Initiator Group Code">Results Of Recommended Actions</label>
                                <textarea type="text" name="results_of_recommended_actions" >{{$verification->results_of_recommended_actions}}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Scheduled end date">Date Of Completion</label>
                                <div class="calenderauditee">
                                    <input type="text" id="completion_date" readonly placeholder="DD-MMM-YYYY" value="{{$verification->date_of_completion}}" />
                                    <input type="date" id="completion_date_checkdate"
                                        name="date_of_completion" value="{{$verification->date_of_completion}}"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                        oninput="handleDateInput(this, 'completion_date');checkDate('start_date_checkdate','completion_date_checkdate')" />
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Execution Attachments">Execution Attachment</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="execution_attachment"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="Execution_Attachment" name="execution_attachment" value="{{$verification->execution_attachment}}"
                                            oninput="addMultipleFiles(this, 'execution_attachment')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div> --}}



                        <div class="col-12">
                            <div class="group-input">
                                <label for="QA Initial Attachments"> Execution Attachment</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                <div class="file-attachment-field">
                                    <div disabled class="file-attachment-list" id="execution_attachment">
                                        @if ($verification->execution_attachment)
                                        @foreach(json_decode($verification->execution_attachment) as $file)
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
                                        <input {{ $verification->stage == 0 || $verification->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="execution_attachment[]"
                                            oninput="addMultipleFiles(this, 'execution_attachment')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="col-12">
                            <div class="group-input">
                                <small class="text-primary">
                                    Justification for delay in completion of activity and closing of verification.
                                </small>
                                <label for="Initiator Group Code">Delay Justification</label>
                                <textarea type="text" name="delay_justification">{{$verification->delay_justification}}</textarea>
                            </div>
                        </div>

                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                    Exit </a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- QC Verification -->
            <div id="CCForm3" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="sub-head">QC Verification</div>
                    <div class="row">

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Initiator Group Code">Supervisor Observations</label>
                                <textarea type="text" name="supervisor_observation" >{{$verification->supervisor_observation}}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Verification Attachments">Verification Attachment</label>
                                {{-- <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div> --}}
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="verification_attachment">
                                        @if ($verification->verification_attachment)
                                        @foreach(json_decode($verification->verification_attachment) as $file)
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
                                        <input type="file" id="Veification_Attachment" name="verification_attachment[]" value="{{$verification->verification_attachment}}"
                                            oninput="addMultipleFiles(this, 'verification_attachment')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                    Exit </a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Under AQA Verification--->
            <div id="CCForm4" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="sub-head">AQA Verification</div>
                    <div class="row">

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Initiator Group Code">AQA Comments</label>
                                <textarea type="text" name="aqa_comments2" >{{$verification->aqa_comments2}}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="AQA Attachments">AQA Attachment</label>
                                {{-- <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div> --}}
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="aqa_attachment">
                                        @if ($verification->aqa_attachment)
                                        @foreach(json_decode($verification->aqa_attachment) as $file)
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
                                        <input type="file" id="AQA_Attachment" name="aqa_attachment[]" value="{{$verification->aqa_attachment}}"
                                            oninput="addMultipleFiles(this, 'aqa_attachment')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                    Exit </a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Log--->
            <div id="CCForm5" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="sub-head">Analysis</div>
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Submitted By">Completed By :- </label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Submitted On">Completed On :- </label>
                                <div class="static"></div>
                            </div>
                        </div>

                    </div>
                    <div class="sub-head">QC Verification</div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Submitted By">QC Verification Done By :- </label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Submitted On">QC Verification Done On :- </label>
                                <div class="static"></div>
                            </div>
                        </div>
                </div>

                    <div class="sub-head">AQA Verification</div>
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Submitted By">Review Completed By :- </label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Submitted On">Review Completed On :- </label>
                                <div class="static"></div>
                            </div>
                        </div>
                </div>
                    <div class="sub-head">Cancellation</div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Submitted By">Cancel By :- </label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Submitted On">Cancel On :- </label>
                                <div class="static"></div>
                            </div>
                        </div>
                </div>

                <div class="button-block">
                    <button type="submit" class="saveButton">Save</button>
                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                    <button type="submit">Submit</button>
                    <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                            Exit </a>
                    </button>
                </div>
                </div>
            </div>
        </form>
    </div>
    </div>


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


<div class="modal fade" id="child-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <form action="{{ route('deviation_child_1', $verification->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        @if ($verification->stage == 3)
                            <label for="major">
                                <input type="radio" name="child_type" id="major"
                                    value="rca">
                                    RCA
                            </label>
                            <br>
                            <label for="major">
                                <input type="radio" name="child_type" id="major"
                                    value="extension">
                                    Extension
                            </label>
                        @endif

                        @if ($verification->stage == 5)
                            <label for="major">
                                <input type="radio" name="child_type" id="major"
                                    value="capa">
                                    CAPA
                            </label>
                            <br>
                            <label for="major">
                                <input type="radio" name="child_type" id="major"
                                    value="extension">
                                    Extension
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
{{-- <div class="modal fade" id="child-modal1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <form  method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        <label for="major">
                            <input type="radio" name="rsa" id="major"
                                value="rsa">
                                RSA
                        </label>
                        <br>
                        <label for="major1">
                            <input type="radio" name="extension" id="major1"
                                value="extension">
                                Extension
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
</div> --}}

<div class="modal fade" id="more-info-required-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('Vrequestmoreinfo_back_stage', $verification->id) }}" method="POST">
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

            <form action="{{ url('Vcancel_stage', $verification->id) }}" method="POST">
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


<div class="modal fade" id="deviationIsCFTRequired">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ url('deviationIsCFTRequired', $verification->id) }}" method="POST">
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
<div class="modal fade" id="sendToInitiator">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('check', $verification->id) }}" method="POST">
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
<div class="modal fade" id="hodsend">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('check2', $verification->id) }}" method="POST">
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
<div class="modal fade" id="qasend">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('check3', $verification->id) }}" method="POST">
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


<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('Vsend_stage', $verification->id) }}" method="POST">
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

{{-- sending back to stage 2 --}}


<div class="modal fade" id="signature-modal02">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('Vsend_stage2', $verification->id) }}" method="POST">
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
                        <input class="input_width" type="text" name="username" required>

                    </div>
                    <div class="group-input">
                        <label for="password">Password</label>
                        <input class="input_width" type="password" name="password" required>
                    </div>
                    <div class="group-input">
                        <label for="comment">Comment</label>
                        <input class="input_width" type="comment" name="comment">
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








    <script>
        VirtualSelect.init({
            ele: '#facility_name, #group_name, #auditee, #audit_team'
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
        }
    </script>
@endsection
