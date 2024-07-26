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
        <strong>Site Division/Project</strong> : {{ Helpers::getDivisionName(session()->get('division')) }}/hypothesis
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

        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head">Record Workflow </div>

                <div class="d-flex" style="gap:20px;">
                    @php
                        $userRoles = DB::table('user_roles')
                            ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' =>1])->get();
                            
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp

                    {{-- <button class="button_theme1" onclick="window.print();return false;"
                        class="new-doc-btn">Print</button> --}}
                    {{-- <button class="button_theme1"> <a class="text-white" href=""> --}}
                            {{-- {{ url('DeviationAuditTrial', $data->id) }} --}}

                            <button class="button_theme1"> <a class="text-white" href="{{ url('hypothesisAuditTrial', $hypothesis->id) }}" >
                                Audit Trail </a> </button>

                    @if ($hypothesis->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Submit
                    </button>
                    
                    @elseif ($hypothesis->stage == 2 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                        More Info Required
                    </button>

                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Hypothesis QC Proposal Complete
                    </button> 
                
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Cancel
                    </button>
                    @elseif ($hypothesis->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds))) 
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                        More Info Required
                    </button>

                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Hypothesis AQA Review Complete
                    </button>
                    
                    @elseif($hypothesis->stage == 4 &&(in_array(5, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))
                    
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Under Hypothesis Execution Complete
                    </button>

                    @elseif ($hypothesis->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                        More Info Required
                    </button>

                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Hypothesis Execution QC Review Complete
                    </button> 

                    @elseif ($hypothesis->stage == 6 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                        More Info Required
                    </button>
                    
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Hypothesis Execution AQA Review Complete
                    </button> 
                    
                    @elseif ($hypothesis->stage == 7 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                @endif 
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>
                </div>
            </div>

{{-- =============================================================================================================== --}}
            <div class="status">
                <div class="head">Current Status</div>
                @if ($hypothesis->stage == 0) 
                <div class="progress-bars ">
                    <div class="bg-danger">Closed-Cancelled</div>
                </div> 

                @else 
                <div class="progress-bars d-flex" style="font-size: 15px;">
                    @if ($hypothesis->stage >= 1)
                    <div class="active">Opened</div>
                    @else 
                    <div class="">Opened</div> 
                    @endif

                    @if ($hypothesis->stage >= 2)
                    <div class="active">Under Hypothesis QC Proposal</div>
                    @else
                    <div class="">Under Hypothesis QC Proposal</div>
                    @endif 

                    @if ($hypothesis->stage >= 3) 
                    <div class="active">Under Hypothesis AQA Review</div> 
                    @else 
                    <div class="">Under Hypothesis AQA Review</div>
                    @endif 

                    @if ($hypothesis->stage >= 4)
                    <div class="active">Under Hypothesis Execution</div> 
                    @else
                    <div class="">Under Hypothesis Execution</div>
                    @endif 

                    @if ($hypothesis->stage >= 5) 
                    <div class="active">Under Hypothesis Execution QC Review</div> 
                    @else 
                    <div class="">Under Hypothesis Execution QC Review</div>
                    @endif

                    @if ($hypothesis->stage >= 6)
                    <div class="active">Under Hypothesis Execution AQA Review</div> 
                    @else 
                    <div class="">Under Hypothesis Execution AQA Review</div>
                    @endif

                    @if ($hypothesis->stage >= 7) 
                    <div class="bg-danger">Close-Done</div>
                    @else 
                    <div class="">Close-Done</div>
                    @endif  
                    @endif 

                    {{-- <div class="progress-bars d-flex" style="font-size: 15px;">
                        <div class="{{ $renewal->stage >= 1 ? 'active' : '' }}">Opened</div>
            
                        <div class="{{ $renewal->stage >= 2 ? 'active' : '' }}">Submission Preparation</div>
            
                        <div class="{{ $renewal->stage >= 3 ? 'active' : '' }}">Pending Submission Review</div>
            
                        <div class="{{ $renewal->stage >= 4 ? 'active' : '' }}">Authority Assessment</div>
            
                        @if ($renewal->stage == 5)
                            <div class="bg-danger">Closed - Withdrawn</div>
                        @elseif ($renewal->stage == 6)  
                            <div class="bg-danger">Closed - Not Approved</div>
                        @elseif ($renewal->stage == 8)
                            <div class="bg-danger">Approved</div>
                        @elseif ($renewal->stage == 9)
                            <div class="bg-danger">Closed - Retired</div>
                        @else
                            <div class="{{ $renewal->stage >= 7 ? 'active' : '' }}">Pending Registration Update</div>
                        @endif
                    </div>
                @endif --}}

                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Under Hypothesis/Experiment QC Proposal
            </button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Under Hypo/Exp.AQA Review</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Under Hypo/Exp. Execution
            </button> <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Under Hypo/Exp. Exe.QC Review
            </button> <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Under Hypo/Exp. Exe.AQA Review
            </button> <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Activity log</button>
        </div>

        <form action="{{ route('hypothesis.update', $hypothesis->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="step-form">

                <!-- General information content -->
                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            @if (!empty($parent_id))
                                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                                    <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                                @endif
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                        value="{{ Helpers::getDivisionName($hypothesis->division_id) }}/HYPO/{{ Helpers::year($hypothesis->created_at) }}/{{ $hypothesis->record }}">  --}}
                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                    {{-- </div>
                                </div> --}}


                            <div class="col-12">
                                <div class="sub-head">Parent record Information</div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) OOS No.</b></label>
                                    <input type="text" name="parent_oos_no" value="{{$hypothesis->parent_oos_no}}">
                                </div>
                            </div>
                             <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent) OOT No.</b></label>
                                    <input type="text" name="parent_oot_no" value="{{$hypothesis->parent_oot_no}}">
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Scheduled Start Date">(Parent) Date Opened</label>
                                    <div class="calenderauditee">
                                        @php
                                            $date = new DateTime($hypothesis->parent_date_opened);
                                        @endphp
                                        <input type="text" id="parent_date_opened"  placeholder="DD-MM-YYYY" value="{{$date->format('j-F-Y')}}" />
                                        <input type="date" name="parent_date_opened" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{$hypothesis->parent_date_opened}}" class="hide-input" oninput="handleDateInput(this, 'parent_date_opened');checkDate('start_date_checkdate','end_date_checkdate')"  />
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
                                        <input id="docname" type="text" name="parent_short_description" maxlength="255" required value="{{$hypothesis->parent_short_description}}">
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
                                            @php
                                            $date = new DateTime($hypothesis->parent_target_closure_date);
                                        @endphp
                                        <input type="text" id="parent_target_closure_date"  placeholder="DD-MM-YYYY" value="{{$date->format('j-F-Y')}}" />
                                        <input type="date" name="parent_target_closure_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{$hypothesis->parent_target_closure_date}}" class="hide-input" oninput="handleDateInput(this, 'parent_target_closure_date');checkDate('start_date_checkdate','end_date_checkdate')"  />
                                    </div>
                                </div>
                            </div>
                                     
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent)Product/Material Name</b></label>
                                    <input type="text" name="parent_product_material_name" value="{{$hypothesis->parent_product_material_name}}">
                                </div>
                            </div>
                            
                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>(Parent)Analyst Name</b></label>
                                    <input type="text" name="parent_analyst_name">
                                </div>
                            </div> -->
{{-- ---------------------------------------------------------------------------------------------------------- --}}
                            <div class="col-12">
                           <div class="group-input">
                            <label for="agenda">
                                (Parent) Product/Material information<button type="button" name="parent_info_on_product_material" id="product_material">+</button>
                            </label>
                            <table class="table table-bordered" id="product_material_body">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Row #</th>
                                        <th>Item/Product Code</th>
                                        <th>Batch Number</th>
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
                                    {{-- @php
                                        dd($gridDatas01);
                                    @endphp --}}
                                    
                                    @foreach ($gridDatas01->data as $datas)                                                           
                                    <tr>
                                        <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                        <td><input type="text" name="parent_info_on_product_material[0][item_product_code]" value="{{$datas['item_product_code']}}"></td>
                                        <td><input type="text" name="parent_info_on_product_material[0][lot_batch_number]" value="{{$datas['lot_batch_number']}}"></td>
                                        <td><input type="text" name="parent_info_on_product_material[0][a_r_number]" value="{{$datas['a_r_number']}}"></td>
                                        <td>
                                            <div class="col-lg-6 new-date-data-field">
                                                <div class="group-input input-date">

                                                    <div class="calenderauditee">
                                                        <input type="text" id="mfg_date" readonly placeholder="DD-MM-YYYY" value="{{$datas['mfg_date']}}" />
                                                        <input type="date" id="start_date_checkdate" name="parent_info_on_product_material[0][mfg_date]"  class="hide-input" oninput="handleDateInput(this, 'mfg_date');" />
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-lg-6 new-date-data-field">
                                                <div class="group-input input-date">
                                                    <div class="calenderauditee">
                                                        <input type="text" id="expiry_date" readonly placeholder="DD-MM-YYYY" value="{{$datas['expiry_date']}}" />
                                                        <input type="date" id="start_date_checkdate" name="parent_info_on_product_material[0][expiry_date]"  class="hide-input" oninput="handleDateInput(this, 'expiry_date');" />
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><input type="text" name="parent_info_on_product_material[0][label_claim]" value="{{$datas['label_claim']}}"></td>
                                        <td><input type="text" name="parent_info_on_product_material[0][pack_size]" value="{{$datas['pack_size']}}"></td>
                                        <!-- <td><button type="button" name="agenda" id="oos_details">Remove</button></td> -->
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
{{-- -------------------------------------------------------------grid-1----------------------------------------- --}}
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
                                {{-- @php
                                    dd($gridDatas02);
                                @endphp --}}
                                <tbody>
                                    @foreach ($gridDatas02->data as $datas  )
                                    <tr>
                                        <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                        <td><input type="text" name="parent_oos_details[0][ar_no]"value="{{$datas['ar_no']}}"></td>
                                        <td><input type="text" name="parent_oos_details[0][test_name_of_oos]"value="{{$datas['test_name_of_oos']}}"></td>
                                        <td><input type="text" name="parent_oos_details[0][results_obtained]"value="{{$datas['results_obtained']}}"></td>
                                        <td><input type="text" name="parent_oos_details[0][specification_limit]"value="{{$datas['specification_limit']}}"></td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
{{-- -------------------------------------------grid-2----------------------------------------------- --}}

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
                                    @foreach ( $gridDatas03->data as $datas)
                                        
                                    <tr>
                                        <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                        <td><input type="text" name="parent_oot_results[0][ar_no]" value="{{$datas['ar_no']}}"></td>
                                        <td><input type="text" name="parent_oot_results[0][test_name_of_oot]" value="{{$datas['test_name_of_oot']}}"></td>
                                        <td><input type="text" name="parent_oot_results[0][results_obtained]"value="{{$datas['results_obtained']}}"></td>
                                        <td><input type="text" name="parent_oot_results[0][initial_intervel_details]"value="{{$datas['initial_intervel_details']}}"></td>
                                        <td><input type="text" name="parent_oot_results[0][previous_interval_details]"value="{{$datas['previous_interval_details']}}"></td>
                                        <td><input type="text" name="parent_oot_results[0][difference_of_results]" value="{{$datas['difference_of_results']}}"></td>
                                        <!-- <td><input type="text" name="parent_oot_results[0]initial_interview_details"></td> -->
                                        <td><input type="text" name="parent_oot_results[0][trend_limit]" value="{{$datas['trend_limit']}}"></td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
{{-- ------------------------------------------------------grid-3----------------------------------------------------------------------------------------- --}}
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
                                    @foreach ($gridDatas04->data as $datas )   
                                    
                                    <tr>
                                        <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][ar_no]" value="{{$datas['ar_no']}}"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][condition_temperature_&_rh]" value="{{$datas['condition_temperature_&_rh']}}"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][interval]"value="{{$datas['interval']}}"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][orientation]"value="{{$datas['orientation']}}"></td>
                                        <td><input type="text" name="parent_details_of_stability_study[0][pack_details]"value="{{$datas['pack_details']}}"></td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
{{-- ---------------------------------------------grid-4----------------------------------------------------- --}}
                        <div class="sub-head">General Information</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number" value="{{ Helpers::getDivisionName(session()->get('division')) }}/HYPO/{{ Helpers::year($hypothesis->created_at) }}/{{ $hypothesis->record }}">
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
                                    <input type="hidden" name="initiator" value="{{auth()->id()}}">
                                    <input disabled type="text" name="initiator" value="{{ auth()->user()->name }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="date_opened">Date of Initiation</label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}" name="initiation_date">
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="initiation_date">
                                </div>
                            </div>

                            {{-- <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="Scheduled Start Date">Date Opened</label>
                            <div class="calenderauditee">
                           @php
                              $date = new DateTime($hypothesis->date_opened);
                            @endphp
                               <input type="text" id="date_opened"  placeholder="DD-MM-YYYY" value="{{$date->format('j-F-Y')}}" />
                               <input type="date" name="date_opened" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{$hypothesis->date_opened}}" class="hide-input" oninput="handleDateInput(this, 'date_opened');checkDate('start_date_checkdate','end_date_checkdate')"  />
                            </div>
                        </div>
                    </div> --}}
                        
                    <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="Scheduled Start Date">Target Closure Date</label>
                            <div class="calenderauditee">
                                @php
                                    $date = new DateTime($hypothesis->target_closure_date)
                                @endphp
                                <input type="text" id="target_closure_date" readonly placeholder="DD-MM-YYYY" value="{{$date->format('j-F-Y')}}"  />
                                <input type="date"  name="target_closure_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{$hypothesis->date_opened}}" class="hide-input" oninput="handleDateInput(this, 'target_closure_date');checkDate('start_date_checkdate','end_date_checkdate')"  />
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
                                        <input id="docname2" type="text" name="short_description" maxlength="255" required value="{{$hypothesis->short_description}}">
                                    </div>
                                </div>

                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Assignee</b></label>
                                    <input type="text" name="assignee">
                                </div>
                            </div> -->

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Description</label>
                                    <textarea name="description">{{$hypothesis->description}}</textarea>
                                </div>
                            </div>

                    
                            <div class="col-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Description">QC Approver</label>
                                    <select   name="qc_approver"  value="{{ $hypothesis->qc_approver }}" >
                                        <option value="0" >Enter your selection here</option>
                                        <option value="user_1" @if ($hypothesis->qc_approver == 'user_1') selected @endif>User1</option>
                                        <option value="user_2" @if ($hypothesis->qc_approver == 'user_2') selected @endif>User2</option>
                                        <option value="user_3" @if ($hypothesis->qc_approver == 'user_3') selected @endif>User3</option>
                                   </select>
                                </div>
                            </div>
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
                             <div class="sub-head"> QC Proposal Comments</div>
                          </div>

                          <div class="col-12">
                             <div class="group-input">
                                <label for="Description">QC Comments</label>
                                 <textarea name="qc_comments" val>{{$hypothesis->qc_comments}}</textarea>
                             </div>
                          </div>

                          <div class="col-lg-6">
                            <div class="group-input input-date">
                                    <label for="RLS Record Number"><b>Assignee</b></label>
                                    <select placeholder="Select" name="assignee" value="{{ $hypothesis->assignee }}">
                                        <option value="0">select</option>
                                        <option value="user1"{{$hypothesis->assignee == 'user1' ? 'selected' : ''}}>user1</option>
                                        <option value="user2"{{$hypothesis->assignee == 'user2' ? 'selected' : ''}}>user2</option>
                                        <option value="user3"{{$hypothesis->assignee == 'user3' ? 'selected' : ''}}>user3</option>
                                   </select>
                                </div>
                            </div>



                            {{-- <div class="col-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Description">QC Approver</label>
                                    <select   name="qc_approver"  value="{{ $hypothesis->qc_approver }}" >
                                        <option value="0" >Enter your selection here</option>
                                        <option value="user_1"
                                        @if ($hypothesis->qc_approver == 'user_1') selected @endif>User1</option>
                                        <option value="user_2" @if ($hypothesis->qc_approver == 'user_2') selected @endif>User2</option>
                                        <option value="user_3" @if ($hypothesis->qc_approver == 'user_3') selected @endif>User3</option>
                                   </select>
                                </div>
                            </div>
                        </div> --}}







                             <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>AQA Approver</b></label>
                                    <select name="aqa_approver" value="{{ $hypothesis->aqa_approver }}">
                                        <option value="">select</option>
                                        <option value="user1"{{$hypothesis->aqa_approver == 'user1' ? 'selected' : ''}}>user1</option>
                                        <option value="user2"{{$hypothesis->aqa_approver == 'user2' ? 'selected' : ''}}>user2</option>
                                        <option value="user3"{{$hypothesis->aqa_approver == 'user3' ? 'selected' : ''}}>user3</option>
                                   </select>
                                </div>
                            </div>
{{-- -------------------------------------------------------------------------------------- --}}
                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                                Experiment details<button type="button" name="experiment_details" id="experiment_details">+</button>
                            </label>
                            <table class="table table-bordered" id="experiment_details_body">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Row #</th>
                                        <th>Test Name</th>
                                        <th>Hypothesis/Experimental Design</th>
                                        <th>Justi. for Experimentation</th>
                                        <th>No. of Sample Preparations</th>
                                        <th>Inject./Measure. for Each Prep</th>
                                        <th>Analyst Name</th>
                                        <th>Instrument Name / ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $gridDatas05->data as $datas )
                                    
                                    <tr>
                                        <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                        <td><input type="text" name="experiment_details[0][test_name]"value="{{$datas['test_name']}}"></td>
                                        <td><input type="text" name="experiment_details[0][hypothesis_experimental_design]"value="{{$datas['hypothesis_experimental_design']}}"></td>
                                        <td><input type="text" name="experiment_details[0][justi_for_experimentation]"value="{{$datas['justi_for_experimentation']}}"></td>
                                        <td><input type="text" name="experiment_details[0][no_of_sample_preparations]"value="{{$datas['no_of_sample_preparations']}}"></td>
                                        <td><input type="text" name="experiment_details[0][inject_measure_for_each_prep]"value="{{$datas['inject_measure_for_each_prep']}}"></td>
                                        <td><input type="text" name="experiment_details[0][analyst_name]"value="{{$datas['analyst_name']}}"></td>
                                        <td><input type="text" name="experiment_details[0][instrument_name_id]"value="{{$datas['instrument_name_id']}}"></td>
                                        <!-- <td><button type="button" name="agenda" id="oos_details">Remove</button></td> -->
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
{{-- -------------------------------------------------------------------------------------------------- --}}
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Hyp./Exp. Comments</label>
                            <textarea name="hyp_exp_comments">{{$hypothesis->hyp_exp_comments}}</textarea>
                        </div>
                    </div> 
                 
                   <div class="col-12">
                     <div class="group-input">
                        <label for="Inv Attachments"> Hypothesis Attachment</label>
                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                        <div class="file-attachment-field">
                        <div disabled class="file-attachment-list" id="hypothesis_attachment" >
                    @if ($hypothesis->hypothesis_attachment)
                      @foreach(json_decode($hypothesis->hypothesis_attachment) as $file)
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
                        <input type="file" id="hypothesis_attachment" name="hypothesis_attachment[]"oninput="addMultipleFiles(this, 'hypothesis_attachment')"multiple>
                    </div>
                </div>
            </div>
        </div>

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
                                <div class="sub-head">AQA Review Comments</div>
                            </div>

                            <div class="col-12">
                        <div class="group-input">
                            <label for="Description">AQA Review Comments</label>
                            <textarea name="aqa_review_comments" >{{$hypothesis->aqa_review_comments}}</textarea>
                        </div>
                    </div>

        <div class="col-12">
            <div class="group-input">
                <label for="Inv Attachments"> AQA Review Attachment</label>
                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                <div class="file-attachment-field">
                    <div disabled class="file-attachment-list" id="aqa_review_attachment">
                        @if ($hypothesis->aqa_review_attachment)
                        @foreach(json_decode($hypothesis->aqa_review_attachment) as $file)
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
                        <input type="file" id="aqa_review_attachment" name="aqa_review_attachment[]"
                            oninput="addMultipleFiles(this, 'aqa_review_attachment')"multiple>
                    </div>
                </div>
            </div>
        </div>
                    
                       </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white"> Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                        <div class="sub-head">Summary Of Experimentation</div>
{{-- -------------------------------------------------------------------------------------------------------- --}}
                        <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">Experiment results<button type="button" name="experiment_results" id="experiment_results">+</button></label>
                            <table class="table table-bordered" id="experiment_results_body">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Row #</th>
                                        <th>Test Name</th>
                                        <th>Hypothesis/Experimental Design</th>
                                        <th>Result from experiment</th>
                                        <th>Ident. Assignab. Cause  (if any)</th>
                                        <th>Conclusion</th>
                                        <th>Further Action/Recommendations</th>
                                        <!-- <th>Instrument Name / ID</th> -->
                                     
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $gridDatas06->data as $datas )
                                    <tr>

                                        <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                        <td><input type="text" name="experiment_results[0][test_name]"value="{{$datas['test_name']}}"></td>
                                        <td><input type="text" name="experiment_results[0][hypothesis_experimental_design]"value="{{$datas['hypothesis_experimental_design']}}"></td>
                                        <td><input type="text" name="experiment_results[0][result_from_experiment]"value="{{$datas['result_from_experiment']}}"></td>
                                        <td><input type="text" name="experiment_results[0][ident_assignab_cause]"value="{{$datas['ident_assignab_cause']}}"></td>
                                        <td><input type="text" name="experiment_results[0][Conclusion]"value="{{$datas['Conclusion']}}"></td>
                                        <td><input type="text" name="experiment_results[0][further_action_recommendations]"value="{{$datas['further_action_recommendations']}}"></td>
                                        <!-- <td><input type="text" name="experiment_details[0][instrument_name_id]"></td> -->
                                        <!-- <td><button type="button" name="agenda" id="oos_details">Remove</button></td> -->
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
{{-- --------------------------------------------------------------------------------------- --}}
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Summary of Hypothesis</label>
                            <textarea name="summary_of_hypothesis" >{{$hypothesis->summary_of_hypothesis}}</textarea>
                        </div>
                    </div>  
                     <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Delay Justification</label>
                            <textarea name="delay_justification">{{$hypothesis->delay_justification}}</textarea>
                        </div>
                    </div>

        <div class="col-12">
            <div class="group-input">
                <label for="Inv Attachments"> Hypo.Execution Attachment</label>
                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                <div class="file-attachment-field">
                    <div disabled class="file-attachment-list" id="hypo_execution_attachment">
                        @if ($hypothesis->hypo_execution_attachment)
                        @foreach(json_decode($hypothesis->hypo_execution_attachment) as $file)
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
                        <input type="file" id="hypo_execution_attachment" name="hypo_execution_attachment[]"
                            oninput="addMultipleFiles(this, 'hypo_execution_attachment')"multiple>
                    </div>
                </div>
            </div>
        </div>

                            <!-- <div class="col-lg-6">
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
                            </div> -->
                            <!-- <div class="col-lg-6">
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
                            </div> -->
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('dashboard') }}"> Exit </a>
                            </button>
                        </div>
                    </div>
                </div>


                <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                        <div class="sub-head">Execution QC Review Comments</div>

                        <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Hypo/Exp QC Review Comments</label>
                            <textarea name="hypo_exp_qc_review_comments">{{$hypothesis->hypo_exp_qc_review_comments}}</textarea>
                        </div>
                    </div>

        <div class="col-12">
            <div class="group-input">
                <label for="Inv Attachments"> QC Review Attachment</label>
                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                <div class="file-attachment-field">
                    <div disabled class="file-attachment-list" id="qc_review_attachment">
                        @if ($hypothesis->qc_review_attachment)
                        @foreach(json_decode($hypothesis->qc_review_attachment) as $file)
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
                        <input type="file" id="qc_review_attachment" name="qc_review_attachment[]"
                            oninput="addMultipleFiles(this, 'qc_review_attachment')"multiple>
                    </div>
                </div>
            </div>
        </div>


                            <!-- <div class="col-lg-6">
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
                            </div> -->
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                            <button type="button"> <a class="text-white" href="{{ url('dashboard') }}"> Exit </a></button>
                        </div>
                    </div>
                </div>

                <div id="CCForm6" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                        <div class="sub-head">Execution AQA Review Comments</div>

                        <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Hypo/Exp AQA Review comments</label>
                            <textarea name="hypo_exp_aqa_review_comments">{{$hypothesis->hypo_exp_aqa_review_comments}}</textarea>
                        </div>
                    </div>

        <div class="col-12">
            <div class="group-input">
                <label for="Inv Attachments"> Hypo/Exp AQA Review Attachment</label>
                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                <div class="file-attachment-field">
                    <div disabled class="file-attachment-list" id="hypo_exp_aqa_review_attachment">
                        @if ($hypothesis->hypo_exp_aqa_review_attachment)
                        @foreach(json_decode($hypothesis->hypo_exp_aqa_review_attachment) as $file)
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
                        <input type="file" id="hypo_exp_aqa_review_attachment" name="hypo_exp_aqa_review_attachment[]"
                            oninput="addMultipleFiles(this, 'hypo_exp_aqa_review_attachment')"multiple>
                    </div>
                </div>
            </div>
        </div>

                            <!-- <div class="col-lg-6">
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
                            </div> -->
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                            <button type="button"> <a class="text-white" href="{{ url('dashboard') }}"> Exit </a>
                            </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm7" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                        <div class="sub-head">Submit</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Completed_By">Submit By </label>
                                    <div class="static" name="submit_by"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Completed_On">Submit On</label>
                                    <div class="static" name="submit_on"></div>
                                </div>
                            </div>

                        <div class="sub-head">Hypo./Exp. Proposed</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Completed_By">Hypo./Exp. Proposed By</label>
                                    <div class="static" name="hypo_proposed_by"></div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Completed_On">Hypo./Exp. Proposed On</label>
                                    <div class="static" name="hypo_proposed_on"></div>
                                </div>
                            </div>

                            <div class="sub-head">Hypothesis Proposed</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA_Approved_By">Hypothesis Proposed By</label>
                                    <div class="static" name="hypothesis_proposed_by"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="QA_Approved_On">Hypothesis Proposed On</label>
                                    <div class="static" name= "hypothesis_proposed_on"></div>
                                </div>
                            </div>

                            <div class="sub-head">AQA Review Complete</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_By">AQA Review Complete  By</label>
                                    <div class="static" name = "aqa_review_complete_by"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_On">AQA Review Complete On</label>
                                    <div class="static" name = "aqa_review_complete_on"></div>
                                </div>
                            </div>

                            <div class="sub-head">Hypo Execution Done</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_By">Hypo. Execution Done By</label>
                                    <div class="static" name="hypo_execution_done_by"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_On">Hypo. Execution Done On</label>
                                    <div class="static" name="hypo_execution_done_on"></div>
                                </div>
                            </div>  
                            
                            <div class="sub-head">Hypo/Exp QC Review Done</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_By">Hypo/Exp QC Review Done By</label>
                                    <div class="static" name = "qc_review_done_by"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_On">Hypo/Exp QC Review Done On</label>
                                    <div class="static" name="qc_review_done_on"></div>
                                </div>
                            </div>
                            
                            <div class="sub-head">Hypo/Exp. AQA Review</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_By">Hypo/Exp AQA Review By</label>
                                    <div class="static" name="exp_aqa_review_by"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_On">Hypo/Exp AQA Review On</label>
                                    <div class="static" name="exp_aqa_review_on"></div>
                                </div>
                            </div>

                            <div class="sub-head">Cancellation</div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_By">Cancel By</label>
                                    <div class="static" name="cancel_by"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Final_Approval_On">Cancel On</label>
                                    <div class="static" name="cancel_on"></div>
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


