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
        / Lab Test
    </div>
</div>



<script>
    $(document).ready(function() {
        $('#Equipment').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="ProductName[]"></td>' +
                    '<td><input type="number" name="BatchNumber[]"></td>' +
                    '<td><input type="date" name="ExpiryDate[]"></td>' +
                    '<td><input type="date" name="ManufacturedDate[]"></td>' +
                    '<td><input type="number" name="NumberOfItemsNeeded[]"></td>' +
                    '<td><input type="text" name="Exist[]"></td>' +
                    '<td><input type="text" name="Comment[]"></td>' +


                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                //     '</tr>';

                return html;
            }

            var tableBody = $('#Equipment_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
@php
    $users = DB::table('users')->get();
@endphp

{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Lab Test</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Signature</button>

        </div>

        <form action="{{ route('labstore.index') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                <!-- Tab content -->
                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">
                            General Information
                        </div> <!-- RECORD NUMBER -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="originator">Originator</label>
                                    <input disabled type="text" name="originator_id"
                                            value="{{ $lab->originator_id ?? Auth::user()->name }}">


                                    {{-- <input disabled type="text" name="originator_id" value="" /> --}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input ">
                                    <label for="Date Due"><b>Date Opened</b></label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Product">Product</label>
                                    <input type="text" name="product" id="product" value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Originator"><b>Record Number</b></label>
                                    <input  type="text" name="record_number"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/LT/{{ date('Y') }}/{{ $record_number }}">
                                </div>
                            </div>



                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span>
                                        <input id="short_description" type="text" name="short_description" maxlength="255"
                                        required>


                                    {{-- <label for="Short Description">Short Description</label>
                                    <input type="text" name="short_description" id="short_description" value=""> --}}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="If Others">Assigned To</label>
                                    <select name="assigned_to" onchange="">

                                        <option value="">Select a value</option>
                                        <option value="">-- select --</option>
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $user)
                                                    <option value='{{ $user->id }}'>{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                        {{-- <option value="">-- select --</option>
                                        <option value=""></option> --}}

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Due Date">Date Due</label>

                                    <div class="calenderauditee">

                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />

                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>


                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Priority Level">Priority Level</label>
                                    <select name="priority_level" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="level1">level 1</option>
                                        <option value="level2">level 2</option>
                                        <option value="level3">level 3</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type of Product">Type of Product</label>
                                    <select name="type_of_product" onchange="">

                                        <option value="">-- select --</option>
                                        <option value="Product1">Product 1</option>
                                        <option value="Product2">Product 2</option>
                                        <option value="Product3">Product 3</option>



                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Internal Product Test Info">Internal Product Test Info</label>
                                    <textarea class="" name="internal_product_test_info" id="">
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Comments">Comments</label>
                                    <textarea class="" name="comments" id="">
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Internal Test Conclusion">Internal Test Conclusion</label>
                                    <textarea class="" name="internal_test_conclusion" id="">
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Reviewer Comments">Reviewer Comments</label>
                                    <textarea class="" name="reviewer_comments" id="">
                                    </textarea>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Action Summary">Action Summary</label>
                                    <textarea class="" name="action_summary" id="">
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Lab Test Summary">Lab Test Summary</label>
                                    <textarea class="" name="lab_test_summary" id="">
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Attached File">Attached File</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="HOD_Attachments" name="file_attachment[]"
                                                oninput="addMultipleFiles(this, 'file_attachment')" multiple>

                                            {{-- <input type="file" id="myfile" name="file_attachment" oninput="" multiple> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Related URLs">Related URLs</label>
                                    <select name="related_urls" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="URL1">URL 1</option>
                                        <option value="URL2">URL 2</option>
                                        <option value="URL3">URL 3</option>


                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Related Records">Related Records</label>
                                    <select name="related_records" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="Record1">Record 1</option>
                                        <option value="Record2">Record 2</option>
                                        <option value="Record3">Record 3</option>

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="button-block">

                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                </a> </button>
                        </div>
                    </div>
                </div>

            <div id="CCForm2" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="sub-head">
                        Activity Log
                    </div>
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Submitted by">Submitted by</label>

                            </div>
                        </div>

                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Submitted on"> Submitted on </label>



                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Cancel By">Cancel By</label>

                            </div>
                        </div>
                        <div class="col-lg-6 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Cancel on">Cancel on </label>


                            </div>
                        </div>


                         </div>

                         <div class="row">

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Submitted by"> Internal Product Test by</label>

                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Submitted on">  Internal Product Test on</label>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Cancel By"> Demand Product
                                        Improvement By</label>

                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Cancel on"> Demand Product Improvement on </label>

                                </div>
                            </div>
                             </div>

                             <div class="row">

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Submitted by"> OK External Testing by</label>

                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Submitted on">  OK External Testing on</label>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Cancel By">  Not OK By</label>

                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Cancel on">Not OK on </label>
                                    </div>
                                </div>
                                 </div>


                                 <div class="row">
                                      <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Submitted by"> OK Panel  External Testing by</label>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Submitted on"> OK Panel  External Testing on</label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Cancel By">  Product Quality Validated By</label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Cancel on">  Product Quality Validated on </label>
                                        </div>
                                    </div>
                                     </div>

                                     <div class="row">
                                        <div class="col-lg-6">
                                          <div class="group-input">
                                              <label for="Submitted by">  Product Quality Not
                                                Validated by</label>

                                          </div>
                                      </div>

                                      <div class="col-lg-6 new-date-data-field">
                                          <div class="group-input input-date">
                                              <label for="Submitted on">  Product Quality Not
                                                Validated on</label>

                                          </div>
                                      </div>
                                      <div class="col-lg-6">
                                          <div class="group-input">
                                              <label for="Cancel By"> Action Needed By</label>

                                          </div>
                                      </div>
                                      <div class="col-lg-6 new-date-data-field">
                                          <div class="group-input input-date">
                                              <label for="Cancel on"> Action Needed on </label>
                                          </div>
                                      </div>
                                       </div>

                                       <div class="row">
                                        <div class="col-lg-6">
                                          <div class="group-input">
                                              <label for="Submitted by">Conduct Product Conclusion by</label>

                                          </div>
                                      </div>

                                      <div class="col-lg-6 new-date-data-field">
                                          <div class="group-input input-date">
                                              <label for="Submitted on">Conduct Product Conclusion on</label>

                                          </div>
                                      </div>
                                      <div class="col-lg-6">
                                          <div class="group-input">
                                              <label for="Cancel By"> Review By</label>

                                          </div>
                                      </div>
                                      <div class="col-lg-6 new-date-data-field">
                                          <div class="group-input input-date">
                                              <label for="Cancel on">  Review on </label>
                                          </div>
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
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>
@endsection
