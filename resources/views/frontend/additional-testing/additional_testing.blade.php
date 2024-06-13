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

    <!-- -----------------------------grid-1--------------------------------->
    <script>
        $(document).ready(function() {
            var index = 0;
            $('#Product_Material').click(function(e) {
                function generateTableRow(serialNumber, index) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material[' + index +
                        '][product_code]"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material[' + index +
                        '][ar_number]"></td>' +
                        '<td>' +
                        '<div class="group-input new-date-data-field mb-0">' +
                        '<div class="input-date ">' +
                        '<div class="calenderauditee">' +
                        '<input type="text" id="agenda_date0' + (index * 2) +
                        '" readonly placeholder="DD-MMM-YYYY" />' +
                        '<input type="date" name="parent_info_no_product_material[' + index +
                        '][mfg_date]" ' +
                        'min="yyyy-mm-dd"class="hide-input" ' +
                        'oninput="handleDateInput(this,\'agenda_date0' + (index * 2) + '\');" />' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td>' +
                        '<div class="group-input new-date-data-field mb-0">' +
                        '<div class="input-date ">' +
                        '<div class="calenderauditee">' +
                        '<input type="text" id="agenda_date1' + (index * 2 + 1) +
                        '" readonly placeholder="DD-MMM-YYYY" />' +
                        '<input type="date" name="parent_info_no_product_material[' + index +
                        '][exp_date]" ' +
                        'min="yyyy-mm-dd"class="hide-input" ' +
                        'oninput="handleDateInput(this, \'agenda_date1' + (index * 2 + 1) + '\');" />' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td><input type="text" name="parent_info_no_product_material[' + index +
                        '][name]"></td>' +
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


    <!-- ------------------------ ----grid-2--------------------------------->
    <script>
        $(document).ready(function() {
            var index = 0; // Initialize index outside the click event handler

            $('#Product_Material1').click(function(e) {
                function generateTableRow(serialNumber, index) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material1[' + index +
                        '][product_code]"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material1[' + index +
                        '][batch_no]"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material1[' + index +
                        '][ar_number]"></td>' +
                        '<td>' +
                        '<div class="group-input new-date-data-field mb-0">' +
                        '<div class="input-date ">' +
                        '<div class="calenderauditee">' +
                        '<input type="text" id="agenda_date2' + (index * 2) +
                        '" readonly placeholder="DD-MMM-YYYY" />' +
                        '<input type="date" name="parent_info_no_product_material1[' + index +
                        '][mfg_date]" ' +
                        'min="yyyy-mm-dd"class="hide-input" ' +
                        'oninput="handleDateInput(this, \'agenda_date2' + (index * 2) + '\');" />' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td>' +
                        '<div class="group-input new-date-data-field mb-0">' +
                        '<div class="input-date ">' +
                        '<div class="calenderauditee">' +
                        '<input type="text" id="agenda_date3' + (index * 2 + 1) +
                        '" readonly placeholder="DD-MMM-YYYY" />' +
                        '<input type="date" name="parent_info_no_product_material1[' + index +
                        '][exp_date]" ' +
                        'min="yyyy-mm-dd"class="hide-input" ' +
                        'oninput="handleDateInput(this, \'agenda_date3' + (index * 2 + 1) + '\');" />' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td><input type="text" name="parent_info_no_product_material1[' + index +
                        '][name]"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material1[' + index +
                        '][pack_size]"></td>' +
                        '<td><input type="text" name="parent_info_no_product_material1[' + index +
                        '][lot_batch_no]"></td>' +
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


    <!-- -----------------------------grid-3--------------------------------->
    <script>
        $(document).ready(function() {
            $('#Product_Material3').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        ' <td><input type="text" name="(root_parent_oos_detailsAR_Number[0][ar_number]"></td>' +
                        '  <td><input type="text" name="(root_parent_oos_detailsTest_Name_OOS[0][test_name_of_oos]"></td>' +
                        ' <td><input type="text" name="(root_parent_oos_detailsResults_Obtained[0][results_obtained]"></td>' +
                        '  <td><input type="text" name="(root_parent_oos_detailsSpecification_Limit[0][specification_limit]"></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#Product_Material3 tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <!-- -----------------------------grid-4--------------------------------->
    <script>
        $(document).ready(function() {
            $('#Product_Material4').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '  <td><input type="text" name="parent_oot_results[0][ar_number]"></td>' +
                        '  <td><input type="text" name="parent_oot_results[0][test_number_of_oot]"></td>' +
                        '  <td><input type="text" name="parent_oot_results[0][results_obtained]"></td>' +
                        '  <td><input type="text" name="parent_oot_results[0][prev_interval_details]"></td>' +
                        '  <td><input type="text" name="parent_oot_results[0][diff_of_results]"></td>' +
                        '  <td><input type="text" name="parent_oot_results[0][initial_interview_details]"></td>' +
                        '  <td><input type="text" name="parent_oot_results[0][trend_limit]"></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#Product_Material4 tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <!--------------------------------grid-5--------------------------------->
    <script>
        $(document).ready(function() {
            $('#Product_Material5').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="parent_details_of_stability_study[0][ar_number]"></td>' +
                        '<td><input type="text" name="parent_details_of_stability_study[0][condition_temp_and_rh]"></td>' +
                        '<td><input type="text" name="parent_details_of_stability_study[0][interval]"></td>' +
                        '<td><input type="text" name="parent_details_of_stability_study[0][orientation]"></td>' +
                        '<td><input type="text" name="parent_details_of_stability_study[0][pack_details_if_any]"></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#Product_Material5 tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <!--------------------------------Date--------------------------------->

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Function to handle the date input and update the text field
            function handleDateInput(dateInput, displayInputId) {
                const displayInput = document.getElementById(displayInputId);
                const selectedDate = new Date(dateInput.value);
                const options = {
                    year: 'numeric',
                    month: 'short',
                    day: '2-digit'
                };

                if (!isNaN(selectedDate.getTime())) {
                    displayInput.value = selectedDate.toLocaleDateString('en-GB', options).replace(/ /g, '-');
                } else {
                    displayInput.value = '';
                }
            }

            // Function to validate date ranges
            function checkDate(startDateId, endDateId) {
                const startDateInput = document.getElementById(startDateId);
                const endDateInput = document.getElementById(endDateId);

                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (!isNaN(startDate.getTime()) && !isNaN(endDate.getTime()) && endDate < startDate) {
                    alert("End date cannot be earlier than start date");
                    endDateInput.value = '';
                    const displayInputId = endDateInput.dataset.displayId;
                    document.getElementById(displayInputId).value = '';
                }
            }

            // Attach event listeners
            document.querySelectorAll('input[type="date"]').forEach((dateInput) => {
                dateInput.addEventListener('input', function() {
                    handleDateInput(this, this.dataset.displayId);
                    checkDate(this.dataset.startId, this.id);
                });
            });
        });
    </script>

    <div class="form-field-head">
        <div class="division-bar pt-3">
            <strong>Site Division/Project</strong> :
            QMS-North America / Additional-Testing
        </div>
    </div>

    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Under Add. Test Proposal</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Under CQ Approval</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Under Add. Test Excecution</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Under Add. Testing Ex. QC Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Under Add. Testing Ex. AQA Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Activity Log </button>

            </div>

            <!-- General Information -->

            <div id="CCForm1" class="inner-block cctabcontent">
                <div class="inner-block-content">

                    <div class="sub-head">Parent Record Information</div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> (Root Parent) OOS No.
                                </label>
                                <input type="text" id="date" name="root_parent_oos_number">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Initiator"> (Root Parent) OOT No.
                                </label>
                                <input type="text" id="date" name="root_parent_oot_number">
                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="parent_date_opened">(Parent) Date Opened</label>
                                <div class="calenderauditee">
                                    <input type="text" id="end_date_1" readonly placeholder="DD-MMM-YYYY" />
                                    <input type="date" id="end_date_checkdate_1" name="parent_date_opened"
                                    min="min="yyyy-mm-dd" " class="hide-input"
                                                                                oninput="handleDateInput(this, 'end_date_1');checkDate('start_date_checkdate_1','end_date_checkdate_1')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="group-input">
                                                                        <label for="Short Description">(Parent) Short Description<span class="text-danger "
                                                                                name="short_description">*</span></label><span id="rchars">255 </span>characters
                                                                        remaining
                                                                        <input id="docname" type="text" name="short_description" maxlength="255" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 new-date-data-field">
                                                                    <div class="group-input input-date">
                                                                        <label for="parent_target_closure_date">(Parent) Target Closure Date</label>
                                                                        <div class="calenderauditee">
                                                                            <input type="text" id="end_date_2" readonly placeholder="DD-MMM-YYYY" />
                                                                            <input type="date" id="end_date_checkdate_2" name="parent_target_closure_date"
                                                                                min="yyyy-mm-dd"
                                                                                class="hide-input"
                                                                                data-display-id="end_date_2" data-start-id="start_date_checkdate_2"
                                                                                oninput="handleDateInput(this, 'end_date_2'); checkDate('start_date_checkdate_2', 'end_date_checkdate_2')" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="group-input">
                                                                        <label for="Initiator"> (Parent)Product / Material Name
                                                                        </label>
                                                                        <input type="text" id="text" name="parent_product_mat_name">
                                                                    </div>
                                                                     </div>
                                                                    < class="col-lg-6">
                                                                    <div class="group-input">
                                                                        <label for="Initiator"> (Root Parent)Product / Material Name
                                                                        </label>
                                                                        <input type="text" id="text" name="root_parent_prod_mat_name">
                                                                    </div>

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
                                                                                                min="yyyy-mm-dd"
                                                                                                class="hide-input"
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
                                                                                                <input type="date" name="parent_info_no_product_material[0][exp_date]"
                                                                                                                                                                                              min="yyyy-mm-dd"
                                                                                                     class="hide-input"
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

                                                                < class="group-input">
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
                                                                                                                                                                                              min="yyyy-mm-dd"
                                                                                 class="hide-input"
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
                                                                                                <input type="date" name="parent_info_no_product_material1[0][exp_date]"
                                                                                                                                                                                              min="yyyy-mm-dd"
                                                                                 class="hide-input"
                                                                                                       oninput="handleDateInput(this, 'agenda_date3');" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td><input type="text" name="parent_info_no_product_material1[0][name]"></td>
                                                                                <td><input type="text" name="parent_info_no_product_material1[0][pack_size]"></td>
                                                                                <td><input type="text" name="parent_info_no_product_material1[0][lot_batch_no]"></td>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                    < class="group-input">
                                        <label for="audit-agenda-grid">
                                            (Root Parent) OOS Details (0)
                                            <button type="button" name="root_parent_oos_detailsAR_Number"
                                                id="Product_Material3">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#document-details-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Open)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="Product_Material3" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 4%">Row#</th>
                                                        <th style="width: 10%">A.R. Number</th>
                                                        <th style="width: 8%">Test Name of OOS</th>
                                                        <th style="width: 8%">Results Obtained</th>
                                                        <th style="width: 8%">Specification Limit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input disabled type="text" name="serial[]" value="1"></td>
                                                        <td><input type="text"
                                                                name="(root_parent_oos_detailsAR_Number[0][ar_number]">
                                                        </td>
                                                        <td><input type="text"
                                                                name="(root_parent_oos_detailsTest_Name_OOS[0][test_name_of_oos]">
                                                        </td>
                                                        <td><input type="text"
                                                                name="(root_parent_oos_detailsResults_Obtained[0][results_obtained]">
                                                        </td>
                                                        <td><input type="text"
                                                                name="(root_parent_oos_detailsSpecification_Limit[0][specification_limit]">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    < class="group-input">
                                        <label for="audit-agenda-grid">
                                            (Parent) OOT Results (0)
                                            <button type="button" name="parent_oot_results" id="Product_Material4">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#document-details-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Open)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="Product_Material4" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 4%">Row#</th>
                                                        <th style="width: 10%">A.R. Number</th>
                                                        <th style="width: 8%">Test Number of OOT</th>
                                                        <th style="width: 8%">Results Obtained</th>
                                                        <th style="width: 8%">Previous Interval Details</th>
                                                        <th style="width: 8%">% Difference of Results</th>
                                                        <th style="width: 8%">Initial Interview Details</th>
                                                        <th style="width: 8%">Trend Limit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input disabled type="text" name="serial[]" value="1"></td>
                                                        <td><input type="text" name="parent_oot_results[0][ar_number]"></td>
                                                        <td><input type="text" name="parent_oot_results[0][test_number_of_oot]">
                                                        </td>
                                                        <td><input type="text" name="parent_oot_results[0][results_obtained]">
                                                        </td>
                                                        <td><input type="text" name="parent_oot_results[0][prev_interval_details]">
                                                        </td>
                                                        <td><input type="text" name="parent_oot_results[0][diff_of_results]">
                                                        </td>
                                                        <td><input type="text"
                                                                name="parent_oot_results[0][initial_interview_details]">
                                                        </td>
                                                        <td><input type="text" name="parent_oot_results[0][trend_limit]"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                            (Parent) Details of Stability Study (0)
                                            <button type="button" name="parent_details_of_stability_study"
                                                id="Product_Material5">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#document-details-field-instruction-modal"
                                                                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                                                        (Open)
                                                                                    </span>
                                                                                </label>
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-bordered" id="Product_Material5" style="width: 100%;">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th style="width: 4%">Row#</th>
                                                                                                <th style="width: 10%">A.R. Number</th>
                                                                                                <th style="width: 8%">Condition: Temperature & RH</th>
                                                                                                <th style="width: 8%">Interval</th>
                                                                                                <th style="width: 8%">Orientation</th>
                                                                                                <th style="width: 8%">Pack Details (if any)</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td><input disabled type="text" name="serial[]" value="1"></td>
                                                                                                <td><input type="text"
                                                                                                        name="parent_details_of_stability_study[0][ar_number]">
                                                                                                </td>
                                                                                                <td><input type="text"
                                                                                                        name="parent_details_of_stability_study[0][condition_temp_and_rh]">
                                                                                                </td>
                                                                                                <td><input type="text"
                                                                                                        name="parent_details_of_stability_study[0][interval]">
                                                                                                </td>
                                                                                                <td><input type="text"
                                                                                                        name="parent_details_of_stability_study[0][orientation]"></td>
                                                                                                <td><input type="text"
                                                                                                        name="parent_details_of_stability_study[0][pack_details_if_any]">
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>



                                                                            <div class="sub-head pt-3">General Information</div>
                                                                            <div class="row">

                                                                                <div class="col-lg-6">
                                                                                    <div class="group-input">
                                                                                        <label for="Initiator"> Originator </label>
                                                                                        <input type="text" disabled name="originator1">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6 new-date-data-field">
                                                                                    <div class="group-input input-date">
                                                                                        <label for="Scheduled end date">Target Closure Date</label>
                                                                                        <div class="calenderauditee" disabled>
                                                                                            <input type="text" id="end_date_3" disabled readonly
                                                                                                placeholder="DD-MMM-YYYY" />
                                                                                            <input type="date" id="end_date_checkdate_3" disabled name="end_date"
                                                                                                min="yyyy-mm-dd" class="hide-input"
                                                                                                oninput="handleDateInput(this, 'end_date_3');checkDate('start_date_checkdate_3','end_date_checkdate_3')" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="group-input">
                                                                                        <label for="Short Description">Short Description<span class="text-danger "
                                                                                                name="short_description">*</span></label><span id="rchars">255
                                                                                        </span>characters
                                                                                        remaining
                                                                                        <input id="docname" type="text" name="short_description" maxlength="255"
                                                                                            required>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-6">
                                                                                    <div class="group-input">
                                                                                        <label for="Initiator"> QC Approver </label>
                                                                                        <input type="text" name="qc_approver">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6 new-date-data-field">
                                                                                    <div class="group-input input-date">
                                                                                        <label for="Scheduled end date">Date opened
                                                                                        </label>
                                                                                        <div class="calenderauditee">
                                                                                            <input type="text" id="end_date4" readonly placeholder="DD-MMM-YYYY" />
                                                                                            <input type="date" id="end_date_checkdate4" name="date_opened"
                                                                                                min="yyyy-mm-dd" class="hide-input"
                                                                                                oninput="handleDateInput(this, 'end_date4');checkDate('start_date_checkdate4','end_date_checkdate4')" />
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

                                                                <!-- under ADD. Test Proposal -->
                                                                <div id="CCForm2" class="inner-block cctabcontent">
                                                                    <div class="inner-block-content">
                                                                        <div class="sub-head">Add. Test Proposal Comment </div>
                                                                        <div class="row">

                                                                            <div class="col-lg-12 mb-4">
                                                                                <div class="group-input">
                                                                                    <label for="Audit Schedule Start Date" name="cq_approver_comments"> CQ Approver
                                                                                        Comments
                                                                                    </label>
                                                                                    <div class="col-md-12">
                                                                                        <div>
                                                                                            <textarea name="cq_approver_comments_rows" id="" cols="10" rows="5"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="group-input">
                                                                                    <label for="resampling_required">Resampling Required?</label>
                                                                                    <select single id="resampling_required" name="resampling_required">
                                                                                        <option value="">Enter Your Selection Here</option>
                                                                                        <option value="option1">Option 1</option>
                                                                                        <option value="option2">Option 2</option>
                                                                                        <option value="option3">Option 3</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="group-input">
                                                                                    <label for="resampling_reference">Resample Reference</label>
                                                                                    <select single id="resampling_reference" name="resampling_reference">
                                                                                        <option value="">Enter Your Selection Here</option>
                                                                                        <option value="reference1">Reference 1</option>
                                                                                        <option value="reference2">Reference 2</option>
                                                                                        <option value="reference3">Reference 3</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>




                                                                            <div class="col-lg-6">
                                                                                <div class="group-input">
                                                                                    <label for="Product/Material Name"> Assignee</label>
                                                                                    <input type="text" name=assignee"">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="group-input">
                                                                                    <label for="Reference Recores">AQA Apporover</label>
                                                                                    <input type="text" name="aqa_approver">

                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-6">
                                                                                <div class="group-input">
                                                                                    <label for="Product/Material Name">CQ Apporver</label>
                                                                                    <input type="text" name="cq_approver">

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="group-input">
                                                                                    <label for="add_test_attachment">Additional Test Attachment</label>
                                                                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                                                                            documents</small></div>
                                                                                    <div class="file-attachment-field">
                                                                                        <div class="file-attachment-list" id="add_test_attachment"></div>
                                                                                        <div class="add-btn">
                                                                                            <div>Add</div>
                                                                                            <input type="file" id="myfile" name="add_test_attachment[]"
                                                                                                oninput="addMultipleFiles(this, 'add_test_attachment')" multiple>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="group-input">
                                                                                    <label for="Product/Material Name"> Additional Test Proposal Completed By</label>
                                                                                    <input type="text" name="additional_test_proposal_completed_by">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-6 new-date-data-field">
                                                                                <div class="group-input input-date">
                                                                                    <label for="Scheduled end date">Additional Test Proposal Completed On</label>
                                                                                    <div class="calenderauditee">
                                                                                        <input type="text" id="end_date5" readonly placeholder="DD-MMM-YYYY" />
                                                                                        <input type="date" id="end_date_checkdate5"
                                                                                            name="additional_test_proposal_completed_on" min="yyyy-mm-dd" class="hide-input"
                                                                                            oninput="handleDateInput(this, 'end_date5');checkDate('start_date_checkdate5','end_date_checkdate5')" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="button-block">
                                                                            <button type="submit" class="saveButton">Save</button>
                                                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                                                            <button type="button" class="exitButton">
                                                                                <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Under CQ Approval -->
                                                                <div id="CCForm3" class="inner-block cctabcontent">
                                                                    <div class="inner-block-content">
                                                                        <div class="sub-head">
                                                                            CQ Approval Comment
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12 mb-4">
                                                                                <div class="group-input">
                                                                                    <label for="Description Deviation" name="cq_approval_comment">CQ Approval Comment
                                                                                    </label>
                                                                                    <textarea name="cq_approval_comment" id="" cols="30" rows="5"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="group-input">
                                                                                <label for="cq_approval_attachment">CQ Approval Attachment</label>
                                                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                                                        documents</small></div>
                                                                                <div class="file-attachment-field">
                                                                                    <div class="file-attachment-list" id="cq_approval_attachment"></div>
                                                                                    <div class="add-btn">
                                                                                        <div>Add</div>
                                                                                        <input type="file" id="myfile" name="cq_approval_attachment[]"
                                                                                            oninput="addMultipleFiles(this, 'cq_approval_attachment')" multiple>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row col-md-12">
                                                                            <div class="col-md-6 mb-4">
                                                                                <div class="group-input">
                                                                                    <label for="Description Deviation" name="cq_approved_by">CQ Approved By
                                                                                    </label>
                                                                                    <input type="text" name="cq_approved_on">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6 new-date-data-field">
                                                                                <div class="group-input input-date">
                                                                                    <label for="Scheduled end date">CQ Approved On</label>
                                                                                    <div class="calenderauditee">
                                                                                        <input type="text" id="end_date6" readonly placeholder="DD-MMM-YYYY" />
                                                                                        <input type="date" id="end_date_checkdate6" name="cq_approved_on"
                                                                                            min="yyyy-mm-dd" class="hide-input"
                                                                                            oninput="handleDateInput(this, 'end_date6');checkDate('start_date_checkdate6','end_date_checkdate6')" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="button-block">
                                                                            <button type="submit" class="saveButton">Save</button>
                                                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                                                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                                                                    Exit </a> </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Under Add. Text  Excecution--->
                                                                <div id="CCForm4" class="inner-block cctabcontent">
                                                                    <div class="inner-block-content">
                                                                        <div class="sub-head">Add. Testing Execution Comment </div>
                                                                        <div class="row">

                                                                            <div class="col-md-12 mb-4">
                                                                                <div class="group-input">
                                                                                    <label for="Description Deviation" name="add_testing_execution_comment">Comments (if
                                                                                        any)</label>
                                                                                    <textarea name="add_testing_execution_comment" id="" cols="30" rows="5"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <small class="text-primary">
                                                                                Jurisdiction for delay in Completion of Activity and closing of Additional Testing
                                                                            </small>
                                                                            <div class="col-md-12 mb-4">
                                                                                <div class="group-input">
                                                                                    <label for="Description Deviation" name="delay_justifictaion">Delay
                                                                                        Justification</label>
                                                                                    <textarea name="delay_justifictaion" id="" cols="30" rows="5"></textarea>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-12">
                                                                                <div class="group-input">
                                                                                    <label for="add_test_exe_attachment">Additional Test Exe. Attachment
                                                                                    </label>
                                                                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                                                                            documents</small></div>
                                                                                    <div class="file-attachment-field">
                                                                                        <div class="file-attachment-list" id="add_test_exe_attachment"></div>
                                                                                        <div class="add-btn">
                                                                                            <div>Add</div>
                                                                                            <input type="file" id="myfile" name="add_test_exe_attachment[]"
                                                                                                oninput="addMultipleFiles(this, 'add_test_exe_attachment')" multiple>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row col-md-12">
                                                                                <div class="col-md-6 mb-4">
                                                                                    <div class="group-input">
                                                                                        <label for="Description Deviation" name="additional_test_exe_by">Additional Test
                                                                                            Exe.
                                                                                            By</label>
                                                                                        <input type="text" name="additional_test_exe_by">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-6 new-date-data-field">
                                                                                    <div class="group-input input-date">
                                                                                        <label for="Scheduled end date">Additional Test Exe. On</label>
                                                                                        <div class="calenderauditee">
                                                                                            <input type="text" id="end_date7" readonly placeholder="DD-MMM-YYYY" />
                                                                                            <input type="date" id="end_date_checkdate7" name="add_test_exe_on"
                                                                                                min="yyyy-mm-dd" class="hide-input"
                                                                                                oninput="handleDateInput(this, 'end_date7');checkDate('start_date_checkdate7','end_date_checkdate7')" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="button-block">
                                                                            <button type="submit" class="saveButton">Save</button>
                                                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                                                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                                                                    Exit </a> </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Under Add. Text  Excecution QC Review--->
                                                                <div id="CCForm5" class="inner-block cctabcontent">
                                                                    <div class="inner-block-content">
                                                                        <div class="sub-head">
                                                                            Add. Testing QC Comment
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12 mb-4">
                                                                                <div class="group-input">
                                                                                    <label for="Description Deviation" name="qc_comments_on_addl_testing">QC Comments on
                                                                                        Addl.
                                                                                        Testing</label>
                                                                                    <textarea name="qc_comments_on_addl_testing" id="" cols="30" rows="5"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="group-input">
                                                                                <label for="qc_review_attachment">QC Review Attachment
                                                                                </label>
                                                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                                                        documents</small></div>
                                                                                <div class="file-attachment-field">
                                                                                    <div class="file-attachment-list" id="qc_review_attachment"></div>
                                                                                    <div class="add-btn">
                                                                                        <div>Add</div>
                                                                                        <input type="file" id="myfile" name="qc_review_attachment[]"
                                                                                            oninput="addMultipleFiles(this, 'qc_review_attachment')" multiple>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row col-md-12">
                                                                            <div class="col-md-6 mb-4">
                                                                                <div class="group-input">
                                                                                    <label for="Description Deviation" name="addl_testing_qc_review_by">Additional Testing
                                                                                        QC
                                                                                        Review By</label>
                                                                                    <input type="text" name="addl_testing_qc_review_by">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6 new-date-data-field">
                                                                                <div class="group-input input-date">
                                                                                    <label for="Scheduled end date">Additional Testing QC Review on
                                                                                    </label>
                                                                                    <div class="calenderauditee">
                                                                                        <input type="text" id="end_date8" readonly placeholder="DD-MMM-YYYY" />
                                                                                        <input type="date" id="end_date_checkdate8" name="add_testing_qc_review_on"
                                                                                            min="yyyy-mm-dd" class="hide-input"
                                                                                            oninput="handleDateInput(this, 'end_date8');checkDate('start_date_checkdate8','end_date_checkdate8')" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="button-block">
                                                                            <button type="submit" class="saveButton">Save</button>
                                                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                                                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                                                                    Exit </a> </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Phase II QC Review -->
                                                                <div id="CCForm6" class="inner-block cctabcontent">
                                                                    <div class="inner-block-content">
                                                                        <div class="sub-head">Additional Testing AQA Comment</div>
                                                                        <div class="row">
                                                                            <div class="col-md-12 mb-4">
                                                                                <div class="group-input">
                                                                                    <label for="Description Deviation" name="summary_of_exp_hyp">Summary of
                                                                                        Exp./Hyp.</label>
                                                                                    <div><small class="text-primary">AQA COmments on Additional Testing</small></div>
                                                                                    <textarea name="summary_of_exp_hyp" id="" cols="30" rows="5"></textarea>
                                                                                </div>


                                                                                <div class="row col-md-12">
                                                                                    <div class="col-md-6 mb-4">
                                                                                        <div class="group-input">
                                                                                            <label for="Description Deviation" name="aqa_review_completed_by">AQA Review
                                                                                                Completed By
                                                                                            </label>
                                                                                            <input type="text" name="aqa_review_completed_by">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-6 new-date-data-field">
                                                                                        <div class="group-input input-date">
                                                                                            <label for="Scheduled end date">AQA Review Completed On
                                                                                            </label>
                                                                                            <div class="calenderauditee">
                                                                                                <input type="text" id="end_date10" readonly placeholder="DD-MMM-YYYY" />
                                                                                                <input type="date" id="end_date_checkdate10"
                                                                                                    name="aqa_review_completed_on" min="yyyy-mm-dd" class="hide-input"
                                                                                                    oninput="handleDateInput(this, 'end_date10');checkDate('start_date_checkdate10','end_date_checkdate10')" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>


                                                                                <div class="sub-head">Cancellation</div>
                                                                                <div class="row col-md-12">
                                                                                    <div class="col-md-6 mb-4">
                                                                                        <div class="group-input">
                                                                                            <label for="Description Deviation">Cancel By
                                                                                            </label>
                                                                                            <input type="text" name="cancel_by">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-6 new-date-data-field">
                                                                                        <div class="group-input input-date">
                                                                                            <label for="Scheduled end date">Cancel On
                                                                                            </label>
                                                                                            <div class="calenderauditee">
                                                                                                <input type="text" id="end_date11" readonly placeholder="DD-MMM-YYYY" />
                                                                                                <input type="date" id="end_date_checkdate11" name="cancel_on"
                                                                                                    min="yyyy-mm-dd" class="hide-input"
                                                                                                    oninput="handleDateInput(this, 'end_date11');checkDate('start_date_checkdate11','end_date_checkdate11')" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <div class="button-block">
                                                                                <button type="submit" class="saveButton">Save</button>
                                                                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                                                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                                                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                                                                        Exit </a> </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!--Activity Log  -->
                                                                <div id="CCForm7" class="inner-block cctabcontent">
                                                                    <div class="inner-block-content">
                                                                        <div class="sub-head">
                                                                            Activity Log
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <div class="group-input">
                                                                                    <label for="Product/Material Name"> Additional Test Proposal Completed By :-</label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-6 new-date-data-field">
                                                                                <div class="group-input input-date">
                                                                                    <label for="Scheduled end date">Additional Test Proposal Completed On :-</label>

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6 new-date-data-field">
                                                                                <div class="group-input input-date">
                                                                                    <label for="Scheduled end date">CQ Approved On :-</label>

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6 new-date-data-field">
                                                                                <div class="group-input input-date">
                                                                                    <label for="Scheduled end date">Additional Test Exe. On :-</label>

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6 new-date-data-field">
                                                                                <div class="group-input input-date">
                                                                                    <label for="Scheduled end date">Additional Testing QC Review on :-
                                                                                    </label>

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6 new-date-data-field">
                                                                                <div class="group-input input-date">
                                                                                    <label for="Scheduled end date">AQA Review Completed On :-
                                                                                    </label>

                                                                                </div>
                                                                            </div>


                                                                            <div class="col-md-6 mb-4">
                                                                                <div class="group-input">
                                                                                    <label for="Description Deviation">Cancel By :-
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6 new-date-data-field">
                                                                                <div class="group-input input-date">
                                                                                    <label for="Scheduled end date">Cancel On :-
                                                                                    </label>

                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="button-block">
                                                                            <button type="submit" class="saveButton">Save</button>
                                                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                                                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                                                                    Exit </a> </button>
                                                                        </div>
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
                                                                        for (i = 0; i < script cctablinks.length; i++) {
                                                                            cctablinks[i].className = cctablinks[i].className.replace(" active", "");
                                                                        }
                                                                        document.getElementById(cityName).style.display = "block";
                                                                        evt.currentTarget.className += " active";
                                                                    }
                                                                </script>
@endsection