<!-- ===============================signature model======================== -->

<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('hypothesis_send_stage', $hypothesis->id) }}" method="POST">
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
                        <label for="comment">Comment</label>
                        <input type="comment" name="comment">
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

{{-- ========================================= more-info-modal=========================================================== --}}
<div class="modal fade" id="more-info-required-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('hypothesis_backword', $hypothesis->id) }}" method="POST">
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
                {{-- <div class="modal-footer">
                    <button type="submit" data-bs-dismiss="modal">Submit</button>
                    <button>Close</button>
                </div> --}}
                <div class="modal-footer">
                    <button type="submit">Submit</button>
                      <button type="button" data-bs-dismiss="modal">Close</button>   
                </div>
            </form>
        </div>
    </div>
</div>
{{-- ========================================= cancel-modal=========================================================== --}}
<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('hypothesis_Cancel', $hypothesis->id) }}" method="POST">
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

        $('#experiment_details').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="experiment_details[0][test_name]"></td>' +
                    '<td><input type="text" name="experiment_details[0][hypothesis_experimental_design]"></td>' +

                    '<td><input type="text" name="experiment_details[0][justi_for_experimentation]"></td>' +

                    '<td><input type="text" name="experiment_details[0][no_of_sample_preparations]"></td>' +

                    '<td><input type="text" name="experiment_details[0][inject_measure_for_each_prep]"></td>' +

                    '<td><input type="text" name="experiment_details[0][analyst_name]"></td>' +
                    '<td><input type="text" name="experiment_details[0][instrument_name_id]"></td>' +

                    '</tr>';
                return html;
            }
            var tableBody = $('#experiment_details_body tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            // var newRow = generateTableRow(rowCount - 1);
            tableBody.append(newRow); 
            
           
        });

        $('#experiment_results').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="experiment_results[0][test_name]"></td>' +

                    '<td><input type="text" name="experiment_results[0][hypothesis_experimental_design]"></td>' +

                    '<td><input type="text" name="experiment_results[0][result_from_experiment]"></td>' +

                    '<td> <input type="text" name="experiment_results[0][ident_assignab_cause]"></td>' +

                    '<td> <input type="text" name="experiment_results[0][Conclusion]"></td>' +

                    '<td><input type="text" name="experiment_results[0][further_action_recommendations]"></td>' +
                    // '<td><input type="text" name="experiment_details[0][instrument_name_id]"></td>' +

                    '</tr>';
                return html;
            }
            var tableBody = $('#experiment_results_body tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            // var newRow = generateTableRow(rowCount - 1);
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
<script>
    var maxLength = 255;
    $('#docname2').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars2').text(textlen);
    });
</script>

@endsection