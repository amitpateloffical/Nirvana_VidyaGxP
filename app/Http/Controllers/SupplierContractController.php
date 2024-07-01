<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RecordNumber;
use App\Models\User;
use App\Models\QMSDivision;
use App\Models\RoleGroup;
use App\Models\SupplierContract;
use App\Models\SupplierContractGrid;
use App\Models\SupplierContractAuditTrail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use PDF;


class SupplierContractController extends Controller
{
       public function index(){

            $old_record = SupplierContract::select('id', 'division_id', 'record')->get();
            $record_number = ((RecordNumber::first()->value('counter')) + 1);
            $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
            $users = User::all();
            $qmsDevisions = QMSDivision::all();
            //dd($qmsDevisions);
            return view('frontend.new_forms.supplier_contract',compact('old_record','record_number','users','qmsDevisions'));
       }


       public function store(Request $request){
            //dd($request->all());
                $contract = new SupplierContract();
                $contract->form_type = "Supplier-Contract";
                $contract->record = ((RecordNumber::first()->value('counter')) + 1);
                $contract->initiator_id = Auth::user()->id;
                $contract->division_id = $request->division_id;
                $contract->division_code = $request->division_code;
                $contract->intiation_date = $request->intiation_date;
                $contract->due_date = Carbon::now()->addDays(30)->format('d-M-Y');
                $contract->parent_id = $request->parent_id;
                $contract->parent_type = $request->parent_type;
                $contract->short_description_gi = $request->short_description_gi;
                $contract->assign_to_gi = $request->assign_to_gi;
                $contract->supplier_list_gi = $request->supplier_list_gi;
                $contract->distribution_list_gi = $request->distribution_list_gi;
                $contract->description_gi = $request->description_gi;
                $contract->manufacturer_gi = $request->manufacturer_gi;
                $contract->priority_level_gi = $request->priority_level_gi;
                $contract->zone_gi = $request->zone_gi;
                $contract->country = $request->country;
                $contract->state = $request->state;
                $contract->city = $request->city;
                $contract->type_gi = $request->type_gi;
                $contract->other_type = $request->other_type;
                $contract->stage = '1';
                $contract->status = 'Opened';

                if (!empty ($request->file_attachments_gi)) {
                    $files = [];
                    if ($request->hasfile('file_attachments_gi')) {
                        foreach ($request->file('file_attachments_gi') as $file) {
                            $name = $request->name . 'file_attachments_gi' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }


                    $contract->file_attachments_gi = $files;
                }

                //Contract Details
                $contract->actual_start_date_cd = $request->actual_start_date_cd;
                $contract->actual_end_date_cd = $request->actual_end_date_cd;
                $contract->suppplier_list_cd = $request->suppplier_list_cd;
                $contract->negotiation_team_cd = $request->negotiation_team_cd;
                $contract->comments_cd = $request->comments_cd;

                $contract->save();


               //Grid Store

                $g_id = $contract->id;
                $newDataGridContract = SupplierContractGrid::where(['supplier_contract_id' => $g_id, 'identifier' => 'financial_transaction'])->firstOrCreate();
                $newDataGridContract->supplier_contract_id = $g_id;
                $newDataGridContract->identifier = 'financial_transaction';
                $newDataGridContract->data = $request->financial_transaction;
                $newDataGridContract->save();


            //Audit Trail Store Start

            if(!empty($request->short_description_gi)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->short_description_gi;
                $history->activity_type = 'Short Description';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->assign_to_gi)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->assign_to_gi;
                $history->activity_type = 'Assigned To';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->due_date)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->due_date;
                $history->activity_type = 'Date Due';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->supplier_list_gi)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->supplier_list_gi;
                $history->activity_type = 'Supplier List';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->distribution_list_gi)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->distribution_list_gi;
                $history->activity_type = 'Distribution List';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->description_gi)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->description_gi;
                $history->activity_type = 'Description';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->manufacturer_gi)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->manufacturer_gi;
                $history->activity_type = 'Manufacturer';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->priority_level_gi)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->priority_level_gi;
                $history->activity_type = 'Priority level';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->zone_gi)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->zone_gi;
                $history->activity_type = 'Zone';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->country)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->country;
                $history->activity_type = 'Country';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->state)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->state;
                $history->activity_type = 'State/District';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->city)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->city;
                $history->activity_type = 'City';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->type_gi)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->type_gi;
                $history->activity_type = 'Type';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

           if(!empty($request->other_type)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->other_type;
                $history->activity_type = 'Other type';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($contract->file_attachments_gi)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = json_encode($contract->file_attachments_gi);
                $history->activity_type = 'File Attachments';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->actual_start_date_cd)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->actual_start_date_cd;
                $history->activity_type = 'Actual start Date';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->actual_end_date_cd)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->actual_end_date_cd;
                $history->activity_type = 'Actual end Date';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->suppplier_list_cd)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->suppplier_list_cd;
                $history->activity_type = 'Suppplier List';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->negotiation_team_cd)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->negotiation_team_cd;
                $history->activity_type = 'Negotiation Team';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }

            if(!empty($request->comments_cd)){
                $history = new SupplierContractAuditTrail();
                $history->supplier_contract_id = $contract->id;
                $history->previous = "Null";
                $history->current = $request->comments_cd;
                $history->activity_type = 'Comments';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->comment = "Not Applicable";
                $history->save();
            }
            toastr()->success("Record is created Successfully");
            return redirect(url('rcms/qms-dashboard'));
         }


            public function edit($id){

                $contract_data = SupplierContract::findOrFail($id);

                $old_record = SupplierContract::select('id', 'division_id', 'record')->get();
                $record_number = ((RecordNumber::first()->value('counter')) + 1);
                $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
                $users = User::all();
                $qmsDevisions = QMSDivision::all();


                $g_id = $contract_data->id;
                $grid_Data = SupplierContractGrid::where(['supplier_contract_id' => $g_id, 'identifier' => 'financial_transaction'])->first();
                //dd($grid_Data);

                return view('frontend.new_forms.supplier_contract_view',compact('contract_data','record_number','users','qmsDevisions','grid_Data'));
            }

                public function update(Request $request, $id){
                //  dd($request->all());
                      $contract_data = SupplierContract::findOrFail($id);

                      $contract = SupplierContract::findOrFail($id);

                      $contract->form_type = "Supplier_contract";
                      $contract->record = ((RecordNumber::first()->value('counter')) + 1);
                      $contract->initiator_id = Auth::user()->id;
                      $contract->division_id = $request->division_id;
                      $contract->division_code = $request->division_code;
                      $contract->intiation_date = $request->intiation_date;
                      //  $contract->due_date = $request->due_date;
                      //dd($request->due_date);
                      $contract->parent_id = $request->parent_id;
                      $contract->parent_type = $request->parent_type;
                      $contract->short_description_gi = $request->short_description_gi;
                      $contract->assign_to_gi = $request->assign_to_gi;
                      $contract->supplier_list_gi = $request->supplier_list_gi;
                      $contract->distribution_list_gi = $request->distribution_list_gi;
                      $contract->description_gi = $request->description_gi;
                      $contract->manufacturer_gi = $request->manufacturer_gi;
                      $contract->priority_level_gi = $request->priority_level_gi;
                      $contract->zone_gi = $request->zone_gi;
                      $contract->country = $request->country;
                      $contract->state = $request->state;
                      $contract->city = $request->city;
                      $contract->type_gi = $request->type_gi;
                      $contract->other_type = $request->other_type;

                      if (!empty ($request->file_attachments_gi)) {
                          $files = [];
                          if ($request->hasfile('file_attachments_gi')) {
                              foreach ($request->file('file_attachments_gi') as $file) {
                                  $name = $request->name . 'file_attachments_gi' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                                  $file->move('upload/', $name);
                                  $files[] = $name;
                              }
                          }


                          $contract->file_attachments_gi = $files;
                      }

                        //Contract Details

                        $contract->actual_start_date_cd = $request->actual_start_date_cd;
                        $contract->actual_end_date_cd = $request->actual_end_date_cd;
                        $contract->suppplier_list_cd = $request->suppplier_list_cd;
                        $contract->negotiation_team_cd = $request->negotiation_team_cd;
                        $contract->comments_cd = $request->comments_cd;

                        $contract->save();


                        //grid update

                        $g_id = $contract->id;
                        $newDataGridContract = SupplierContractGrid::where(['supplier_contract_id' => $g_id, 'identifier' => 'financial_transaction'])->firstOrCreate();
                        $newDataGridContract->supplier_contract_id = $g_id;
                        $newDataGridContract->identifier = 'financial_transaction';
                        $newDataGridContract->data = $request->financial_transaction;
                        $newDataGridContract->update();

                    //audit trail update

                if($contract_data->short_description_gi != $contract->short_description_gi){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->short_description_gi;
                        $history->current = $contract->short_description_gi;
                        $history->activity_type = 'Short Description';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->assign_to_gi != $contract->assign_to_gi){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->assign_to_gi;
                        $history->current = $contract->assign_to_gi;
                        $history->activity_type = 'Assigned To';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->due_date != $contract->due_date){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->due_date;
                        $history->current = $contract->due_date;
                        $history->activity_type = 'Date Due';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->supplier_list_gi != $contract->supplier_list_gi){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->supplier_list_gi;
                        $history->current = $contract->supplier_list_gi;
                        $history->activity_type = 'Supplier List';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->distribution_list_gi != $contract->distribution_list_gi){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->distribution_list_gi;
                        $history->current = $contract->distribution_list_gi;
                        $history->activity_type = 'Distribution List';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->description_gi != $contract->description_gi){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->description_gi;
                        $history->current = $contract->description_gi;
                        $history->activity_type = 'Description';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->manufacturer_gi != $contract->manufacturer_gi){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->manufacturer_gi;
                        $history->current = $contract->manufacturer_gi;
                        $history->activity_type = 'Manufacturer';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->priority_level_gi != $contract->priority_level_gi){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->priority_level_gi;
                        $history->current = $contract->priority_level_gi;
                        $history->activity_type = 'Priority level';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->zone_gi != $contract->zone_gi){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->zone_gi;
                        $history->current = $contract->zone_gi;
                        $history->activity_type = 'Zone';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->country != $contract->country){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->country;
                        $history->current = $contract->country;
                        $history->activity_type = 'Country';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->state != $contract->state){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->state;
                        $history->current = $contract->state;
                        $history->activity_type = 'State/District';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->city != $contract->city){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->city;
                        $history->current = $contract->city;
                        $history->activity_type = 'City';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->type_gi != $contract->type_gi){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->type_gi;
                        $history->current = $contract->type_gi;
                        $history->activity_type = 'Type';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->other_type != $contract->other_type){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->other_type;
                        $history->current = $contract->other_type;
                        $history->activity_type = 'Other type';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->file_attachments_gi != $contract->file_attachments_gi){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = json_encode($contract_data->file_attachments_gi);
                        $history->current = json_encode($contract->file_attachments_gi);
                        $history->activity_type = 'File Attachments';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->actual_start_date_cd != $contract->actual_start_date_cd){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->actual_start_date_cd;
                        $history->current = $contract->actual_start_date_cd;
                        $history->activity_type = 'Actual start Date';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->actual_end_date_cd != $contract->actual_end_date_cd){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->actual_end_date_cd;
                        $history->current = $contract->actual_end_date_cd;
                        $history->activity_type = 'Actual end Date';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->suppplier_list_cd != $contract->suppplier_list_cd){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->suppplier_list_cd;
                        $history->current = $contract->suppplier_list_cd;
                        $history->activity_type = 'Suppplier List';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->negotiation_team_cd != $contract->negotiation_team_cd){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->negotiation_team_cd;
                        $history->current = $contract->negotiation_team_cd;
                        $history->activity_type = 'Negotiation Team';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                if($contract_data->comments_cd != $contract->comments_cd){
                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $contract->id;
                        $history->previous = $contract_data->comments_cd;
                        $history->current = $contract->comments_cd;
                        $history->activity_type = 'Comments';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $contract_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }


                      toastr()->success("Record is Updated Successfully");
                      return back();
                }

                public function Supplier_contract_send_stage(Request $request, $id){

                    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                           $contract_data = SupplierContract::find($id);
                           $lastDocument = SupplierContract::find($id);

                       if ($contract_data->stage == 1) {
                               $contract_data->stage = "2";
                               $contract_data->status = "Qualification In Progress";
                               $contract_data->supplier_details_submit_by = Auth::user()->name;
                               $contract_data->supplier_details_submit_on = Carbon::now()->format('d-M-Y');
                               $contract_data->supplier_details_submit_comment = $request->comment;
                               $contract_data->save();

                               $history = new SupplierContractAuditTrail();
                               $history->supplier_contract_id = $id;
                               $history->activity_type = 'Activity Log';
                               $history->previous = "";
                               $history->current = "";
                               $history->comment = $request->comment;
                               $history->user_id = Auth::user()->id;
                               $history->user_name = Auth::user()->name;
                               $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                               $history->change_from = "Opened";
                               $history->change_to = "Qualification In Progress";
                               $history->action_name = "Submit";
                               $history->stage = 'Plan Approved';
                               $history->save();

                               return back();

                       }

                      elseif ($contract_data->stage == 2) {
                               $contract_data->stage = "3";
                               $contract_data->status = "Pending Supplier Audit";
                               $contract_data->qualification_complete_by = Auth::user()->name;
                               $contract_data->qualification_complete_on = Carbon::now()->format('d-M-Y');
                               $contract_data->qualification_complete_comment = $request->comment;
                               $contract_data->save();

                               $history = new SupplierContractAuditTrail();
                               $history->supplier_contract_id = $id;
                               $history->activity_type = 'Activity Log';
                               $history->previous = "";
                               $history->current = "";
                               $history->comment = $request->comment;
                               $history->user_id = Auth::user()->id;
                               $history->user_name = Auth::user()->name;
                               $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                               $history->change_from = "Qualification In Progress";
                               $history->change_to = "Pending Supplier Audit";
                               $history->action_name = "Submit";
                               $history->stage = 'Plan Approved';
                               $history->save();
                               return back();
                       }

                      elseif($contract_data->stage == 3) {

                           if($request->type == 'audit_passed'){
                                $contract_data->stage = "4";
                                $contract_data->status = "Supplier Approved";
                                $contract_data->audit_passed_by = Auth::user()->name;
                                $contract_data->audit_passed_on = Carbon::now()->format('d-M-Y');
                                $contract_data->audit_passed_comment = $request->comment;
                                $contract_data->save();

                                $history = new SupplierContractAuditTrail();
                                $history->supplier_contract_id = $id;
                                $history->activity_type = 'Activity Log';
                                $history->previous = "";
                                $history->current = "";
                                $history->comment = $request->comment;
                                $history->user_id = Auth::user()->id;
                                $history->user_name = Auth::user()->name;
                                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                                $history->change_from = "Pending Supplier Audit";
                                $history->change_to = "Supplier Approved";
                                $history->action_name = "Submit";
                                $history->stage = 'Plan Approved';
                                $history->save();

                                return back();
                           }else{
                                $contract_data->stage = "5";
                                $contract_data->status = "Pending Rejction";
                                $contract_data->audit_failed_by = Auth::user()->name;
                                $contract_data->audit_failed_on = Carbon::now()->format('d-M-Y');
                                $contract_data->audit_failed_comment = $request->comment;
                                $contract_data->save();

                                $history = new SupplierContractAuditTrail();
                                $history->supplier_contract_id = $id;
                                $history->activity_type = 'Activity Log';
                                $history->previous = "";
                                $history->current = "";
                                $history->comment = $request->comment;
                                $history->user_id = Auth::user()->id;
                                $history->user_name = Auth::user()->name;
                                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                                $history->change_from = "Pending Supplier Audit";
                                $history->change_to = "Pending Rejction";
                                $history->action_name = "Submit";
                                $history->stage = 'Plan Approved';
                                $history->save();

                                return back();

                           }

                           }

                      elseif($contract_data->stage == 4) {
                                $contract_data->stage = "6";
                                $contract_data->status = "Obselete";
                                $contract_data->approve_supplier_obsolete_by = Auth::user()->name;
                                $contract_data->approve_supplier_obsolete_on = Carbon::now()->format('d-M-Y');
                                $contract_data->approve_supplier_obsolete_comment = $request->comment;
                                $contract_data->save();

                                $history = new SupplierContractAuditTrail();
                                $history->supplier_contract_id = $id;
                                $history->activity_type = 'Activity Log';
                                $history->previous = "";
                                $history->current = "";
                                $history->comment = $request->comment;
                                $history->user_id = Auth::user()->id;
                                $history->user_name = Auth::user()->name;
                                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                                $history->change_from = "Supplier Approved";
                                $history->change_to = "Obselete";
                                $history->action_name = "Submit";
                                $history->stage = 'Plan Approved';
                                $history->save();

                                return back();
                           }

                      elseif($contract_data->stage == 5) {
                                $contract_data->stage = "6";
                                $contract_data->status = "Obselete";
                                $contract_data->reject_supplier_obsolete_by = Auth::user()->name;
                                $contract_data->reject_supplier_obsolete_on = Carbon::now()->format('d-M-Y');
                                $contract_data->reject_supplier_obsolete_comment = $request->comment;
                                $contract_data->save();

                                $history = new SupplierContractAuditTrail();
                                $history->supplier_contract_id = $id;
                                $history->activity_type = 'Activity Log';
                                $history->previous = "";
                                $history->current = "";
                                $history->comment = $request->comment;
                                $history->user_id = Auth::user()->id;
                                $history->user_name = Auth::user()->name;
                                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                                $history->change_from = "Pending Rejction";
                                $history->change_to = "Obselete";
                                $history->action_name = "Submit";
                                $history->stage = 'Plan Approved';
                                $history->save();

                                return back();
                           }
                       }
                          else
                            {
                              toastr()->error('E-signature Not match');
                                return back();
                            }
               }

               public function Supplier_contract_cancel(Request $request, $id){

                    if ($request->username == Auth::user()->email && Hash::check($request->password,  Auth::user()->password)) {
                        $contract_data = SupplierContract::find($id);
                        $lastDocument = SupplierContract::find($id);

                        if ($contract_data->stage == 1) {
                            $contract_data->stage = "0";
                            $contract_data->status = "Closed-Cancelled";
                            $contract_data->open_cancel_by = Auth::user()->name;
                            $contract_data->open_cancel_on = Carbon::now()->format('d-M-Y');
                            $contract_data->open_cancel_comment = $request->comment;
                            $contract_data->save();

                            $history = new SupplierContractAuditTrail();
                            $history->supplier_contract_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Opened";
                            $history->change_to = "Closed-Cancelled";
                            $history->action_name = "Submit";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                        }
                        elseif ($contract_data->stage == 2) {
                            $contract_data->stage = "0";
                            $contract_data->status = "Closed-Cancelled";
                            $contract_data->qualification_cancel_by = Auth::user()->name;
                            $contract_data->qualification_cancel_on = Carbon::now()->format('d-M-Y');
                            $contract_data->qualification_cancel_comment = $request->comment;
                            $contract_data->save();

                            $history = new SupplierContractAuditTrail();
                            $history->supplier_contract_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Qualification In Progress";
                            $history->change_to = "Closed-Cancelled";
                            $history->action_name = "Submit";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                        }
                    }
                        else {
                            toastr()->error('E-signature Not match');
                            return back();
                    }
        }

           public function Reject_stage(Request $request, $id){

               if ($request->username == Auth::user()->email && Hash::check($request->password,  Auth::user()->password)) {
                   $contract_data = SupplierContract::find($id);
                   $lastDocument = SupplierContract::find($id);

                    if ($contract_data->stage == 4) {
                        $contract_data->stage = "3";
                        $contract_data->status = "Pending Supplier Audit";
                        $contract_data->quality_issues_by = Auth::user()->name;
                        $contract_data->quality_issues_on = Carbon::now()->format('d-M-Y');
                        $contract_data->quality_issues_comment = $request->comment;
                        $contract_data->save();

                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Supplier Approved";
                        $history->change_to = "Pending Supplier Audit";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
                    }
                elseif ($contract_data->stage == 5) {
                        $contract_data->stage = "3";
                        $contract_data->status = "Pending Supplier Audit";
                        $contract_data->re_audit_by = Auth::user()->name;
                        $contract_data->re_audit_on = Carbon::now()->format('d-M-Y');
                        $contract_data->re_audit_comment = $request->comment;
                        $contract_data->save();

                        $history = new SupplierContractAuditTrail();
                        $history->supplier_contract_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Pending Rejction";
                        $history->change_to = "Pending Supplier Audit";
                        $history->action_name = "Submit";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
                    }
                }
                    else {
                        toastr()->error('E-signature Not match');
                        return back();
                }

        }

        public function Supplier_contract_child(Request $request, $id){

                $contract_data = SupplierContract::find($id);

                 if($contract_data->stage == 3){

                        //return redirect(route('supplier_contract.index'));
                    }

     }


        //Single Report Start

        public function Supplier_Contract_SingleReport(Request $request, $id){

                $contract_data = SupplierContract::find($id);
                //$users = User::all();
                $grid_Data = SupplierContractGrid::where(['supplier_contract_id' => $id, 'identifier' => 'financial_transaction'])->first();

                if (!empty($contract_data)) {
                    $contract_data->data = SupplierContractGrid::where('supplier_contract_id', $id)->where('identifier', "financial_transaction")->first();

                    $contract_data->originator = User::where('id', $contract_data->initiator_id)->value('name');
                    $contract_data->assign_to_gi = User::where('id', $contract_data->assign_to_gi)->value('name');
                    $pdf = App::make('dompdf.wrapper');
                    $time = Carbon::now();
                    $pdf = PDF::loadview('frontend.new_forms.supplier_contractSingleReport', compact('contract_data','grid_Data'))
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
                    $canvas->page_text($width / 4, $height / 2, $contract_data->status, null, 25, [0, 0, 0], 2, 6, -20);
                    return $pdf->stream('Supplier_Contract' . $id . '.pdf');
                }
            }

                //Audit Trail Start

                public function Supplier_ContractAuditTrial($id){

                    $audit = SupplierContractAuditTrail::where('supplier_contract_id', $id)->orderByDESC('id')->paginate(5);
                    // dd($audit);
                    $today = Carbon::now()->format('d-m-y');
                    $document = SupplierContract::where('id', $id)->first();
                    $document->originator = User::where('id', $document->initiator_id)->value('name');
                    // dd($document);

                    return view('frontend.new_forms.supplier_contractAuditTrail',compact('document','audit','today'));
                }

                //Audit Trail Report Start

                public function Supplier_Contract_AuditTrailPdf($id)
                {
                    $doc = SupplierContract::find($id);
                    $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                    $data = SupplierContractAuditTrail::where('supplier_contract_id', $doc->id)->orderByDesc('id')->get();
                    $pdf = App::make('dompdf.wrapper');
                    $time = Carbon::now();
                    $pdf = PDF::loadview('frontend.new_forms.supplier_contractAuditTrailPdf', compact('data', 'doc'))
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
