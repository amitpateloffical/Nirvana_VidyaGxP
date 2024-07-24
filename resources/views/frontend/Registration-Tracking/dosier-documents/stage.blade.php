<style>
    #statusBlock > div > .active {
        background: #1aa71a;
        color: white;
    }

    #statusBlock > div > .closed {
        background: #d81515;
        color: white;
    }

    #statusBlock > div > div {
        font-size: 0.7rem;
    }
</style>
<div class="inner-block state-block">
    <div class="d-flex justify-content-between align-items-center">
    <div class="main-head">Record Workflow </div>
        <div class="d-flex" style="gap:20px;">
            @php
            $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])->get();
            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
            @endphp
            <button class="button_theme1"> <a class="text-white" href="{{ route('dosierdocuments.audit_trial', $data->id) }}"> Audit Trail </a> </button>

            @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">Assign Owner</button>  
                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal"> Cancel  </button>                        
            @elseif($data->stage == 2 && (in_array([4,14], $userRoleIds) || in_array(18, $userRoleIds)))
                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#request-more-info-modal">Request More Info</button>  
                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal"> Approve  </button> 
                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal"> Cancel  </button>                        

            @elseif($data->stage == 3 && (in_array(9, $userRoleIds) || in_array(18, $userRoleIds)))
                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#request-more-info-modal">Update Dossier</button>  
                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">Retire</button>
            @endif
            <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit</a> </button>
                
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
            <form action="{{ route('dosierdocuments.send_stage', $data->id) }}" method="POST">
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
            <div class="modal-footer">
            <button type="submit">Submit</button>
            <button type="button" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- request-more-info-modal  -->
<div class="modal fade" id="request-more-info-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">E-Signature</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('dosierdocuments.requestmoreinfo_back_stage', $data->id) }}" method="POST">
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
            <form action="{{ route('dosierdocuments.cancel_stage', $data->id) }}" method="POST">
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
                <div class="modal-footer">
                    <button type="submit">Submit</button>
                    <button type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Current Status -->
<div class="status" id="statusBlock">
    <div class="head">Current Status</div>
            @if ($data->stage == 0)
                <div class="progress-bars">
                    <div class="bg-danger">Closed-Cancelled</div>
                </div>
            @else
            <div class="progress-bars d-flex">
                @if ($data->stage >= 1)
                <div class="d-flex justify-items-center align-items-center border border-1 border-dark rounded-start p-2 active">Opened</div>
                @else
                <div class="d-flex justify-items-center align-items-center border border-1 border-dark rounded-start p-2">Opened</div>
                @endif

                @if ($data->stage >= 2)
                <div class=" active d-flex justify-items-center align-items-center border border-1 border-dark p-2 border-start-0">Dossier Review</div>
                @else
                <div class="  d-flex justify-items-center align-items-center border border-1 border-dark p-2 border-start-0">Dossier Review</div>
                @endif
                @if ($data->stage >= 3)
                <div class=" active d-flex justify-items-center align-items-center border border-1 border-dark p-2 border-start-0">Effective</div>
                @else
                <div class="d-flex justify-items-center align-items-center border border-1 border-dark p-2 border-start-0">Effective</div>
                @endif
                @if ($data->stage >= 4)
                <div class="bg-danger d-flex justify-items-center align-items-center border border-1 border-dark p-2 border-start-0"> Close Done</div>
                @else
                    <div class="d-flex justify-items-center align-items-center border border-1 border-dark p-2 border-start-0"> Close Done</div>
                @endif
            </div>
            @endif
    </div>
</div>