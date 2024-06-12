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
        / Serious Adverse Event
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

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">SAE</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">SAE Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Activity Log</button>
        </div>

        <form action="{{ route('serious_store') }}" method="POST" enctype="multipart/form-data">
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
                            <!-- General Information -->
                        </div>
                         <!-- RECORD NUMBER -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input type="hidden" name="record_number">
                                    <input disabled type="text"
                                     name="record_number" value="{{ Helpers::getDivisionName(session()->get('division')) }}/SAE/{{ date('Y') }}/{{ $record_number }}">
                                        {{-- value="{{ $data->division_code }}/OBS/{{ Helpers::year($data->created_at) }}/{{ $data->record }}"> --}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input readonly type="text" name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    {{-- <div class="static">QMS-North America</div> --}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Initiator</b></label>
                                    <input disabled type="text" name="" value="{{ Auth::user()->name }}">

                                </div>
                            </div>


                            {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Due Date"> Date Opened</label>

                                        @if (!empty($cc->due_date))
                                        <div class="static"></div>
                                        @endif
                                    </div>
                                </div> --}}


                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date of Initiation<span class="text-danger"></span></label>
                                    <!-- <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="" name="due_date"> -->
                                    <div class="calenderauditee">
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="date_of_initiation">
                                        <input  type="hidden" value="{{ date('Y-m-d') }}" name="date_of_initiation">
                                        {{-- <input type="text" disabled id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input disabled type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" /> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" maxlength="255">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">

                                    <label for="Short Description"> Assigned To<span class="text-danger"></span></label>
                                    <select name="assign_to">
                                        <option value="">--Select--</option>
                                        <option value="Pankaj jat">Pankaj jat</option>
                                        <option value="Gourav">Gourav</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Due Date<span class="text-danger"></span></label>
                                    <p class="text-primary">Please mention expected date of completion</p>
                                    <!-- <input type="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            value="" name="due_date"> -->
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" />
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">

                                    <label for="Short Description"> Type<span class="text-danger"></span></label>
                                    <select name="type">
                                        <option value="">--Select--</option>
                                        <option value="SAE">SAE</option>
                                        <option value="RWD">RWD</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="File Attachments">File Attachments</label>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="file_attach[]" oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                        </div>
                                    </div>
                                    {{-- <input type="file" name="file_attach[]" multiple> --}}
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Description"> Description<span class="text-danger"></span></label>
                                    <textarea name="description"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Comments"> Comments<span class="text-danger"></span></label>
                                    <textarea name="comments"></textarea>
                                </div>
                            </div>

                            <div class="sub-head">Location</div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Zone">Zone</label>
                                    <select name="zone">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="Asia">Asia</option>
                                        <option value="Europe">Europe</option>
                                        <option value="Africa">Africa</option>
                                        <option value="Central America">Central America</option>
                                        <option value="South America">South America</option>
                                        <option value="Oceania">Oceania</option>
                                        <option value="North America">North America</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Country">Country</label>
                                    <select name="country" class="form-select country" aria-label="Default select example"
                                        onchange="loadStates()">
                                        <option selected>Select Country</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="City">State</label>
                                    <select name="state" class="form-select state" aria-label="Default select example"
                                        onchange="loadCities()">
                                        <option selected>Select State/District</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="State/District">City</label>
                                    <select name="city" class="form-select city" aria-label="Default select example">
                                        <option selected>Select City</option>
                                    </select>
                                </div>
                            </div>
                            <script>
                                var config = {
                                    cUrl: 'https://api.countrystatecity.in/v1',
                                    ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
                                };

                                var countrySelect = document.querySelector('.country'),
                                    stateSelect = document.querySelector('.state'),
                                    citySelect = document.querySelector('.city');

                                function loadCountries() {
                                    let apiEndPoint = `${config.cUrl}/countries`;

                                    $.ajax({
                                        url: apiEndPoint,
                                        headers: {
                                            "X-CSCAPI-KEY": config.ckey
                                        },
                                        success: function(data) {
                                            data.forEach(country => {
                                                const option = document.createElement('option');
                                                option.value = country.iso2;
                                                option.textContent = country.name;
                                                countrySelect.appendChild(option);
                                            });
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error loading countries:', error);
                                        }
                                    });
                                }

                                function loadStates() {
                                    stateSelect.disabled = false;
                                    stateSelect.innerHTML = '<option value="">Select State</option>';

                                    const selectedCountryCode = countrySelect.value;

                                    $.ajax({
                                        url: `${config.cUrl}/countries/${selectedCountryCode}/states`,
                                        headers: {
                                            "X-CSCAPI-KEY": config.ckey
                                        },
                                        success: function(data) {
                                            data.forEach(state => {
                                                const option = document.createElement('option');
                                                option.value = state.iso2;
                                                option.textContent = state.name;
                                                stateSelect.appendChild(option);
                                            });
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error loading states:', error);
                                        }
                                    });
                                }

                                function loadCities() {
                                    citySelect.disabled = false;
                                    citySelect.innerHTML = '<option value="">Select City</option>';

                                    const selectedCountryCode  = countrySelect.value;
                                    const selectedStateCode = stateSelect.value;

                                    $.ajax({
                                        url: `${config.cUrl}/countries/${selectedCountryCode}/states/${selectedStateCode}/cities`,
                                        headers: {
                                            "X-CSCAPI-KEY": config.ckey
                                        },
                                        success: function(data) {
                                            data.forEach(city => {
                                                const option = document.createElement('option');
                                                option.value = city.id;
                                                option.textContent = city.name;
                                                citySelect.appendChild(option);
                                            });
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error loading cities:', error);
                                        }
                                    });
                                }
                                $(document).ready(function() {
                                    loadCountries();
                                });
                            </script>



                            {{-- <div class="col-lg-6">
                                <div class="group-input"> --}}

                                    {{-- <label for="Zone"> Zone<span class="text-danger"></span></label>
                                    <select name="zone">
                                        <option value="">--Select Zone--</option>
                                        <option value="Asia">Asia</option>
                                        <option value="Europe">Europe</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">

                                    <label for="Country"> Country<span class="text-danger"></span></label>
                                    <select name="country">
                                        <option value="">--Select Country--</option>
                                        <option value="India">India</option>
                                        <option value="USA">USA</option>
                                        </select>
                                        </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="group-input">

                                                <label for="State/District"> State/District<span class="text-danger"></span></label>
                                                <select name="state">
                                                    <option value="">--Select State--</option>
                                                    <option value="Mp">Mp</option>
                                                    <option value="Gujrat">Gujrat</option>
                                                    </select>
                                                    </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="group-input">

                                                            <label for="City"> City<span class="text-danger"></span></label>
                                                            <select name="city">
                                                                <option value="">--Select City--</option>
                                                                <option value="Indore">Indore</option>
                                                                <option value="Bhopal">Bhopal</option>
                                                            </select>
                                                        </div>
                                                    </div> --}}

                                                    <div class="col-lg-6">
                                                        <div class="group-input">

                                    <label for="Site Name"> Site Name<span class="text-danger"></span></label>
                                    <select name="site_name">
                                        <option value="">--Select Site Name--</option>
                                        <option value="Pharma">Pharma</option>
                                        <option value="IT">IT</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">

                                    <label for="Building"> Building<span class="text-danger"></span></label>
                                    <select name="building">
                                        <option value="">--Select Building--</option>
                                        <option value="Pu-4">Pu-4</option>
                                        <option value="Pu-5">Pu-5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">

                                    <label for="Floor"> Floor<span class="text-danger"></span></label>
                                    <select name="floor">
                                        <option value="">--Select Floor--</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Room"> Room<span class="text-danger"></span></label>
                                    <select name="room">
                                        <option value="">--Select Room--</option>
                                        <option value="C-101">C-101</option>
                                        <option value="C-102">C-102</option>
                                    </select>
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



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Number (ID)">Number (ID)</label>
                                    <input name="number" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Project Code">Project Code</label>
                                    <input name="project_code" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Primary SAE">Primary SAE</label>
                                    <input name="primary_sae" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="SAE Number">SAE Number</label>
                                    <input name="Sae_number" />
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Severity Rate">Severity Rate<span class="text-danger"></span></label>
                                    <select name="severity_rate">
                                        <option value="">--Select Severity Rate--</option>
                                        <option value="101">101</option>
                                        <option value="102">102</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Occurence"> Occurence<span class="text-danger"></span></label>
                                    <select name="occurance">
                                        <option value="">--Select Occurence--</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Detection"> Detection<span class="text-danger"></span></label>
                                    <select name="detection">
                                        <option value="">--Select Detection--</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RPN">RPN<span class="text-danger"></span></label>
                                    <select name="RPN">
                                        <option value="">--Select RPN--</option>
                                        <option value="pankaj">pankaj</option>
                                        <option value="jat">jat</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Protocol Type"> Protocol Type<span class="text-danger"></span></label>
                                    <select name="protocol_type">
                                        <option value="">--Select Protocol Type--</option>
                                        <option value="select">select</option>
                                        <option value="select1">select1</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Reportability"> Reportability<span class="text-danger"></span></label>
                                    <select name="reportability">
                                        <option value="">--Select Reportability--</option>
                                        <option value="123">123</option>
                                        <option value="1234">1234</option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CROM"> CROM<span class="text-danger"></span></label>
                                    <select name="crom">
                                        <option value="">--Select CROM--</option>
                                        <option value="C-A">C-A</option>
                                        <option value="C-B">C-B</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Lead Investigator"> Lead Investigator<span class="text-danger"></span></label>
                                    <select name="lead_investigator">
                                        <option value="">--Select Lead Investigator--</option>
                                        <option value="Pankaj">Pankaj</option>
                                        <option value="Gaurav">Gaurav</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Follow-up Information"> Follow-up Information<span class="text-danger"></span></label>
                                    <select name="follow_up_information">
                                        <option value="">--Select Follow-up Information--</option>
                                        <option value="AB-1">AB-1</option>
                                        <option value="AB-2">AB-2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Route Of Administration">Route Of Administration<span class="text-danger"></span></label>
                                    <select name="route_of_administration">
                                        <option value="">--Select Route Of Administration--</option>
                                        <option value="SAE">SAE</option>
                                        <option value="SAR">SAR</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Carbon Copy List"> Carbon Copy List<span class="text-danger"></span></label>
                                    <select name="carbon_copy_list">
                                        <option value="">--Select Carbon Copy List--</option>
                                        <option value="C-101">C-101</option>
                                        <option value="C-102">C-102</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Comments"> Comments<span class="text-danger"></span></label>
                                    <textarea name="comments2"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Primary SAE">Primary SAE</label>
                                    <input name="primary_sae2"/>
                                </div>
                            </div>
                            <div class="sub-head">Product Information</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Manufacturer">Manufacturer</label>
                                    <input name="manufacturer" />
                                </div>
                            </div>
                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Product/Material (0)
                                    <button type="button" name="product" id="ObservationAdd">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        Open
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="onservation-field-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Product Name</th>
                                                <th style="width: 16%"> Batch Number</th>
                                                <th style="width: 15%">Expiry Date</th>
                                                <th style="width: 15%">Manufactured Date</th>
                                                <th style="width: 15%">Disposition </th>
                                                <th style="width: 15%">Comment</th>
                                                <th style="width: 15%">Remarks</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td><input disabled type="text" name="product[0][serial]" value="1"></td>

                                            <td><input type="text" name="product[0][ProductName]"></td>
                                            <td><input type="text" name="product[0][BatchNumber]"></td>
                                            <td><input type="date" name="product[0][ExpiryDate]"></td>
                                            <td><input type="date" name="product[0][ManufacturedDate]"></td>
                                            <td><input type="text" name="product[0][Disposition]"></td>
                                            <td><input type="text" name="product[0][Comment]"></td>
                                            <td><input type="text" name="product[0][Remarks]"></td>

                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="sub-head">Important Dates</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Awareness Date">Awareness Date</label>
                                    <input type="date" name="awareness_date" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CROM Safety Report App On">CROM Safety Report App On</label>
                                    <input type="date" name="crom_saftey_report_app_on"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date CROM Concurred"> Date CROM Concurred</label>
                                    <input type="date" name="date_crom_concurred"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Draft SR Sent">Date Draft SR Sent</label>
                                    <input type="date" name="date_draft_sr_sent" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date MM Concurred">Date MM Concurred</label>
                                    <input type="date" name="date_mm_concurred"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Of Event Resolution">Date Of Event Resolution</label>
                                    <input type="date" name="date_of_event_resolution"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date PI Concurred">Date PI Concurred</label>
                                    <input type="date" name="date_pi_concurred"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Recieved">Date Recieved</label>
                                    <input type="date" name="date_recieved"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Safety Assessment Sent">Date Safety Assessment Sent</label>
                                    <input type="date" name="date_safety_assessment_sent"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Sent To RA">Date Sent To RA</label>
                                    <input type="date" name="date_sent_to_ra"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Sent To Sites">Date Sent To Sites</label>
                                    <input type="date" name="date_sent_to_sites"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="SAE Onset Date">SAE Onset Date</label>
                                    <input type="date" name="sae_onset_date"/>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="MM Safety Report Approved On">MM Safety Report Approved On</label>
                                    <input type="date" name="mm_saftey_report_approved_on"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="PI Safety Report Approved On">PI Safety Report Approved On</label>
                                    <input type="date" name="pi_saftey_report_approved_on"/>
                                </div>
                            </div>
                            <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>

                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">

                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Closed by">Closed By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Closed on">Closed On</label>
                                        <div class="Date"></div>
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
        $(document).ready(function() {
            $('#ObservationAdd').click(function(e) {
                function generateTableRow(serialNumber) {


                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +'"></td>' +
                       '<td><input type="text" name="product[0][ProductName]" ></td>'+
                         '<td><input type="text" name="product[0][BatchNumber]"></td>'+
                         '<td><input type="date" name="product[0][ExpiryDate]"></td>'+
                         '<td><input type="date" name="product[0][ManufacturedDate]"></td>'+
                        '<td><input type="text" name="product[0][Disposition]"></td>'+
                         '<td><input type="text" name="product[0][Comment]"></td>'+
                         '<td><input type="text" name="product[0][Remarks]"></td>'+
                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                    // html += '</select></td>' +

                        '</tr>';

                    return html;
                }

                var tableBody = $('#onservation-field-table tbody');
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
