<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\Resampling;
use App\Models\Resampling_Grid;
// use App\Models\Deviation;
use Illuminate\Support\Facades\Auth;




class ResamplingController extends Controller
{
    public function create(){


        return view('frontend.OOS.resampling_new');
    }


    public function store(Request $request)
    {
        // dd($request);
        // if (!$request->short_description) {
        //     toastr()->error("Short description is required");
        //     return response()->redirect()->back()->withInput();
        // }
        $resampling = new Resampling();
        $resampling->form_type = "Resampling";
        $resampling->record = ((RecordNumber::first()->value('counter')) + 1);
        // $resampling->initiator_id = Auth::user()->id;

        # -------------new-----------
            $resampling->record_number = $request->record_number;
            $resampling->division_id = $request->division_id;

            $resampling->division_code = $request->division_code;

            $resampling->intiation_date = $request->intiation_date;
            $resampling->assign_to = $request->assign_to;
            $resampling->due_date = $request->due_date;
            $resampling->initiator_Group = $request->initiator_Group;
            $resampling->initiator_group_code = $request->initiator_group_code;
            $resampling->short_description = $request->short_description;
            $resampling->cq_Approver = $request->cq_Approver;
            $resampling->supervisor = $request->supervisor;
            $resampling->api_Material_Product_Name = $request->api_Material_Product_Name;
            $resampling->lot_Batch_Number = $request->lot_Batch_Number;
            $resampling->ar_Number_GI = $request->ar_Number_GI;
            $resampling->test_Name_GI = $request->test_Name_GI;
            $resampling->justification_for_resampling_GI = $request->justification_for_resampling_GI;
            $resampling->predetermined_Sampling_Strategies_GI = $request->predetermined_Sampling_Strategies_GI;

            $resampling->parent_tcd_hid = $request->parent_tcd_hid;
            $resampling->parent_oos_no = $request->parent_oos_no;
            $resampling->parent_oot_no = $request->parent_oot_no;
            $resampling->parent_lab_incident_no = $request->parent_lab_incident_no;
            $resampling->parent_date_opened = $request->parent_date_opened;
            $resampling->parent_short_description = $request->parent_short_description;
            $resampling->parent_product_material_name = $request->parent_product_material_name;
            $resampling->parent_target_closure_date = $request->parent_target_closure_date;

            //tab 2
            $resampling->sample_Request_Approval_Comments = $request->sample_Request_Approval_Comments;

            //tab 3
            $resampling->sample_Received = $request->sample_Received;
            $resampling->sample_Quantity = $request->sample_Quantity;
            $resampling->sample_Received_Comments = $request->sample_Received_Comments;
            $resampling->delay_Justification = $request->delay_Justification;

            $resampling->record = $request->record;
            $resampling->division_id = $request->division_id;
            $resampling->form_type = $request->form_type;

            $resampling->status = $request->status;
            $resampling->stage = $request->stage;


        // $deviation->Closure_Comments = $request->Closure_Comments;
        // $deviation->Disposition_Batch = $request->Disposition_Batch;

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
        //dd($request->Initial_attachment);
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
        // $record = RecordNumber::first();
        // $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        // $record->update();
                    // $resampling->status = 'Opened';
                    // $resampling->stage = 1;

        $resampling->save();
// ----------------------------------- Grid ------------------------------------------------------------------

//    if($request->has('oocevoluation')){
// if (!empty($request->instrumentdetails)) {

// $oocevaluation = OOC_Grid::where(['ooc_id'=>$oocGrid,'identifier'=>'OOC Evaluation'])->firstOrNew();
// $oocevaluation->ooc_id = $oocGrid;
// $oocevaluation->identifier = 'OOC Evaluation';
// $oocevaluation->data = $request->oocevoluation;
// $oocevaluation->save();

// resampling grid 1------------------------------

                    $grid_data = $resampling->id;
                    $product_material = Resampling_Grid::where(['resampling_id'=>$grid_data,'identifier'=>'product material info'])->firstOrNew();
                    $product_material->resampling_id = $grid_data;
                    $product_material->identifier = 'Product Material Info';
                    $product_material->data = $request->product_material_information;
                    $product_material->save();


                    // resampling grid 2-----------------------------

                    $grid_data2 = $resampling->id;
                    $info_on_product = Resampling_Grid::where(['resampling_id'=>$grid_data2,'identifier'=>'info on product mat'])->firstOrNew();
                    $info_on_product->resampling_id = $grid_data2;
                    $info_on_product->identifier = 'Info on Product Material';
                    $info_on_product->data = $request->info_on_product_mat;
                    $info_on_product->save();


                     // resampling grid 3-----------------------------

                     $grid_data3 = $resampling->id;
                     $oos_detail = Resampling_Grid::where(['resampling_id'=>$grid_data3,'identifier'=>'OOS Detail'])->firstOrNew();
                     $oos_detail->resampling_id = $grid_data3;
                     $oos_detail->identifier = 'OOS Details';
                     $oos_detail->data = $request->oos_details;
                     $oos_detail->save();


                      // resampling grid 4-----------------------------

                    $grid_data4 = $resampling->id;
                    $oot_details = Resampling_Grid::where(['resampling_id'=>$grid_data4,'identifier'=>'oot detail'])->firstOrNew();
                    $oot_details->resampling_id = $grid_data4;
                    $oot_details->identifier = 'OOT Detail';
                    $oot_details->data = $request->oot_detail;
                    $oot_details->save();


                     // resampling grid 5-----------------------------

                     $grid_data5 = $resampling->id;
                     $stability_study1 = Resampling_Grid::where(['resampling_id'=>$grid_data5,'identifier'=>'stability study1'])->firstOrNew();
                     $stability_study1->resampling_id = $grid_data5;
                     $stability_study1->identifier = 'stability study1';
                     $stability_study1->data = $request->stability_study;
                     $stability_study1->save();

                      // resampling grid 6-----------------------------

                    $grid_data6 = $resampling->id;
                    $stability_studys2 = Resampling_Grid::where(['resampling_id'=>$grid_data6,'identifier'=>'stability study2'])->firstOrNew();
                    $stability_studys2->resampling_id = $grid_data6;
                    $stability_studys2->identifier = 'Stability Study2';
                    $stability_studys2->data = $request->stability_study2;
                    $stability_studys2->save();
                    return redirect()->back()->with('success', 'Resampling data has been saved successfully.');

// ----------------------------------------------------------------------------------------------------
    }

