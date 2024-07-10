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
        /CTMS - CTA Amendement
    </div>
</div>



<script>
    $(document).ready(function() {
        $('#ATC_codes').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="atc_Search[]"></td>' +
                    '<td><input type="text" name="1st_Level[]"></td>' +
                    '<td><input type="text" name="2nd_Level[]"></td>' +
                    '<td><input type="text" name="3rd_Level[]"></td>' +
                    '<td><input type="text" name="4th_Level[]"></td>' +
                    '<td><input type="text" name="5th_Level[]"></td>' +
                    '<td><input type="text" name="atc_Code[]"></td>' +
                    '<td><input type="text" name="substance[]"></td>' +
                    '<td><input type="text" name="remarks[]"></td>' +


                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                //     '</tr>';

                return html;
            }

            var tableBody = $('#ATC_codes-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#Ingredients').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="ingredient_Type[]"></td>' +
                    ' <td><input type="text" name="ingredient_Name[]"></td>' +
                    '<td><input type="text" name="ingredient_Strength[]"></td>' +
                    '<td><input type="text" name="Specification_Date[]"></td>' +
                    '<td><input type="text" name="Remarks[]"></td>' +



                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                //     '</tr>';

                return html;
            }

            var tableBody = $('#Ingredients-first-table');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#Product_Material').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="product_material[' + serialNumber + '][ProductName]"></td>' +
                    '<td><input type="number" name="product_material[' + serialNumber + '][BatchNumber]"></td>' +
                    '<td><input type="date" name="product_material[' + serialNumber + '][ExpiryDate]"></td>' +
                    '<td><input type="date" name="product_material[' + serialNumber + '][ManufacturedDate]"></td>' +
                    '<td><input type="text" name="product_material[' + serialNumber + '][Disposition]"></td>' +
                    '<td><input type="text" name="product_material[' + serialNumber + '][Comments]"></td>' +
                    '<td><input type="text" name="product_material[' + serialNumber + '][Remarks]"></td>' +
                    '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                //     '</tr>';

                return html;
            }

            var tableBody = $('#Product_Material-first-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#Packaging_Information').click(function(e) {
            function generateTableRow(serialNumber) {


                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +

                    '<td><input type="text" name="Primary_Packaging[]"></td>'
                '<td><input type="text" name="Material[]"></td>' +
                '<td><input type="text" name="Pack_Size[]"></td>' +
                '<td><input type="text" name="Shelf_Life[]"></td>' +
                '<td><input type="text" name="Storage_Condition[]"></td>' +
                '<td><input type="text" name="Secondary_Packaging[]"></td>' +
                '<td><input type="text" name="Remarks[]"></td>' +

                '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                // html += '</select></td>' +

                //     '</tr>';

                return html;
            }

            var tableBody = $('#Packaging_Information-first-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>


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


{{--workflow css start--}}
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

    #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(6) {
        border-radius: 0px 20px 20px 0px;

    }

    .new_style{
        width: 100%;
        border-radius: 5px;
        margin-bottom: 10px;
    }

   #change-control-view > div.container-fluid > div.inner-block.state-block > div.status > div.progress-bars > div.canceled{
border-radius:20px;
}
/*element.style{
border-radius:10px;
}*/
</style>

{{--workflow css end--}}


{{--workflow--}}

<div id="change-control-view">
  <div class="container-fluid">
        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head">Record Workflow</div>

                <div class="d-flex" style="gap:20px;">
                    @php
                        $userRoles = DB::table('user_roles')
                            ->where(['user_id' => auth()->id(), 'q_m_s_divisions_id' => $amendement_data->division_id])
                            ->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp
                    <button class="button_theme1"> <a class="text-white"
                            href="{{ route('cta_amendement.audit_trail', $amendement_data->id) }}">
                            Audit Trail </a>
                    </button>

                    @if ($amendement_data->stage == 1 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Submission
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            Cancel
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#notification-modal">
                            Notification Only
                        </button>

                    @elseif($amendement_data->stage == 2 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Finalize Dossier
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#notification-modal">
                            Withdraw
                        </button>

                    @elseif($amendement_data->stage == 3 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Approved
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#not-approved">
                            Not Approved
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#approved-comments">
                            Approved with Conditions/Comments
                         </button>
                         <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#notification-modal">
                            Withdraw
                        </button>

                        @elseif($amendement_data->stage == 4 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#no-condition">
                            No Conditions to Fulfill Before FPI
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#approved-comments">
                            Conditions to Fulfill Before FPI
                        </button>

                        @elseif($amendement_data->stage == 5 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#approved-comments">
                            Submit response
                        </button>

                        @elseif($amendement_data->stage == 6 && (in_array(3, $userRoleIds) || in_array(3, $userRoleIds)))
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#approved-comments">
                            All Conditions/Comments are met
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#early-termination">
                            Early Termination
                        </button>
                        <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            More Comments
                        </button>

                    @endif
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>
                </div>

            </div>


            <div class="status">
                <div class="head">Current Status</div>
                @if ($amendement_data->stage == 0)
                    <div class="progress-bars">
                        <div class="bg-danger canceled">Closed-Cancelled</div>
                    </div>
                @elseif ($amendement_data->stage == 8)
                    <div class="progress-bars">
                        <div class="bg-danger canceled">Closed-Notified</div>
                    </div>
                @elseif ($amendement_data->stage == 9)
                    <div class="progress-bars">
                        <div class="bg-danger canceled">Closed-Witdrawn</div>
                    </div>
                @elseif ($amendement_data->stage == 10)
                    <div class="progress-bars">
                        <div class="bg-danger canceled">Closed Not Approved</div>
                    </div>
                @elseif ($amendement_data->stage == 11)
                    <div class="progress-bars">
                        <div class="bg-danger canceled">Closed-Terminated</div>
                    </div>
                @else
                    <div class="progress-bars d-flex" style="font-size: 15px;">
                        @if ($amendement_data->stage >= 1)
                            <div class="active">Opened</div>
                        @else
                            <div class="">Opened</div>
                        @endif

                        @if ($amendement_data->stage >= 2)
                            <div class="active">Dossier Finalization</div>
                        @else
                            <div class="">Dossier Finalization</div>
                        @endif

                        @if ($amendement_data->stage >= 3)
                            <div class="active">Submitted for Authority</div>
                        @else
                            <div class="">Submitted for Authority</div>
                        @endif

                        {{--@if($amendement_data->stage != 5)--}}
                            @if ($amendement_data->stage >= 4)
                                <div class="active">Approved with Comments/Conditions</div>
                            @else
                                <div class="">Approved with Comments/Conditions</div>
                            @endif
                        {{--@endif--}}

                       {{--@if($amendement_data->stage != 4)--}}
                        @if ($amendement_data->stage >= 5)
                            <div class="active">Pending Comments</div>
                        @else
                            <div class="">Pending Comments</div>
                        @endif
                      {{--@endif--}}

                        @if ($amendement_data->stage >= 6)
                            <div class="active">RA Review of Response to Comments</div>
                        @else
                            <div class="">RA Review of Response to Comments</div>
                       @endif

                       @if ($amendement_data->stage >= 7)
                            <div class="bg-danger">Closed-Approved</div>
                       @else
                            <div class="">Closed-Approved</div>
                       @endif

                    </div>
                @endif
            </div>
        </div>


{{--workflow end--}}


{{--Submit Supplier Details button Model Open--}}
<div class="modal fade" id="signature-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cta_amendement.send_stage', $amendement_data->id) }}" method="POST">
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

{{--Submit audit passed button Model Open--}}

{{--cancel button Model Open--}}
<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cta_amendement.cancel', $amendement_data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-3 text-justify">
                        Please select a meaning and a outcome for this task and enter your username
                        and password for this task. You are performing an electronic signature,
                        which is legally binding equivalent of a hand written signature.
                    </div>
                    <input type="hidden" name="type" value="cancel">
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

{{--cancel button Model Close--}}

{{--cancel button Model Open--}}
<div class="modal fade" id="notification-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cta_amendement.cancel', $amendement_data->id) }}" method="POST">
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
                        <input type="text" class="new_style" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="new_style" name="password" required>
                    </div>
                    <div class="group-input">
                        <label for="comment">Comment</label>
                        <input type="comment" class="new_style" name="comment">
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

{{--E-Signature cancel button Model Close--}}

{{--not approved button Model Open--}}
<div class="modal fade" id="not-approved">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cta_amendement.cancel', $amendement_data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-3 text-justify">
                        Please select a meaning and a outcome for this task and enter your username
                        and password for this task. You are performing an electronic signature,
                        which is legally binding equivalent of a hand written signature.
                    </div>
                    <input type="hidden" name="type" value="not_approved">
                    <div class="group-input">
                        <label for="username">Username <span class="text-danger">*</span></label>
                        <input type="text" class="new_style" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="new_style" name="password" required>
                    </div>
                    <div class="group-input">
                        <label for="comment">Comment</label>
                        <input type="comment" class="new_style" name="comment">
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

{{--not approved button Model Close--}}

{{--Approved with Conditions/Comments button Model Open--}}
<div class="modal fade" id="approved-comments">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cta_amendement.send', $amendement_data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-3 text-justify">
                        Please select a meaning and a outcome for this task and enter your username
                        and password for this task. You are performing an electronic signature,
                        which is legally binding equivalent of a hand written signature.
                    </div>
                    <input type="hidden" name="type" value="not_approved">
                    <div class="group-input">
                        <label for="username">Username <span class="text-danger">*</span></label>
                        <input type="text" class="new_style" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="new_style" name="password" required>
                    </div>
                    <div class="group-input">
                        <label for="comment">Comment</label>
                        <input type="comment" class="new_style" name="comment">
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

{{--Approved with Conditions/Comments button Model Close--}}

{{--Approved with Conditions/Comments button Model Open--}}
<div class="modal fade" id="no-condition">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cta_amendement.send', $amendement_data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-3 text-justify">
                        Please select a meaning and a outcome for this task and enter your username
                        and password for this task. You are performing an electronic signature,
                        which is legally binding equivalent of a hand written signature.
                    </div>
                    <input type="hidden" name="type" value="no_condition">
                    <div class="group-input">
                        <label for="username">Username <span class="text-danger">*</span></label>
                        <input type="text" class="new_style" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="new_style" name="password" required>
                    </div>
                    <div class="group-input">
                        <label for="comment">Comment</label>
                        <input type="comment" class="new_style" name="comment">
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

{{--Approved with Conditions/Comments button Model Close--}}

{{--Approved with Conditions/Comments button Model Open--}}
<div class="modal fade" id="early-termination">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">E-Signature</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cta_amendement.send_stage', $amendement_data->id) }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-3 text-justify">
                        Please select a meaning and a outcome for this task and enter your username
                        and password for this task. You are performing an electronic signature,
                        which is legally binding equivalent of a hand written signature.
                    </div>
                    <input type="hidden" name="type" value="early_termination">
                    <div class="group-input">
                        <label for="username">Username <span class="text-danger">*</span></label>
                        <input type="text" class="new_style" name="username" required>
                    </div>
                    <div class="group-input">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="new_style" name="password" required>
                    </div>
                    <div class="group-input">
                        <label for="comment">Comment</label>
                        <input type="comment" class="new_style" name="comment">
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

{{--Approved with Conditions/Comments button Model Close--}}

{{-- ! ========================================= --}}
{{-- !               DATA FIELDS                 --}}
{{-- ! ========================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">CTA Amendement</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')">CTA amendement Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Root Cause Analysis</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Signatures</button>

        </div>

        {{--disabled field code start--}}

        <?php if (in_array($amendement_data->stage, [0, 7, 8, 9, 10, 11])) : ?>
            <script>
                $(document).ready(function() {
                    $("#target :input").prop("disabled", true);
                });
            </script>
        <?php endif; ?>

        {{--disabled field code start--}}

        <form id="target" action="{{ route('cta_amendement.update', $amendement_data->id) }}" method="POST"  enctype="multipart/form-data">
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
                                    <label for="Initiator"> Record Number </label>
                                    <input disabled type="text" name="record"
                                    value="{{ Helpers::getDivisionName(session()->get('division')) }}/CTA_Amendement/{{ date('Y') }}/{{ $record_number }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code</b></label>
                                    <input readonly type="text" name="division_code"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    {{-- <div class="static">QMS-North America</div> --}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator">Initiator</label>
                                    <input disabled type="text" name="initiator_id" value="{{ auth()->user()->name }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input ">
                                    <label for="Date Of Initiation"><b>Date Of Initiation</b></label>
                                    <input readonly type="text" value="{{ date('d-M-Y', strtotime($amendement_data->intiation_date)) }}" name="intiation_date">
                                    <input type="hidden" value="{{ date('d-M-Y', strtotime($amendement_data->intiation_date)) }}" name="intiation_date">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Initiator Group Code">Short Description<span class="text-danger">*</span></label>
                                    <p class="text-primary">PSUR Short Description to be presented on dekstop</p>
                                    <input type="text" name="short_description" id="initiator_group_code" value="{{ $amendement_data->short_description }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="If Others">Assigned To</label>
                                    <select name="assigned_to">
                                     <option value="">Select a value</option>
                                        @if($users->isNotEmpty())
                                            @foreach($users as $user)
                                            <option value='{{ $user->id }}' {{ $user->id == $amendement_data->assigned_to ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Due Date">Date Due</label>
                                    <p class="text-primary"> last date this record should be closed by</p>
                                    <div class="calenderauditee">
                                        <input  type="hidden" value="{{ $due_date }}" name="due_date">
                                        <input disabled type="text" value="{{ Helpers::getdateFormat($due_date) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type">Type</label>
                                    <select name="type">
                                        <option value="">-- select --</option>
                                        <option value="administrative-amendment" @if($amendement_data->type == 'administrative-amendment') selected @endif>Administrative Amendment</option>
                                        <option value="budget-amendment" @if($amendement_data->type == 'budget-amendment') selected @endif>Budget Amendment</option>
                                        <option value="scope-of-work-amendment" @if($amendement_data->type == 'scope-of-work-amendment') selected @endif>Scope of Work Amendment</option>
                                        <option value="regulatory-amendment" @if($amendement_data->type == 'regulatory-amendment') selected @endif>Regulatory Amendment</option>
                                        <option value="milestone-amendment" @if($amendement_data->type == 'milestone-amendment') selected @endif>Milestone Amendment</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Other Type">Other Type</label>
                                    <select name="other_type">
                                        <option value="">-- select --</option>
                                        <option value="data-management-amendment" @if($amendement_data->other_type == 'data-management-amendment') selected @endif>Data Management Amendment</option>
                                        <option value="logistical-amendment" @if($amendement_data->other_type == 'logistical-amendment') selected @endif>Logistical Amendment</option>
                                        <option value="communication-amendment" @if($amendement_data->other_type == 'communication-amendment') selected @endif>Communication Amendment</option>
                                        <option value="quality-assurance-amendment" @if($amendement_data->other_type == 'quality-assurance-amendment') selected @endif>Quality Assurance Amendment</option>
                                        <option value="equipment-amendment" @if($amendement_data->other_type == 'equipment-amendment') selected @endif>Equipment Amendment</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Attached Files">Attached Files</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="file_attach">
                                            @if ($amendement_data->attached_files)
                                                @foreach($amendement_data->attached_files as $file)
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
                                            <input type="file" id="myfile" name="attached_files[]" oninput="addMultipleFiles(this, 'file_attach')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="group-input">
                                    <label for="Description">Description</label>
                                    <small class="text-primary">
                                        Amendment detailled description
                                    </small>
                                    <textarea class="" name="description" id="">{{ $amendement_data->description }}</textarea>
                                </div>
                            </div>


                            <div class="sub-head">Location</div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">Zone</label>
                                    <select name="zone">
                                        <option value="">Select a value</option>
                                        <option value="asia" @if ($amendement_data->zone == "asia") selected @endif>Asia</option>
                                        <option value="europe" @if ($amendement_data->zone == "europe") selected @endif>Europe</option>
                                        <option value="africa" @if ($amendement_data->zone == "africa") selected @endif>Africa</option>
                                        <option value="central-america" @if ($amendement_data->zone == "central-america") selected @endif>Central America</option>
                                        <option value="south-america" @if ($amendement_data->zone == "south-america") selected @endif>South America</option>
                                        <option value="oceania" @if ($amendement_data->zone == "oceania") selected @endif>Oceania</option>
                                        <option value="north-america" @if ($amendement_data->zone == "north-america") selected @endif>North America</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Country <span class="text-danger"></span>
                                    </label>
                                    <select name="country" class="form-select country" aria-label="Default select example" onchange="loadStates()">
                                        <option value="{{ $amendement_data->country }}" selected>{{ $amendement_data->country }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        State/District <span class="text-danger"></span>
                                    </label>
                                    <select name="state" class="form-select state" aria-label="Default select example" onchange="loadCities()">
                                        <option value="{{ $amendement_data->state }}" selected>{{ $amendement_data->state }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        City <span class="text-danger"></span>
                                    </label>
                                    <select name="city" class="form-select city" aria-label="Default select example">
                                        <option value="{{ $amendement_data->city }}" selected>{{ $amendement_data->city }}</option>
                                    </select>
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
                </div>
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="sub-head col-12">Amendement Information</div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Procedure Number">Procedure Number</label>
                                    <input type="number" name="procedure_number" id="procedure_number" value="{{ $amendement_data->procedure_number }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Project Code">Project Code</label>
                                    <input type="text" name="project_code" id="project_code" value="{{ $amendement_data->project_code }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Registration Number">Registration Number</label>
                                    <input type="number" name="registration_number" id="registration_number" value="{{ $amendement_data->registration_number }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Other Authority">Other Authority</label>
                                    <input type="text" name="other_authority" id="other_authority" value="{{ $amendement_data->other_authority }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Authority Type">Authority Type</label>
                                    <select name="authority_type">
                                        <option value="">-- select --</option>
                                        <option value="ethics-committee" @if($amendement_data->authority_type == 'ethics-committee') selected @endif>Ethics Committee/Institutional Review Board </option>
                                        <option value="regulatory-authority" @if($amendement_data->authority_type == 'regulatory-authority') selected @endif>Regulatory Authority</option>
                                        <option value="sponsor-investigator" @if($amendement_data->authority_type == 'sponsor-investigator') selected @endif>Sponsor/Investigator</option>
                                        <option value="data-safety-monitoring-board" @if($amendement_data->authority_type == 'data-safety-monitoring-board') selected @endif>Data Safety Monitoring Board</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Authority">Authority</label>
                                    <select name="authority">
                                        <option value="">-- select --</option>
                                        <option value="national-competent-authority" @if($amendement_data->authority == 'national-competent-authority') selected @endif>National Competent Authority</option>
                                        <option value="ethics-committee" @if($amendement_data->authority == 'ethics-committee') selected @endif>Ethics Committee</option>
                                        <option value="local-ethics-committees" @if($amendement_data->authority == 'local-ethics-committees') selected @endif>Local Ethics Committees</option>
                                        <option value="national-health-authorities" @if($amendement_data->authority == 'national-health-authorities') selected @endif>National Health Authorities</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Year">Year</label>
                                    <select name="year">
                                        <option value="">-- select --</option>
                                        <option value="2024" @if($amendement_data->year == '2024') selected @endif>2024</option>
                                        <option value="2025" @if($amendement_data->year == '2025') selected @endif>2025</option>
                                        <option value="2026" @if($amendement_data->year == '2026') selected @endif>2026</option>
                                        <option value="2027" @if($amendement_data->year == '2027') selected @endif>2027</option>
                                        <option value="2028" @if($amendement_data->year == '2028') selected @endif>2028</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Registration Status">Registration Status</label>
                                    <select name="registration_status">
                                        <option value="">-- select --</option>
                                        <option value="pending-submission" @if($amendement_data->registration_status == 'pending-submission') selected @endif>Pending Submission</option>
                                        <option value="submitted" @if($amendement_data->registration_status == 'submitted') selected @endif>Submitted</option>
                                        <option value="under-review" @if($amendement_data->registration_status == 'under-review') selected @endif>Under Review</option>
                                        <option value="approved" @if($amendement_data->registration_status == 'approved') selected @endif>Approved</option>
                                        <option value="rejected" @if($amendement_data->registration_status == 'rejected') selected @endif>Rejected</option>
                                        <option value="withdrawn" @if($amendement_data->registration_status == 'withdrawn') selected @endif>Withdrawn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="CAR Clouser Time Weight">CAR Clouser Time Weight</label>
                                    <select name="car_clouser_time_weight">
                                        <option value="">-- select --</option>
                                        <option value="high-priority" @if($amendement_data->car_clouser_time_weight == 'high-priority') selected @endif>High Priority</option>
                                        <option value="medium-high-priority" @if($amendement_data->car_clouser_time_weight == 'medium-high-priority') selected @endif>Medium-High Priority</option>
                                        <option value="medium-priority" @if($amendement_data->car_clouser_time_weight == 'medium-priority') selected @endif>Medium Priority</option>
                                        <option value="medium-low-priority" @if($amendement_data->car_clouser_time_weight == 'medium-low-priority') selected @endif>Medium-Low Priority</option>
                                        <option value="low-priority" @if($amendement_data->car_clouser_time_weight == 'low-priority') selected @endif>Low Priority</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Outcome">Outcome</label>
                                    <select name="outcome">
                                        <option value="">-- select --</option>
                                        <option value="approved" @if($amendement_data->outcome == 'approved') selected @endif>Approved</option>
                                        <option value="pending-approval" @if($amendement_data->outcome == 'pending-approval') selected @endif>Pending Approval</option>
                                        <option value="under-review" @if($amendement_data->outcome == 'under-review') selected @endif>Under Review</option>
                                        <option value="pending-approval" @if($amendement_data->outcome == 'pending-approval') selected @endif>modification-required</option>
                                        <option value="superseded" @if($amendement_data->outcome == 'superseded') selected @endif>superseded</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Trade Name">Trade Name</label>
                                    <input type="text" name="trade_name" id="trade_name" value="{{ $amendement_data->trade_name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Estimated Man-Hours">Estimated Man-Hours</label>
                                    <input type="text" name="estimated_man_hours" id="estimated_man_hours" value="{{ $amendement_data->estimated_man_hours }}">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="group-input">
                                    <label for="Comments">Comments</label>
                                    <textarea class="" name="comments" id="">{{ $amendement_data->comments }}</textarea>
                                </div>
                            </div>

                            <div class="sub-head">Product Information</div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="manufacturer">Manufacturer</label>
                                    <select name="manufacturer">
                                        <option value="">-- select --</option>
                                        <option value="sponsor-manufacturer"@if($amendement_data->manufacturer == 'sponsor-manufacturer') selected @endif>Sponsor Manufacturer</option>
                                        <option value="contract-manufacturing-organization"@if($amendement_data->manufacturer == 'contract-manufacturing-organization') selected @endif>Contract Manufacturing Organization</option>
                                        <option value="in-house-manufacturing"@if($amendement_data->manufacturer == 'in-house-manufacturing') selected @endif>In-house Manufacturing</option>
                                        <option value="academic-institution"@if($amendement_data->manufacturer == 'academic-institution') selected @endif>Academic Institution</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Product_Material">
                                        (Root Parent) Product/Material
                                        <button type="button" name="product_material" id="Product_Material">+</button>
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="Product_Material-first-table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 4%">Row #</th>
                                                    <th style="width: 12%">Product Name</th>
                                                    <th style="width: 16%">Batch Number</th>
                                                    <th style="width: 16%">Expiry Date</th>
                                                    <th style="width: 16%">Manufactured Date</th>
                                                    <th style="width: 16%">Disposition</th>
                                                    <th style="width: 16%">Comments</th>
                                                    <th style="width: 16%">Remarks</th>
                                                    <th style="width: 16%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $data = isset($grid_Data) && $grid_Data->data ? json_decode($grid_Data->data, true) : null;
                                                @endphp
                                                @if ($data && is_array($data))
                                                 @foreach ($data as $index => $item)
                                                <tr>
                                                    <td><input disabled type="text" name="[{{ $index }}][serial]" value="{{ $index + 1 }}" value="1"></td>
                                                    <td><input type="text" name="product_material[{{ $index }}][ProductName]" value="{{ isset($item['ProductName']) ? $item['ProductName'] : '' }}"></td>
                                                    <td><input type="number" name="product_material[{{ $index }}][BatchNumber]" value="{{ isset($item['BatchNumber']) ? $item['BatchNumber'] : '' }}"></td>
                                                    <td><input type="date" name="product_material[{{ $index }}][ExpiryDate]" value="{{ isset($item['ExpiryDate']) ? $item['ExpiryDate'] : '' }}"></td>
                                                    <td><input type="date" name="product_material[{{ $index }}][ManufacturedDate]" value="{{ isset($item['ManufacturedDate']) ? $item['ManufacturedDate'] : '' }}"></td>
                                                    <td><input type="text" name="product_material[{{ $index }}][Disposition]" value="{{ isset($item['Disposition']) ? $item['Disposition'] : '' }}"></td>
                                                    <td><input type="text" name="product_material[{{ $index }}][Comments]" value="{{ isset($item['Comments']) ? $item['Comments'] : '' }}"></td>
                                                    <td><input type="text" name="product_material[{{ $index }}][Remarks]" value="{{ isset($item['Remarks']) ? $item['Remarks'] : '' }}"></td>
                                                    <td><button readonly type="text" class="removeRowBtn">Remove</button></td>
                                                    {{--<td><input readonly type="text"></td>--}}
                                                </tr>
                                                @endforeach
                                             @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">Important Dates</div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Actual Submission Date"> Actual Submission Date </label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $amendement_data->actual_submission_date }}" id="actual_submission_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $amendement_data->actual_submission_date }}" name="actual_submission_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'actual_submission_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Actual Rejection Date"> Actual Rejection Date </label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $amendement_data->actual_rejection_date }}" id="actual_rejection_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $amendement_data->actual_rejection_date }}" name="actual_rejection_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'actual_rejection_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Actual Withdrawn Date"> Actual Withdrawn Date </label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $amendement_data->actual_withdrawn_date }}" id="actual_withdrawn_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $amendement_data->actual_withdrawn_date }}" name="actual_withdrawn_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'actual_withdrawn_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Inquiry Date"> Inquiry Date </label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $amendement_data->inquiry_date }}" id="inquiry_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $amendement_data->inquiry_date }}" name="inquiry_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'inquiry_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Planened Submission Date"> Planned Submission Date </label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $amendement_data->planned_submission_date }}" id="planned_submission_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $amendement_data->planned_submission_date }}" name="planned_submission_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'planned_submission_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Planned DateSent To Affiliate"> Planned Date Sent To Affiliate </label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $amendement_data->planned_date_sent_to_affiliate }}" id="planned_date_sent_to_affiliate" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $amendement_data->planned_date_sent_to_affiliate }}" name="planned_date_sent_to_affiliate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'planned_date_sent_to_affiliate')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Effective Date"> Effective Date </label>
                                    <div class="calenderauditee">
                                        <input type="text" value="{{ $amendement_data->effective_date }}" id="effective_date" readonly placeholder="DD-MMM-YYYY" />
                                        <input type="date" value="{{ $amendement_data->effective_date }}" name="effective_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'effective_date')" />
                                    </div>
                                </div>
                            </div>

                            <div class="sub-head">Person Involved</div>


                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Additional Assignees">Additional Assignees</label>
                                    <textarea class="" name="additional_assignees">{{ $amendement_data->additional_assignees }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Additional Investigators">Additional Investigators</label>
                                    <textarea class="" name="additional_investigators">{{ $amendement_data->additional_investigators }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Approvers">Approvers</label>
                                    <textarea class="" name="approvers">{{ $amendement_data->approvers }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Negotiation Team">Negotiation Team</label>
                                    <textarea class="" name="negotiation_team">{{ $amendement_data->negotiation_team }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Trainer">Trainer</label>
                                    <select name="trainer" onchange="">
                                        <option value="">-- select --</option>
                                        <option value="internal-trainer" @if($amendement_data->trainer == 'internal-trainer') selected @endif>Internal Trainer</option>
                                        <option value="external-trainer" @if($amendement_data->trainer == 'external-trainer') selected @endif>External Trainer</option>
                                        <option value="contract-research-organization-trainer" @if($amendement_data->trainer == 'contract-research-organization-trainer') selected @endif>Contract Research Organization Trainer</option>
                                        <option value="subject-matter-expert" @if($amendement_data->trainer == 'subject-matter-expert') selected @endif>Subject Matter Expert</option>
                                        <option value="clinical-educator" @if($amendement_data->trainer == 'clinical-educator') selected @endif>Clinical Educator</option>
                                    </select>
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

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="sub-head">
                            Root Cause
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Root Cause Description">Root Cause Description</label>
                                    <textarea class="" name="root_cause_description">{{ $amendement_data->root_cause_description }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Reason(s) for Non-Approval">Reason(s) for Non-Approval</label>
                                    <textarea class="" name="reason_for_non_approval">{{ $amendement_data->reason_for_non_approval }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Reason(s) for Withdrawal">Reason(s) for Withdrawal</label>
                                    <textarea class="" name="reason_for_withdrawal">{{ $amendement_data->reason_for_withdrawal }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Justification/ Rationale">Justification/ Rationale</label>
                                    <textarea class="" name="justification_rationale">{{ $amendement_data->justification_rationale }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Meeting Minutes">Meeting Minutes</label>
                                    <textarea class="" name="meeting_minutes">{{ $amendement_data->meeting_minutes }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Rejection Reason">Rejection Reason</label>
                                    <textarea class="" name="rejection_reason">{{ $amendement_data->rejection_reason }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Effectiveness Check Summary">Effectiveness Check Summary</label>
                                    <textarea class="" name="effectiveness_check_summary">{{ $amendement_data->effectiveness_check_summary }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Decision">Decision</label>
                                    <textarea class="" name="decision">{{ $amendement_data->decision }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Summary">Summary</label>
                                    <textarea class="" name="summary">{{ $amendement_data->summary }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Documents Affected">Documents Affected</label>
                                    <select id="documents_affected" name="documents_affected" id="">
                                        <option value="">--Select---</option>
                                        <option value="protocol" @if($amendement_data->documents_affected == 'protocol') selected @endif>Protocol</option>
                                        <option value="informed-consent-form" @if($amendement_data->documents_affected == 'informed-consent-form') selected @endif>Informed Consent Form</option>
                                        <option value="investigators-brochure" @if($amendement_data->documents_affected == 'investigators-brochure') selected @endif>Investigators Brochure</option>
                                        <option value="case-report-forms" @if($amendement_data->documents_affected == 'case-report-forms') selected @endif>Case Report Forms</option>
                                        <option value="clinical-study-report" @if($amendement_data->documents_affected == 'clinical-study-report') selected @endif>Clinical Study Report</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Actual Time Spend">Actual Time Spend</label>
                                    <input type="text" name="actual_time_spend" id="actual_time_spend" value="{{ $amendement_data->actual_time_spend }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Documents">Documents</label>
                                    <input type="text" name="documents" id="documents" value="{{ $amendement_data->documents }}">
                                </div>
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

                <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Submission</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Submitted By :</b></label>
                                        <div class="">{{ $amendement_data->submit_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Submitted On : </b></label>
                                        <div class="date">{{ $amendement_data->submit_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Submitted Comments : </b></label>
                                        <div class="date">{{ $amendement_data->submit_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Cancel</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Cancelled By :</b></label>
                                        <div class="">{{ $amendement_data->cancel_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Cancelled On : </b></label>
                                        <div class="date">{{ $amendement_data->cancel_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Cancelled Comments : </b></label>
                                        <div class="date">{{ $amendement_data->cancel_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Notification Only</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Notified By :</b></label>
                                        <div class="">{{ $amendement_data->notification_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Notified On : </b></label>
                                        <div class="date">{{ $amendement_data->notification_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Notified Comments : </b></label>
                                        <div class="date">{{ $amendement_data->notification_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Finalize Dossier</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Finalized Dossier By :</b></label>
                                        <div class="">{{ $amendement_data->finalize_dossier_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Finalized Dossier On : </b></label>
                                        <div class="date">{{ $amendement_data->finalize_dossier_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Finalized Dossier Comments : </b></label>
                                        <div class="date">{{ $amendement_data->finalize_dossier_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Withdraw</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Withdraw By :</b></label>
                                        <div class="">{{ $amendement_data->withdraw_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Withdraw On : </b></label>
                                        <div class="date">{{ $amendement_data->withdraw_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Withdraw Comments : </b></label>
                                        <div class="date">{{ $amendement_data->withdraw_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Approved</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Approved By :</b></label>
                                        <div class="">{{ $amendement_data->approve_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Approved On : </b></label>
                                        <div class="date">{{ $amendement_data->approve_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Approved Comments : </b></label>
                                        <div class="date">{{ $amendement_data->approve_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Not Approved</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Not Approved By :</b></label>
                                        <div class="">{{ $amendement_data->not_approved_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Not Approved On : </b></label>
                                        <div class="date">{{ $amendement_data->not_approved_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Not Approved Comments : </b></label>
                                        <div class="date">{{ $amendement_data->not_approved_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Management Withdraw</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Management Withdraw By :</b></label>
                                        <div class="">{{ $amendement_data->management_withdraw_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Management Withdraw On : </b></label>
                                        <div class="date">{{ $amendement_data->management_withdraw_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Management Withdraw Comments : </b></label>
                                        <div class="date">{{ $amendement_data->management_withdraw_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Approved with Conditions/Comments</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Approved with Conditions By :</b></label>
                                        <div class="">{{ $amendement_data->management_approved_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Approved with Conditions On : </b></label>
                                        <div class="date">{{ $amendement_data->management_approved_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Approved with Conditions Comments : </b></label>
                                        <div class="date">{{ $amendement_data->management_approved_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">No Conditions to Fulfill Before FPI</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>No Conditions to Fulfill Before FPI By :</b></label>
                                        <div class="">{{ $amendement_data->no_conditions_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>No Conditions to Fulfill Before FPI On : </b></label>
                                        <div class="date">{{ $amendement_data->no_conditions_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>No Conditions to Fulfill Before FPI Comments : </b></label>
                                        <div class="date">{{ $amendement_data->no_conditions_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Conditions to Fulfill Before FPI</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Conditions to Fulfill Before FPI By :</b></label>
                                        <div class="">{{ $amendement_data->conditions_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Conditions to Fulfill Before FPI On : </b></label>
                                        <div class="date">{{ $amendement_data->conditions_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Conditions to Fulfill Before FPI Comments : </b></label>
                                        <div class="date">{{ $amendement_data->conditions_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Submit response</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Response submitted By :</b></label>
                                        <div class="">{{ $amendement_data->submit_response_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Response submitted On : </b></label>
                                        <div class="date">{{ $amendement_data->submit_response_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Response submitted Comments : </b></label>
                                        <div class="date">{{ $amendement_data->submit_response_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">All Conditions/Comments are met</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>All Conditions/Comments are met By :</b></label>
                                        <div class="">{{ $amendement_data->all_conditions_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>All Conditions/Comments are met On : </b></label>
                                        <div class="date">{{ $amendement_data->all_conditions_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>All Conditions Met Comments : </b></label>
                                        <div class="date">{{ $amendement_data->all_conditions_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Early Termination</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Early Terminated By :</b></label>
                                        <div class="">{{ $amendement_data->early_termination_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Early Terminated On : </b></label>
                                        <div class="date">{{ $amendement_data->early_termination_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Early Terminated Comments : </b></label>
                                        <div class="date">{{ $amendement_data->early_termination_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">More Comments</div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Victim"><b>Most Commented By :</b></label>
                                        <div class="">{{ $amendement_data->more_comments_by }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Most Commented On : </b></label>
                                        <div class="date">{{ $amendement_data->more_comments_on }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Most Commented : </b></label>
                                        <div class="date">{{ $amendement_data->more_comments_comment }}</div>
                                    </div>
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
    document.getElementById('clearSelection').addEventListener('click', function() {
        var radios = document.querySelectorAll('input[type="radio"]');
        for (var i = 0; i < radios.length; i++) {
            radios[i].checked = false;
        }
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
    $(document).on('click', '.removeRowBtn', function() {
        $(this).closest('tr').remove();
    })
</script>

     {{--Country Statecity API--}}
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

            const selectedCountryCode = countrySelect.value;
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
{{--Country Statecity API End--}}




@endsection
