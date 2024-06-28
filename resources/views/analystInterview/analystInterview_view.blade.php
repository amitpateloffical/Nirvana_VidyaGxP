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
        <strong>Site Division/Project</strong> : {{ Helpers::getDivisionName(session()->get('division')) }}Analyst Interview
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
        <div id="change-control-view">
            <div class="container-fluid">


                <div class="inner-block state-block">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="main-head">Record Workflow </div>

                        <div class="d-flex" style="gap:20px;">
                            @php
                                $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $analystinterview->division_id])->get();
                                $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                                // $cftRolesAssignUsers = collect($userRoleIds); //->contains(fn ($roleId) => $roleId >= 22 && $roleId <= 33);
                                // $cftUsers = DB::table('verifications')->where(['verification_id' => $analystinterview->id])->first();

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
                                //     ->where('deviation_id',$analystinterview->id)
                                //     ->where('cft_user_id', Auth::user()->id)
                                //     ->whereNull('deleted_at')
                                //     ->first();
                                // dd($cftCompleteUser);
                            @endphp
                            {{-- <button class="button_theme1" onclick="window.print();return false;"
                                class="new-doc-btn">Print</button> --}}
                             <button class="button_theme1"> <a class="text-white" href="{{ route('AIaudit_trial', $analystinterview->id) }}"> {{-- add here url for auditTrail i.e. href="{{ url('CapaAuditTrial', $analystinterview->id) }}" --}}
                                    Audit Trail </a> </button>

                            @if ($analystinterview->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    Submit
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                    Cancel
                                </button>

                            @elseif($analystinterview->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                    More Info from Open
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    Interview Complete
                                </button>
                                {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                    Cancel
                                </button> --}}
                            {{-- @elseif($analystinterview->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                                   <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                  Return to Analysis in Progress
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    QC Verification Complete
                                </button> --}}
                                {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cft-not-reqired">
                                    CFT Review Not Required
                                </button> --}}
                                {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                    Child
                                </button> --}}
                            {{-- @elseif($analystinterview->stage == 4 && (in_array(5, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray))) --}}
                            {{-- @if(!$cftCompleteUser) --}}
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                Return to QC Verification
                              </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal02">
                                Return to Analysis in Progress
                            </button> --}}
                                {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info Required
                                </button> --}}
                                    {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                        AQA Verification Complete
                                    </button>
                                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                        Approved
                                    </button> --}}
                                {{-- @endif --}}
                            {{-- @elseif($analystinterview->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
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
                            {{-- @elseif($analystinterview->stage == 6 && (in_array(9, $userRoleIds) || in_array(18, $userRoleIds)))
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
                        @if ($analystinterview->stage == 0)
                            <div class="progress-bars">
                                <div class="bg-danger">Closed-Cancelled</div>
                            </div>
                        @else
                            <div class="progress-bars">
                                @if ($analystinterview->stage >= 1)
                                    <div class="active">Opened</div>
                                @else
                                    <div class="">Opened</div>
                                @endif

                                @if ($analystinterview->stage >= 2)
                                    <div class="active">Interview Under Progress </div>
                                @else
                                    <div class="">Interview Under Progress</div>
                                @endif

                                {{-- @if ($analystinterview->stage >= 3)
                                    <div class="active">Under QC Verification</div>
                                @else
                                    <div class="">Under QC Verification</div>
                                @endif

                                @if ($analystinterview->stage >= 4)
                                    <div class="active">Under AQA Verification</div>
                                @else
                                    <div class="">Under AQA Verification</div>
                                @endif
 --}}

                                {{-- @if ($analystinterview->stage >= 5)
                                    <div class="active">QA Final Review</div>
                                @else
                                    <div class="">QA Final Review</div>
                                @endif
                                @if ($analystinterview->stage >= 6)
                                    <div class="active">QA Head/Manager Designee</div>
                                @else
                                    <div class="">Approval</div>
                                @endif --}}
                                @if ($analystinterview->stage >= 3)
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
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Interview Under Progress</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Activity log</button>
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Activity log</button> -->
            <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Signatures</button> -->
        </div>

        <form action="{{ route('analystinterview_update', $analystinterview->id ) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="step-form">

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">

                        <div class="sub-head">Parent Record Information</div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"> (Parent) OOS No.
                                    </label>
                                    <input type="text" id="root_parent_oos_number" name="root_parent_oos_number" value="{{$analystinterview->root_parent_oos_number}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"> (Parent) OOT No.
                                    </label>
                                    <input type="text" id="root_parent_oot_number" name="root_parent_oot_number" value="{{$analystinterview->root_parent_oot_number}}">
                                </div>
                            </div>
                            <div class="col-lg-6 new-date-data-field" >
                                <div class="group-input input-date">
                                    <label for="parent_date_opened">(Parent) Date Opened</label>
                                    <div class="calenderauditee">
                                        <input type="text" id="end_date_1" readonly placeholder="DD-MMM-YYYY" value="{{$analystinterview->parent_date_opened}}" />
                                        <input type="date" id="end_date_checkdate_1" name="parent_date_opened"
                                            min="yyyy-mm-dd"  class="hide-input" oninput="handleDateInput(this, 'end_date_1');checkDate('start_date_checkdate_1','end_date_checkdate_1')" />
                                                          </div>
                                                        </div>
                                                    </div>
                    <div class="col-6">
                        <div class="group-input">
                            <label for="Short Description">(Parent) Short Description<span class="text-danger "
                                    name="parent_short_description">*</span></label>
                            <input id="docname" type="text" name="parent_short_description" value="{{$analystinterview->parent_short_description}}" maxlength="255" required>
                        </div>
                    </div>
                    <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="parent_target_closure_date">(Parent) Target Closure Date</label>
                            <div class="calenderauditee">
                                <input type="text" id="end_date_2" readonly placeholder="DD-MMM-YYYY" value="{{$analystinterview->parent_target_closure_date}}" />
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
                            <input type="text" id="text" name="parent_product_mat_name" value="{{$analystinterview->parent_product_mat_name}}" />
                            </div>
                            </div>
                            <div class="col-lg-6">
                            <div class="group-input">
                                <label for="RLS Record Number"><b>(Parent)Analyst Name</b></label>
                                <input type="text" name="parent_analyst_name" value="{{$analystinterview->parent_analyst_name}}" >
                            </div>
                        </div>

        <div class="group-input">
            <label for="audit-agenda-grid">
                (Parent) Info. On Product/ Material
                <button type="button" name="parent_info_on_product_material1" id="Product_Material1">+</button>
                <span class="text-primary" data-bs-toggle="modal"
                        data-bs-target="#document-details-field-instruction-modal"
                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                    (Launch Instruction)
                </span>
            </label>
            <div class="table-responsive">
                <table class="table table-bordered" id="parent_info_on_product_material1" style="width: 100%;">
                    <!-- Table headers -->
                    <thead>
                        <tr>
                            <th style="width: 4%">Row#</th>
                            <th style="width: 10%">Item/Product Code</th>
                            <th style="width: 8%">Batch No*.</th>
                            <th style="width: 8%">A.R.Number</th>
                            <th style="width: 8%">Mfg.Date</th>
                            <th style="width: 8%">Expiry Date</th>
                            <th style="width: 8%">Label Claim.</th>
                            <th style="width: 8%">Pack Size</th>
                            {{-- <th style="width: 8%">Lot/Batch Number</th> --}}
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody>
                        <!-- Existing first row -->
                        @foreach($gridDatas01->data as $datas)
                        <tr>
                            <td><input disabled type="text" name="serial[]" value="1"></td>
                            <td><input type="text" name="parent_info_on_product_material1[0][item_product_code]" value="{{$datas['item_product_code']}}"></td>
                            <td><input type="text" name="parent_info_on_product_material1[0][batch_no]" value="{{$datas['batch_no']}}"></td>
                            <td><input type="text" name="parent_info_on_product_material1[0][ar_number]" value="{{$datas['ar_number']}}"></td>
                            <td>
                                <div class="group-input new-date-data-field mb-0">
                                    <div class="input-date">
                                        <div class="calenderauditee">
                                            <input type="text" id="agenda_date52_0" readonly placeholder="DD-MMM-YYYY" value="{{$datas['mfg_date']}}" />
                                            <input type="date" name="parent_info_on_product_material1[0][mfg_date]" class="hide-input"
                                                    oninput="handleDateInput(this, 'agenda_date52_0');" />
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="group-input new-date-data-field mb-0">
                                    <div class="input-date">
                                        <div class="calenderauditee">
                                            <input type="text" id="agenda_date53_0" readonly placeholder="DD-MMM-YYYY"  value="{{$datas['exp_date']}}"/>
                                            <input type="date" name="parent_info_on_product_material1[0][exp_date]" class="hide-input"
                                                    oninput="handleDateInput(this, 'agenda_date53_0');" />
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><input type="text" name="parent_info_on_product_material1[0][label_claim]" value="{{$datas['label_claim']}}"></td>
                            <td><input type="text" name="parent_info_on_product_material1[0][pack_size]" value="{{$datas['pack_size']}}"></td>
                            {{-- <td><input type="text" name="parent_info_on_product_material1[0][lot_batch_number]"></td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


                    <div class="group-input">
                        <label for="audit-agenda-grid">
                            (Parent) OOS Details (0)
                            <button type="button" name="root_parent_oos_details"
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
                        @foreach($gridDatas02->data as $datas)

                                    <tr>
                                        <td><input disabled type="text" name="serial[]" value="1"></td>
                                        <td><input type="text"
                                                name="root_parent_oos_details[0][ar_number]" value="{{$datas['ar_number']}}">
                                        </td>
                                        <td><input type="text"
                                                name="root_parent_oos_details[0][test_name_of_oos]" value="{{$datas['test_name_of_oos']}}">
                                        </td>
                                        <td><input type="text"
                                                name="root_parent_oos_details[0][results_obtained]"value="{{$datas['results_obtained']}}">
                                        </td>
                                        <td><input type="text"
                                                name="root_parent_oos_details[0][specification_limit]"value="{{$datas['specification_limit']}}">
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                                <div class="group-input">
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
                        @foreach($gridDatas03->data as $datas)

                                                <tr>
                                                    <td><input disabled type="text" name="serial[]" value="1"></td>
                                                    <td><input type="text" name="parent_oot_results[0][ar_number]" value="{{$datas['ar_number']}}"></td>
                                                    <td><input type="text" name="parent_oot_results[0][test_number_of_oot]" value="{{$datas['test_number_of_oot']}}" >
                                                    </td>
                                                    <td><input type="text" name="parent_oot_results[0][results_obtained]" value="{{$datas['results_obtained']}}" >
                                                    </td>
                                                    <td><input type="text" name="parent_oot_results[0][prev_interval_details]" value="{{$datas['prev_interval_details']}}" >
                                                    </td>
                                                    <td><input type="text" name="parent_oot_results[0][diff_of_results]" value="{{$datas['diff_of_results']}}" >
                                                    </td>
                                                    <td><input type="text"
                                                            name="parent_oot_results[0][initial_interview_details]" value="{{$datas['initial_interview_details']}}" >
                                                    </td>
                                                    <td><input type="text" name="parent_oot_results[0][trend_limit]" value="{{$datas['trend_limit']}}" ></td>
                                                </tr>
                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
                        @foreach($gridDatas04->data as $datas)
                        <tbody>
                                                <tr>
                                                    <td><input disabled type="text" name="serial[]" value="1"></td>
                                                    <td><input type="text"
                                                            name="parent_details_of_stability_study[0][ar_number]" value="{{$datas['ar_number']}}" >
                                                    </td>
                                                    <td><input type="text"
                                                            name="parent_details_of_stability_study[0][condition_temp_and_rh]" value="{{$datas['condition_temp_and_rh']}}" >
                                                    </td>
                                                    <td><input type="text"
                                                            name="parent_details_of_stability_study[0][interval]" value="{{$datas['interval']}}" >
                                                    </td>
                                                    <td><input type="text"
                                                            name="parent_details_of_stability_study[0][orientation]" value="{{$datas['orientation']}}" ></td>
                                                    <td><input type="text"
                                                            name="parent_details_of_stability_study[0][pack_details_if_any]" value="{{$datas['pack_details_if_any']}}" >
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="sub-head pt-3">General Information</div>
                                <div class="row">


                                    {{-- record or site/division code ANSHUL --}}
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="RLS Record Number"><b>Record Number</b></label>
                                            <input disabled type="text" name="record"  value="{{ Helpers::getDivisionName($analystinterview->division_id) }}/DEV/{{ Helpers::year($analystinterview->created_at) }}/{{ $analystinterview->record }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Division Code"><b>Site/Division Code</b></label>
                                            <input readonly type="text" name="division_id" value="{{ $divisionName }}"  />
                                        <input type="hidden" name="division_code"
                                            value="{{ session()->get('division') }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"> Initiator </label>
                                        <input type="text" disabled name="initiator_id"  value="{{ Auth::user()->name }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="date_opened">Date of Initiation</label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date"value="{{$analystinterview->intiation_date}}">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Scheduled end date">Target Closure Date</label>
                                        <div class="calenderauditee" disabled>
                                            <input type="text" id="end_date_3" disabled readonly
                                                placeholder="DD-MMM-YYYY" value="{{$analystinterview->target_closure_date_gi}}"/>
                                            <input type="date" id="end_date_checkdate_3" disabled
                                                name="target_closure_date_gi" min="yyyy-mm-dd" class="hide-input"
                                                oninput="handleDateInput(this, 'end_date_3');checkDate('start_date_checkdate_3','end_date_checkdate_3')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars2"></span>

                                        <input id="docname" type="text" name="short_description" maxlength="255" required value="{{$analystinterview->short_description}}">
                                    </div>
                                </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Assignee</b></label>
                                    <input type="text" name="assignee" value="{{$analystinterview->assignee}}">
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Description</label>
                                    <textarea name="description">{{$analystinterview->description}}</textarea>
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
                                <input type="text" id="start_date" readonly placeholder="DD-MM-YYYY"   value="{{$analystinterview->analyst_qualification_date}}"/>
                                <input type="date" id="start_date_checkdate" name="analyst_qualification_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="group-input">
                            <label for="agenda">
                                Precautionary measures
                            </label>
                            {{-- <button type="button" name="precautionary_measures"
                            id="Product_Material90"></button> --}}
                            <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 50%;">Question</th>
                                        <th style="width: 45%;">Response</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gridDatas05->data as $datas)

                                    <tr>
                                        <td>1</td>
                                        <td>Is there any precautions mentioned in the method of analysis for sample and standard preparation?</td>
                                        <td><input type="text" name="precautionary_measures[0][Q1]" value="{{$datas['Q1']}}"></td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>Whether the test under investigation is performed by the analyst for first time?</td>
                                        <td><input type="text" name="precautionary_measures[0][Q2]" value="{{$datas['Q1']}}" ></td>
                                    </tr>
                                </tbody>
                                @endforeach
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
                                @foreach($gridDatas06->data as $datas)

                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>What are the chemicals used for mobile phase preparation?</td>
                                        <td><input type="text" name="mobile_phase_preparation[0][mpp_Q1]"value="{{$datas['mpp_Q1']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>What is the acid/base used for buffer ph adjustment?</td>
                                        <td><input type="text" name="mobile_phase_preparation[0][mpp_Q2]"value="{{$datas['mpp_Q2']}}" ></td>
                                    </tr>
                                     <tr>
                                        <td>3</td>
                                        <td>What is the buffer solution final ph observed value?</td>
                                        <td><input type="text" name="mobile_phase_preparation[0][mpp_Q3]" value="{{$datas['mpp_Q3']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Have you filtered the buffer solution? If Yes what is the MOC of the filter used?</td>
                                        <td><input type="text" name="mobile_phase_preparation[0][mpp_Q4]" value="{{$datas['mpp_Q4']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Have you used mobile phase within the valid date?</td>
                                        <td><input type="text" name="mobile_phase_preparation[0][mpp_Q5]" value="{{$datas['mpp_Q5']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Mobile phase stability mentioned in the MOA(Hrs):</td>
                                        <td><input type="text" name="mobile_phase_preparation[0][mpp_Q6]" value="{{$datas['mpp_Q6']}}" ></td>
                                    </tr>
                                </tbody>
                                @endforeach
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
                                    @foreach($gridDatas07->data as $datas)

                                    <tr>
                                        <td>1</td>
                                        <td>What is the storage condition of working standard?(Specify)</td>
                                        <td><input type="text" name="reference_working_standards[0][Q1]" value="{{$datas['Q1']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>How long working standard kept in desiccator to attain room temperature?</td>
                                        <td><input type="text" name="reference_working_standards[0][Q2]" value="{{$datas['Q2']}}" ></td>
                                    </tr>
                                     <tr>
                                        <td>3</td>
                                        <td>What is nature of standard?(Light sensitive,moisture sensitive, oxygen sensitive or hygroscopic)</td>
                                        <td><input type="text" name="reference_working_standards[0][Q3]" value="{{$datas['Q3']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>What precaution required while handling/analysis?</td>
                                        <td><input type="text" name="reference_working_standards[0][Q4]" value="{{$datas['Q4']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Whether LOD or Water content determination required before usage? If yes what is the results observed?</td>
                                        <td><input type="text" name="reference_working_standards[0][Q5]" value="{{$datas['Q5']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Have you observed any spillage during weighing?</td>
                                        <td><input type="text" name="reference_working_standards[0][Q6]" value="{{$datas['Q6']}}" ></td>
                                    </tr>
                                     <tr>
                                        <td>7</td>
                                        <td>Have you used working standard solution within the valid date?</td>
                                        <td><input type="text" name="reference_working_standards[0][Q7]" value="{{$datas['Q7']}}" ></td>
                                    </tr>
                                      <tr>
                                        <td>8</td>
                                        <td>Working standard solution stability mentioned in the MOA?(specify hours):</td>
                                        <td><input type="text" name="reference_working_standards[0][Q8]" value="{{$datas['Q8']}}" ></td>
                                    </tr>
                                    @endforeach

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
                                    @foreach($gridDatas08->data as $datas)

                                    <tr>
                                        <td>1</td>
                                        <td>Is there any special precaution mentioned in the method of analysis for sample handling?</td>
                                        <td><input type="text" name="handling_of_samples[0][Q1]"  value="{{$datas['Q1']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Whether sample mixed/triturate thoroughly before weighing?</td>
                                        <td><input type="text" name="handling_of_samples[0][Q2]" value="{{$datas['Q2']}}" ></td>
                                    </tr>
                                     <tr>
                                        <td>3</td>
                                        <td>Is there any unusual observation on composite sample prepared?</td>
                                        <td><input type="text" name="handling_of_samples[0][Q3]" value="{{$datas['Q3']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>How you weighed the composite sample?</td>
                                        <td><input type="text" name="handling_of_samples[0][Q4]" value="{{$datas['Q4']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Have you observed any spillage during weighing?</td>
                                        <td><input type="text" name="handling_of_samples[0][Q5]" value="{{$datas['Q5']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>How you transferred the sample to volumetric glassware after weighing?</td>
                                        <td><input type="text" name="handling_of_samples[0][Q6]" value="{{$datas['Q6']}}" ></td>
                                    </tr>
                                     <tr>
                                        <td>7</td>
                                        <td>Is there any unusual observation on sample solution after preparatio?</td>
                                        <td><input type="text" name="handling_of_samples[0][Q7]" value="{{$datas['Q7']}}" ></td>
                                    </tr>
                                      <tr>
                                        <td>8</td>
                                        <td>Have you used correct volume of volumetric glassware?(specify the volume and number of glassware used)</td>
                                        <td><input type="text" name="handling_of_samples[0][Q8]" value="{{$datas['Q8']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>Whether sample preparation involves sonication? If Yes, What is the time & temperature followed?</td>
                                        <td><input type="text" name="handling_of_samples[0][Q9]" value="{{$datas['Q9']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>Whether sample preparation involves intermittent shaking? If Yes, What is the time interval followed?</td>
                                        <td><input type="text" name="handling_of_samples[0][Q10]" value="{{$datas['Q10']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td>What is the MOC of sample filter used? And How many filters used while sample preparation?</td>
                                        <td><input type="text" name="handling_of_samples[0][Q11]" value="{{$datas['Q12']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td>Sample solution stability mentioned in the  MOA?(specify Hrs)</td>
                                        <td><input type="text" name="handling_of_samples[0][Q12]" value="{{$datas['Q12']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>Please describe any abnormality noticed while performing weighing/pipetting/volume makeup/dilution etc.</td>
                                        <td><input type="text" name="handling_of_samples[0][Q13]" value="{{$datas['Q13']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>14</td>
                                        <td>Any other information related to testing?</td>
                                        <td><input type="text" name="handling_of_samples[0][Q14]" value="{{$datas['Q14']}}" ></td>
                                    </tr>
                                    @endforeach
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
                                    @foreach($gridDatas09->data as $datas)

                                    <tr>
                                        <td>1</td>
                                        <td>Have you followed instrument set up instruction?</td>
                                        <td><input type="text" name="instrument_setup_handling[0][Q1]" value="{{$datas['Q1']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Have you verified solvent filters before placing mobile phase?</td>
                                        <td><input type="text" name="instrument_setup_handling[0][Q2]" value="{{$datas['Q2']}}" ></td>
                                    </tr>
                                     <tr>
                                        <td>3</td>
                                        <td>Specify the HPLC/GC column make/ID and total no. of previous injections.</td>
                                        <td><input type="text" name="instrument_setup_handling[0][Q3]" value="{{$datas['Q3']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>How much time taken for column conditioning and instrument stabilization?</td>
                                        <td><input type="text" name="instrument_setup_handling[0][Q4]" value="{{$datas['Q4']}}" ></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Any other information related to instrument set up?</td>
                                        <td><input type="text" name="instrument_setup_handling[0][Q5]" value="{{$datas['Q5']}}" ></td>
                                    </tr>
                                    </tbody>
                                    @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="sub-head">Interviewer(s) Assessment</div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Interviewer(s) Assessment</label>
                            <textarea name="interviewer_assessment">{{$analystinterview->interviewer_assessment}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Recommendations</label>
                            <textarea name="recommendations">{{$analystinterview->recommendations}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Delay justification</label>
                            <textarea name="delay_justification">{{$analystinterview->delay_justification}}</textarea>
                        </div>
                    </div>
                     <div class="col-12">
                        <div class="group-input">
                            <label for="Description">Any other Comments</label>
                            <textarea name="any_other_comments">{{$analystinterview->any_other_comments}}</textarea>
                        </div>
                    </div>

                    @php
                        // dd($analystinterview);
                    @endphp
                    <div class="group-input">
            <label for="file_attchment_if_any">File Attachment</label>
            <div><small class="text-primary">Please Attach all relevant or supporting
                    documents</small></div>
            <div class="file-attachment-field">
                <div class="file-attachment-list" id="file_attchment_if_any">
                    @if ($analystinterview->file_attchment_if_any)
                    @foreach(json_decode($analystinterview->file_attchment_if_any) as $file)
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
                    <input type="file" id="myfile" name="file_attchment_if_any[]" {{-- ignore --}} oninput="addMultipleFiles(this, 'file_attchment_if_any')" multiple value="{{$analystinterview->file_attchment_if_any}}">
                </div>
            </div>
        </div>
        {{-- <div class="col-12">
            <div class="group-input">
                <label for="Inv Attachments">HOD Attachments</label>
                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                <div class="file-attachment-field">
                    <div disabled class="file-attachment-list" id="Audit_file">
                        @if ($data->Audit_file)
                        @foreach(json_decode($data->Audit_file) as $file)
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
                        <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="HOD_Attachments" name="Audit_file[]"
                            oninput="addMultipleFiles(this, 'Audit_file')"
                            multiple>
                    </div>
                </div>
            </div>
        </div> --}}

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
                                        <div class="static">{{ $analystinterview->submitted_by }}</div>
                                        {{-- <div class="static">Person datafield</div>/ --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Completed On">Submit On :-</label>
                                        <div class="static">{{ $analystinterview->submitted_by }}</div>
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




{{-- All Grids Script  --}}


    <!-- ------------------------ ----grid-2--------------------------------->
    <script>
        $(document).ready(function() {
            var index = 1; // Start index from 1 since the first row is already present

            $('#Product_Material1').click(function(e) {
                e.preventDefault(); // Prevent default action of button click

                function generateTableRow(serialNumber, index) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="parent_info_on_product_material1[' + index +
                        '][item_product_code]"></td>' +
                        '<td><input type="text" name="parent_info_on_product_material1[' + index +
                        '][batch_no]"></td>' +
                        '<td><input type="text" name="parent_info_on_product_material1[' + index +
                        '][ar_number]"></td>' +
                        '<td>' +
                        '<div class="group-input new-date-data-field mb-0">' +
                        '<div class="input-date">' +
                        '<div class="calenderauditee">' +
                        '<input type="text" id="agenda_date52_' + index +
                        '" readonly placeholder="DD-MMM-YYYY" />' +
                        '<input type="date" name="parent_info_on_product_material1[' + index +
                        '][mfg_date]" ' +
                        'min="yyyy-mm-dd" class="hide-input" ' +
                        'oninput="handleDateInput(this, \'agenda_date52_' + index + '\');" />' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td>' +
                        '<div class="group-input new-date-data-field mb-0">' +
                        '<div class="input-date">' +
                        '<div class="calenderauditee">' +
                        '<input type="text" id="agenda_date53_' + index +
                        '" readonly placeholder="DD-MMM-YYYY" />' +
                        '<input type="date" name="parent_info_on_product_material1[' + index +
                        '][exp_date]" ' +
                        'min="yyyy-mm-dd" class="hide-input" ' +
                        'oninput="handleDateInput(this, \'agenda_date53_' + index + '\');" />' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td><input type="text" name="parent_info_on_product_material1[' + index +
                        '][label_claim]"></td>' +
                        '<td><input type="text" name="parent_info_on_product_material1[' + index +
                        '][pack_size]"></td>' +
                        '</tr>';

                return html;
            }

                var tableBody = $('#parent_info_on_product_material1 tbody');
                var rowCount = tableBody.find('tr').length;
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
                        ' <td><input type="text" name="root_parent_oos_details[0][ar_number]"></td>' +
                        '  <td><input type="text" name="root_parent_oos_details[0][test_name_of_oos]"></td>' +
                        ' <td><input type="text" name="root_parent_oos_details[0][results_obtained]"></td>' +
                        '  <td><input type="text" name="root_parent_oos_details[0][specification_limit]"></td>' +
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



<script>
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);
    });
</script>


{{-- Modals required for Analyst interview --}}
<div class="modal fade" id="sendToInitiator">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('AIsend_stage', $analystinterview->id) }}" method="POST">
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



<div class="modal fade" id="more-info-required-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('AIrequestmoreinfo_back_stage', $analystinterview->id) }}" method="POST">
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

            <form action="{{ route('AIcancel_stage', $analystinterview->id) }}" method="POST">
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
            <form action="{{ route('AIsend_stage', $analystinterview->id) }}" method="POST">
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




@endsection
