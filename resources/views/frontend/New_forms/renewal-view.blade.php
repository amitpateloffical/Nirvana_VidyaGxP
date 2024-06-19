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
        width: 100%;
        border-redius: 5px;
        margin-bottom: 11px;

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

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(9) {
        border-radius: 0px 20px 20px 0px;

    }
</style>

<div class="form-field-head">
    {{-- <div class="pr-id">
            New Child
        </div> --}}
    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        / Renewal
    </div>
</div>

{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
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

                            <button class="button_theme1"> <a class="text-white" href="{{ route('renewalAuditTrial', $renewal->id) }}">
                                Audit Trail </a> </button>

                    @if ($renewal->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Submit
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Cancel
                    </button>
                    
                    @elseif ($renewal->stage == 2 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                        More Info Required
                    </button> 
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Submit for Review
                    </button> 
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                        Child
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Cancel
                    </button>
                    @elseif ($renewal->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds))) 
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                        More Info Required
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Submit
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Cancel
                    </button>
                    @elseif($renewal->stage == 4 &&(in_array(5, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                        Child
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#redirect2-modal">
                        Approval Received
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#redirect-modal">
                        Refused
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Withdraw
                    </button>

                    @elseif ($renewal->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds))) 

                    @elseif ($renewal->stage == 6 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                    
                    @elseif ($renewal->stage == 7 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#redirect-modal">
                        Registration Updated
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#redirect2-modal">
                        Registration Retired
                    </button> 
                    @elseif($renewal->stage == 8 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                        Child
                    </button>
                    @elseif ($renewal->stage == 9 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                @endif 
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>
                </div>
            </div>

{{-- =============================================================================================================== --}}
            <div class="status">
                <div class="head">Current Status</div>
                @if ($renewal->stage == 0) 
                <div class="progress-bars ">
                    <div class="bg-danger">Closed-Cancelled</div>
                </div> 

                @else 
                {{-- <div class="progress-bars d-flex" style="font-size: 15px;">
                    @if ($renewal->stage >= 1)
                    <div class="active">Opened</div>
                    @else 
                    <div class="">Opened</div> 
                    @endif

                    @if ($renewal->stage >= 2)
                    <div class="active">Submission Preparation</div>
                    @else
                    <div class="active">Submission Preparation</div>
                    @endif 

                    @if ($renewal->stage >= 3) 
                    <div class="active">Pending Submission Review</div> 
                    @else 
                    <div class="">Pending Submission Review</div>
                    @endif 

                    @if ($renewal->stage >= 4)
                    <div class="active">Authority Assessment</div> 
                    @else
                    <div class="">Authority Assessment</div>
                    @endif 


                    @if ($renewal->stage >= 5) 
                    <div class="bg-danger">Closed - Withdrawn</div> 
                    @else 
                    <div class="">Closed - Withdrawn</div>
                    @endif

                    @if ($renewal->stage >= 6)
                    <div class="bg-danger">Closed – Not Approved</div> 
                    @else 
                    <div class="">Closed – Not Approved</div>
                    @endif

                    @if ($renewal->stage >= 7) 
                    <div class="active">Pending Registration Update</div>
                    @else 
                    <div class="">Pending Registration Update</div>
                    @endif 

                    @if ($renewal->stage >= 8) 
                    <div class="bg-danger">Approved</div> 
                    @else 
                    <div class="">Approved</div>
                    @endif 

                    @if ($renewal->stage >= 9) 
                    <div class="bg-danger">Closed – Retired</div> 
                    @else 
                    <div class="">Closed – Retired</div>
                    </div>
                    @endif 
                    @endif  --}}

                    <div class="progress-bars d-flex" style="font-size: 15px;">
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
                @endif

                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
    

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Renewal</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Renewal Plan</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Product Information</button>
            {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Manufacturer Details</button> --}}
            {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Registration Information</button> --}}
            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Signatures</button>
        </div>

        <form action="{{ route('renewal.update', $renewal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div id="step-form">
                @if (!empty($parent_id))
                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif

<!-- ==================General information content====================== -->
                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="manufacturer"><b>(Root Parent) Manufacturer</b></label>
                                    <input type="text" name="manufacturer" value="{{$renewal->manufacturer}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Trade Name">(Root Parent)Trade Name</label>
                                    <input type="text" name="trade_name" value="{{$renewal->trade_name}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Initiator</b></label>
                                      {{-- <input disabled type="text" name="initiator" value="{{$renewal->initiator}}"> --}}
                                    <input type="hidden" name="initiator" value="{{ auth()->id() }}">
                                    <input disabled type="text" name="initiator_show" value="{{ auth()->user()->name }}">
                                </div>
                            </div>
                           
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date of Initiation"><b>Date of Initiation</b></label>
                                    {{-- Parse the date string into a DateTime object --}}

                                    @php
                                        $date = new DateTime($renewal->date_of_initiation);
                                     @endphp
                                     {{-- Format the date as desired --}}
                                    <input disabled type="text" name="date_of_initiation" value="{{date('j-F-Y')}}">
                                    <input type="hidden"  name="date_of_initiation" value="{{$renewal->date_of_initiation}}" >
                                </div>
                            </div>
                           
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="docname" type="text" name="short_description" maxlength="255" value="{{$renewal->short_description}}" required>
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option >Select a value</option>
                                        <option value="Amit sir"{{ $renewal->assign_to == 'Amit sir' ? 'selected' : ''  }}>Amit sir </option>
                                        <option value="Nilesh sir"{{ $renewal->assign_to == 'Nilesh sir' ? 'selected' : ''  }}>Nilesh sir </option>
                                        <option value="Himanshu sir"{{ $renewal->assign_to == 'Himanshu sir' ? 'selected' : ''  }}>Himanshu sir </option>
                                        <option value="Goutam sir"{{ $renewal->assign_to == 'Goutam sir' ? 'selected' : ''  }}>Goutam sir</option>
                                        <option value="Gourav sir"{{ $renewal->assign_to == 'Gourav sir' ? 'selected' : ''  }}>Gourav sir </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="due-date">Date Due</label>
                                    <div><small class="text-primary">Please mention expected date of completion</small></div>
                                    <div class="calenderauditee">
                                        {{-- Parse the date string into a DateTime object --}}
                                        @php
                                        $date = new DateTime($renewal->due_date);
                                         @endphp
                                         {{-- Format the date as desired --}}
                                         <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" value="{{$date->format('j-F-Y')}}" />
                                         <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{$renewal->due_date}}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                     </div>
                                 </div>
                             </div>
                           
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Documents">Documents</label>
                                    <input type="text" name="documents" id="" value="{{$renewal->documents}}">
                                </div>
                            </div>

                            {{-- <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Attached_Files">Attached Files</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="Attached_files"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="Attached_files" name="Attached_files[]"
                                                oninput="addMultipleFiles(this, 'Attached_files')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Inv Attachments"> Attached Files</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Attached_Files">
                                            @if ($renewal->Attached_Files)
                                            @foreach(json_decode($renewal->Attached_Files) as $file)
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
                                            <input type="file" id="Attached_Files" name="Attached_Files[]"
                                                oninput="addMultipleFiles(this, 'Attached_Files')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Documents">Dossier Parts</label>
                                    <input type="text" name="dossier_parts" id="" value="{{$renewal->dossier_parts}}">
                                </div>
                            </div>
                           
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Related_Dossier">Related Dossier Documents</label>
                                    <input type="text" name="related_dossier_documents" id="" value="{{$renewal->related_dossier_documents}}">
                                </div>
                            </div>
                        {{-- </div> --}}
                       
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>
            </div>
                
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">
                                Registration Status
                            </div>
                           
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Registration Status">Registration Status</label>
                                    <select name="registration_status">
                                        <option >Enter Your Selection Here</option>
                                        <option value="1"{{ $renewal->registration_status == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $renewal->registration_status == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $renewal->registration_status == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                           
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Registration Number">Registration Number</label>
                                    <input type="text" name="registration_number" value="{{$renewal->registration_number}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Planned Submission Date">Planned Submission Date</label>
                                    <input type="date" name="planned_submission_date" value="{{$renewal->planned_submission_date}}">
                                </div>
                            </div>
                           
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Submission Date">Actual Submission Date</label>
                                    <input type="date" name="actual_submission_date" value="{{$renewal->actual_submission_date}}">
                                </div>
                            </div>
                           
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Planed Approval Date">Planed Approval Date</label>
                                    <input type="date" name="planned_approval_date" value="{{$renewal->planned_approval_date}}">
                                </div>
                            </div>
                           
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Approval Date">Actual Approval Date</label>
                                    <input type="date" name="actual_approval_date" value="{{$renewal->actual_approval_date}}">
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Withdrawn Date">Actual Withdrawn Date</label>
                                    <input type="date" name="actual_withdrawn_date" value="{{$renewal->actual_withdrawn_date}}">
                                </div>
                            </div>
                           
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Rejection Date">Actual Rejection Date</label>
                                    <input type="date" name="actual_rejection_date" value="{{$renewal->actual_rejection_date}}">
                                </div>
                            </div>
                           
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Comments">Comments</label>
                                    <textarea name="comments" id="" cols="30" rows="3"></textarea>
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

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head">
                                (Parent) Renewal Rule
                            </div>
                           
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="safety_impact_Probability">(Root Parent) Trade Name</label>
                                    <input type="text" name="root_parent_trade_name" id=""value="{{$renewal->root_parent_trade_name}}">
                                </div>
                            </div>
                           
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="LocalTradeName">(Parent)Local Trade Name</label>
                                    <input type="text" name="parent_local_trade_name" id="" value="{{$renewal->parent_local_trade_name}}">
                                </div>
                            </div>
                           
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Renewal Rule">(Parent) Renewal Rule</label>
                                    <select name="">
                                        <option >--select--</option>
                                        <option value="1"{{ $renewal->renewal_rule == '1' ? 'selected' : ''  }}>1</option>
                                        <option value="2"{{ $renewal->renewal_rule == '2' ? 'selected' : ''  }}>2</option>
                                        <option value="3"{{ $renewal->renewal_rule == '3' ? 'selected' : ''  }}>3</option>
                                    </select>
                                </div>
                            </div>
                           
                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Product Information
                                    <button type="button" name="Product_Information" id="Product_Information">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Product_Information-field-instruction-modal">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Row#</th>
                                                <th style="width: 12%">Primary Packaging</th>
                                                <th style="width: 16%">Material</th>
                                                <th style="width: 16%">Pack Size</th>
                                                <th style="width: 16%">Shelf Life</th>
                                                <th style="width: 15%">Storage Condition</th>
                                                <th style="width: 15%">Secondary Packaging</th>
                                                <th style="width: 15%">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($repo->data as $item)
                                            
                                            <td><input disabled type="text" name="serial[]" value="1"></td>
                                            {{-- <td><input type="text" name="[IDnumber]"></td> --}}
                                            <td><input type="text" name="productinfo[0][primary_packaging]" value="{{array_key_exists('primary_packaging',$item) ? $item['primary_packaging'] : ''}}"></td>
                                            <td><input type="text" name="productinfo[0][material]" value="{{array_key_exists('material',$item) ? $item['material'] : ''}}"></td>
                                            <td><input type="text" name="productinfo[0][pack_size]" value="{{array_key_exists('pack_size', $item) ? $item['pack_size'] : ''}}"></td>
                                            <td><input type="text" name="productinfo[0][shelf_life]" value="{{array_key_exists('shelf_life',$item) ? $item['shelf_life'] : ''}}"></td>
                                            <td><input type="text" name="productinfo[0][storage _condition]" value="{{array_key_exists('storage_condition', $item) ? $item['storage_condition'] : ''}}"></td>
                                            <td><input type="text" name="productinfo[0][secondary_packaging]" value="{{array_key_exists('secondary_packaging', $item) ? $item['secondary_packaging'] : ''}}"></td>
                                            <td><input type="text" name="productinfo[0][remarks]" value="{{array_key_exists('remarks',$item) ? $item['remarks'] : ''}}"></td>
                                        </tbody>
                                            @endforeach
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

                {{-- <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div> --}}

                {{-- <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div> --}}

                <div id="CCForm6" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Started by">Started By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Started on">Started On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Submitted by">Submitted By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Submitted on">Submitted On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Approved_by">Approved By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Approved_on">Approved On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Withdrawn_by">Withdrawn By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Withdrawn on">Withdrawn On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Refused">Refused By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Refused on">Refused On</label>
                                    <div class="static"></div>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">Exit
                                    </a> </button>
                            </div>
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
        const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);
        currentStep = index;
    }

    const saveButtons = document.querySelectorAll(".saveButton");
    const nextButtons = document.querySelectorAll(".nextButton");
    const form = document.getElementById("step-form");
    const stepButtons = document.querySelectorAll(".cctablinks");
    const steps = document.querySelectorAll(".cctabcontent");
    let currentStep = 0;

    function nextStep() {
        if (currentStep < steps.length - 1) {
            steps[currentStep].style.display = "none";
            steps[currentStep + 1].style.display = "block";
            stepButtons[currentStep + 1].classList.add("active");
            stepButtons[currentStep].classList.remove("active");
            currentStep++;
        }
    }

    function previousStep() {
        if (currentStep > 0) {
            steps[currentStep].style.display = "none";
            steps[currentStep - 1].style.display = "block";
            stepButtons[currentStep - 1].classList.add("active");
            stepButtons[currentStep].classList.remove("active");
            currentStep--;
        }
    }
</script>
<script>
    $(document).ready(function() {
        $('#Product_Information').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '<td><input type="text" name="[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#Product_Information-field-instruction-modal tbody');
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
    function addMultipleFiles(input, id) {
        const fileList = document.getElementById(id);
        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            const fileItem = document.createElement('h6');
            fileItem.className = 'file-container text-dark';
            fileItem.style.backgroundColor = 'rgb(243, 242, 240)';
            fileItem.innerHTML = `
                <b>${file.name}</b>
                <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
            `;
            fileList.appendChild(fileItem);
        }
    }
</script>
<script>
    function addMultipleFiles(input, id) {
        const fileList = document.getElementById(id);
        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            const fileItem = document.createElement('h6');
            fileItem.className = 'file-container text-dark';
            fileItem.style.backgroundColor = 'rgb(243, 242, 240)';
            fileItem.innerHTML = `
                <b>${file.name}</b>
                <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;" onclick="removeFile(this)"></i>
            `;
            fileList.appendChild(fileItem);
        }
    }

    function removeFile(element) {
        const fileItem = element.parentElement;
        fileItem.remove();
    }
</script>
{{-- ===============================================child model=============================================== --}}

<div class="modal fade" id="child-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Child</h4>
            </div>
            <form action="{{ route('renewal_child_stage', $renewal->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="group-input">
                        @if ($renewal->stage == 2)
                            <label for="major">
                                <input type="radio" name="child_type" id="major"
                                    value="Dossier_Documents">
                                    Dossier Documents
                            </label>
                            {{-- <br>
                            <label for="major">
                                <input type="radio" name="child_type" id="major"
                                    value="extension">
                                    Extension
                            </label> --}}
                        @endif
                        
                        @if ($renewal->stage == 4)
                            <label for="major">
                                <input type="radio" name="child_type" id="major"
                                    value="Correspondence">
                                    Correspondence
                            </label>
                            {{-- <br>
                            <label for="major">
                                <input type="radio" name="child_type" id="major"
                                    value="extension">
                                    Extension
                            </label> --}}
                        @endif

                        @if ($renewal->stage == 8)
                            <label for="major">
                                <input type="radio" name="child_type" id="major"
                                    value="Correspondence">
                                    Correspondence
                            </label>
                            {{-- <br>
                            <label for="major">
                                <input type="radio" name="child_type" id="major"
                                    value="extension">
                                    Extension
                            </label> --}}
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

{{-- ==========================rejection(backword) e-signature======================================== --}}
<div class="modal fade" id="more-info-required-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content"> 

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('renewal_backword_stage', $renewal->id) }}" method="POST">
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
{{-- =====================================cancle e-signature============================ --}}
<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('renewal_cancel_stage', $renewal->id) }}" method="POST">
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



{{-- ==========================signature======================== --}}

<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('renewal_send_stage', $renewal->id) }}" method="POST">
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
{{-- ==========================redirect======================== --}}

<div class="modal fade" id="redirect-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('renewal_forword_close', $renewal->id) }}" method="POST">
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
{{-- ==========================redirect2======================== --}}

<div class="modal fade" id="redirect2-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('renewal_forword2_close', $renewal->id) }}" method="POST">
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

@endsection