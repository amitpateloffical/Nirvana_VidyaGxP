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
            var index = 0;
            $('#Product_Material').click(function(e) {
                function generateTableRow(serialNumber,index) {


                    var html =
                      '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material[' + index + '][product_code]"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material[' + index + '][ar_number]"></td>' +
                        '<td>' +
                        '<div class="group-input new-date-data-field mb-0">' +
                        '<div class="input-date ">' +
                        '<div class="calenderauditee">' +
                        '<input type="text" id="agenda_date0' + (index * 2) + '" readonly placeholder="DD-MMM-YYYY" />' +
                        '<input type="date" name="parent_info_no_product_material[' + index + '][mfg_date]" ' +
                        'min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" class="hide-input" ' +
                        'oninput="handleDateInput(this,\'agenda_date0' + (index * 2) + '\');" />' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td>' +
                        '<div class="group-input new-date-data-field mb-0">' +
                        '<div class="input-date ">' +
                        '<div class="calenderauditee">' +
                        '<input type="text" id="agenda_date1' + (index * 2 + 1) + '" readonly placeholder="DD-MMM-YYYY" />' +
                        '<input type="date" name="parent_info_no_product_material[' + index + '][expiry_date]" ' +
                        'min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" class="hide-input" ' +
                        'oninput="handleDateInput(this, \'agenda_date1' + (index * 2 + 1) + '\');" />' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td><input type="text" name="parent_info_no_product_material[' + index + '][name]"></td>' +
                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' +

                    '</tr>';

                    return html;
                }

                var tableBody = $('#Product_Material_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1, index);
                tableBody.append(newRow);
                index++; // Increment the index for the next row
            });
        });
    </script>

    <!-- -----------------------------grid-2----------------------------script -->
    {{-- <script>
        $(document).ready(function() {
            $('#Product_Material1').click(function(e) {
                function generateTableRow(serialNumber,index) {


                    var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="parent_info_no_product_material1[' + index + '][product_code]"></td>' +
                    '<td><input type="text" name="parent_info_no_product_material1[' + index + '][batch_no]"></td>' +
                    '<td><input type="text" name="parent_info_no_product_material1[' + index + '][ar_number]"></td>' +
                    '<td>' +
                    '<div class="group-input new-date-data-field mb-0">' +
                    '<div class="input-date ">' +
                    '<div class="calenderauditee">' +
                    '<input type="text" id="agenda_date2' + (index * 2) + '" readonly placeholder="DD-MMM-YYYY" />' +
                    '<input type="date" name="parent_info_no_product_material1[' + index + '][mfg_date]" ' +
                    'min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" class="hide-input" ' +
                    'oninput="handleDateInput(this, \'agenda_date2' + (index * 2) + '\');" />' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td>' +
                    '<div class="group-input new-date-data-field mb-0">' +
                    '<div class="input-date ">' +
                    '<div class="calenderauditee">' +
                    '<input type="text" id="agenda_date3' + (index * 2 + 1) + '" readonly placeholder="DD-MMM-YYYY" />' +
                    '<input type="date" name="parent_info_no_product_material1[' + index + '][expiry_date]" ' +
                    'min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" class="hide-input" ' +
                    'oninput="handleDateInput(this, \'agenda_date3' + (index * 2 + 1) + '\');" />' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td><input type="text" name="parent_info_no_product_material1[' + index + '][name]"></td>' +
                    '<td><input type="text" name="parent_info_no_product_material1[' + index + '][pack_size]"></td>' +
                    '<td><input type="text" name="parent_info_no_product_material1[' + index + '][lot_batch_no]"></td>' +
                    '</tr>';

                // Increment the index for the next row

                    return html;
                }

                var tableBody = $('#Product_Material1_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1, index);
                tableBody.append(newRow);
                index++;
            });
        });
    </script>    --}}
<script>
    $(document).ready(function() {
        var index = 0; // Initialize index outside the click event handler

        $('#Product_Material1').click(function(e) {
            function generateTableRow(serialNumber, index) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="parent_info_no_product_material1[' + index + '][product_code]"></td>' +
                    '<td><input type="text" name="parent_info_no_product_material1[' + index + '][batch_no]"></td>' +
                    '<td><input type="text" name="parent_info_no_product_material1[' + index + '][ar_number]"></td>' +
                    '<td>' +
                    '<div class="group-input new-date-data-field mb-0">' +
                    '<div class="input-date ">' +
                    '<div class="calenderauditee">' +
                    '<input type="text" id="agenda_date2' + (index * 2) + '" readonly placeholder="DD-MMM-YYYY" />' +
                    '<input type="date" name="parent_info_no_product_material1[' + index + '][mfg_date]" ' +
                    'min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" class="hide-input" ' +
                    'oninput="handleDateInput(this, \'agenda_date2' + (index * 2) + '\');" />' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td>' +
                    '<div class="group-input new-date-data-field mb-0">' +
                    '<div class="input-date ">' +
                    '<div class="calenderauditee">' +
                    '<input type="text" id="agenda_date3' + (index * 2 + 1) + '" readonly placeholder="DD-MMM-YYYY" />' +
                    '<input type="date" name="parent_info_no_product_material1[' + index + '][expiry_date]" ' +
                    'min="{{ \Carbon\Carbon::now()->format("Y-m-d") }}" class="hide-input" ' +
                    'oninput="handleDateInput(this, \'agenda_date3' + (index * 2 + 1) + '\');" />' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td><input type="text" name="parent_info_no_product_material1[' + index + '][name]"></td>' +
                    '<td><input type="text" name="parent_info_no_product_material1[' + index + '][pack_size]"></td>' +
                    '<td><input type="text" name="parent_info_no_product_material1[' + index + '][lot_batch_no]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#Product_Material1_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1, index);
            tableBody.append(newRow);
            index++; // Increment the index for the next row
        });
    });
</script>

    <!-- ------------------------------grid-3-------------------------script -->
    <script>
        $(document).ready(function() {
            $('#OOS_Details').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="parent_oos_details[0][ar_number]"></td>' +
                        '<td><input type="text" name="parent_oos_details[0][test_name_of_oos]"></td>' +
                        '<td><input type="text" name="parent_oos_details[0][result_obtained]"></td>' +
                        '<td><input type="text" name="parent_oos_details[0][specification_limit]"></td>' +

                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' +

                    '</tr>';

                    return html;
                }

                var tableBody = $('#OOS_Details_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <!-- ---------------------------grid-4 -------------------------------- -->

    <script>
        $(document).ready(function() {
            $('#OOT_Results').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="OOT_Results[0][AR_Number]"></td>' +
                        '<td><input type="text" name="OOT_Results[0][Test_Name_Of_OOT]"></td>' +
                        '<td><input type="text" name="OOT_Results[0][Result_Obtained]"></td>' +
                        '<td><input type="text" name="OOT_Results[0][Initial_Interval_Details]"></td>' +
                        '<td><input type="text" name="OOT_Results[0][Previous_Interval_Details]"></td>' +
                        '<td><input type="text" name="OOT_Results[0][Difference_Of_Results]"></td>' +
                        '<td><input type="text" name="OOT_Results[0][Trend_Limit]"></td>' +

                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' +

                    '</tr>';

                    return html;
                }

                var tableBody = $('#OOT_Results_Details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>


<!-- --------------------------------grid-5--------------------------script -->

<script>
    $(document).ready(function() {
        $('#Details_Stability').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                    '"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[0][ar_number]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[0][temperature_rh]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[0][interval]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[0][orientation]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[0][pack_details]"></td>' +

                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                '</tr>';

                return html;
            }

            var tableBody = $('#Details_Stability_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
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
    <div id="change-control-fields">
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
            <form action="{{ route('verification_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="step-form">
            <div id="CCForm1" class="inner-block cctabcontent">
                <div class="inner-block-content">

                    <div class="sub-head">Parent Record Information</div>
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> (Parent) OOS No. </label>
                                <input type="number" name="parent_oos_no">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator Group"> (Parent) OOT No.</label>
                                <input type="number" name="parent_oot_no">
                            </div>
                        </div>

                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Scheduled end date">(Parent)Date Opened</label>
                                <div class="calenderauditee">
                                    <input type="text" id="date_opened" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" id="date_opened_checkdate"
                                        name="parent_date_opened"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                        oninput="handleDateInput(this, 'date_opened');checkDate('start_date_checkdate','date_opened_checkdate')" />
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Short Description">(Parent) Short Description</label>
                                <textarea name="parent_short_description"></textarea>

                            </div>
                        </div>

                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Scheduled end date">(Parent) Target Closure Date</label>
                                <div class="calenderauditee">
                                    <input type="text" id="end_date_target" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" id="end_date_checkdate_target"
                                        name="parent_target_closure_date"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                        oninput="handleDateInput(this, 'end_date_target');checkDate('start_date_checkdate','end_date_checkdate_target')" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="parent_product_material">(Parent) Product/Material Name</label>
                                <input type="text" id="text" name="parent_product_material_name">

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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>
                                        <td><input type="text" name="parent_info_no_product_material[0][product_code]"></td>
                                        <td><input type="text" name="parent_info_no_product_material[0][ar_number]"></td>
                                        <td>
                                            <div class="group-input new-date-data-field mb-0">
                                                <div class="input-date ">
                                                    <div class="calenderauditee">
                                                        <input type="text" id="agenda_date0" readonly placeholder="DD-MMM-YYYY" />
                                                        <input type="date" name="parent_info_no_product_material[0][mfg_date]"
                                                               min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                               oninput="handleDateInput(this, 'agenda_date0');" />
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="group-input new-date-data-field mb-0">
                                                <div class="input-date ">
                                                    <div class="calenderauditee">
                                                        <input type="text" id="agenda_date1" readonly placeholder="DD-MMM-YYYY" />
                                                        <input type="date" name="parent_info_no_product_material[0][expiry_date]"
                                                               min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                               oninput="handleDateInput(this, 'agenda_date1');" />
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- <td><input type="date" name="parent_info_no_product_material[0][expiry_date]"></td> --}}
                                        <td><input type="text" name="parent_info_no_product_material[0][name]"></td>
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
                                            <th style="width: 8%">Lot/Batch Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>
                                        <td><input type="text" name="parent_info_no_product_material1[0][product_code]"></td>
                                        <td><input type="text" name="parent_info_no_product_material1[0][batch_no]"></td>
                                        <td><input type="text" name="parent_info_no_product_material1[0][ar_number]"></td>

                                        <td>
                                            <div class="group-input new-date-data-field mb-0">
                                                <div class="input-date ">
                                                    <div class="calenderauditee">
                                                        <input type="text" id="agenda_date2" readonly placeholder="DD-MMM-YYYY" />
                                                        <input type="date" name="parent_info_no_product_material1[0][mfg_date]"
                                                               min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                               oninput="handleDateInput(this, 'agenda_date2');" />
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="group-input new-date-data-field mb-0">
                                                <div class="input-date ">
                                                    <div class="calenderauditee">
                                                        <input type="text" id="agenda_date3" readonly placeholder="DD-MMM-YYYY" />
                                                        <input type="date" name="parent_info_no_product_material1[0][expiry_date]"
                                                               min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                               oninput="handleDateInput(this, 'agenda_date3');" />
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- <td><input type="date" name="parent_info_no_product_material1[0][mfg_date]"></td>
                                        <td><input type="date" name="parent_info_no_product_material1[0][expiry_date]"></td> --}}
                                        <td><input type="text" name="parent_info_no_product_material1[0][label]"></td>
                                        <td><input type="text" name="parent_info_no_product_material1[0][pack_size]"></td>
                                        <td><input type="text" name="parent_info_no_product_material1[0][lot_batch_no]"></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

    <!-- ---------------------------grid-3 -------------------------------- -->

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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>
                                        <td><input type="text" name="parent_oos_details[0][ar_number]"></td>
                                        <td><input type="text" name="parent_oos_details[0][test_name_of_oos]"></td>
                                        <td><input type="text" name="parent_oos_details[0][result_obtained]"></td>
                                        <td><input type="text" name="parent_oos_details[0][specification_limit]"></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

    <!-- ---------------------------grid-4 -------------------------------- -->

                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                (Parent) OOT Results
                                <button type="button" name="OOT_Results" id="OOT_Results">+</button>
                                <span class="text-primary" data-bs-toggle="modal"
                                    data-bs-target="#document-details-field-instruction-modal"
                                    style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="OOT_Results_Details" style="width: 100%;">
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>
                                        <td><input type="text" name="OOT_Results[0][AR_Number]"></td>
                                        <td><input type="text" name="OOT_Results[0][Test_Name_Of_OOT]"></td>
                                        <td><input type="text" name="OOT_Results[0][Result_Obtained]"></td>
                                        <td><input type="text" name="OOT_Results[0][Initial_Interval_Details]"></td>
                                        <td><input type="text" name="OOT_Results[0][Previous_Interval_Details]"></td>
                                        <td><input type="text" name="OOT_Results[0][Difference_Of_Results]"></td>
                                        <td><input type="text" name="OOT_Results[0][Trend_Limit]"></td>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][ar_number]"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][temperature_rh]"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][interval]"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][orientation]"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][pack_details]"></td>
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
                                <input disabled type="text" name="record">
                                    {{-- value="{{ Helpers::getDivisionName(session()->get('division')) }}/MR/{{ date('Y') }}/{{ $record_number }}" --}}
                                 {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Division Code"><b>Site/Location Code</b></label>
                                <input readonly type="text" name="division_code"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
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
                                    {{-- <input type="text" id="date_opened1" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" id="date_opened1_checkdate"
                                        name="intiation_date"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                        oninput="handleDateInput(this, 'date_opened1');checkDate('start_date_checkdate','date_opened1_checkdate')" /> --}}
                                        <input readonly type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Date Due"><b>Date Openedii</b></label>
                                <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date" >
                                <div class="static">{{ date('d-M-Y') }}</div>
                            </div>
                        </div> --}}
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Scheduled end date">Target Closure Date</label>
                                <div class="calenderauditee">
                                    <input type="text" id="closure_date" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" id="closure_date_checkdate"
                                        name="target_closure_date_gi"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                        oninput="handleDateInput(this, 'closure_date');checkDate('start_date_checkdate','closure_date_checkdate')" />
                                    </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Initiator Group Code"> Short description <span
                                    class="text-danger">*</span></label>
                                <textarea type="text" name="short_description" ></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> Assignee </label>
                                <input type="text" id="text" name="assignee" >
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> Supervisor</label>
                                <input type="text" id="text" name="supervisor" >
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> AQA Reviewer</label>
                                <input type="text" id="text" name="aqa_reviewer" >
                            </div>
                        </div>
                        <div class="col-lg-6">
                        </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Reference Recores">Recommended Actions </label>
                                <select multiple id="reference_record" name="recommended_actions" id="">
                                    <option value="recalculation_of_results">Re-Calculation Of Results By Omiting The Error</option>
                                    <option value="re_injection">Re-Injection Of Original Vials of Sample</option>
                                    <option value="injection">Injection Of Re-Filled Sample Solution</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Initiator Group Code">Specify If Any Other Action</label>
                                <textarea type="text" name="specify_if_any_action"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Initiator Group Code">Justification For Actions</label>
                                <textarea type="text" name="justification_for_actions" ></textarea>
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

        </form>
            <!-- Analysis in Progress -->
            <div id="CCForm2" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="sub-head">Analysis in Progress</div>
                    <div class="row">

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Initiator Group Code">Results Of Recommended Actions</label>
                                <textarea type="text" name="results_of_recommended_actions" ></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Scheduled end date">Date Of Completion</label>
                                <div class="calenderauditee">
                                    <input type="text" id="completion_date" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" id="completion_date_checkdate"
                                        name="date_of_completion"
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                        oninput="handleDateInput(this, 'completion_date');checkDate('start_date_checkdate','completion_date_checkdate')" />
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Execution Attachments">Execution Attachment</label>
                                {{-- <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div> --}}
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="execution_attachment"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="Execution_Attachment" name="execution_attachment[]"
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
                                <textarea type="text" name="delay_justification"></textarea>
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
                                <textarea type="text" name="supervisor_observation" ></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Verification Attachments">Verification Attachment</label>
                                {{-- <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div> --}}
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="verification_attachment"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="Veification_Attachment" name="verification_attachment[]"
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
                                <textarea type="text" name="aqa_comments2" ></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="AQA Attachments">AQA Attachment</label>
                                {{-- <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div> --}}
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="aqa_attachment"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="AQA_Attachment" name="aqa_attachment[]"
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
