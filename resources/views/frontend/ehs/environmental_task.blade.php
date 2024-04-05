@extends('frontend.layout.main')
@section('container')


<!-- ----------------------------grid-1 AXO---------------------- -->
<script>
    $(document).ready(function() {
        $('#axo').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="PrimaryPackaging[]"></td>' +
                    '<td><input type="text" name="Material[]"></td>' +
                    '<td><input type="text" name="PackSize[]"></td>' +

                    '</tr>';
                '</tr>';

                return html;
            }

            var tableBody = $('#axo-Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<!-- ------------------------grid----heavy-2 ---------------------- -->

<script>
    $(document).ready(function() {
        $('#heavy').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="PrimaryPackaging[]"></td>' +
                    '<td><input type="text" name="Material[]"></td>' +
                    '<td><input type="text" name="PackSize[]"></td>' +

                    '</tr>';
                '</tr>';

                return html;
            }

            var tableBody = $('#heavy-Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<!-- -------------------grid  dissolved-------------->
<script>
    $(document).ready(function() {
        $('#dissolved').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="PrimaryPackaging[]"></td>' +
                    '<td><input type="text" name="Material[]"></td>' +
                    '<td><input type="text" name="PackSize[]"></td>' +

                    '</tr>';
                '</tr>';

                return html;
            }

            var tableBody = $('#dissolved-Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>



<!-- -------------------grid  otheremission--4------------>
<script>
    $(document).ready(function() {
        $('#otheremission').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="PrimaryPackaging[]"></td>' +
                    '<td><input type="text" name="Material[]"></td>' +
                    '<td><input type="text" name="PackSize[]"></td>' +

                    '</tr>';
                '</tr>';

                return html;
            }

            var tableBody = $('#otheremission-Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<!-- 
========================Emission to Air==================gird -->

<!-- ----------------------------grid-1 ODS Emission ---------------------- -->
<script>
    $(document).ready(function() {
        $('#odsemission').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="PrimaryPackaging[]"></td>' +
                    '<td><input type="text" name="Material[]"></td>' +
                    '<td><input type="text" name="PackSize[]"></td>' +

                    '</tr>';
                '</tr>';

                return html;
            }

            var tableBody = $('#odsemission-Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<!-- ------------------------grid-2---VOC Emission---------------------- -->

<script>
    $(document).ready(function() {
        $('#vocemission').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="PrimaryPackaging[]"></td>' +
                    '<td><input type="text" name="Material[]"></td>' +
                    '<td><input type="text" name="PackSize[]"></td>' +

                    '</tr>';
                '</tr>';

                return html;
            }

            var tableBody = $('#vocemission-Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<!-- -------------------grid -3 Heavy Material Emission------------->
<script>
    $(document).ready(function() {
        $('#heavymeterial').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="PrimaryPackaging[]"></td>' +
                    '<td><input type="text" name="Material[]"></td>' +
                    '<td><input type="text" name="PackSize[]"></td>' +

                    '</tr>';
                '</tr>';

                return html;
            }

            var tableBody = $('#heavymeterial-Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>



<!-- -------------------grid  otheremission--4------------>
<script>
    $(document).ready(function() {
        $('#emissionother').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="PrimaryPackaging[]"></td>' +
                    '<td><input type="text" name="Material[]"></td>' +
                    '<td><input type="text" name="PackSize[]"></td>' +

                    '</tr>';
                '</tr>';

                return html;
            }

            var tableBody = $('#emissionother-Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>





<style>
    textarea.note-codable {
        display: none !important;
    }

    header {
        display: none;
    }
</style>

<div class="form-field-head">
    <div class="pr-id">
      
    </div>
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        QMS-North America / Environmental Task
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
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Environmental Task </button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Natural Resource Consumption</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Water Consumption</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Emission to water</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Emission to Air</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Chemical waste</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Solid waste</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm8')">Energy Consumption</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Recycling</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm10')">External Complaints</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm11')"> signatures</button>
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button> -->
        </div>

        <!-- Environmental Task -->

        <div id="CCForm1" class="inner-block cctabcontent">
            <div class="inner-block-content">

                <div class="sub-head">Environmental Task</div>
                <div class="row">
                    <!-- <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Division Code"> Division Code </label>
                                <div class=" static">CRS</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Initiator"> Initiator </label>
                                <div class=" static">Shaleen Mishra</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Date Due"> Date of Initiator </label>
                                <div class=" static">17-04-2023 11:12PM</div>
                            </div>
                        </div> -->
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Initiator </label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option></option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group Code"> Date Opened </label>

                            <input type="date" id="date" name="date-time">

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Short Description"> Short Description </label>
                            <div class="text-primary">Environmental Event short description to be presented desktop</div>
                            <textarea name="text"></textarea>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Assigned to"> Assigned to </label>
                                <div class=" static">Shaleen Mishra</div>
                            </div>
                        </div> -->
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Assigned To</label>
                            <div class="text-primary"> Person Responsible</div>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>sandhya</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group Code">Due Date </label>
                            <div class="text-primary">6 Last date this Task should be closed by</div>

                            <input type="date" id="date" name="date-time">

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group Code">Task Start Date </label>

                            <input type="date" id="date" name="date-time">

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group Code">Task End Date </label>

                            <input type="date" id="date" name="date-time">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Site</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>s</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Zone</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>sandhya</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Country</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>Bhart</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">City</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>sagar</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Sate/District</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>Madhya Pradesh</option>
                                <option></option>
                            </select>
                        </div>
                    </div>

                    <div class="sub-head pt-3">Additional Information</div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <div class="text-primary">Task detailed Information</div>
                            <label for="Short Description"> Short Description </label>
                            <textarea name="text"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input pt-4">
                            <label for="Short Description "> Immediate Action </label>
                            <textarea name="text"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Short Description"> Comments </label>
                            <textarea name="text"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Attached Document(s)</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>sagar</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Initiator Group">Related URLs</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>.com</option>
                                <option></option>
                            </select>
                        </div>
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


        <!-- Natural Resource Consumption -->
        <div id="CCForm2" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="row">

                    <!-- <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Schedule Start Date"> Audit Schedule Start Date </label>
                            <div class=" static">17-04-2023 11:12PM</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Schedule End Date"> Audit Schedule End Date </label>
                            <div class=" static">17-04-2023 11:12PM</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Agenda"> Audit Agenda </label>
                            <input type="file" id="myfile" name="myfile">
                        </div>
                    </div>
                    <div class="col-lg-6">
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
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Product/Material Name"> Product/Material Name </label>
                            <input type="text" name="title">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Comments(If Any)"> Comments(If Any) </label>
                            <textarea name="text"></textarea>
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






        <!-- Water Consumption -->
        <div id="CCForm3" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">Water Comsumption</div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Short Description">Water Comsumption</label>
                            <div class="text-primary">Water that consumed by employee</div>
                            <input type="text">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Lead Auditor">Process Water Units</label>
                            <div class="text-primary">Please Choose the relevent units</div>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>Madhya Pradesh</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team"> Number Of Yearly Working Days</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Water Userd Daily Per Employee</label>
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
                            <label for="Audit Team">Irrigation Water</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Irrigation Water Unit</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>8.0</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Other Water Consumption Factor</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Other Water Conssumption Amount</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Other Water Consumption Unit</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>8.0</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Total Water Consumption</label>
                            <input type="text">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Potable Water</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Surface</label>
                            <input type="text">
                        </div>

                    </div>

                    <div class="col-12">
                        <div class="group-input">
                            <label for="Audit Team">Ground Water</label>
                            <input type="text">

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Audit Team">Water Consumption Comments</label>
                            <textarea name="text"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team"> Water Attached Document(s)</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>8.0</option>
                                <option></option>
                            </select>
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

        <!-- Emission to water -->
        <div id="CCForm4" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">Emission to water</div>
                <div class="row">

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Due Date"> Directly/Indirectly Discharge </label>
                            <label for="Initiator Group">Initiator </label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option value="sandhya"></option>
                                <option value="sandhya"></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <div class="text-primary ">Remarks are needed only if the figures of the current quarter are more then 10% higher or lower than those of the previous quarter. In this case the remarks should include an explanation.</div>
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">COD</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 0.1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5"> COD Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>



                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">N</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5"> N Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>

                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">P</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 0.1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5"> P Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>

                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">Suspended Solids</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5">Suspended Solids Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>

                    <!-- ---------------grid-1 AXO----------- -->
                    <div class="col-12">
                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                AXO (0)
                                <button type="button" name="audit-agenda-grid" id="axo">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                                <div class="text-primary">The measurement units are tonnes.</div>
                                <div class="text-primary">Values below 0.001 should not be reported.</div>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="axo-Table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">Row#</th>
                                            <th style="width: 12%">AXO (0)</th>
                                            <th style="width: 16%"> AXO Quantity</th>
                                            <th style="width: 15%">Remark </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>

                                        <td><input type="text" name="PrimaryPackaging[]"></td>
                                        <td><input type="text" name="Material[]"></td>
                                        <td><input type="text" name="PackSize[]"></td>
                                    </tbody>
                                </table>
                            </div>         
                        </div>
                    </div>

                    <!-- ---grid-2 ----Heavy Material ----- -->

                    <div class="col-12">
                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                Heavy Material Emission (0)
                                <button type="button" name="audit-agenda-grid" id="heavy">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                                <div class="text-primary">The measurement units are tonnes.</div>
                                <div class="text-primary">Values below 0.001 should not be reported.</div>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="heavy-Table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">Row#</th>
                                            <th style="width: 12%">Heavy Material Name</th>
                                            <th style="width: 16%"> Heavy Material Quantity</th>
                                            <th style="width: 15%">Remarks </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>

                                        <td><input type="text" name="PrimaryPackaging[]"></td>
                                        <td><input type="text" name="Material[]"></td>
                                        <td><input type="text" name="PackSize[]"></td>
                                    </tbody>
                                </table>
                            </div>         
                        </div>
                    </div>


                    <!-- -------grid-3 -Dissolved--------- -->


                    <div class="col-12">
                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                Dissolved (0)
                                <button type="button" name="audit-agenda-grid" id="dissolved">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                                <div class="text-primary">The measurement units are tonnes.</div>
                                <div class="text-primary">Values below 0.001 should not be reported.</div>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dissolved-Table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">Row#</th>
                                            <th style="width: 12%">Dissolved Salts Name</th>
                                            <th style="width: 16%">Dissolved Salts Quantity</th>
                                            <th style="width: 15%">Remark </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>

                                        <td><input type="text" name="PrimaryPackaging[]"></td>
                                        <td><input type="text" name="Material[]"></td>
                                        <td><input type="text" name="PackSize[]"></td>
                                    </tbody>
                                </table>
                            </div>         
                        </div>
                    </div>


                    <!-- -------grid-4 -other-emission--------- -->


                    <div class="col-12">
                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                Other Emission (Water) (0)
                                <button type="button" name="audit-agenda-grid" id="otheremission">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                                <div class="text-primary">The measurement units are tonnes.</div>
                                <div class="text-primary">Values below 0.001 should not be reported.</div>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="otheremission-Table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">Row#</th>
                                            <th style="width: 12%"> Other Emission Name</th>
                                            <th style="width: 16%"> Other Emission Quantity</th>
                                            <th style="width: 15%">Remark </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>

                                        <td><input type="text" name="PrimaryPackaging[]"></td>
                                        <td><input type="text" name="Material[]"></td>
                                        <td><input type="text" name="PackSize[]"></td>
                                    </tbody>
                                </table>
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
        </div>


        <!-------- Emission to Air ------>
        <div id="CCForm5" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">
                    Emission to Air
                </div>
                <div class="row">

                    <div class="col-lg-6">
                        <div class="group-input">
                            <!-- <label for="Due Date"> Directly/Indirectly Discharge </label>
                            <label for="Initiator Group">Initiator </label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option value="sandhya"></option>
                                <option value="sandhya"></option>
                            </select> -->
                        </div>
                    </div>

                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <div class="text-primary ">Remarks are needed only if the figures of the current quarter are more then 10% higher or lower than those of the previous quarter. In this case the remarks should include an explanation.</div>
                        </div>
                    </div>
                    <div class="col-lg-6 pt-4">
                        <div class="group-input">
                            <label for="Audit End Date ">Dust</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 0.1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 pt-4">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5"> Dust Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>



                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">SO2</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5"> SO2 Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>

                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">NOx</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5"> NOx Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>

                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">NO2</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5">NO2 Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>

                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">CO</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5">CO Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>

                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">CH4</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5">CH4 Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">NH3</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5">NH3 Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">CO2</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5">CO2 Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>

                    <!-- ---------------grid-1 ods---------- -->
                    <div class="col-12">
                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                ODS Emission (0)
                                <button type="button" name="audit-agenda-grid" id="odsemission">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                                <div class="text-primary">The measurement units are tonnes.</div>
                                <div class="text-primary">Values below 0.001 should not be reported.</div>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="odsemission-Table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">Row#</th>
                                            <th style="width: 12%">ODS (0)</th>
                                            <th style="width: 16%"> ODS Quantity</th>
                                            <th style="width: 15%">Remark </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>

                                        <td><input type="text" name="PrimaryPackaging[]"></td>
                                        <td><input type="text" name="Material[]"></td>
                                        <td><input type="text" name="PackSize[]"></td>
                                    </tbody>
                                </table>
                            </div>         
                        </div>
                    </div>

                    <!-- ---grid-2 ----VOC Emission ----- -->

                    <div class="col-12">
                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                VOC Emission (0)
                                <button type="button" name="audit-agenda-grid" id="vocemission">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                                <div class="text-primary">The measurement units are tonnes.</div>
                                <div class="text-primary">Values below 0.001 should not be reported.</div>
                                <div class="text-primary">VOC is refer to Volatile Organic Compound</div>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="vocemission-Table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">Row#</th>
                                            <th style="width: 12%">VOC Name</th>
                                            <th style="width: 16%">VOC Quantity</th>
                                            <th style="width: 15%">Remarks </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>

                                        <td><input type="text" name="PrimaryPackaging[]"></td>
                                        <td><input type="text" name="Material[]"></td>
                                        <td><input type="text" name="PackSize[]"></td>
                                    </tbody>
                                </table>
                            </div>         
                        </div>
                    </div>


                    <!-- -------grid-3 ------heavy material-- -->


                    <div class="col-12">
                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                Heavy Material Emission (0)
                                <button type="button" name="audit-agenda-grid" id="heavymeterial">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                                <div class="text-primary">The measurement units are tonnes.</div>
                                <div class="text-primary">Values below 0.005 should not be reported.</div>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="heavymeterial-Table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">Row#</th>
                                            <th style="width: 12%">Heavy Material Name</th>
                                            <th style="width: 16%"> Heavy Material Quantity</th>
                                            <th style="width: 15%">Remarks </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>

                                        <td><input type="text" name="PrimaryPackaging[]"></td>
                                        <td><input type="text" name="Material[]"></td>
                                        <td><input type="text" name="PackSize[]"></td>
                                    </tbody>
                                </table>
                            </div>         
                        </div>
                    </div>


                    <!-- -------grid-4 -other-emission--------- -->


                    <div class="col-12">
                        <div class="group-input">
                            <label for="audit-agenda-grid">
                                Other Emission (Water) (0)
                                <button type="button" name="audit-agenda-grid" id="emissionother">+</button>
                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                                <div class="text-primary">The measurement units are tonnes.</div>
                                <div class="text-primary">Values below 1 should not be reported.</div>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="emissionother-Table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">Row#</th>
                                            <th style="width: 12%"> Other Emission Name</th>
                                            <th style="width: 16%"> Other Emission Quantity</th>
                                            <th style="width: 15%">Remark </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>

                                        <td><input type="text" name="PrimaryPackaging[]"></td>
                                        <td><input type="text" name="Material[]"></td>
                                        <td><input type="text" name="PackSize[]"></td>
                                    </tbody>
                                </table>
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
        </div>

        <!-- -----------------Chemical Waste------------- -->
        <div id="CCForm6" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">Chemical Waste</div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Short Description">Total Chemical Waste</label>

                            <input type="text">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Lead Auditor">Total Chemical Waste Units</label>

                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>Madhya Pradesh</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team"> Wasted Chemical</label>
                            <select multiple name="auditee" placeholder="Select Nature of Deviation" data-search="false" data-silent-initial-value-set="true" id="auditee">
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
                            <label for="Audit Team">Chamical Attached Document(s)</label>
                            <div class="file-attachment-field">
                                <div class="file-attachment-list" id="file_attach"></div>
                                <div class="add-btn">
                                    <div>Add</div>
                                    <input type="file" id="myfile" name="file_attach[]" oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="group-input">
                            <label for="Audit Team">Chemical Waste Comments</label>
                            <textarea name="text"></textarea>
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



        <!-------- Solid waste ------>
        <div id="CCForm7" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">
                    Hazardous waste
                </div>
                <div class="row">

                    <div class="col-lg-6">
                        <div class="group-input">
                            <!-- <label for="Due Date"> Directly/Indirectly Discharge </label>
                            <label for="Initiator Group">Initiator </label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option value="sandhya"></option>
                                <option value="sandhya"></option> -->
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <div class="text-primary ">Remarks are needed only if the figures of the current quarter are more then 10% higher or lower than those of the previous quarter. In this case the remarks should include an explanation.</div>
                        </div>
                    </div>
                    <div class="col-lg-6 pt-3">
                        <div class="group-input">
                            <label for="Audit End Date ">Landfill (Hazardous)</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 pt-3">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5">Landfill (Hazardous) Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>



                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">Incineration</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5"> Incineration Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>

                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">Recovery</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 1 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5"> Recovery (Hazardous) Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>
                    <!-- -------------------------------------sub-head------------------------------------------------- -->


                    <div class="sub-head">Non Hazardous Waste</div>
                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">Landfill</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 5 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5">Landfill Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>


                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">Incineration</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 5 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5">Incineration Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>



                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">Recovery</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 5 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5">Recovery Remark </label>
                            <input type="text" id="text" name="text">
                        </div>
                    </div>

                    <div class="col-lg-6 ">
                        <div class="group-input">
                            <label for="Audit End Date ">Land Farming</label>
                            <div class="text-primary">The measurement units are tonnes.</div>
                            <div class="text-primary">Values below 5 should not be reported.</div>
                            <input type="text" name="data">
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="group-input ">
                            <label for="Audit Attachments" class="pb-5">Land Farming Remark </label>
                            <input type="text" id="text" name="text">.
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

        <!-- Energy Consumption -->
        <div id="CCForm8" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">Energy Consumption</div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Short Description">Energy Usage</label>
                            <!-- <div class="text-primary">Water that consumed by employee</div> -->
                            <input type="text">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Lead Auditor">Frequacy of Energy Reading<< /label>
                                    <!-- <div class="text-primary">Please Choose the relevent units</div> -->
                                    <select>
                                        <option>Enter Your Selection Here</option>
                                        <option></option>
                                        <option></option>
                                    </select>
                        </div>
                    </div>
                    <div class="col-lg-6 pt-3">
                        <div class="group-input">
                            <label for="Audit Team" class="pb-1">Total Energy Cost</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Energy Attached Document(s)</label>
                            <small class="text-primary">
                                Please Attach all relevant or supporting documents
                            </small>
                            <div class="file-attachment-field">
                                <div class="file-attachment-list" id="file_attach"></div>
                                <div class="add-btn">
                                    <div>Add</div>
                                    <input type="file" id="myfile" name="file_attach[]" oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Gas (Natural)</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">LHV Gas</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Coal</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team"> LHV Coal</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Fuel Oil</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>8.0</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">LHV Fuel Oil</label>
                            <input type="text">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Extranal Steam</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">HIV Extranal Steam</label>
                            <input type="text">
                        </div>

                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Other (Energy)</label>
                            <input type="text">
                        </div>

                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Energy Comments</label>
                            <textarea name="text"></textarea>
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

        <!-- Recycling -->
        <div id="CCForm9" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">Recycling</div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Short Description">Paper</label>
                            <input type="text">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Lead Auditor">Paper Unit</label>
                            <!-- <div class="text-primary">Please Choose the relevent units</div> -->
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option value="unit"></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Plastic</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Plastic Unit</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option value="unit"></option>
                            </select>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Glass</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Glass Unit</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>8.0</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Wood</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Wood Unit</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>8.0</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Metal</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Metal Unit</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>8.0</option>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Other Factor</label>
                            <input type="text">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Other Factor Amount</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6 pt-3">
                        <div class="group-input">
                            <label for="Audit Team" class="pt-1">Other Factor Unit</label>
                            <select>
                                <option>Enter Your Selection Here</option>
                                <option>8.0</option>
                                <option></option>
                            </select>
                        </div>

                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Tea">Recycling Atteched Document(s)</label>
                            <small class="text-primary">
                                Please Attach all relevant or supporting documents
                            </small>
                            <div class="file-attachment-field">
                                <div class="file-attachment-list" id="file_attach"></div>
                                <div class="add-btn">
                                    <div>Add</div>
                                    <input type="file" id="myfile" name="file_attach[]" oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Audit Team">Recycling Comments</label>
                            <textarea name="text"></textarea>
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


        <!-- External Complaints -->
        <div id="CCForm10" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">External Complaints</div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="group-input">

                            <label for="Short Description">Number Of Odour</label>
                            <input type="text">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Lead Auditor">Number Of Noise</label>
                            <!-- <div class="text-primary">Please Choose the relevent units</div> -->
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Number Of Light (Flaring)</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Number Of Sood/Dust</label>
                            <input type="text">

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Number Of Other Complaints</label>
                            <input type="text">
                        </div>
                    </div>

                    <!-- 
--------------sub-head------- -->
                    <div class="sub-head">
                        Fines and Sanctions
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">Total Significant Fines</label>
                            <input type="text">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Team">No. of non-monetary sanctions</label>
                            <input type="text">
                        </div>
                    </div>


                    <div class="col-12">
                        <div class="group-input">
                            <label for="Audit Team"> Comments</label>
                            <textarea name="text"></textarea>
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


        <!-- Activity Log content -->
        <div id="CCForm11" class="inner-block cctabcontent">
            <div class="inner-block-content">
                <div class="sub-head">signatures</div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Schedule On"> Submitted By </label>
                            <div class=" static"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Audit Schedule On"> Submitted On </label>
                            <div class=" static"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Cancelled By">Approved By </label>
                            <div class=" static"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Cancelled On"> Approved On </label>
                            <div class=" static"></div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

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