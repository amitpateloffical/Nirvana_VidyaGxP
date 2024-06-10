<?php

namespace App\Http\Controllers\registrationTracking;

use App\Http\Controllers\Controller;
use App\Models\RoleGroup;
use App\Models\User;
use App\Models\Variation;
use App\Models\VariationAuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VariationController extends Controller
{

    public function index() {
        return view('frontend.Registration-Tracking.variation');
    }

    public function store(Request $request) {
        $variation = new Variation();
        $variation->stage = '1';
        $variation->status = 'Opened';
        $variation->trade_name = $request->trade_name;
        $variation->member_state = $request->member_state;
        $variation->initiator = Auth::user()->id;
        $variation->date_of_initiation = $request->date_of_initiation;
        $variation->short_description = $request->short_description;
        $variation->assigned_to = $request->assigned_to;
        $variation->date_due = $request->date_due;
        $variation->type = $request->type;
        $variation->related_change_control = $request->related_change_control;
        $variation->variation_description = $request->variation_description;
        $variation->variation_code = $request->variation_code;
        if (!empty($request->attached_files)) {
            $files = [];
            if ($request->hasfile('attached_files')) {
                foreach ($request->file('attached_files') as $file) {
                    $name = "CC" . '-attached_files' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $variation->attached_files = json_encode($files);
        }
        $variation->change_from = $request->change_from;
        $variation->change_to = $request->change_to;
        $variation->description = $request->description;
        $variation->documents = $request->documents;
        $variation->save();

        // -------------------create audit trail--------------------

        // (Root Parent) Trade Name
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = '(Root Parent) Trade Name';
        $history->previous = 'Null';
        $history->current = $variation->trade_name;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // (Parent) Member State
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = '(Parent) Member State';
        $history->previous = 'Null';
        $history->current = $variation->member_state;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // Initiator
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = 'Initiator';
        $history->previous = 'Null';
        $history->current = $variation->initiator;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // Date Of Initiation
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = 'Date Of Initiation';
        $history->previous = 'Null';
        $history->current = $variation->date_of_initiation;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // Short Description
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = 'Short Description';
        $history->previous = 'Null';
        $history->current = $variation->short_description;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // Assigned To
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = 'Assigned To';
        $history->previous = 'Null';
        $history->current = $variation->assigned_to;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // Date Due
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = 'Date Due';
        $history->previous = 'Null';
        $history->current = $variation->date_due;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // Type
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = 'Type';
        $history->previous = 'Null';
        $history->current = $variation->type;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // Related Change Control
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = 'Related Change Control';
        $history->previous = 'Null';
        $history->current = $variation->related_change_control;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // Variation Description
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = 'Variation Description';
        $history->previous = 'Null';
        $history->current = $variation->variation_description;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // Variation Code
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = 'Variation Code';
        $history->previous = 'Null';
        $history->current = $variation->variation_code;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // Change From
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = 'Change From';
        $history->previous = 'Null';
        $history->current = $variation->change_from;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // Change To
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = 'Change To';
        $history->previous = 'Null';
        $history->current = $variation->change_to;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // Description
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = 'Description';
        $history->previous = 'Null';
        $history->current = $variation->description;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        // Documents
        $history = new VariationAuditTrail();
        $history->variation_id = $variation->id;
        $history->activity_type = 'Documents';
        $history->previous = 'Null';
        $history->current = $variation->documents;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->change_to = 'Opened';
        $history->change_from = 'Initiate';
        $history->comment = 'Not Applicable';
        $history->action_name = 'Create';
        $history->save();

        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function show($id) {
        $data = Variation::find($id);
        return view('frontend.Registration-Tracking.variationView',compact('data'));
    }
}