    public function update(Request $request, $id)
    {
        // if (!$request->short_description) {
        //     toastr()->error("Short description is required");
        //     return redirect()->back();
        // }
        // $lastDeviation = deviation::find($id);
        //$deviation->parent_id = $request->parent_id;
        //$deviation->parent_type = $request->parent_type;
        //$deviation->division_id = $request->division_id;
        //$deviation->text = $request->text;


        $resampling = Resampling::find($id);

        $resampling->record_number = $request->record_number;
            $resampling->division_id = $request->division_id;

            $resampling->division_code = $request->division_code;

            $resampling->intiation_date = $request->intiation_date;
            $resampling->assign_to = $request->assign_to;
            $resampling->due_date = $request->due_date;
            $resampling->initiator_Group = $request->initiator_Group;
            $resampling->initiator_group_code = $request->initiator_group_code;
            $resampling->short_description = $request->short_description;
            $resampling->cq_Approver = $request->cq_Approver;
            $resampling->supervisor = $request->supervisor;
            $resampling->api_Material_Product_Name = $request->api_Material_Product_Name;
            $resampling->lot_Batch_Number = $request->lot_Batch_Number;
            $resampling->ar_Number_GI = $request->ar_Number_GI;
            $resampling->test_Name_GI = $request->test_Name_GI;
            $resampling->justification_for_resampling_GI = $request->justification_for_resampling_GI;
            $resampling->predetermined_Sampling_Strategies_GI = $request->predetermined_Sampling_Strategies_GI;

            $resampling->parent_tcd_hid = $request->parent_tcd_hid;
            $resampling->parent_oos_no = $request->parent_oos_no;
            $resampling->parent_oot_no = $request->parent_oot_no;
            $resampling->parent_lab_incident_no = $request->parent_lab_incident_no;
            $resampling->parent_date_opened = $request->parent_date_opened;
            $resampling->parent_short_description = $request->parent_short_description;
            $resampling->parent_product_material_name = $request->parent_product_material_name;
            $resampling->parent_target_closure_date = $request->parent_target_closure_date;

            //tab 2
            $resampling->sample_Request_Approval_Comments = $request->sample_Request_Approval_Comments;

            //tab 3
            $resampling->sample_Received = $request->sample_Received;
            $resampling->sample_Quantity = $request->sample_Quantity;
            $resampling->sample_Received_Comments = $request->sample_Received_Comments;
            $resampling->delay_Justification = $request->delay_Justification;

            $resampling->record = $request->record;
            $resampling->division_id = $request->division_id;
            $resampling->form_type = $request->form_type;

            $resampling->status = $request->status;
            $resampling->stage = $request->stage;



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
            //dd($request->Initial_attachment);
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

//--------------------// =============================================Update Grid ================================//
                //grid 1

                                $grid_data = $resampling->id;
                                if (!empty($request->instrumentdetails)) {
                                $product_material = Resampling_Grid::where(['resampling_id'=>$grid_data,'identifier'=>'product material info'])->firstOrNew();
                                $product_material->resampling_id = $grid_data;
                                $product_material->identifier = 'Product Material Info';
                                $product_material->data = $request->product_material_information;
                                $product_material->update();
                                        }

                    // resampling grid 2-----------------------------

                    $grid_data2 = $resampling->id;
                    $info_on_product = Resampling_Grid::where(['resampling_id'=>$grid_data2,'identifier'=>'info on product mat'])->firstOrNew();
                    $info_on_product->resampling_id = $grid_data2;
                    $info_on_product->identifier = 'Info on Product Material';
                    $info_on_product->data = $request->info_on_product_mat;
                    $info_on_product->update();


                     // resampling grid 3-----------------------------

                     $grid_data3 = $resampling->id;
                     $oos_detail = Resampling_Grid::where(['resampling_id'=>$grid_data3,'identifier'=>'OOS Detail'])->firstOrNew();
                     $oos_detail->resampling_id = $grid_data3;
                     $oos_detail->identifier = 'OOS Details';
                     $oos_detail->data = $request->oos_details;
                     $oos_detail->update();


                      // resampling grid 4-----------------------------

                    $grid_data4 = $resampling->id;
                    $oot_details = Resampling_Grid::where(['resampling_id'=>$grid_data4,'identifier'=>'oot detail'])->firstOrNew();
                    $oot_details->resampling_id = $grid_data4;
                    $oot_details->identifier = 'OOT Detail';
                    $oot_details->data = $request->oot_detail;
                    $oot_details->save();


                     // resampling grid 5-----------------------------

                     $grid_data5 = $resampling->id;
                     $stability_study1 = Resampling_Grid::where(['resampling_id'=>$grid_data5,'identifier'=>'stability study1'])->firstOrNew();
                     $stability_study1->resampling_id = $grid_data5;
                     $stability_study1->identifier = 'stability study1';
                     $stability_study1->data = $request->stability_study;
                     $stability_study1->save();

                      // resampling grid 6-----------------------------

                    $grid_data6 = $resampling->id;
                    $stability_studys2 = Resampling_Grid::where(['resampling_id'=>$grid_data6,'identifier'=>'stability study2'])->firstOrNew();
                    $stability_studys2->resampling_id = $grid_data6;
                    $stability_studys2->identifier = 'Stability Study2';
                    $stability_studys2->data = $request->stability_study2;
                    $stability_studys2->save();


                            // $oocGrid = $ooc->id;
                            // // if($request->has('instrumentDetail')){
                            // if (!empty($request->instrumentdetails)) {
                            // $instrumentDetail = OOC_Grid::where(['ooc_id' => $oocGrid, 'identifier' => 'Instrument Details'])->firstOrNew();
                            // $instrumentDetail->ooc_id = $oocGrid;
                            // $instrumentDetail->identifier = 'Instrument Details';
                            // $instrumentDetail->data = $request->instrumentdetails;
                            // $instrumentDetail->save();
                            // }

                            // //    if($request->has('oocevoluation')){
                            // if (!empty($request->instrumentdetails)) {

                            // $oocevaluation = OOC_Grid::where(['ooc_id'=>$oocGrid,'identifier'=>'OOC Evaluation'])->firstOrNew();
                            // $oocevaluation->ooc_id = $oocGrid;
                            // $oocevaluation->identifier = 'OOC Evaluation';
                            // $oocevaluation->data = $request->oocevoluation;
                            // $oocevaluation->save();
                            // }





        $resampling->save();
        toastr()->success('Record is Update Successfully');
        return back();
    }

    public function edit($id) {
        $resampling = Resampling::findOrFail($id);
        $gridDatas01 = Resampling_Grid::where(['resampling_id'=> $id,'identifier'=>'Product Material Info'])->first();
        $gridDatas02 = Resampling_Grid::where(['resampling_id'=> $id,'identifier'=>'Info on Product Material'])->first();
        $gridDatas03 = Resampling_Grid::where(['resampling_id'=> $id,'identifier'=>'OOS Details'])->first();
        $gridDatas04 = Resampling_Grid::where(['resampling_id'=> $id,'identifier'=>'OOT Detail'])->first();
        $gridDatas05 = Resampling_Grid::where(['resampling_id'=> $id,'identifier'=>'stability study1'])->first();
        $gridDatas06 = Resampling_Grid::where(['resampling_id'=> $id,'identifier'=>'Stability Study2'])->first();




        return view('frontend.OOS.resampling_view', compact('resampling', 'gridDatas01', 'gridDatas02', 'gridDatas03', 'gridDatas04', 'gridDatas05', 'gridDatas06'));
    }












    }

