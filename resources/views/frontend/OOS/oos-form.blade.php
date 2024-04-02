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

<!-- -----------------------------grid-1----------------------------script -->
<script>
    $(document).ready(function() {
        $('#Product_Material').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="Number[]"></td>' +
                    '<td><input type="text" name="Product/ MaterialName[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +


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
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>



<!-- --------------------------------grid-2--------------------------script -->

<script>
    $(document).ready(function() {
        $('#Details_Stability').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="Number[]"></td>' +
                    '<td><input type="text" name="Stability_StudyName[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +


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
<!-- ------------------------------grid-3-------------------------script -->
<script>
    $(document).ready(function() {
        $('#OOS_Details').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="Number[]"></td>' +
                    '<td><input type="text" name="OOS_DetailsName[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +


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

<!-- ---------------------------grid-1 ---Preliminary Lab Invst. Review----------------------------- -->

<script>
    $(document).ready(function() {
        $('#oos_capa').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="Number[]"></td>' +
                    '<td><input type="text" name="oos_capaName[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +


                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' + 

                '</tr>';

                return html;
            }

            var tableBody = $('#oos_capa_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>


<!-- -----------------------------grid-1----------OOS Conclusion ---------------- -->

<script>
    $(document).ready(function() {
        $('#oos_conclusion').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="Number[]"></td>' +
                    '<td><input type="text" name="oos_conclusionName[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +


                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' + 

                '</tr>';

                return html;
            }

            var tableBody = $('#oos_conclusion_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>


<!-- -----------------------------grid-1----------OOSConclusion_Review ---------------- -->

<script>
    $(document).ready(function() {
        $('#oosconclusion_review').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="Number[]"></td>' +
                    '<td><input type="text" name="oosconclusion_reviewName[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +


                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' + 

                '</tr>';

                return html;
            }

            var tableBody = $('#oosconclusion_review_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>





<div class="form-field-head">
    <div class="pr-id">
        New Document
    </div>
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        QMS-North America / OOS
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
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Preliminary Lab. Investigation</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Preliminary Lab Inv. Conclusion</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Preliminary Lab Invst. Review</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Phase II Investigation</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Phase II QC Review</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Additional Testing Proposal </button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm8')">OOS Conclusion</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm9')">OOS Conclusion Review</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm10')">OOS CQ Review</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm11')">Batch Disposition</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm12')">Re-Open</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm13')">Under Addendum Approval</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm14')">Under Addendum Execution</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm15')">Under Addendum Review</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm16')">Under Addendum Verification</button>

        </div>

        <!-- General Information -->

        <div id="CCForm1" class="inner-block cctabcontent">
            <div class="inner-block-content">

                <div class="sub-head">General Information</div>
                <div class="row">

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator"> Record Number </label>
                            <input type="number">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group"> Division Code </label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Initiator Group Code"> Initiator </label>

                            <input type="text">

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator"> Date of Initiation </label>
                            <input type="date" id="date" name="date-time">

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator"> Due Date
                            </label>
                            <input type="date" id="date" name="date-time">

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Short Description"> Severity Level</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Short Description"> Initiator group</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Initiator group code</label>

                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group Code">Initiated Through </label>
                            <textarea name="text"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group Code">If Others</label>


                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group Code">Is Repeat?</label>

                            <textarea name="text"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Repeat Nature</label>
                            <textarea name="text"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Nature of Change</label>
                            <input type="file">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Deviation Occured On</label>
                            <input type="date">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Description</label>
                            <textarea name="text"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Initial Attachment</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input pt-4">
                            <label for="Short Description ">Reference System Document </label>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Short Description"> Reference Document</label>
                            <input type="number">
                        </div>
                    </div>

                    <div class="sub-head pt-3">OOS Information</div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Short Description ">Product / Material Name</label>

                            <input type="number">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input ">
                            <label for="Short Description ">Market</label>

                            <input type="number" name="num">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Initiator Group">Customer*</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>


                    <!-- ---------------------------grid-1 -------------------------------- -->
                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            Info. On Product/ Material
                            <button type="button" name="audit-agenda-grid" id="Product_Material">+</button>
                            <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                (Launch Instruction)
                            </span>
                        </label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="Product_Material_details" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 4%">Row#</th>
                                        <th style="width: 8%">Item/Product Code</th>
                                        <th style="width: 8%"> Batch No*.</th>
                                        <th style="width: 12%"> Mfg.Date</th>
                                        <th style="width: 16%">Expiry Date</th>
                                        <th style="width: 16%"> Label Claim.</th>
                                        <th style="width: 16%">Pack Size</th>
                                        <th style="width: 16%">Analyst Name</th>

                                        <th style="width: 16%">Others (Specify)</th>
                                        <th style="width: 16%"> In- Process Sample Stage.</th>
                                        <th style="width: 16% pt-3">Packing Material Type</th>
                                        <th style="width: 16% pt-2"> Stability for</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    <td><input disabled type="text" name="serial[]" value="1"></td>
                                    <td><input type="text" name="Number[]"></td>
                                    <td><input type="text" name="Name[]"></td>
                                    <td><input type="text" name="Remarks[]"></td>
                                    <td><input type="text" name="Number[]"></td>
                                    <td><input type="text" name="Name[]"></td>
                                    <td><input type="text" name="Remarks[]"></td>
                                    <td><input type="text" name="Number[]"></td>
                                    <td><input type="text" name="Name[]"></td>
                                    <td><input type="text" name="Remarks[]"></td>
                                    <td><input type="text" name="Number[]"></td>
                                    <td><input type="text" name="Name[]"></td>
                                 

                                </tbody>

                            </table>
                        </div>
                    </div>


                    <!-- -------------------------------grid-2  ----------------------------------   -->
                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            Details of Stability Study
                            <button type="button" name="audit-agenda-grid" id="Details_Stability">+</button>
                            <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                (Launch Instruction)
                            </span>
                        </label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="Details_Stability_details" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 4%">Row#</th>
                                        <th style="width: 8%">AR Number</th>
                                        <th style="width: 8%">Condition: Temperature & RH</th>
                                        <th style="width: 12%">Interval</th>
                                        <th style="width: 16%">Orientation</th>
                                        <th style="width: 16%">Pack Details (if any)</th>
                                        <th style="width: 16%">Specification No.</th>
                                        <th style="width: 16%">Sample Description</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <td><input disabled type="text" name="serial[]" value="1"></td>
                                    <td><input type="text" name="Number[]"></td>
                                    <td><input type="text" name="Name[]"></td>
                                    <td><input type="text" name="Remarks[]"></td>
                                    <td><input type="text" name="Number[]"></td>
                                    <td><input type="text" name="Name[]"></td>
                                    <td><input type="text" name="Remarks[]"></td>
                                    <td><input type="text" name="Number[]"></td>



                                </tbody>

                            </table>
                        </div>
                    </div>


                    <!-- 
------------------------------------------grid-3----------------------------------- -->

                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            OOS Details
                            <button type="button" name="audit-agenda-grid" id="OOS_Details">+</button>
                            <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                (Launch Instruction)
                            </span>
                        </label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="OOS_Details_details" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 4%">Row#</th>
                                        <th style="width: 8%">AR Number.</th>
                                        <th style="width: 8%">Test Name of OOS</th>
                                        <th style="width: 12%">Results Obtained</th>
                                        <th style="width: 16%">Specification Limit</th>
                                        <th style="width: 16%">Details of Obvious Error</th>
                                        <th style="width: 16%">File Attachment</th>
                                        <th style="width: 16%">Submit By</th>
                                        <th style="width: 16%">Submit On</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <td><input disabled type="text" name="serial[]" value="1"></td>
                                    <td><input type="text" name="Number[]"></td>
                                    <td><input type="text" name="Name[]"></td>
                                    <td><input type="text" name="Remarks[]"></td>
                                    <td><input type="text" name="Number[]"></td>
                                    <td><input type="text" name="text[]"></td>
                                    <td><input type="file" name="file[]"></td>
                                    <td><input type="text" name="text[]"></td>
                                    <td><input type="date" name="time[]"></td>



                                </tbody>

                            </table>
                        </div>
                    </div>



                    <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>
                </div>
            </div>


        </div>



        <!-- Preliminary Lab. Investigation -->
        <div id="CCForm2" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">Preliminary Lab. Investigation </div>
                <div class="row">

                    <div class="col-lg-12">
                        <div class="group-input">
                            <label for="Audit Schedule Start Date"> Comments </label>
                            <div class="col-md-12 4">
                                <div class="group-input">
                                    <!-- <label for="Description Deviation">Description of Deviation</label> -->
                                    <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                                    <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Schedule End Date"> Field Alert Required</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Agenda">Field Alert Ref.No.</label>
                            <input type="num" name="num">
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <div class="group-input">
                            <label for="Description Deviation">Justify if no Field Alert</label>
                            <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                            <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Facility Name"> Facility Name </label>
                                <select multiple name="facility_name" placeholder="Select Nature of Deviation" data-search="false" data-silent-initial-value-set="true" id="facility_name">
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Group Name"> Group Name </label>
                                <select multiple name="group_name" placeholder="Select Nature of Deviation" data-search="false" data-silent-initial-value-set="true" id="group_name">
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                </select>
                            </div>
                        </div> -->
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Product/Material Name"> Verification Analysis Required</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Agenda">Verification Analysis Ref.</label>
                            <input type="num" name="num">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Product/Material Name">Analyst Interview Req.</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Agenda">Analyst Interview Ref.</label>
                            <input type="num" name="num">
                        </div>
                    </div>

                    <div class="col-lg-12 mb-4">
                        <div class="group-input">
                            <label for="Audit Schedule Start Date">Justify if no Analyst Int. </label>

                            <!-- <label for="Description Deviation">Description of Deviation</label> -->
                            <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                            <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Product/Material Name">Phase I Investigation Required</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Product/Material Name">Phase I Investigation</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Agenda">Phase I Investigation Ref.</label>
                            <input type="num" name="num">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Attachments">File Attachments</label>
                            <input type="file" id="myfile" name="myfile">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Agenda">Preliminary Lab Inves. Done By</label>
                            <input type="text" name="name">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Agenda">Preliminary Lab Inves. Done On</label>
                            <input type="date" name="time">
                        </div>
                    </div>

                    <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>
                </div>
            </div>
            
        </div>



        <!-- Preliminary Lab Inv. Conclusion -->
        <div id="CCForm3" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">Investigation Conclusion</div>
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="group-input">
                            <label for="Description Deviation">Summary of Prelim.Investiga.</label>
                            <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                            <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Lead Auditor">Root Cause Identified</label>
                            <!-- <div class="text-primary">Please Choose the relevent units</div> -->
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team"> OOS Category-Root Cause Ident.</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="group-input">
                            <label for="Description Deviation">OOS Category (Others)</label>
                            <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                            <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="group-input">
                            <label for="Description Deviation">Root Cause Details</label>
                            <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                            <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="group-input">
                            <label for="Description Deviation">OOS Category-Root Cause Ident.</label>
                            <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                            <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Product/Material Name">Recommended Actions Required?</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Agenda">Recommended Actions Reference</label>
                            <input type="num" name="num">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Product/Material Name">CAPA Required</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Agenda">Reference CAPA No.</label>
                            <input type="num" name="num">
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <div class="group-input">
                            <label for="Description Deviation">Delay Justification for P.I.</label>
                            <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                            <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Attachments"> Supporting Attachment </label>
                            <input type="file" id="myfile" name="myfile">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Pre. Lab Inv. Conclusion By</label>
                            <input type="text">

                            <!-- <label for="Auditee"> Auditee </label>
                                <select multiple name="auditee" placeholder="Select Nature of Deviation"
                                    data-search="false" data-silent-initial-value-set="true" id="auditee">
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                    <option value="Piyush">Piyush Sahu</option>
                                </select> -->
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Pre. Lab Inv. Conclusion On</label>
                            <input type="date" name="time">
                        </div>
                    </div>






                    <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Preliminary Lab Invst. Review--->
        <div id="CCForm4" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">Preliminary Lab Invstigation Review</div>
                <div class="row">

                    <div class="col-md-12 mb-4">
                        <div class="group-input">
                            <label for="Description Deviation">Review Comments</label>
                            <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                            <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                        </div>
                    </div>

                    <div class="sub-head">OOS Review for Similar Nature</div>

                    <!-- ---------------------------grid-1 ---Preliminary Lab Invst. Review----------------------------- -->
                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            Info. On Product/ Material
                            <button type="button" name="audit-agenda-grid" id="oos_capa">+</button>
                            <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                (Launch Instruction)
                            </span>
                        </label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="oos_capa_details" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 4%">Row#</th>
                                        <th style="width: 8%">OOS Number</th>
                                        <th style="width: 8%"> OOS Reported Date</th>
                                        <th style="width: 12%">Description of OOS</th>
                                        <th style="width: 16%">Previous OOS Root Cause</th>
                                        <th style="width: 16%"> CAPA</th>
                                        <th style="width: 16% pt-3">Closure Date of CAPA</th>
                                        <th style="width: 16%">CAPA Requirement</th>

                                        <th style="width: 16%">Reference CAPA Number</th>




                                    </tr>
                                </thead>
                                <tbody>
                                    <td><input disabled type="text" name="serial[]" value="1"></td>
                                    <td><input type="text" name="Number[]"></td>
                                    <td><input type="text" name="Name[]"></td>
                                    <td><input type="text" name="Remarks[]"></td>
                                    <td><input type="text" name="Number[]"></td>
                                    <td><input type="text" name="Name[]"></td>
                                    <td><input type="text" name="Remarks[]"></td>
                                    <td><input type="text" name="Number[]"></td>
                                    <td><input type="text" name="Name[]"></td>


                                </tbody>

                            </table>
                        </div>
                    </div>



                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Start Date"> Phase II Inv. Required?</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Attachments"> Supporting Attachments</label>
                            <input type="file" id="myfile" name="myfile">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="Audit Comments"> Pre.Lab Invest. Review By </label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Attachments">Pre.Lab Invest. Review On</label>
                            <input type="date" name="date">
                        </div>
                    </div>

                    <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Phase II Investigation -->
    <div id="CCForm5" class="inner-block cctabcontent">
        <div class="inner-block-content">
            <div class="sub-head">
                Phase II Investigation
            </div>
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">QA Approver Comments</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Report Attachments"> Manufact. Invest. Required? </label>
                        <select>
                            <option>Enter Your Selection Here</option>
                            <option></option>
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">


                        <label for="Auditee"> Manufacturing Invest. Type </label>
                        <select multiple name="auditee" placeholder="Select Nature of Deviation" data-search="false" data-silent-initial-value-set="true" id="auditee">
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>

                        </select>
                    </div>
                </div>



                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Manufacturing Invst. Ref. </label>
                        <input type="num" name="num">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments"> Re-sampling Required? </label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>

                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="group-input">
                        <label for="Audit Comments"> Audit Comments </label>
                        <textarea name="text"></textarea>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Re-sampling Ref. No. </label>
                        <input type="num" name="num">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments"> Hypo/Exp. Required</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>

                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Hypo/Exp. Reference </label>
                        <input type="num" name="num">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments"> Attachment</label>
                        <input type="file" id="myfile" name="myfile">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">Phase II Invest. Proposed By</label>
                        <input type="text" name="name">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">Phase II Invest. Proposed On</label>
                        <input type="date" name="time">
                    </div>
                </div>
                <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>

            </div>
        </div>
    </div>

    <!-- Phase II QC Review -->
    <div id="CCForm6" class="inner-block cctabcontent">
        <div class="inner-block-content">
            <div class="sub-head">Summary of Phase II Testing</div>
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Summary of Exp./Hyp.</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Summary Mfg. Investigation</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Cancelled By"> Root Casue Identified. </label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>

                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Cancelled By">OOS Category-Reason identified </label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>

                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Preparation Completed On">Others (OOS category)</label>
                        <input type="string">
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Details of Root Cause</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Impact Assessment.</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Mgr.more Info Reqd On">Recommended Action Required? </label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>

                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Observation Submitted By"> Recommended Action Reference</label>
                        <input type="num" name="num">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Observation Submitted On">Investi. Required</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>

                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Lead More Info Reqd By"> Invest. Ref. </label>
                        <input type="num" name="num">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Lead More Info Reqd On">Attachments </label>
                        <input type="file" id="myfile" name="myfile">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Response Completed By"> Phase II QC Review Done By</label>
                        <!-- <div class=" static">Person datafield</div> -->
                        <input type="text" name="name">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Response Completed On">Phase II QC Review Done On</label>
                        <!-- <div class=" static">17-04-2023 11:12PM</div> -->
                        <input type="date" name="time">
                    </div>
                </div>
                <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>




            </div>
        </div>
    </div>



    <!--Additional Testing Proposal  -->
    <div id="CCForm7" class="inner-block cctabcontent">
        <div class="inner-block-content">
            <div class="sub-head">
                Additional Testing Proposal by QA
            </div>
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Review Comment</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Report Attachments"> Additional Test Proposal </label>
                        <select>
                            <option>Enter Your Selection Here</option>
                            <option></option>
                            <option></option>
                        </select>
                    </div>
                </div>








                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Additional Test Reference. </label>
                        <input type="num" name="num">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments"> Any Other Actions Required</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>

                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Comments"> Action Task Reference </label>
                        <input type="num" name="num">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Additional Testing Attachment </label>
                        <input type="file" name="myfile">
                    </div>
                </div>




                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">Additional Test Proposed By</label>
                        <input type="text" name="name">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">Additional Test Proposed On</label>
                        <input type="date" name="time">
                    </div>
                </div>

                <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>
            </div>
        </div>
    </div>


    <!--OOS Conclusion  -->
    <div id="CCForm8" class="inner-block cctabcontent">
        <div class="inner-block-content">
            <div class="sub-head">
                Conclusion Comments
            </div>
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Conclusion Comments</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>


                <!-- ---------------------------grid-1 -------------------------------- -->
                <div class="group-input">
                    <label for="audit-agenda-grid">
                        Summary of OOS Test Results
                        <button type="button" name="audit-agenda-grid" id="oos_conclusion">+</button>
                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                            (Launch Instruction)
                        </span>
                    </label>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="oos_conclusion_details" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 4%">Row#</th>
                                    <th style="width: 16%">Analysis Detials</th>
                                    <th style="width: 16%">Hypo./Exp./Add.Test PR No.</th>
                                    <th style="width: 16%">Results</th>
                                    <th style="width: 16%">Analyst Name.</th>
                                    <th style="width: 16%">Remarks</th>




                                </tr>
                            </thead>
                            <tbody>
                                <td><input disabled type="text" name="serial[]" value="1"></td>
                                <td><input type="text" name="Number[]"></td>
                                <td><input type="text" name="Name[]"></td>
                                <td><input type="text" name="Remarks[]"></td>
                                <td><input type="text" name="Name[]"></td>
                                <td><input type="text" name="Remarks[]"></td>



                            </tbody>

                        </table>
                    </div>
                </div>



                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Report Attachments">Specification Limit </label>
                        <input type="string" name="string">
                    </div>
                </div>




                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">Results to be Reported</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>

                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Final Reportable Results</label>
                        <input type="string" name="string">
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Justifi. for Averaging Results</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">OOS Stands </label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>


                        </select>
                    </div>
                </div>




                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">CAPA Req.</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>


                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">CAPA Ref No.</label>
                        <input type="num" name="num">
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Justify if CAPA not required</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">Action Plan Req.</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>


                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">Action Plan Ref.</label>
                        <input type="num" name="num">
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Justification for Delay</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Attachments if Any</label>
                        <input type="file" name="myfile">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">OOS Conclusion Complete By</label>
                        <input type="text" name="name">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">OOS Conclusion Complete On</label>
                        <input type="date" name="time">
                    </div>
                </div>
                <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>

            </div>
        </div>
    </div>


    <!--OOS Conclusion Review -->
    <div id="CCForm9" class="inner-block cctabcontent">
        <div class="inner-block-content">
            <div class="sub-head">
                Conclusion Review Comments
            </div>
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Conclusion Review Comments</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>


                <!-- ---------------------------grid-1 ------"OOSConclusion_Review-------------------------- -->
                <div class="group-input">
                    <label for="audit-agenda-grid">
                        Summary of OOS Test Results
                        <button type="button" name="audit-agenda-grid" id="oosconclusion_review">+</button>
                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                            (Launch Instruction)
                        </span>
                    </label>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="oosconclusion_review_details" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 4%">Row#</th>
                                    <th style="width: 16%">Material/Product Name</th>
                                    <th style="width: 16%">Batch No.(s) / A.R. No. (s)</th>
                                    <th style="width: 16%">Any Other Information</th>
                                    <th style="width: 16%">Action Taken on Affec.batch</th>





                                </tr>
                            </thead>
                            <tbody>
                                <td><input disabled type="text" name="serial[]" value="1"></td>
                                <td><input type="text" name="Number[]"></td>
                                <td><input type="text" name="Name[]"></td>
                                <td><input type="text" name="Remarks[]"></td>
                                <td><input type="text" name="Number[]"></td>




                            </tbody>

                        </table>
                    </div>
                </div>


                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Action Taken on Affec.batch</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>






                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">CAPA Req?</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>


                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">CAPA Refer.</label>
                        <input type="num" name="num">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Report Attachments">Required Action Plan? </label>
                        <input type="num" name="num">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Required Action Task?</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>


                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Report Attachments">Action Task Ref. </label>
                        <input type="num" name="num">
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">Risk Assessment Req?</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>


                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">Risk Assessment Ref.</label>
                        <input type="num" name="num">
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Justify if No Risk Assessment</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Conclusion Attachment</label>
                        <input type="file" name="myfile">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">CQ Approver</label>
                        <input type="text" name="name">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">OOS Conclusion Review by</label>
                        <input type="text" name="name">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">OOS Conclusion Review On</label>
                        <input type="date" name="time">
                    </div>
                </div>

                <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>
            </div>
        </div>
    </div>





    <!--CQ Review Comments -->
    <div id="CCForm10" class="inner-block cctabcontent">
        <div class="inner-block-content">
            <div class="sub-head">
                CQ Review Comments
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="group-input">
                            <label for="Description Deviation">CQ Review comments</label>
                            <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                            <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Report Attachments">Require CAPA </label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Reference Recores">Reference of CAPA </label>
                            <input type="num" name="num">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">


                            <label for="Auditee"> Action plan requirement </label>
                            <select multiple name="auditee" placeholder="Select Nature of Deviation" data-search="false" data-silent-initial-value-set="true" id="auditee">
                                <option value="sandhya"></option>
                                <option value="sandhya"></option>

                                <option value="sandhya"></option>

                            </select>
                        </div>
                    </div>




                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Attachments"> Ref Action Plan </label>
                            <input type="num" name="num">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Attachments"> CQ Attachment</label>
                            <input type="file" id="myfile" name="myfile">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Attachments">CQ Review Done By</label>
                            <input type="text" name="name">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Attachments">CQ Review Done On</label>
                            <input type="date" name="time">
                        </div>
                    </div>

                    <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--OOS Conclusion Review -->


    <!-- Batch Disposition -->
    <div id="CCForm11" class="inner-block cctabcontent">
        <div class="inner-block-content">
            <div class="sub-head">
                Batch Disposition
            </div>
            <div class="row">



                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">OOS Category</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>


                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Other's</label>
                        <input type="string" name="string">
                    </div>
                </div>
                <!-- <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Report Attachments">Required Action Plan? </label>
                        <input type="num" name="num">
                    </div>
                </div> -->

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Material/Batch Release</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>


                        </select>
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Other Action (Specify)</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Report Attachments">Field alert reference </label>
                        <input type="string" name="string">
                    </div>
                </div>

                <div class="sub-head">Assessment for batch disposition</div>

                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Other Parameters Results</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>



                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Trend of Previous Batches</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>

                </div>
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Stability Data</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Process Validation Data</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Method Validation </label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Any Market Complaints </label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>

                </div>

                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Statistical Evaluation </label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>

                </div>
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Risk Analysis for Disposition </label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>

                </div>
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Conclusion </label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>

                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Phase-III Inves. Required?</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>


                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">Phase-III Inves. Reference</label>
                        <input type="num" name="num">
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Justify for Delay in Activity</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Disposition Attachment</label>
                        <input type="file" name="myfile">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">Disposition Decision Done by</label>
                        <input type="text" name="name">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Audit Attachments">Disposition Decision Done On</label>
                        <input type="date" name="time">
                    </div>
                </div>
                <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>
            </div>




        </div>

    </div>
    <!-- Re-Open -->
    <div id="CCForm12" class="inner-block cctabcontent">
        <div class="inner-block-content">
            <div class="sub-head">
                Reopen Request
            </div>
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Other Action (Specify)</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Reopen Attachment</label>
                        <input type="file" name="myfile">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Reopen Addendum Complete By

                        </label>
                        <input type="text" name="name">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Reopen Addendum Complete on

                        </label>
                        <input type="date" name="date">
                    </div>
                </div>
                
                <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>
            </div>
        </div>

    </div>








    <!-- Under Addendum Approval -->

    <div id="CCForm13" class="inner-block cctabcontent">
        <div class="inner-block-content">
            <div class="sub-head">
                Addendum Approval Comment
            </div>

            <div class="row">

                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Reopen Approval Comments </label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Addendum Attachment</label>
                        <input type="file" name="myfile">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Addendum Approval Completed By

                        </label>
                        <input type="text" name="name">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Reopen Addendum Complete on

                        </label>
                        <input type="date" name="date">
                    </div>
                </div>
                <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>

            </div>

        </div>

    </div>





    <!--Under Addendum Execution -->
    <div id="CCForm14" class="inner-block cctabcontent">
        <div class="inner-block-content">
            <div class="sub-head">
                Addendum Execution Comment
            </div>
            <div class="row">

                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Execution Comments</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                                    </textarea>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Action Task Required?</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>


                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Report Attachments">Action Task Reference No. </label>
                        <input type="string" name="string">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Addi.Testing Req?</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>


                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Report Attachments">Addi.Testing Ref. </label>
                        <input type="string" name="string">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Investigation Req.?</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>


                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Report Attachments">Investigation Ref. </label>
                        <input type="string" name="string">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Hypo-Exp Req?</label>
                        <select>
                            <option value="sandhya"></option>
                            <option value="sandhya"></option>


                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Report Attachments">Hypo-Exp Ref. </label>
                        <input type="string" name="string">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Addendum Attachments

                        </label>
                        <input type="file" name="myfile">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Addendum Execution Done By

                        </label>
                        <input type="text" name="name">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Addendum Execution Done On

                        </label>
                        <input type="date" name="date">
                    </div>
                </div>

                <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>
            </div>

        </div>

    </div>

    <!-- Under Addendum Review-->
    <div id="CCForm15" class="inner-block cctabcontent">
        <div class="inner-block-content">
            <div class="sub-head">
                Under Addendum Review
            </div>
            <div class="row">

                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Addendum Review Comments</label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                    </textarea>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Required Attachment</label>
                        <input type="file" name="myfile">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Addendum Review Done By

                        </label>
                        <input type="text" name="name">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Addendum Review Done On

                        </label>
                        <input type="date" name="date">
                    </div>
                </div>
                <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                Exit </a> </button>
                    </div>

            </div>

        </div>

    </div>


    <!-- Under Addendum Verification -->
    <div id="CCForm16" class="inner-block cctabcontent">
        <div class="inner-block-content">
            <div class="sub-head">
                Addendum Verification Comment
            </div>
            <div class="row">

                <div class="col-md-12 mb-4">
                    <div class="group-input">
                        <label for="Description Deviation">Verification Comments </label>
                        <!-- <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div> -->
                        <textarea class="summernote" name="Description_Deviation[]" id="summernote-1">
                    </textarea>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Verification Attachment</label>
                        <input type="file" name="myfile">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Verification Review Done By

                        </label>
                        <input type="text" name="name">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Recores">Verification Review Done On

                        </label>
                        <input type="date" name="date">
                    </div>
                </div>
                <div class="button-block">
                        <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        <button type="button" id="ChangeNextButton" class="nextButton" onclick="nextStep()">Next</button>
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
        for (i = 0; i < cctablinks.length; i++) {
            cctablinks[i].className = cctablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
@endsection