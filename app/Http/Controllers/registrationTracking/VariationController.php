<?php

namespace App\Http\Controllers\registrationTracking;

use App\Http\Controllers\Controller;
use App\Models\RoleGroup;
use App\Models\User;
use App\Models\Variation;
use App\Models\VariationGrid;
use App\Models\VariationAuditTrail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use PDF;



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

        $variation_id = $variation->id;

        $variationGrid = VariationGrid::where(['variation_id' => $variation_id, 'identifier' => 'Packaging'])->firstOrNew();
        $variationGrid->variation_id = $variation_id;
        $variationGrid->identifier = 'Packaging';
        $variationGrid->data = $request->packaging;
        $variationGrid->save();


        // -------------------create audit trail--------------------

        // (Root Parent) Trade Name
        if (!empty($request->trade_name)) {
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
        }

        // (Parent) Member State
        if (!empty($request->member_state)) {
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
        }

        // Initiator
        if (!empty($request->initiator)) {
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
        }

        // Date Of Initiation
        if (!empty($request->date_of_initiation)) {
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
        }

        // Short Description
        if (!empty($request->short_description)) {
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
        }

        // Assigned To
        if (!empty($request->assigned_to)) {
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
        }

        // Date Due
        if (!empty($request->date_due)) {
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
        }

        // Type
        if (!empty($request->type)) {
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
        }

        // Related Change Control
        if (!empty($request->related_change_control)) {
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
        }

        // Variation Description
        if (!empty($request->variation_description)) {
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
        }

        // Variation Code
        if (!empty($request->variation_code)) {
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
        }

        // Change From
        if (!empty($request->change_from)) {
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
        }

        // Change To
        if (!empty($request->change_to)) {
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
        }

        // Description
        if (!empty($request->description)) {
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
        }

        // Documents
        if (!empty($request->documents)) {
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
        }

        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function show($id) {
        $data = Variation::find($id);

        $packaging = VariationGrid::where(['variation_id' => $id, 'identifier' => 'Packaging'])->first();

        return view('frontend.Registration-Tracking.variationView',compact('data', 'packaging'));
    }

    public function update(Request $request, $id) {
        // dd($request->all());

        $lastVariation = Variation::find($id);
        $variation = Variation::find($id);

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
        // variation plan
        $variation->registration_status = $request->registration_status;
        $variation->registration_number = $request->registration_number;
        $variation->planned_submission_date = $request->planned_submission_date;
        $variation->actual_submission_date = $request->actual_submission_date;
        $variation->planned_approval_date = $request->planned_approval_date;
        $variation->actual_approval_date = $request->actual_approval_date;
        $variation->actual_withdrawn_date = $request->actual_withdrawn_date;
        $variation->actual_rejection_date = $request->actual_rejection_date;
        $variation->comments = $request->comments;
        $variation->related_countries = $request->related_countries;
        // product details
        $variation->product_trade_name = $request->product_trade_name;
        $variation->local_trade_name = $request->local_trade_name;
        $variation->manufacturer = $request->manufacturer;
        $variation->update();

        $variation_id = $variation->id;

        $variationGrid = VariationGrid::where(['variation_id' => $variation_id, 'identifier' => 'Packaging'])->firstOrNew();
        $variationGrid->variation_id = $variation_id;
        $variationGrid->identifier = 'Packaging';
        $variationGrid->data = $request->packaging;
        $variationGrid->save();
        return back();

        // -------------------- Audit Trail------------------------

        // (Root Parent) Trade Name
        if ($lastVariation->trade_name != $variation->trade_name || !empty($request->trade_name)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = '(Root Parent) Trade Name';
            $history->previous = $lastVariation->trade_name;
            $history->current = $variation->trade_name;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // (Parent) Member State
        if ($lastVariation->member_state != $variation->member_state || !empty($request->member_state)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = '(Parent) Member State';
            $history->previous = $lastVariation->member_state;
            $history->current = $variation->member_state;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // Initiator
        if ($lastVariation->initiator != $variation->initiator || !empty($request->initiator)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Initiator';
            $history->previous = $lastVariation->initiator;
            $history->current = $variation->initiator;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // Date Of Initiation
        if ($lastVariation->date_of_initiation != $variation->date_of_initiation || !empty($request->date_of_initiation)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Date Of Initiation';
            $history->previous = $lastVariation->date_of_initiation;
            $history->current = $variation->date_of_initiation;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // Short Description
        if ($lastVariation->short_description != $variation->short_description || !empty($request->short_description)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastVariation->short_description;
            $history->current = $variation->short_description;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // Assigned To
        if ($lastVariation->assigned_to != $variation->assigned_to || !empty($request->assigned_to)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Assigned To';
            $history->previous = $lastVariation->assigned_to;
            $history->current = $variation->assigned_to;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // Date Due
        if ($lastVariation->date_due != $variation->date_due || !empty($request->date_due)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Date Due';
            $history->previous = $lastVariation->date_due;
            $history->current = $variation->date_due;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // Type
        if ($lastVariation->type != $variation->type || !empty($request->type)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Type';
            $history->previous = $lastVariation->type;
            $history->current = $variation->type;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // Related Change Control
        if ($lastVariation->related_change_control != $variation->related_change_control || !empty($request->related_change_control)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Related Change Control';
            $history->previous = $lastVariation->related_change_control;
            $history->current = $variation->related_change_control;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // Variation Description
        if ($lastVariation->variation_description != $variation->variation_description || !empty($request->variation_description)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Variation Description';
            $history->previous = $lastVariation->variation_description;
            $history->current = $variation->variation_description;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // Variation Code
        if ($lastVariation->variation_code != $variation->variation_code || !empty($request->variation_code)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Variation Code';
            $history->previous = $lastVariation->variation_code;
            $history->current = $variation->variation_code;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // Change From
        if ($lastVariation->change_from != $variation->change_from || !empty($request->change_from)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Change From';
            $history->previous = $lastVariation->change_from;
            $history->current = $variation->change_from;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // Change To
        if ($lastVariation->change_to != $variation->change_to || !empty($request->change_to)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Change To';
            $history->previous = $lastVariation->change_to;
            $history->current = $variation->change_to;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // Description
        if ($lastVariation->description != $variation->description || !empty($request->description)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Description';
            $history->previous = $lastVariation->description;
            $history->current = $variation->description;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // Documents
        if ($lastVariation->documents != $variation->documents || !empty($request->documents)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->documents;
            $history->current = $variation->documents;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // registration_status
        if ($lastVariation->registration_status != $variation->registration_status || !empty($request->registration_status)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->registration_status;
            $history->current = $variation->registration_status;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // registration_number
        if ($lastVariation->registration_number != $variation->registration_number || !empty($request->registration_number)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->registration_number;
            $history->current = $variation->registration_number;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // planned_submission_date
        if ($lastVariation->planned_submission_date != $variation->planned_submission_date || !empty($request->planned_submission_date)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->planned_submission_date;
            $history->current = $variation->planned_submission_date;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // actual_submission_date
        if ($lastVariation->actual_submission_date != $variation->actual_submission_date || !empty($request->actual_submission_date)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->actual_submission_date;
            $history->current = $variation->actual_submission_date;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // planned_approval_date
        if ($lastVariation->planned_approval_date != $variation->planned_approval_date || !empty($request->planned_approval_date)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->planned_approval_date;
            $history->current = $variation->planned_approval_date;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // actual_approval_date
        if ($lastVariation->actual_approval_date != $variation->actual_approval_date || !empty($request->actual_approval_date)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->actual_approval_date;
            $history->current = $variation->actual_approval_date;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // actual_withdrawn_date
        if ($lastVariation->actual_withdrawn_date != $variation->actual_withdrawn_date || !empty($request->actual_withdrawn_date)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->actual_withdrawn_date;
            $history->current = $variation->actual_withdrawn_date;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // actual_rejection_date
        if ($lastVariation->actual_rejection_date != $variation->actual_rejection_date || !empty($request->actual_rejection_date)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->actual_rejection_date;
            $history->current = $variation->actual_rejection_date;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // comments
        if ($lastVariation->comments != $variation->comments || !empty($request->comments)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->comments;
            $history->current = $variation->comments;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // related_countries
        if ($lastVariation->related_countries != $variation->related_countries || !empty($request->related_countries)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->related_countries;
            $history->current = $variation->related_countries;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // product_trade_name
        if ($lastVariation->product_trade_name != $variation->product_trade_name || !empty($request->product_trade_name)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->product_trade_name;
            $history->current = $variation->product_trade_name;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // local_trade_name
        if ($lastVariation->local_trade_name != $variation->local_trade_name || !empty($request->local_trade_name)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->local_trade_name;
            $history->current = $variation->local_trade_name;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }

        // manufacturer
        if ($lastVariation->manufacturer != $variation->manufacturer || !empty($request->manufacturer)) {
            $history = new VariationAuditTrail();
            $history->variation_id = $variation->id;
            $history->activity_type = 'Documents';
            $history->previous = $lastVariation->manufacturer;
            $history->current = $variation->manufacturer;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->change_to = 'Not Applicable';
            $history->change_from = $lastVariation->status;
            $history->comment = 'Not Applicable';
            $history->action_name = 'Update';
            $history->save();
        }
    }

    public function sendStage(Request $request, $id) {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $variation = Variation::find($id);
            $lastVariation = Variation::find($id);

            if ($variation->stage == 1) {
                $variation->stage = "2";
                $variation->status = "Submission Preparation";
                $variation->started_by = Auth::user()->name;
                $variation->started_on = Carbon::now()->format('d-m-Y');
                $variation->started_comment = $request->comment;
                    // ------------ Audit Trail -----------
                    $history = new VariationAuditTrail;
                    $history->variation_id = $variation->id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = 'Not Applicable';
                    $history->current = 'Not Applicable';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = 'Submission Preparation';
                    $history->change_from = $lastVariation->status;
                    $history->comment = $request->comment;
                    $history->action = 'Submit';
                    $history->save();

                $variation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($variation->stage == 2) {
                $variation->stage = "3";
                $variation->status = "Pending Submission Review";
                $variation->review_submitted_by = Auth::user()->name;
                $variation->review_submitted_on = Carbon::now()->format('d-m-Y');
                $variation->review_submitted_comment = $request->comment;
                    // ------------ Audit Trail -----------
                    $history = new VariationAuditTrail;
                    $history->variation_id = $variation->id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = 'Not Applicable';
                    $history->current = 'Not Applicable';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = 'Pending Submission Review';
                    $history->change_from = $lastVariation->status;
                    $history->comment = $request->comment;
                    $history->action = 'Submit';
                    $history->save();

                $variation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($variation->stage == 3) {
                $variation->stage = "4";
                $variation->status = "Authority Assessment";
                $variation->submitted_by = Auth::user()->name;
                $variation->submitted_on = Carbon::now()->format('d-m-Y');
                $variation->submitted_comment = $request->comment;
                    // ------------ Audit Trail -----------
                    $history = new VariationAuditTrail;
                    $history->variation_id = $variation->id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = 'Not Applicable';
                    $history->current = 'Not Applicable';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = 'Authority Assessment';
                    $history->change_from = $lastVariation->status;
                    $history->comment = $request->comment;
                    $history->action = 'Submit';
                    $history->save();

                $variation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($variation->stage == 4) {
                $variation->stage = "5";
                $variation->status = "Pending Registration Update";
                $variation->approved_by = Auth::user()->name;
                $variation->approved_on = Carbon::now()->format('d-m-Y');
                $variation->approved_comment = $request->comment;
                    // ------------ Audit Trail -----------
                    $history = new VariationAuditTrail;
                    $history->variation_id = $variation->id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = 'Not Applicable';
                    $history->current = 'Not Applicable';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = 'Pending Registration Update';
                    $history->change_from = $lastVariation->status;
                    $history->comment = $request->comment;
                    $history->action = 'Submit';
                    $history->save();

                $variation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($variation->stage == 5) {
                $variation->stage = "6";
                $variation->status = "Approved";
                $variation->registration_updated_by = Auth::user()->name;
                $variation->registration_updated_on = Carbon::now()->format('d-m-Y');
                $variation->registration_updated_comment = $request->comment;
                    // ------------ Audit Trail -----------
                    $history = new VariationAuditTrail;
                    $history->variation_id = $variation->id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = 'Not Applicable';
                    $history->current = 'Not Applicable';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = 'Approved';
                    $history->change_from = $lastVariation->status;
                    $history->comment = $request->comment;
                    $history->action = 'Submit';
                    $history->save();

                $variation->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }

    public function cancel(Request $request, $id) {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $variation = Variation::find($id);
            $lastVariation = Variation::find($id);

            if ($variation->stage == 1) {
                $variation->stage = "0";
                $variation->status = "Closed - Cancelled";
                $variation->cancelled_by = Auth::user()->name;
                $variation->cancelled_on = Carbon::now()->format('d-m-Y');
                $variation->cancelled_comment = $request->comment;
                    // ------------ Audit Trail -----------
                    $history = new VariationAuditTrail;
                    $history->variation_id = $variation->id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = 'Not Applicable';
                    $history->current = 'Not Applicable';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = 'Closed - Cancelled';
                    $history->change_from = $lastVariation->status;
                    $history->comment = $request->comment;
                    $history->action = 'Submit';
                    $history->save();

                $variation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($variation->stage == 2) {
                $variation->stage = "0";
                $variation->status = "Closed - Cancelled";
                $variation->cancelled_by = Auth::user()->name;
                $variation->cancelled_on = Carbon::now()->format('d-m-Y');
                $variation->cancelled_comment = $request->comment;
                    // ------------ Audit Trail -----------
                    $history = new VariationAuditTrail;
                    $history->variation_id = $variation->id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = 'Not Applicable';
                    $history->current = 'Not Applicable';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = 'Closed - Cancelled';
                    $history->change_from = $lastVariation->status;
                    $history->comment = $request->comment;
                    $history->action = 'Submit';
                    $history->save();

                $variation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($variation->stage == 3) {
                $variation->stage = "0";
                $variation->status = "Closed - Cancelled";
                $variation->cancelled_by = Auth::user()->name;
                $variation->cancelled_on = Carbon::now()->format('d-m-Y');
                $variation->cancelled_comment = $request->comment;
                    // ------------ Audit Trail -----------
                    $history = new VariationAuditTrail;
                    $history->variation_id = $variation->id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = 'Not Applicable';
                    $history->current = 'Not Applicable';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = 'Closed - Cancelled';
                    $history->change_from = $lastVariation->status;
                    $history->comment = $request->comment;
                    $history->action = 'Submit';
                    $history->save();

                $variation->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }

    public function withdraw(Request $request, $id) {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $variation = Variation::find($id);
            $lastVariation = Variation::find($id);

            if ($variation->stage == 4) {
                $variation->stage = "-1";
                $variation->status = "Closed - Withdrawn";
                $variation->withdrawn_by = Auth::user()->name;
                $variation->withdrawn_on = Carbon::now()->format('d-m-Y');
                $variation->withdrawn_comment = $request->comment;
                    // ------------ Audit Trail -----------
                    $history = new VariationAuditTrail;
                    $history->variation_id = $variation->id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = 'Not Applicable';
                    $history->current = 'Not Applicable';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = 'Closed - Withdrawn';
                    $history->change_from = $lastVariation->status;
                    $history->comment = $request->comment;
                    $history->action = 'Submit';
                    $history->save();

                $variation->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }

    public function refused(Request $request, $id) {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $variation = Variation::find($id);
            $lastVariation = Variation::find($id);

            if ($variation->stage == 4) {
                $variation->stage = "-2";
                $variation->status = "Closed - Not Approved";
                $variation->refused_by = Auth::user()->name;
                $variation->refused_on = Carbon::now()->format('d-m-Y');
                $variation->refused_comment = $request->comment;
                    // ------------ Audit Trail -----------
                    $history = new VariationAuditTrail;
                    $history->variation_id = $variation->id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = 'Not Applicable';
                    $history->current = 'Not Applicable';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = 'Closed - Not Approved';
                    $history->change_from = $lastVariation->status;
                    $history->comment = $request->comment;
                    $history->action = 'Submit';
                    $history->save();

                $variation->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }

    public function retired(Request $request, $id) {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $variation = Variation::find($id);
            $lastVariation = Variation::find($id);

            if ($variation->stage == 5) {
                $variation->stage = "-3";
                $variation->status = "Closed - Retired";
                $variation->registration_retired_by = Auth::user()->name;
                $variation->registration_retired_on = Carbon::now()->format('d-m-Y');
                $variation->registration_retired_comment = $request->comment;
                    // ------------ Audit Trail -----------
                    $history = new VariationAuditTrail;
                    $history->variation_id = $variation->id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = 'Not Applicable';
                    $history->current = 'Not Applicable';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = 'Closed - Retired';
                    $history->change_from = $lastVariation->status;
                    $history->comment = $request->comment;
                    $history->action = 'Submit';
                    $history->save();

                $variation->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }

    public function moreInfo(Request $request, $id) {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $variation = Variation::find($id);
            $lastVariation = Variation::find($id);

            if ($variation->stage == 2) {
                $variation->stage = "1";
                $variation->status = "Opened";
                $variation->req_info_by = Auth::user()->name;
                $variation->req_info_on = Carbon::now()->format('d-m-Y');
                $variation->req_info_comment = $request->comment;
                    // ------------ Audit Trail -----------
                    $history = new VariationAuditTrail;
                    $history->variation_id = $variation->id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = 'Not Applicable';
                    $history->current = 'Not Applicable';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = 'Opened';
                    $history->change_from = $lastVariation->status;
                    $history->comment = $request->comment;
                    $history->action = 'Submit';
                    $history->save();

                $variation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($variation->stage == 3) {
                $variation->stage = "1";
                $variation->status = "Opened";
                $variation->req_info_by = Auth::user()->name;
                $variation->req_info_on = Carbon::now()->format('d-m-Y');
                $variation->req_info_comment = $request->comment;
                    // ------------ Audit Trail -----------
                    $history = new VariationAuditTrail;
                    $history->variation_id = $variation->id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = 'Not Applicable';
                    $history->current = 'Not Applicable';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to = 'Opened';
                    $history->change_from = $lastVariation->status;
                    $history->comment = $request->comment;
                    $history->action = 'Submit';
                    $history->save();

                $variation->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }

    public function auditTrail($id) {
        $audit = VariationAuditTrail::where('variation_id', $id)
        ->orderByDesc('id')
        ->paginate(5);

        // dd($audit);
        $today = Carbon::now()->format('d-m-y');
        $document = Variation::where('id', $id)->first();
        // dd( $document);

        $document->initiator = User::where('id', $document->initiator_id)->value('name');


        // return $audit;

        return view('frontend.Registration-Tracking.variationAudit', compact('audit', 'document', 'today'));
    }

    public function audit_pdf($id) {
        $doc = Variation::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        }
        $data = VariationAuditTrail::where('variation_id', $doc->id)->orderByDesc('id')->get();
        // pdf related work
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.Registration-Tracking.variationAuditPdf', compact('data', 'doc'))
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
            ]);
        $pdf->setPaper('A4');
        $pdf->render();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $height = $canvas->get_height();
        $width = $canvas->get_width();

        $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');

        $canvas->page_text(
            $width / 3,
            $height / 2,
            $doc->status,
            null,
            60,
            [0, 0, 0],
            2,
            6,
            -20
        );



        return $pdf->stream('SOP' . $id . '.pdf');
    }

    public function single_pdf($id)
    {
        $data = Variation::find($id);
        $packaging = VariationGrid::where(['variation_id' => $id, 'identifier' => 'Packaging'])->first();

        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator)->value('name');

            // pdf related work
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.Registration-Tracking.variationSingleReport', compact('data', 'packaging'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();

            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');

            $canvas->page_text(
                $width / 4,
                $height / 2,
                $data->status,
                null,
                25,
                [0, 0, 0],
                2,
                6,
                -20
            );



            return $pdf->stream('SOP' . $id . '.pdf');
        }
    }
}
