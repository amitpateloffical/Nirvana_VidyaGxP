<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\Resampling;
use App\Models\Resampling_Grid;
use App\Models\ResamplingAuditTrail;
use App\Models\ResamplingHistory;
use App\Models\RoleGroup;
use Carbon\Carbon;
use PDF;
use App\Models\User;
// use App\Models\Deviation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;




class ResamplingController extends Controller
{
    public function create()
    {
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.OOS.resampling_new', compact('due_date', 'record_number'));
    }


    public function resampling_store(Request $request)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
              return redirect()->back();
         }
         
        $resampling = new Resampling();
        $resampling->form_type = "Resampling";
        $resampling->originator_id = Auth::user()->name;
        $resampling->record = ((RecordNumber::first()->value('counter')) + 1);
        $resampling->division_id = $request->division_id;
        $resampling->initiator_id = Auth::user()->id;
        $resampling->division_code = $request->division_code;
        $resampling->intiation_date = $request->intiation_date;
        $resampling->assign_to = $request->assign_to;
        $resampling->due_date = $request->due_date;
        $resampling->initiator_Group = $request->initiator_Group;
        $resampling->initiator_group_code = $request->initiator_group_code;
        $resampling->short_description = ($request->short_description);
        $resampling->cq_Approver = $request->cq_Approver;
        $resampling->supervisor = $request->supervisor;
        $resampling->api_Material_Product_Name = $request->api_Material_Product_Name;
        $resampling->lot_Batch_Number = $request->lot_Batch_Number;
        $resampling->ar_Number_GI = $request->ar_Number_GI;
        $resampling->test_Name_GI = $request->test_Name_GI;
        $resampling->justification_for_resampling_GI = $request->justification_for_resampling_GI;
        $resampling->predetermined_Sampling_Strategies_GI = $request->predetermined_Sampling_Strategies_GI;
        
        if (!empty ($request->supporting_attach)) {
            $files = [];
            if ($request->hasfile('supporting_attach')) {
                foreach ($request->file('supporting_attach') as $file) {
                    $name = $request->name . 'supporting_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $resampling->supporting_attach = json_encode($files);
        }

        $resampling->parent_tcd_hid = $request->parent_tcd_hid;
        $resampling->parent_oos_no = $request->parent_oos_no;
        $resampling->parent_oot_no = $request->parent_oot_no;
        $resampling->parent_lab_incident_no = $request->parent_lab_incident_no;
        $resampling->parent_date_opened = $request->parent_date_opened;
        $resampling->parent_short_description = $request->parent_short_description;
        $resampling->parent_product_material_name = $request->parent_product_material_name;
        $resampling->parent_target_closure_date = $request->parent_target_closure_date;
        $resampling->sample_Request_Approval_Comments = $request->sample_Request_Approval_Comments;
        // $resampling->sample_Request_Approval_Comments = $request->sample_Request_Approval_Comments;

        if (!empty ($request->sample_Request_Approval_attachment)) {
            $files = [];
            if ($request->hasfile('sample_Request_Approval_attachment')) {
                foreach ($request->file('sample_Request_Approval_attachment') as $file) {
                    $name = $request->name . 'sample_Request_Approval_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $resampling->sample_Request_Approval_attachment = json_encode($files);
        }

        $resampling->sample_Received = $request->sample_Received;
        $resampling->sample_Quantity = $request->sample_Quantity;
        $resampling->sample_Received_Comments = $request->sample_Received_Comments;
        $resampling->delay_Justification = $request->delay_Justification;
        $resampling->delay_Justification = $request->delay_Justification;

        if (!empty ($request->file_attchment_pending_sample)) {
            $files = [];
            if ($request->hasfile('file_attchment_pending_sample')) {
                foreach ($request->file('file_attchment_pending_sample') as $file) {
                    $name = $request->name . 'file_attchment_pending_sample' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $resampling->file_attchment_pending_sample = json_encode($files);
        }

        $resampling->status = 'Opened';
        $resampling->stage = 1;
        $resampling->save();

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update(); 

        $grid_data = $resampling->id;


        $product_material = Resampling_Grid::where(['r_id'=>$grid_data,'identifer'=>'ProductMaterialInfo'])->firstOrNew();
        $product_material->r_id = $grid_data;
        $product_material->identifer = 'ProductMaterialInfo';
        $product_material->data = $request->product_material_information;
        $product_material->save();


                    // resampling grid 2-----------------------------

        $info_on_product = Resampling_Grid::where(['r_id'=>$grid_data,'identifer'=>'InfoOnProductMaterial'])->firstOrNew();
        $info_on_product->r_id = $grid_data;
        $info_on_product->identifer = 'InfoOnProductMaterial';
        $info_on_product->data = $request->info_on_product_mat;
        $info_on_product->save();


                     // resampling grid 3-----------------------------

        $oos_detail = Resampling_Grid::where(['r_id'=>$grid_data,'identifer'=>'OOSDetails'])->firstOrNew();
        $oos_detail->r_id = $grid_data;
        $oos_detail->identifer = 'OOSDetails';
        $oos_detail->data = $request->oos_details;
        $oos_detail->save();


                      // resampling grid 4-----------------------------

        $oot_details = Resampling_Grid::where(['r_id'=>$grid_data,'identifer'=>'OOTDetail'])->firstOrNew();
        $oot_details->r_id = $grid_data;
        $oot_details->identifer = 'OOTDetail';
        $oot_details->data = $request->oot_detail;
        $oot_details->save();


                     // resampling grid 5-----------------------------

        $stability_study1 = Resampling_Grid::where(['r_id'=>$grid_data,'identifer'=>'StabilityStudy1'])->firstOrNew();
        $stability_study1->r_id = $grid_data;
        $stability_study1->identifer = 'StabilityStudy1';
        $stability_study1->data = $request->stability_study;
        $stability_study1->save();

                      // resampling grid 6-----------------------------

        $stability_studys2 = Resampling_Grid::where(['r_id'=>$grid_data,'identifer'=>'StabilityStudy2'])->firstOrNew();
        $stability_studys2->r_id = $grid_data;
        $stability_studys2->identifer = 'StabilityStudy2';
        $stability_studys2->data = $request->stability_study2;
        $stability_studys2->save();

        if (!empty($resampling->short_description)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $resampling->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->assign_to)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Assign To';
            $history->previous = "Null";
            $history->current = $resampling->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->due_date)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = $resampling->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->initiator_Group)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Initiator Group';
            $history->previous = "Null";
            $history->current = $resampling->initiator_Group;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->cq_Approver)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'CQ Approver';
            $history->previous = "Null";
            $history->current = $resampling->cq_Approver;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->supervisor)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Supervisor';
            $history->previous = "Null";
            $history->current = $resampling->supervisor;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->api_Material_Product_Name)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'API Material Product Name';
            $history->previous = "Null";
            $history->current = $resampling->api_Material_Product_Name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->lot_Batch_Number)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'LOT Batch Number';
            $history->previous = "Null";
            $history->current = $resampling->lot_Batch_Number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->ar_Number_GI)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'AR Number';
            $history->previous = "Null";
            $history->current = $resampling->ar_Number_GI;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->test_Name_GI)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Test Name';
            $history->previous = "Null";
            $history->current = $resampling->test_Name_GI;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->justification_for_resampling_GI)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Justification For Resampling';
            $history->previous = "Null";
            $history->current = $resampling->justification_for_resampling_GI;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->predetermined_Sampling_Strategies_GI)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Predetermined Sampling Strategies';
            $history->previous = "Null";
            $history->current = $resampling->predetermined_Sampling_Strategies_GI;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->supporting_attach)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Supporting Attach';
            $history->previous = "Null";
            $history->current = $resampling->supporting_attach;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->parent_tcd_hid)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Parent TCD HID';
            $history->previous = "Null";
            $history->current = $resampling->parent_tcd_hid;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->parent_oos_no)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Parent OOS No';
            $history->previous = "Null";
            $history->current = $resampling->parent_oos_no;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->parent_oot_no)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Parent OOT No';
            $history->previous = "Null";
            $history->current = $resampling->parent_oot_no;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->parent_lab_incident_no)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Parent Lab Incident No';
            $history->previous = "Null";
            $history->current = $resampling->parent_lab_incident_no;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->parent_date_opened)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Parent Date Opened';
            $history->previous = "Null";
            $history->current = $resampling->parent_date_opened;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->parent_short_description)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Parent Short Description';
            $history->previous = "Null";
            $history->current = $resampling->parent_short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->parent_product_material_name)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Parent Product Material Name';
            $history->previous = "Null";
            $history->current = $resampling->parent_product_material_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->parent_target_closure_date)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Parent Target Closure Date';
            $history->previous = "Null";
            $history->current = $resampling->parent_target_closure_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->sample_Request_Approval_Comments)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Sample Request Approval Comments';
            $history->previous = "Null";
            $history->current = $resampling->sample_Request_Approval_Comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->sample_Request_Approval_attachment)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Sample Request Approval Attachment';
            $history->previous = "Null";
            $history->current = $resampling->sample_Request_Approval_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->sample_Received)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Sample Received';
            $history->previous = "Null";
            $history->current = $resampling->sample_Received;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->sample_Quantity)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Sample Quantity';
            $history->previous = "Null";
            $history->current = $resampling->sample_Quantity;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->sample_Received_Comments)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Sample Received Comments';
            $history->previous = "Null";
            $history->current = $resampling->sample_Received_Comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->delay_Justification)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'Delay Justification';
            $history->previous = "Null";
            $history->current = $resampling->delay_Justification;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty($resampling->file_attchment_pending_sample)) {
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $resampling->id;
            $history->activity_type = 'File Attchment Pending Sample';
            $history->previous = "Null";
            $history->current = $resampling->file_attchment_pending_sample;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $resampling->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }



        toastr()->success("Record is created Successfully");
         return redirect(url('rcms/qms-dashboard'));
    }

    public function resampling_update(Request $request, $id)
    {
        if (!$request->short_description) {
            toastr()->error("Short description is required");
              return redirect()->back();
         }

         $lastData =  Resampling::find($id);
         $resampling = Resampling::find($id); 

        //  $resampling->form_type = "Resampling";
        // $resampling->originator_id = Auth::user()->name;
        // $resampling->record = ((RecordNumber::first()->value('counter')) + 1);
        // $resampling->initiator_id = Auth::user()->id;
        // $resampling->division_id = $request->division_id;
        // $resampling->division_code = $request->division_code;
        // $resampling->intiation_date = $request->intiation_date;
        $resampling->assign_to = $request->assign_to;
        $resampling->due_date = $request->due_date;
        $resampling->initiator_Group = $request->initiator_Group;
        $resampling->initiator_group_code = $request->initiator_group_code;
        $resampling->short_description = ($request->short_description);
        $resampling->cq_Approver = $request->cq_Approver;
        $resampling->supervisor = $request->supervisor;
        $resampling->api_Material_Product_Name = $request->api_Material_Product_Name;
        $resampling->lot_Batch_Number = $request->lot_Batch_Number;
        $resampling->ar_Number_GI = $request->ar_Number_GI;
        $resampling->test_Name_GI = $request->test_Name_GI;
        $resampling->justification_for_resampling_GI = $request->justification_for_resampling_GI;
        $resampling->predetermined_Sampling_Strategies_GI = $request->predetermined_Sampling_Strategies_GI;
        
        if (!empty ($request->supporting_attach)) {
            $files = [];
            if ($request->hasfile('supporting_attach')) {
                foreach ($request->file('supporting_attach') as $file) {
                    $name = $request->name . 'supporting_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $resampling->supporting_attach = json_encode($files);
        }

        $resampling->parent_tcd_hid = $request->parent_tcd_hid;
        $resampling->parent_oos_no = $request->parent_oos_no;
        $resampling->parent_oot_no = $request->parent_oot_no;
        $resampling->parent_lab_incident_no = $request->parent_lab_incident_no;
        $resampling->parent_date_opened = $request->parent_date_opened;
        $resampling->parent_short_description = $request->parent_short_description;
        $resampling->parent_product_material_name = $request->parent_product_material_name;
        $resampling->parent_target_closure_date = $request->parent_target_closure_date;
        $resampling->sample_Request_Approval_Comments = $request->sample_Request_Approval_Comments;
        $resampling->sample_Request_Approval_Comments = $request->sample_Request_Approval_Comments;

        if (!empty ($request->sample_Request_Approval_attachment)) {
            $files = [];
            if ($request->hasfile('sample_Request_Approval_attachment')) {
                foreach ($request->file('sample_Request_Approval_attachment') as $file) {
                    $name = $request->name . 'sample_Request_Approval_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $resampling->sample_Request_Approval_attachment = json_encode($files);
        }

        $resampling->sample_Received = $request->sample_Received;
        $resampling->sample_Quantity = $request->sample_Quantity;
        $resampling->sample_Received_Comments = $request->sample_Received_Comments;
        $resampling->delay_Justification = $request->delay_Justification;
        $resampling->delay_Justification = $request->delay_Justification;

        if (!empty ($request->file_attchment_pending_sample)) {
            $files = [];
            if ($request->hasfile('file_attchment_pending_sample')) {
                foreach ($request->file('file_attchment_pending_sample') as $file) {
                    $name = $request->name . 'file_attchment_pending_sample' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $resampling->file_attchment_pending_sample = json_encode($files);
        }

        $resampling->update();

        $grid_data = $resampling->id;

        $product_material = Resampling_Grid::where(['r_id'=>$grid_data,'identifer'=>'ProductMaterialInfo'])->firstOrNew();
        $product_material->r_id = $grid_data;
        $product_material->identifer = 'ProductMaterialInfo';
        $product_material->data = $request->product_material_information;
        $product_material->update();


                    // resampling grid 2-----------------------------

        $info_on_product = Resampling_Grid::where(['r_id'=>$grid_data,'identifer'=>'InfoOnProductMaterial'])->firstOrNew();
        $info_on_product->r_id = $grid_data;
        $info_on_product->identifer = 'InfoOnProductMaterial';
        $info_on_product->data = $request->info_on_product_mat;
        $info_on_product->update();


                     // resampling grid 3-----------------------------

        $oos_detail = Resampling_Grid::where(['r_id'=>$grid_data,'identifer'=>'OOSDetails'])->firstOrNew();
        $oos_detail->r_id = $grid_data;
        $oos_detail->identifer = 'OOSDetails';
        $oos_detail->data = $request->oos_details;
        $oos_detail->update();


                      // resampling grid 4-----------------------------

        $oot_details = Resampling_Grid::where(['r_id'=>$grid_data,'identifer'=>'OOTDetail'])->firstOrNew();
        $oot_details->r_id = $grid_data;
        $oot_details->identifer = 'OOTDetail';
        $oot_details->data = $request->oot_detail;
        $oot_details->update();


                     // resampling grid 5-----------------------------

        $stability_study1 = Resampling_Grid::where(['r_id'=>$grid_data,'identifer'=>'StabilityStudy1'])->firstOrNew();
        $stability_study1->r_id = $grid_data;
        $stability_study1->identifer = 'StabilityStudy1';
        $stability_study1->data = $request->stability_study;
        $stability_study1->update();

                      // resampling grid 6-----------------------------

        $stability_studys2 = Resampling_Grid::where(['r_id'=>$grid_data,'identifer'=>'StabilityStudy2'])->firstOrNew();
        $stability_studys2->r_id = $grid_data;
        $stability_studys2->identifer = 'StabilityStudy2';
        $stability_studys2->data = $request->stability_study2;
        $stability_studys2->update();


        if ($lastData->short_description != $resampling->short_description || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastData->short_description;
            $history->current = $resampling->short_description;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->assign_to != $resampling->assign_to || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Assigned To';
            $history->previous = $lastData->assign_to;
            $history->current = $resampling->assign_to;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->due_date != $resampling->due_date || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Due Date';
            $history->previous = $lastData->due_date;
            $history->current = $resampling->due_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->initiator_Group != $resampling->initiator_Group || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Initiator Group';
            $history->previous = $lastData->initiator_Group;
            $history->current = $resampling->initiator_Group;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->cq_Approver != $resampling->cq_Approver || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'CQ Approver';
            $history->previous = $lastData->cq_Approver;
            $history->current = $resampling->cq_Approver;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->supervisor != $resampling->supervisor || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Supervisor';
            $history->previous = $lastData->supervisor;
            $history->current = $resampling->supervisor;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->api_Material_Product_Name != $resampling->api_Material_Product_Name || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'API Material Product Name';
            $history->previous = $lastData->api_Material_Product_Name;
            $history->current = $resampling->api_Material_Product_Name;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->lot_Batch_Number != $resampling->lot_Batch_Number || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'LOT Batch Number';
            $history->previous = $lastData->lot_Batch_Number;
            $history->current = $resampling->lot_Batch_Number;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->ar_Number_GI != $resampling->ar_Number_GI || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'AR Number';
            $history->previous = $lastData->ar_Number_GI;
            $history->current = $resampling->ar_Number_GI;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->test_Name_GI != $resampling->test_Name_GI || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Test Name';
            $history->previous = $lastData->test_Name_GI;
            $history->current = $resampling->test_Name_GI;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->justification_for_resampling_GI != $resampling->justification_for_resampling_GI || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Justification For Resampling';
            $history->previous = $lastData->justification_for_resampling_GI;
            $history->current = $resampling->justification_for_resampling_GI;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->predetermined_Sampling_Strategies_GI != $resampling->predetermined_Sampling_Strategies_GI || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Predetermined Sampling Strategies';
            $history->previous = $lastData->predetermined_Sampling_Strategies_GI;
            $history->current = $resampling->predetermined_Sampling_Strategies_GI;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->supporting_attach != $resampling->supporting_attach || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Supporting Attach';
            $history->previous = $lastData->supporting_attach;
            $history->current = $resampling->supporting_attach;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->parent_tcd_hid != $resampling->parent_tcd_hid || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Parent TCD HID';
            $history->previous = $lastData->parent_tcd_hid;
            $history->current = $resampling->parent_tcd_hid;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->parent_oos_no != $resampling->parent_oos_no || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Parent OOS No';
            $history->previous = $lastData->parent_oos_no;
            $history->current = $resampling->parent_oos_no;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->parent_oot_no != $resampling->parent_oot_no || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Parent OOT No';
            $history->previous = $lastData->parent_oot_no;
            $history->current = $resampling->parent_oot_no;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->parent_lab_incident_no != $resampling->parent_lab_incident_no || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Parent Lab Incident No';
            $history->previous = $lastData->parent_lab_incident_no;
            $history->current = $resampling->parent_lab_incident_no;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->parent_date_opened != $resampling->parent_date_opened || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Parent Date Opened';
            $history->previous = $lastData->parent_date_opened;
            $history->current = $resampling->parent_date_opened;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->parent_short_description != $resampling->parent_short_description || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Parent Short Description';
            $history->previous = $lastData->parent_date_opened;
            $history->current = $resampling->parent_date_opened;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->parent_product_material_name != $resampling->parent_product_material_name || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Parent Product Material Name';
            $history->previous = $lastData->parent_product_material_name;
            $history->current = $resampling->parent_product_material_name;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->parent_target_closure_date != $resampling->parent_target_closure_date || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Parent Target Closure Date';
            $history->previous = $lastData->parent_target_closure_date;
            $history->current = $resampling->parent_target_closure_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->sample_Request_Approval_Comments != $resampling->sample_Request_Approval_Comments || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Sample Request Approval Comments';
            $history->previous = $lastData->sample_Request_Approval_Comments;
            $history->current = $resampling->sample_Request_Approval_Comments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->sample_Request_Approval_attachment != $resampling->sample_Request_Approval_attachment || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Sample Request Approval Attachment';
            $history->previous = $lastData->sample_Request_Approval_attachment;
            $history->current = $resampling->sample_Request_Approval_attachment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->sample_Received != $resampling->sample_Received || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Sample Received';
            $history->previous = $lastData->sample_Received;
            $history->current = $resampling->sample_Received;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->sample_Quantity != $resampling->sample_Quantity || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Sample Quantity';
            $history->previous = $lastData->sample_Quantity;
            $history->current = $resampling->sample_Quantity;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->sample_Received_Comments != $resampling->sample_Received_Comments || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Sample Received Comments';
            $history->previous = $lastData->sample_Received_Comments;
            $history->current = $resampling->sample_Received_Comments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->delay_Justification != $resampling->delay_Justification || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'Delay Justification';
            $history->previous = $lastData->delay_Justification;
            $history->current = $resampling->delay_Justification;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastData->file_attchment_pending_sample != $resampling->file_attchment_pending_sample || !empty($request->comment)) {
            // return 'history';
            $history = new ResamplingAuditTrail();
            $history->resampling_id = $id;
            $history->activity_type = 'File Attchment Pending Sample';
            $history->previous = $lastData->file_attchment_pending_sample;
            $history->current = $resampling->file_attchment_pending_sample;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = 'Update';
            $history->save();
        }



        toastr()->success("Record is update Successfully");
        return back();

    }

    public function resampling_show($id) {
        $data = Resampling::find($id);
        if(empty($data)) {
            toastr()->error('Invalid ID.');
            return back();
        }

        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assigned_to)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        $resampling_id = $data->id;

        $gridDatas01 = Resampling_Grid::where(['r_id' => $resampling_id, 'identifer' => 'ProductMaterialInfo'])->first();
        $gridDatas02 = Resampling_Grid::where(['r_id' => $resampling_id,'identifer' => 'InfoOnProductMaterial'])->first();
        $gridDatas03 = Resampling_Grid::where(['r_id' => $resampling_id,'identifer' => 'OOSDetails'])->first();
        $gridDatas04 = Resampling_Grid::where(['r_id' => $resampling_id,'identifer' => 'OOTDetail'])->first();
        $gridDatas05 = Resampling_Grid::where(['r_id' => $resampling_id,'identifer' => 'StabilityStudy1'])->first();
        $gridDatas06 = Resampling_Grid::where(['r_id' => $resampling_id,'identifer' => 'StabilityStudy2'])->first();

        return view('frontend.OOS.resampling_view', compact('data', 'gridDatas01', 'gridDatas02', 'gridDatas03', 'gridDatas04', 'gridDatas05', 'gridDatas06','resampling_id'));
    }

    public function resampling_send_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $resampling = Resampling::find($id);
            $lastDocument =  Resampling::find($id);

            if ($resampling->stage == 1) {
                $resampling->stage = "2";
                $resampling->status = 'Under Sample Request Approval';
                $resampling->submitted_by = Auth::user()->name;
                $resampling->submitted_on = Carbon::now()->format('d-M-Y');
                $resampling->submitted_comment = $request->comment;
                $history = new ResamplingAuditTrail();
                $history->resampling_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $resampling->submitted_by;
                $history->comment = $request->comment;
                $history->action = 'Under Sample Request Approval';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Under Sample Request Approval";
                $history->change_from = $lastDocument->status;
                $history->stage='Under Sample Request Approval';

                $history->save();
                $resampling->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($resampling->stage == 2) {
                $resampling->stage = "3";
                $resampling->status = 'Pending Sample Receive';
                $resampling->approval_done_by = Auth::user()->name;
                $resampling->approval_done_on = Carbon::now()->format('d-M-Y');
                $resampling->approval_done_comment = $request->comment;
                $history = new ResamplingAuditTrail();
                $history->resampling_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $resampling->approval_done_by;
                $history->comment = $request->comment;
                $history->action = 'Pending Sample Receive';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Pending Sample Receive";
                $history->change_from = $lastDocument->status;
                $history->stage='Pending Sample Receive';

                $history->save();
                $resampling->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($resampling->stage == 3) {
                $resampling->stage = "4";
                $resampling->status = 'Closed - Done';
                $resampling->sample_received_by = Auth::user()->name;
                $resampling->sample_received_on = Carbon::now()->format('d-M-Y');
                $resampling->sample_received_comment = $request->comment;
                $history = new ResamplingAuditTrail();
                $history->resampling_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $resampling->sample_received_by;
                $history->comment = $request->comment;
                $history->action = 'Closed - Done';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Closed - Done";
                $history->change_from = $lastDocument->status;
                $history->stage='Closed - Done';

                $history->save();
                $resampling->update();
                toastr()->success('Document Sent');
                return back();
            }


        }else {
            toastr()->error('E-signature Not match');
            return back();
        }

    }

    public function resampling_Cancle(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $resampling = Resampling::find($id);
            $lastDocument =  Resampling::find($id);

            if ($resampling->stage == 1) {
                $resampling->stage = "0";
                $resampling->status = "Closed - Cancelled";
                $resampling->cancelled_by = Auth::user()->name;
                $resampling->cancelled_on = Carbon::now()->format('d-M-Y');
                $resampling->cancelled_comment = $request->comment;
                $resampling->update();

                $history = new ResamplingAuditTrail();
                $history->resampling_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $resampling->cancelled_by;
                $history->comment = $request->comment;
                $history->action = 'Closed - Cancelled';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to = "Closed - Cancelled";
                $history->change_from = $lastDocument->status;
                $history->stage='Closed - Cancelled';
                $history->save();

                $history = new ResamplingHistory();
                $history->type = "Resampling";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $resampling->stage;
                $history->status = $resampling->status;
                $history->save();
                toastr()->success('Document Sent');
                return back();
                
            }

        }else {
            toastr()->error('E-signature Not match');
            return back();
        }

    }

    public function resampling_reject(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $resampling = Resampling::find($id);

            if ($resampling->stage == 2) {
                $resampling->stage = "1";
                $resampling->status = "Opened";
                $resampling->more_info_by = Auth::user()->name;
                $resampling->more_info_on = Carbon::now()->format('d-M-Y');
                $resampling->more_info_comment = $request->comment;
                $resampling->update();

                $history = new ResamplingAuditTrail();
                $history->resampling_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $resampling->more_info_by;
                $history->comment = $request->comment;
                $history->action = 'Opened';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Opened";
                $history->change_from = $lastDocument->status;
                $history->stage='Opened';

                toastr()->success('Document Sent');
                return back();
            }

            if ($resampling->stage == 3) {
                $resampling->stage = "2";
                $resampling->status = "Under Sample Request Approval";
                $resampling->more_info_from_sample_req_by = Auth::user()->name;
                $resampling->more_info_from_sample_req_on = Carbon::now()->format('d-M-Y');
                $resampling->more_info_from_sample_req_comment = $request->comment;
                $resampling->update();

                $history = new ResamplingAuditTrail();
                $history->resampling_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $resampling->submitted_by;
                $history->comment = $request->comment;
                $history->action = 'Under Sample Request Approval';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Under Sample Request Approval";
                $history->change_from = $lastDocument->status;
                $history->stage='Under Sample Request Approval';

                toastr()->success('Document Sent');
                return back();
            }

        }else {
            toastr()->error('E-signature Not match');
            return back();
        }

    }

    public function resamplingAuditTrail($id)
    {
        $audit = ResamplingAuditTrail::where('resampling_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $today = Carbon::now()->format('d-m-y');
        $document = Resampling::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view("frontend.OOS.resampling_audit_trail", compact('audit', 'document', 'today'));

    }

    public function auditDetails(Request $request, $id)
    {
        $detail = ResamplingAuditTrail::find($id);

        $detail_data = ResamplingAuditTrail::where('activity_type', $detail->activity_type)->where('resampling_id', $detail->resampling_id)->latest()->get();

        $doc = Resampling::where('id', $detail->resampling_id)->first();

        $doc->origiator_name = User::find($doc->initiator_id);
        return view("frontend.OOS.audit-trail-inner", compact('detail', 'doc', 'detail_data'));
    }

    public static function singleReport($id)
    {
        $data = Resampling::find($id);

        $gridDatas1 = Resampling_Grid::where(['r_id' => $id, 'identifer' => 'ProductMaterialInfo'])->first();
        $gridDatas2 = Resampling_Grid::where(['r_id' => $id, 'identifer' => 'InfoOnProductMaterial'])->first();
        $gridDatas3 = Resampling_Grid::where(['r_id' => $id, 'identifer' => 'OOSDetails'])->first();
        $gridDatas4 = Resampling_Grid::where(['r_id' => $id, 'identifer' => 'OOTDetail'])->first();
        $gridDatas5 = Resampling_Grid::where(['r_id' => $id, 'identifer' => 'StabilityStudy1'])->first();
        $gridDatas6 = Resampling_Grid::where(['r_id' => $id, 'identifer' => 'StabilityStudy2'])->first();

        if (!empty($data)) {
            $data->originator_id = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.OOS.singleReport', compact('data','gridDatas1','gridDatas2','gridDatas3','gridDatas4','gridDatas5','gridDatas6'))
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
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('Resampling' . $id . '.pdf');
        }

    }

    public static function auditReport($id)
    {
        $doc = Resampling::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = ResamplingAuditTrail::where('resampling_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.OOS.auditReport', compact('data', 'doc'))
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

}





