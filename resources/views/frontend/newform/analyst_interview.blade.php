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
    function calculateRiskAnalysis(selectElement) {
        // Get the row containing the changed select element
        let row = selectElement.closest('tr');

        // Get values from select elements within the row
        let R = parseFloat(document.getElementById('analysisR').value) || 0;
        let P = parseFloat(document.getElementById('analysisP').value) || 0;
        let N = parseFloat(document.getElementById('analysisN').value) || 0;

        // Perform the calculation
        let result = R * P * N;

        // Update the result field within the row
        document.getElementById('analysisRPN').value = result;
    }
</script>

<div class="form-field-head">

    <div class="division-bar">
        <strong>Site Division/Project</strong> : {{ Helpers::getDivisionName(session()->get('division')) }}/Observation
    </div>
</div>

@php
$users = DB::table('users')->get();
@endphp
{{-- ======================================
                    DATA FIELDS
    ======================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Interview Under Progress</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Activity log</button>
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Activity log</button> -->
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button> -->
        </div>

        <form action="{{ route('observationstore') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="step-form">

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="sub-head">Parent record Information</div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) OOS No.</b></label>
                                    <input type="text" name="parent_oos_no">
                                </div>
                            </div>
                             <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) OOT No.</b></label>
                                    <input type="text" name="parent_oot_no">
                                </div>
                            </div>

                           
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">(Parent) Date Opened</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="parent_date_opened"  placeholder="DD-MM-YYYY" />
                                        <input type="date" id="start_date_checkdate" name="parent_date_opened" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'parent_date_opened');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) Short Description</b></label>
                                    <input type="text" required name="parent_short_description">
                                </div>
                            </div> -->

                            <div class="col-6">
                                    <div class="group-input">
                                        <label for="Short Description">(Parent) Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" name="parent_short_description" maxlength="255" required>
                                    </div>
                                </div>


                            <!-- <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">(Parent) Observation</label>
                                    <textarea name="parent_observation"></textarea>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Description">(Parent) Classification</label>
                                    <select name="parent_classification">
                                        <option value="">Enter Your Selection Here</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">(Parent) CAPA Taken/Proposed</label>
                                    <textarea name="parent_capa_taken_proposed"></textarea>
                                </div>
                            </div> -->

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">(Parent) Target Closure Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="parent_target_closure_date" readonly placeholder="DD-MM-YYYY" />
                                        <input type="date" id="start_date_checkdate" name="parent_target_closure_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'parent_target_closure_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent)Product/Material Name</b></label>
                                    <input type="text" name="parent_product_material_name">
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent)Analyst Name</b></label>
                                    <input type="text" name="parent_analyst_name">
                                </div>
                            </div>




                            <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                                (Parent) Info. On Product/Material..<button type="button" name="parent_info_on_product_material" id="product_material">+</button>
                            </label>
                            <table class="table table-bordered" id="product_material_body">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Row #</th>
                                        <th>Item/Product Code</th>
                                        <th>Lot/Batch Number</th>
                                        <th>A.R.Number</th>
                                        <th>Mfg.Date</th>
                                        <th>Expiry Date</th>
                                        <th>Label Claim</th>
                                        <th>Pack Size</th>
                                        <!-- <th>Action</th> -->
                                        {{-- <th>Instru. Caliberation Due Date</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                        <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                        <td><input type="text" name="parent_info_on_product_material[0][item_product_code]"></td>
                                        <td><input type="text" name="parent_info_on_product_material[0][lot_batch_number]"></td>
                                        <td><input type="text" name="parent_info_on_product_material[0][a_r_number]"></td>
                                        <td>
                                            <div class="col-lg-6 new-date-data-field">
                                                <div class="group-input input-date">

                                                    <div class="calenderauditee">
                                                        <input type="text" id="mfg_date" readonly placeholder="DD-MM-YYYY" />
                                                        <input type="date" id="start_date_checkdate" name="parent_info_on_product_material[0][mfg_date]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'mfg_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-lg-6 new-date-data-field">
                                                <div class="group-input input-date">
                                                    <div class="calenderauditee">
                                                        <input type="text" id="expiry_date" readonly placeholder="DD-MM-YYYY" />
                                                        <input type="date" id="start_date_checkdate" name="parent_info_on_product_material[0][expiry_date]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'expiry_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><input type="text" name="parent_info_on_product_material[0][label_claim]"></td>
                                        <td><input type="text" name="parent_info_on_product_material[0][pack_size]"></td>
                                        <!-- <td><button type="button" name="agenda" id="oos_details">Remove</button></td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                                (Parent) OOS Details <button type="button" name="parent_oos_details" id="oos_details">+</button>
                            </label>
                            <table class="table table-bordered" id="oos_details_body2">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Row #</th>
                                        <th>AR Number</th>
                                        <th>Test Name of OOS</th>
                                        <th>Results Obtained</th>
                                        <th>Specification Limit</th>
                                        {{-- <th>Instru. Caliberation Due Date</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                        <td><input type="text" name="parent_oos_details[0][ar_no]"></td>
                                        <td><input type="text" name="parent_oos_details[0][test_name_of_oos]"></td>
                                        <td><input type="text" name="parent_oos_details[0][results_obtained]"></td>
                                        <td><input type="text" name="parent_oos_details[0][specification_limit]"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                                (Parent) OOT Results <button type="button" name="parent_oot_results" id="oot_results">+</button>
                            </label>
                            <table class="table table-bordered" id="oot_results_body3">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Row #</th>
                                        <th>AR Number</th>
                                        <th>Test Name of OOT</th>
                                        <th>Result Obtained</th>
                                        <th>Initial Intervel Details</th>
                                        <th>Previous Interval Details</th>
                                        <th>%Difference of Results</th>
                                        <!-- <th>Initial Interview Details</th> -->
                                        <th>Trend Limit</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                        <td><input type="text" name="parent_oot_results[0][ar_no]"></td>
                                        <td><input type="text" name="parent_oot_results[0][test_name_of_oot]"></td>
                                        <td><input type="text" name="parent_oot_results[0][results_obtained]"></td>
                                        <td><input type="text" name="parent_oot_results[0][initial_intervel_details]"></td>
                                        <td><input type="text" name="parent_oot_results[0][previous_interval_details]"></td>
                                        <td><input type="text" name="parent_oot_results[0][difference_of_results]"></td>
                                        <!-- <td><input type="text" name="parent_oot_results[0]initial_interview_details"></td> -->
                                        <td><input type="text" name="parent_oot_results[0][trend_limit]"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                                (Parent) Details of Stability Study <button type="button" name="parent_details_of_stability_study" id="details_of_stability_study">+</button>
                            </label>
                            <table class="table table-bordered" id="details_of_stability_study_body4">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Row #</th>
                                        <th>AR Number</th>
                                        <th>Condition: Temperature & RH</th>
                                        <th>Interval</th>
                                        <th>Orientation</th>
                                        <th>Pack Details(if any)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][ar_no]"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][condition_temperature_&_rh]"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][interval]"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][orientation]"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][pack_details]"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    


                            <div class="sub-head">General Information</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Division Code</b></label>
                                    <input readonly type="text" name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    {{-- <div class="static">QMS-North America</div> --}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="originator">Initiator</label>
                                    <input disabled type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_opened">Date of Initiation</label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="Scheduled Start Date">Date Opened</label>
                            <div class="calenderauditee">
                                <input type="text" id="date_opened" readonly placeholder="DD-MM-YYYY" />
                                <input type="date" id="start_date_checkdate" name="date_opened" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'date_opened');checkDate('start_date_checkdate','end_date_checkdate')" />
                            </div>
                        </div>
                    </div>

                            <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="Scheduled Start Date">Target Closure Date</label>
                            <div class="calenderauditee">
                                <input type="text" id="target_closure_date" readonly placeholder="DD-MM-YYYY" />
                                <input type="date" id="start_date_checkdate" name="target_closure_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'target_closure_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- <div class="col-lg-6">
                        <div class="group-input">
                            <label for="RLS Record Number"><b>Short Description</b></label>
                            <input type="text" name="short_description">
                        </div>
                    </div> -->

                    <div class="col-6">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars2">255</span>
                                        characters remaining
                                        <input id="docname" type="text" name="short_description" maxlength="255" required>
                                    </div>
                                </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Assignee</b></label>
                                    <input type="text" name="assignee">
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Description</label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>

                            
                            <!-- <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Submit By</label>
                                    <input name="description"></input>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Submit On</label>
                                    <input name="description"></input>
                                </div>
                            </div> -->



                            <!-- <div class="group-input">
                                <label for="file_attchment_if_any">File Attachment</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="file_attchment_if_any"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="file_attchment_if_any[]" {{-- ignore --}} oninput="addMultipleFiles(this, 'file_attchment_if_any')" multiple>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Follow-up Task Submit By</b></label>
                                    <input type="text" name="assignee">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Follow-up Task Submit On</b></label>
                                    <input type="text" name="assignee">
                                </div>
                            </div> -->

                        </div>
                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                            <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                            <button type="button"> <a class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="sub-head">Analyst Interview</div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="Scheduled Start Date">Analyst Qualification  Date</label>
                            <div class="calenderauditee">
                                <input type="text" id="start_date" readonly placeholder="DD-MM-YYYY" />
                                <input type="date" id="start_date_checkdate" name="analyst_qualification_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                                Precautionary measures
                            </label>
                            <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 50%;">Question</th>
                                        <th style="width: 45%;">Response</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Is there any precautions mentioned in the method of analysis for sample and standard preparation?</td>
                                        <td><input type="text"></td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>Whether the test under investigation is performed by the analyst for first time?</td>
                                        <td><input type="text"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                               Mobile phase preparation
                            </label>
                            <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 50%;">Question</th>
                                        <th style="width: 45%;">Response</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>What are the chemicals used for mobile phase preparation?</td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>What is the acid/base used for buffer ph adjustment?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                     <tr>
                                        <td>3</td>
                                        <td>What is the buffer solution final ph observed value?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    <tr>
                                        <td>4</td>
                                        <td>Have you filtered the buffer solution? If Yes what is the MOC of the filter used?</td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Have you used mobile phase within the valid date?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    <tr>
                                        <td>6</td>
                                        <td>Mobile phase stability mentioned in the MOA(Hrs):</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                             Reference/Working Standards
                            </label>
                            <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 50%;">Question</th>
                                        <th style="width: 45%;">Response</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>What is the storage condition of working standard?(Specify)</td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>How long working standard kept in desiccator to attain room temperature?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                     <tr>
                                        <td>3</td>
                                        <td>What is nature of standard?(Light sensitive,moisture sensitive, oxygen sensitive or hygroscopic)</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    <tr>
                                        <td>4</td>
                                        <td>What precaution required while handling/analysis?</td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Whether LOD or Water content determination required before usage? If yes what is the results observed?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    <tr>
                                        <td>6</td>
                                        <td>Have you observed any spillage during weighing?</td>
                                        <td><input type="text"></td>
                                    </tr>
                                     <tr>
                                        <td>7</td>
                                        <td>Have you used working standard solution within the valid date?</td>
                                        <td><input type="text"></td>
                                    </tr>
                                      <tr>
                                        <td>8</td>
                                        <td>Working standard solution stability mentioned in the MOA?(specify hours):</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                             Handling of Samples
                            </label>
                            <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 50%;">Question</th>
                                        <th style="width: 45%;">Response</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Is there any special precaution mentioned in the method of analysis for sample handling?</td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Whether sample mixed/triturate thoroughly before weighing?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                     <tr>
                                        <td>3</td>
                                        <td>Is there any unusual observation on composite sample prepared?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    <tr>
                                        <td>4</td>
                                        <td>How you weighed the composite sample?</td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Have you observed any spillage during weighing?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    <tr>
                                        <td>6</td>
                                        <td>How you transferred the sample to volumetric glassware after weighing?</td>
                                        <td><input type="text"></td>
                                    </tr>
                                     <tr>
                                        <td>7</td>
                                        <td>Is there any unusual observation on sample solution after preparatio?</td>
                                        <td><input type="text"></td>
                                    </tr>
                                      <tr>
                                        <td>8</td>
                                        <td>Have you used correct volume of volumetric glassware?(specify the volume and number of glassware used)</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    <tr>
                                        <td>9</td>
                                        <td>Whether sample preparation involves sonication? If Yes, What is the time & temperature followed?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    <tr>
                                        <td>10</td>
                                        <td>Whether sample preparation involves intermittent shaking? If Yes, What is the time interval followed?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    <tr>
                                        <td>11</td>
                                        <td>What is the MOC of sample filter used? And How many filters used while sample preparation?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    <tr>
                                        <td>12</td>
                                        <td>Sample solution stability mentioned in the  MOA?(specify Hrs)</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    <tr>
                                        <td>13</td>
                                        <td>Please describe any abnormality noticed while performing weighing/pipetting/volume makeup/dilution etc.</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    <tr>
                                        <td>14</td>
                                        <td>Any other information related to testing?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                            Instrument Set up & handling
                            </label>
                            <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 50%;">Question</th>
                                        <th style="width: 45%;">Response</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Have you followed instrument set up instruction?</td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Have you verified solvent filters before placing mobile phase?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                     <tr>
                                        <td>3</td>
                                        <td>Specify the HPLC/GC column make/ID and total no. of previous injections.</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    <tr>
                                        <td>4</td>
                                        <td>How much time taken for column conditioning and instrument stabilization?</td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Any other information related to instrument set up?</td>
                                        <td><input type="text"></td>
                                    </tr> 
                                    </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="sub-head">Interviewer(s) Assessment</div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Interviewer(s) Assessment</label>
                            <textarea name="interviewer_assessment"></textarea>
                        </div>
                    </div> 
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Recommendations</label>
                            <textarea name="recommendations"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Delay justification</label>
                            <textarea name="delay_justification"></textarea>
                        </div>
                    </div> 
                     <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Any other Comments</label>
                            <textarea name="any_other_comments"></textarea>
                        </div>
                    </div>
                    <div class="group-input">
            <label for="file_attchment_if_any">File Attachment</label>
            <div><small class="text-primary">Please Attach all relevant or supporting
                    documents</small></div>
            <div class="file-attachment-field">
                <div class="file-attachment-list" id="file_attchment_if_any"></div>
                <div class="add-btn">
                    <div>Add</div>
                    <input type="file" id="myfile" name="file_attchment_if_any[]" {{-- ignore --}} oninput="addMultipleFiles(this, 'file_attchment_if_any')" multiple>
                </div>
            </div>
        </div>

        <!-- <div class="col-6">
                        <div class="group-input">
                            <label for="Description">Interview Done By</label>
                        </div>
                    </div>   
                     <div class="col-6">
                        <div class="group-input">
                            <label for="Description">Interview Done On</label>
                        </div>
                    </div> 


  <div class="col-6">
                        <div class="group-input">
                            <label for="Description">Cancel By</label>
                        </div>
                    </div>   
                     <div class="col-6">
                        <div class="group-input">
                            <label for="Description">Cancel On</label>
                        </div>
                    </div>  -->


                    
                 










                            <!-- <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Compliance Execution Details</label>
                                    <textarea name="compliance_execution_details"></textarea>
                                </div>
                            </div> -->

                            <!-- <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">Date of Completion</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="date_of_completion" readonly placeholder="DD-MM-YYYY" />
                                        <input type="date" id="start_date_checkdate" name="date_of_completion" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'date_of_completion');checkDate('start_date_checkdate','end_date_checkdate')" />
                                    </div>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="file_attchment_if_any">Execution Attachment</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="file_attchment_if_any"></div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="execution_attachment" {{-- ignore --}} oninput="addMultipleFiles(this, 'file_attchment_if_any')" multiple>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Delay Justification</label>
                                    <textarea name="delay_justification"></textarea>
                                </div>
                            </div>
  -->
                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Country">Execution Complete By</label>
                                    <input type="text" name="country">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Country">Execution Complete On</label>
                                    <input type="text" name="country">
                                </div>
                            </div> -->

                            <!-- {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="date_Response_due">Date Response Due</label>
                                        <input type="date" name="date_Response_due2" />
                                    </div>
                                </div> --}}
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date ">
                                    <label for="date_Response_due1">Date Response Due</label>
                                    <div class="calenderauditee">
                                        <input type="text" name="date_response_due1" id="date_Response_due" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="date_Response_due_checkdate" class="hide-input" oninput="handleDateInput(this, 'date_Response_due');checkDate('date_Response_due_checkdate','date_due_checkdate')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date ">
                                    <label for="date_due"> Due Date</label>
                                    <div class="calenderauditee">
                                        <input type="text" name="capa_date_due" id="date_due" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="date_due_checkdate" class="hide-input" oninput="handleDateInput(this, 'date_due');checkDate('date_Response_due_checkdate','date_due_checkdate')" />
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="date_due">Date Due</label>
                                        <input type="date" name="capa_date_due">
                                    </div>
                                </div> --}}
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="assign_to2">Assigned To</label>
                                    <select name="assign_to2">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="cro_vendor">CRO/Vendor</label>
                                        <select name="cro_vendor">
                                            <option value="">-- Select --</option>
                                            <option title="Amit Guru" value="1">
                                                Amit Guru
                                            </option>
                                            <option title="Shaleen Mishra" value="2">
                                                Shaleen Mishra
                                            </option>
                                            <option title="Vikas Prajapati" value="3">
                                                Vikas Prajapati
                                            </option>
                                            <option title="Anshul Patel" value="4">
                                                Anshul Patel
                                            </option>
                                            <option title="Amit Patel" value="5">
                                                Amit Patel
                                            </option>
                                            <option title="Madhulika Mishra" value="6">
                                                Madhulika Mishra
                                            </option>
                                            <option title="Jim Kim" value="7">
                                                Jim Kim
                                            </option>
                                            <option title="Akash Asthana" value="8">
                                                Akash Asthana
                                            </option>
                                            <option title="Not Applicable" value="9">
                                                Not Applicable
                                            </option>
                                            {{-- @foreach ($users as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach --}}
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-12">
                        <div class="group-input">
                            <label for="action-plan-grid">
                                Action Plan<button type="button" name="action-plan-grid" id="observation_table">+</button>
                            </label>
                            <table class="table table-bordered" id="observation">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Action</th>
                                        <th>Responsible</th>
                                        <th>Deadline</th>
                                        <th>Item Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                    <td><input type="text" name="action[]"></td>
                                    {{-- <td><input type="text" name="responsible[]"></td> --}}
                                    <td> <select id="select-state" placeholder="Select..." name="responsible[]">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}
                                            </option>
                                            @endforeach
                                        </select></td>
                                    {{-- <td><input type="text" name="deadline[]"></td> --}}
                                    <td>
                                        <div class="group-input new-date-data-field mb-0">
                                            <div class="input-date ">
                                                <div class="calenderauditee">
                                                    <input type="text" id="deadline' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" />
                                                    <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" name="deadline[]" class="hide-input" oninput="handleDateInput(this, `deadline' + serialNumber +'`)" />
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" name="item_status[]"></td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="comments">Comments</label>
                            <textarea name="comments"></textarea>
                        </div>
                    </div> -->
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                
                </div>
                </div>

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="sub-head">General Information</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Submit By :-</label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Submit On :-</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="sub-head">Interview Under Progress</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Interview Done By :-</label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Interview Done On :-</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div> 

                                <div class="sub-head">Cancellation</div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Cancel By :-</label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Cancel On :-</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>



                            <!-- <div class="col-12 mt-4">
                                <div class="sub-head">Compliance Verification</div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Verification Completed By</label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Verification Completed On</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed By">Cancellation Done By</label>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Cancellation Done On</label>
                                        {{-- <div class="static">17-04-2023 11:12PM</div> --}}
                                    </div>
                                </div>
                            </div>

 -->





                            <!-- {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="actual_start_date">Actual Start Date</label>
                                        <input type="date" name="actual_start_date">
                                    </div>
                                </div> --}}
                <div class="col-lg-6 new-date-data-field">
                    <div class="group-input input-date">
                        <label for="actual_start_date">Actual Start Date</label>
                        <div class="calenderauditee">
                            <input type="text" id="actual_start_date" readonly placeholder="DD-MMM-YYYY" />
                            <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="actual_start_date_checkdate" name="actual_start_date" class="hide-input" oninput="handleDateInput(this, 'actual_start_date');checkDate('actual_start_date_checkdate','actual_end_date_checkdate')" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6  new-date-data-field">
                    <div class="group-input input-date">
                        <label for="actual_end_date">Actual End Date</lable>
                            <div class="calenderauditee">
                                <input type="text" id="actual_end_date" placeholder="DD-MMM-YYYY" />
                                <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="actual_end_date_checkdate" name="actual_end_date" class="hide-input" oninput="handleDateInput(this, 'actual_end_date');checkDate('actual_start_date_checkdate','actual_end_date_checkdate')" />
                            </div>


                    </div>
                </div>
                <div class="col-12">
                    <div class="group-input">
                        <label for="action_taken">Action Taken</label>
                        <textarea name="action_taken"></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="sub-head">Response Summary</div>
                </div>
                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="date_response_due">Date Response Due</label>
                                        <input type="date" name="date_response_due1">
                                    </div>
                                </div> --}}
                {{-- <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date ">
                                        <label for="date_response_due">Date Response Due</label>
                                        <div class="calenderauditee">
                                            <input type="text" name="date_response_due1" id="date_response_due1" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                oninput="handleDateInput(this, 'date_response_due1')" />
            </div>
        </div>
    </div> --}}
    {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="response_date">Date of Response</label>
                                        <input type="date" name="response_date">
                                    </div>
                                </div> --}}
    {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="attach_files">Attached Files</label>
                                        <input type="file" name="attach_files2">
                                    </div>
                                </div> --}}
    <div class="col-12">
        <div class="group-input">
            <label for="attach_files">Attached Files</label>
            <div><small class="text-primary">Please Attach all relevant or supporting
                    documents</small></div>
            <div class="file-attachment-field">
                <div class="file-attachment-list" id="attach_files2"></div>
                <div class="add-btn">
                    <div>Add</div>
                    <input type="file" id="myfile" name="attach_files2[]" oninput="addMultipleFiles(this, 'attach_files2')" multiple>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="group-input">
            <label for="related_url">Related URL</label>
            <input type="url" name="related_url">
        </div>
    </div>
    <div class="col-12">
        <div class="group-input">
            <label for="response_summary">Response Summary</label>
            <textarea name="response_summary"></textarea>
        </div>
    </div> -->
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Completed_By">Completed By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Completed_On">Completed On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA_Approved_By">QA Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA_Approved_On">QA Approved On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_By">Final Approval By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_On">Final Approval On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="submit">Submit</button>
                            <button type="button"> <a class="text-white" href="{{ url('dashboard') }}"> Exit </a>
                            </button>
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
    VirtualSelect.init({
        ele: '#Facility, #Group, #Audit, #Auditee'
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
    $(document).ready(function() {
        $('#observation_table').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);
                console.log(users);
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="action[]"></td>' +
                    '<td><select name="responsible[]">' +
                    '<option value="">Select a value</option>';

                for (var i = 0; i < users.length; i++) {
                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }

                html += '</select></td>' +
                    // '<td><input type="date" name="deadline[]"></td>' +
                    '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="deadline' + serialNumber + '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="deadline[]" class="hide-input" oninput="handleDateInput(this, `deadline' + serialNumber + '`)" /></div></div></div></td>' +

                    '<td><input type="text" name="item_status[]"></td>' +
                    '</tr>';



                return html;
            }

            var tableBody = $('#observation tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>





<script>
    $(document).ready(function() {
        // 3

        $('#product_material').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="parent_info_on_product_material[0][item_product_code]"></td>' +
                    '<td><input type="text" name="parent_info_on_product_material[0][lot_batch_number]"></td>' +
                    '<td><input type="text" name="parent_info_on_product_material[0][a_r_number]"></td>' +
                    '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="mfg_date" readonly placeholder="DD-MM-YYYY" /><input type="date" name="parent_info_on_product_material[0][mfg_date]" min="{{ \Carbon\Carbon::now()->format('Y-m-d')}}" class="hide-input" oninput="handleDateInput(this, mfg_date);" /></div></div></div></td>' +
                    '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="expiry_date" readonly placeholder="DD-MM-YYYY" /><input type="date" name="parent_info_on_product_material[0][expiry_date]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, expiry_date);" /></div></div></div></td>' +
                    '<td><input type="text" name="parent_info_on_product_material[0][label_claim]"></td>' +
                    '<td><input type="text" name="parent_info_on_product_material[0][pack_size]"></td>' +

                    '</tr>';
                return html;
            }
            var tableBody = $('#product_material_body tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            // var newRow = generateTableRow(rowCount - 1);
            tableBody.append(newRow); 
            
           
        });


        $('#oos_details').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="parent_oos_details[0][ar_no]"></td>' +
                    '<td><input type="text" name="parent_oos_details[0][test_name_of_oos]"></td>' +
                    '<td><input type="text" name="parent_oos_details[0][results_obtained]"></td>' +
                    '<td><input type="text" name="parent_oos_details[0][specification_limit]"></td>' +
                    '</tr>';
                return html;
            }
            var tableBody = $('#oos_details_body2 tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });

        $('#oot_results').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    // '<td><input type="date" name="date[]"></td>' +
                    '<td><input type="text" name="parent_oot_results[0][ar_no]"></td>' +
                    '<td><input type="text" name="parent_oot_results[0][test_name_of_oot]"></td>' +
                    '<td><input type="text" name="parent_oot_results[0][results_obtained]"></td>' +
                    '<td><input type="text" name="parent_oot_results[0][initial_intervel_details]"></td>' +
                    '<td><input type="text" name="parent_oot_results[0][previous_interval_details]"></td>' +
                    // '<td><input type="text" name="difference_of_results"></td>' +
                    '<td><input type="text" name="parent_oot_results[0][difference_of_results]"></td>' +
                    '<td><input type="text" name="parent_oot_results[0][trend_limit]"></td>' +
                    '</tr>';
                return html;
            }
            var tableBody = $('#oot_results_body3 tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });

        $('#details_of_stability_study').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[0][ar_no]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[0][condition_temperature_&_rh]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[0][interval]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[0][orientation]"></td>' +
                    '<td><input type="text" name="parent_details_of_stability_study[0][pack_details]"></td>' +
                    '</tr>';
                return html;
            }
            var tableBody = $('#details_of_stability_study_body4 tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });








        $('#check_detail ').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);
                console.log(users);
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber +
                    '"></td>' +
                    '<td><input type="text" name="record[]">' +
                    '<td><input type="text" name="short_description[]">' +
                    '<td><input type="date" name="date_opened[]">' +
                    '<td><input type="text" name="site[]">' +
                    '<td><input type="date" name="date_due[]">' +
                    '<td><input type="text" name="current_status[]">' +
                    '<td><select name="responsible_person[]">' +
                    '<option value="">Select a value</option>';

                for (var i = 0; i < users.length; i++) {
                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }

                html += '</select></td>' +
                    '<td><input type="date" name="date_closed[]"></td>' +
                    '</tr>';
                return html;
            }

            var tableBody = $('#check_detail_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
        $('#check_plan12').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);
                console.log(users);
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="mitigation_steps[]"></td>' +
                    '<td><input type="date" name="deadline2[]"></td>' +
                    '<td><select name="responsible_person[]">' +
                    '<option value="">Select a value</option>';

                for (var i = 0; i < users.length; i++) {
                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }

                html += '</select></td>' +
                    '<td><input type="text" name="status[]"></td>' +
                    '<td><input type="text" name="remark[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#check_plan_details12 tbody');
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