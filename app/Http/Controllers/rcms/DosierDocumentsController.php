<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RoleGroup;
use App\Models\DosierDocuments;
use App\Models\DosierDocumentsgrids;
use App\Models\DosierDocumentsAuditTrial;
// use App\Services\Qms\DosierDocumentsService;
use App\Models\RecordNumber;
use App\Models\Division;
use App\Models\QMSDivision;
use App\Models\Extension;
use Carbon\Carbon;
use Error;
use Helpers;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;



class DosierDocumentsController extends Controller
{
    public function index()
    {
        // dd('fdfdfdf');
        $cft = [];

        $old_record = DosierDocuments::select('id', 'division_id', 'record_number')->get();
        
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $division = QMSDivision::where('name', Helpers::getDivisionName(session()->get('division')))->first();
        
        if ($division) {
            $last_DosierDocuments = DosierDocuments::where('division_id', $division->id)->latest()->first();
            if ($last_DosierDocuments) {
                $record_number = $last_DosierDocuments->record_number ? str_pad($last_DosierDocuments->record_number + 1, 4, '0', STR_PAD_LEFT) : '0001';
                
            } else {
                $record_number = '0001';
            }
        }

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date= $formattedDate->format('Y-m-d');
        // $changeControl = OpenStage::find(1);
        //  if(!empty($changeControl->cft)) $cft = explode(',', $changeControl->cft);
        return view("frontend.Registration-Tracking.dosier-documents", compact('due_date', 'record_number', 'old_record', 'cft'));

    }
    
    public function store(Request $request)
    { 
        $res = Helpers::getDefaultResponse();
        try {
            
            $input = $request->all();
            $input['form_type'] = "Dosier Documents";
            $input['status'] = 'Opened';
            $input['stage'] = 1;
            $input['record_number'] = ((RecordNumber::first()->value('counter')) + 1);

            if (!empty ($request->file_attachments_pli)) {
                $files = [];
                if ($request->hasfile('file_attachments_pli')) {
                    foreach ($request->file('file_attachments_pli') as $file) {
                        $name = $request->name . 'file_attachments_pli' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $input['file_attachments_pli'] = json_encode($files);
            }
             
            $DosierDocuments = DosierDocuments::create($input);
            $record = RecordNumber::first();
            $record->counter = ((RecordNumber::first()->value('counter')) + 1);
            $record->update();

            if(!empty($request->short_description)){
                $history = new DosierDocumentsAuditTrial();
                $history->dosier_documents_id = $DosierDocuments->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Short Description';
                $history->current = $request->short_description;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $DosierDocuments->status;
                $history->stage = $DosierDocuments->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->due_date)){
                $history = new DosierDocumentsAuditTrial();
                $history->dosier_documents_id = $DosierDocuments->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Short Description';
                $history->current = $request->due_date;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $DosierDocuments->status;
                $history->stage = $DosierDocuments->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->dosier_documents_type)){
                $history = new DosierDocumentsAuditTrial();
                $history->dosier_documents_id = $DosierDocuments->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Dosier Documents Type';
                $history->current = $request->dosier_documents_type;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $DosierDocuments->status;
                $history->stage = $DosierDocuments->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->document_language)){
                $history = new DosierDocumentsAuditTrial();
                $history->dosier_documents_id = $DosierDocuments->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Document Language';
                $history->current = $request->document_language;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $DosierDocuments->status;
                $history->stage = $DosierDocuments->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->documents)){
                $history = new DosierDocumentsAuditTrial();
                $history->dosier_documents_id = $DosierDocuments->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Documents';
                $history->current = $request->documents;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $DosierDocuments->status;
                $history->stage = $DosierDocuments->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->dossier_parts)){
                $history = new DosierDocumentsAuditTrial();
                $history->dosier_documents_id = $DosierDocuments->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Dossier Parts';
                $history->current = $request->dossier_parts;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $DosierDocuments->status;
                $history->stage = $DosierDocuments->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->root_parent_manufacture)){
                $history = new DosierDocumentsAuditTrial();
                $history->dosier_documents_id = $DosierDocuments->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Root Parent Manufacture';
                $history->current = $request->root_parent_manufacture;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $DosierDocuments->status;
                $history->stage = $DosierDocuments->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->root_parent_product_code)){
                $history = new DosierDocumentsAuditTrial();
                $history->dosier_documents_id = $DosierDocuments->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Root Parent Product Code';
                $history->current = $request->root_parent_product_code;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $DosierDocuments->status;
                $history->stage = $DosierDocuments->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->root_parent_trade_name)){
                $history = new DosierDocumentsAuditTrial();
                $history->dosier_documents_id = $DosierDocuments->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Root Parent Trade Name';
                $history->current = $request->root_parent_trade_name;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $DosierDocuments->status;
                $history->stage = $DosierDocuments->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            if(!empty($request->root_parent_therapeutic_area)){
                $history = new DosierDocumentsAuditTrial();
                $history->dosier_documents_id = $DosierDocuments->id;
                $history->previous = "Null";
                $history->comment = "Not Applicable";
                $history->activity_type = 'Root Parent Therapeutic Area';
                $history->current = $request->root_parent_therapeutic_area;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $DosierDocuments->status;
                $history->stage = $DosierDocuments->stage;
                $history->change_to =   "Opened";
                $history->change_from = "Initiator";
                $history->action_name = 'Create';
                $history->save();
            }
            // ========audit trail complete========
            if ($DosierDocuments_record['status'] == 'error')
            {
                throw new Error($DosierDocuments_record['message']);
            } 

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
            info('Error in DosierDocumentsController@store', [
                'message' => $e->getMessage()
            ]);
        }
        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }


    public static function show($id)
    {
        $cft = [];
        $revised_date = "";
        $data = DosierDocuments::find($id);
        // dd($data);
        $old_record = DosierDocuments::select('id', 'division_id', 'record_number')->get();
        // $revised_date = Extension::where('parent_id', $id)->where('parent_type', "DosierDocuments Chemical")->value('revised_date');
        $data->record_number = str_pad($data->record_number, 4, '0', STR_PAD_LEFT);
        
        $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        // dd($data);
         return view('frontend.Registration-Tracking.dosier-documents-view', 
        compact('data', 'old_record','revised_date'));

    }

    public function update(Request $request, $id)
    {
        
        $res = Helpers::getDefaultResponse();

        try {
                $input = $request->all();
                if (!empty ($request->file_attachments_pli)) {
                    $files = [];
                    if ($request->hasfile('file_attachments_pli')) {
                        foreach ($request->file('file_attachments_pli') as $file) {
                            $name = $request->name . 'file_attachments_pli' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                            $file->move('upload/', $name);
                            $files[] = $name;
                        }
                    }
    
                    $input['file_attachments_pli'] = json_encode($files);
                }
                // dd($input);
                $DosierDocuments = DosierDocuments::findOrFail($id);
                $DosierDocuments->update($input);

                $lastDosierDocumentsRecod = DosierDocuments::where('id', $id)->first();
            // ============= update audit trail==========
            if ($lastDosierDocumentsRecod->short_description != $request->short_description){
               $history = new DosierDocumentsAuditTrial();
               $history->DosierDocuments_id = $lastDosierDocumentsRecod->id;
               $history->previous = $lastDosierDocumentsRecod->short_description;
               $history->activity_type = 'Short Description ';
               $history->current = $request->short_description;
               $history->comment = "Not Applicable";
               $history->user_id = Auth::user()->id;
               $history->user_name = Auth::user()->name;
               $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
               $history->origin_state = $lastDosierDocumentsRecod->status;
               $history->stage = $lastDosierDocumentsRecod->stage;
               $history->change_to =   "Opened";
               $history->change_from = $lastDosierDocumentsRecod->status;
               $history->action_name = 'Update';
               $history->save();
           }
           if ($lastDosierDocumentsRecod->due_date != $request->due_date){
            $history = new DosierDocumentsAuditTrial();
            $history->DosierDocuments_id = $lastDosierDocumentsRecod->id;
            $history->previous = $lastDosierDocumentsRecod->due_date;
            $history->activity_type = 'Due Date ';
            $history->current = $request->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDosierDocumentsRecod->status;
            $history->stage = $lastDosierDocumentsRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastDosierDocumentsRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastDosierDocumentsRecod->dosier_documents_type != $request->dosier_documents_type){
            $history = new DosierDocumentsAuditTrial();
            $history->DosierDocuments_id = $lastDosierDocumentsRecod->id;
            $history->previous = $lastDosierDocumentsRecod->dosier_documents_type;
            $history->activity_type = 'dosier_documents_type ';
            $history->current = $request->dosier_documents_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDosierDocumentsRecod->status;
            $history->stage = $lastDosierDocumentsRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastDosierDocumentsRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        
        if ($lastDosierDocumentsRecod->document_language != $request->document_language){
            $history = new DosierDocumentsAuditTrial();
            $history->DosierDocuments_id = $lastDosierDocumentsRecod->id;
            $history->previous = $lastDosierDocumentsRecod->document_language;
            $history->activity_type = 'document_language ';
            $history->current = $request->document_language;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDosierDocumentsRecod->status;
            $history->stage = $lastDosierDocumentsRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastDosierDocumentsRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastDosierDocumentsRecod->documents != $request->documents){
            $history = new DosierDocumentsAuditTrial();
            $history->DosierDocuments_id = $lastDosierDocumentsRecod->id;
            $history->previous = $lastDosierDocumentsRecod->documents;
            $history->activity_type = 'Document ';
            $history->current = $request->documents;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDosierDocumentsRecod->status;
            $history->stage = $lastDosierDocumentsRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastDosierDocumentsRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastDosierDocumentsRecod->dossier_parts != $request->dossier_parts){
            $history = new DosierDocumentsAuditTrial();
            $history->DosierDocuments_id = $lastDosierDocumentsRecod->id;
            $history->previous = $lastDosierDocumentsRecod->dossier_parts;
            $history->activity_type = 'Dossier Parts ';
            $history->current = $request->dossier_parts;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDosierDocumentsRecod->status;
            $history->stage = $lastDosierDocumentsRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastDosierDocumentsRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastDosierDocumentsRecod->root_parent_manufacture != $request->root_parent_manufacture){
            $history = new DosierDocumentsAuditTrial();
            $history->DosierDocuments_id = $lastDosierDocumentsRecod->id;
            $history->previous = $lastDosierDocumentsRecod->root_parent_manufacture;
            $history->activity_type = 'Root Parent Manufacture ';
            $history->current = $request->root_parent_manufacture;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDosierDocumentsRecod->status;
            $history->stage = $lastDosierDocumentsRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastDosierDocumentsRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastDosierDocumentsRecod->root_parent_product_code != $request->root_parent_product_code){
            $history = new DosierDocumentsAuditTrial();
            $history->DosierDocuments_id = $lastDosierDocumentsRecod->id;
            $history->previous = $lastDosierDocumentsRecod->root_parent_product_code;
            $history->activity_type = 'Root Parent Product Code ';
            $history->current = $request->root_parent_product_code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDosierDocumentsRecod->status;
            $history->stage = $lastDosierDocumentsRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastDosierDocumentsRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastDosierDocumentsRecod->root_parent_trade_name != $request->root_parent_trade_name){
            $history = new DosierDocumentsAuditTrial();
            $history->DosierDocuments_id = $lastDosierDocumentsRecod->id;
            $history->previous = $lastDosierDocumentsRecod->root_parent_trade_name;
            $history->activity_type = 'Root Parent Trade Name ';
            $history->current = $request->root_parent_trade_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDosierDocumentsRecod->status;
            $history->stage = $lastDosierDocumentsRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastDosierDocumentsRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
        if ($lastDosierDocumentsRecod->root_parent_therapeutic_area != $request->root_parent_therapeutic_area){
            $history = new DosierDocumentsAuditTrial();
            $history->DosierDocuments_id = $lastDosierDocumentsRecod->id;
            $history->previous = $lastDosierDocumentsRecod->root_parent_therapeutic_area;
            $history->activity_type = 'Root Parent Therapeutic Area';
            $history->current = $request->root_parent_therapeutic_area;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDosierDocumentsRecod->status;
            $history->stage = $lastDosierDocumentsRecod->stage;
            $history->change_to =   "Opened";
            $history->change_from = $lastDosierDocumentsRecod->status;
            $history->action_name = 'Update';
            $history->save();
        }
            // $DosierDocuments_record = DosierDocumentsService::update_oss($request,$id);
        
            if ($DosierDocuments_record['status'] == 'error')
            {
                throw new Error($DosierDocuments_record['message']);
            } 

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
            info('Error in DosierDocumentsController@store', [
                'message' => $e->getMessage()
            ]);
        }
        toastr()->success('Record is Update Successfully');
        return back();
        // return redirect()->route('qms.dashboard');
        
        
    }

    // public function send_stage(Request $request, $id)
    // {
    //     if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
    //         $changestage = DosierDocuments::find($id);
    //         $lastDocument = DosierDocuments::find($id);
    //         if ($changestage->stage == 1) {
    //             $changestage->stage = "2";
    //             $changestage->status = "Pending Initial Assessment & LabIncident";
    //             $changestage->completed_by_pending_initial_assessment = Auth::user()->name;
    //             $changestage->completed_on_pending_initial_assessment = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_pending_initial_assessment = $request->comment;
    //                             $history = new DosierDocumentsAuditTrial();
    //                             $history->DosierDocuments_id = $id;
    //                             $history->activity_type = 'Activity Log';
    //                             $history->current = $changestage->completed_by_pending_initial_assessment;
    //                             $history->comment = $request->comment;
    //                             $history->user_id = Auth::user()->id;
    //                             $history->user_name = Auth::user()->name;
    //                             $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                             $history->origin_state = $lastDocument->status;
    //                             $history->stage = "Completed";
    //                             $history->save();
    //                         //     $list = Helpers::getLeadAuditeeUserList();
    //                         //     foreach ($list as $u) {
    //                         //         if($u->q_m_s_divisions_id == $changestage->division_id){
    //                         //             $email = Helpers::getInitiatorEmail($u->user_id);
    //                         //              if ($email !== null) {
                                      
    //                         //               Mail::send(
    //                         //                   'mail.view-mail',
    //                         //                    ['data' => $changestage],
    //                         //                 function ($message) use ($email) {
    //                         //                     $message->to($email)
    //                         //                         ->subject("Document sent ".Auth::user()->name);
    //                         //                 }
    //                         //               );
    //                         //             }
    //                         //      } 
    //                         //   }
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 2) {
    //             $changestage->stage = "3";
    //             $changestage->status = "Under Phase I investigation";
    //             $changestage->completed_by_under_phaseI_investigation = Auth::user()->name;
    //             $changestage->completed_on_under_phaseI_investigation = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_phaseI_investigation = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_phaseIB_investigation;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Lab Supervisor";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 3) {
    //             $changestage->stage = "5";
    //             $changestage->status = "Under Phase I b Investigation";
    //             $changestage->completed_by_under_phaseIB_investigation = Auth::user()->name;
    //             $changestage->completed_on_under_phaseIB_investigation = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_phaseIB_investigation = $request->comment;
    //                         $history = new DosierDocumentsAuditTrial();
    //                         $history->DosierDocuments_id = $id;
    //                         $history->activity_type = 'Activity Log';
    //                         $history->current = $changestage->completed_by_under_phaseIB_investigation;
    //                         $history->comment = $request->comment;
    //                         $history->user_id = Auth::user()->id;
    //                         $history->user_name = Auth::user()->name;
    //                         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                         $history->origin_state = $lastDocument->status;
    //                         $history->stage = "Lab Supervisor";
    //                         $history->save();
                        
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 5) {
    //             $changestage->stage = "6";
    //             $changestage->status = "Under Hypothesis Experient";
    //             $changestage->completed_by_under_hypothesis = Auth::user()->name;
    //             $changestage->completed_on_under_hypothesis = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_hypothesis = $request->comment;

    //             $history = new DosierDocumentsAuditTrial();
    //             $history->DosierDocuments_id = $id;
    //             $history->activity_type = 'Activity Log';
    //             $history->current = $changestage->completed_by_under_hypothesis;
    //             $history->comment = $request->comment;
    //             $history->user_id = Auth::user()->id;
    //             $history->user_name = Auth::user()->name;
    //             $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //             $history->origin_state = $lastDocument->status;
    //             $history->stage = "Final Approval";
    //             $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }

    //         if ($changestage->stage == 6) {
    //             $changestage->stage = "8";
    //             $changestage->status = "under phase II Investigation";
    //             $changestage->completed_by_under_phaseII_investigation = Auth::user()->name;
    //             $changestage->completed_on_under_phaseII_investigation = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_phaseII_investigation = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_phaseII_investigation;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Under Phase II investigation";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 8) {
    //             $changestage->stage = "9";
    //             $changestage->status = "under Manufacturing Investigation phase II a";
    //             $changestage->completed_by_under_manufacturing_investigation_phaseIIA = Auth::user()->name;
    //             $changestage->completed_on_under_manufacturing_investigation_phaseIIA = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_manufacturing_investigation_phaseIIA = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_manufacturing_investigation_phaseIIA;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Under Manufacturing Phase II b Additional Lab Investigation";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 9) {
    //             $changestage->stage = "11";
    //             $changestage->status = "Under phase II b Additional Lab Investigation";
    //             $changestage->completed_by_under_phaseIIB_additional_lab_investigation= Auth::user()->name;
    //             $changestage->completed_on_under_phaseIIB_additional_lab_investigation = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_phaseIIB_additional_lab_investigation = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_manufacturing_investigation_phaseIIA;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Under Manufacturing Phase II b Additional Lab Investigation";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 11) {
    //             $changestage->stage = "13";
    //             $changestage->status = "Under phase III Investigation";
    //             $changestage->completed_by_under_phaseIII_investigation= Auth::user()->name;
    //             $changestage->completed_on_under_phaseIII_investigation = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_phaseIII_investigation = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_phaseIII_investigation;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Under Manufacturing Phase II b Additional Lab Investigation";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 13) {
    //             $changestage->stage = "14";
    //             $changestage->status = "Pending Final Approval Completed";
    //             $changestage->completed_by_approval_completed= Auth::user()->name;
    //             $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_approval_completed = $request->comment;

    //             $history = new DosierDocumentsAuditTrial();
    //             $history->DosierDocuments_id = $id;
    //             $history->activity_type = 'Activity Log';
    //             $history->current = $changestage->completed_by_under_phaseIII_investigation;
    //             $history->comment = $request->comment;
    //             $history->user_id = Auth::user()->id;
    //             $history->user_name = Auth::user()->name;
    //             $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //             $history->origin_state = $lastDocument->status;
    //             $history->stage = "Approval Completed";
    //             $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
           
    //         if ($changestage->stage == 14) {
    //             $changestage->stage = "15";
    //             $changestage->status = "Close-Done";
    //             $changestage->completed_by_close_done= Auth::user()->name;
    //             $changestage->completed_on_close_done = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_close_done = $request->comment;
                
    //             $history = new DosierDocumentsAuditTrial();
    //             $history->DosierDocuments_id = $id;
    //             $history->activity_type = 'Activity Log';
    //             $history->current = $changestage->completed_by_under_phaseIII_investigation;
    //             $history->comment = $request->comment;
    //             $history->user_id = Auth::user()->id;
    //             $history->user_name = Auth::user()->name;
    //             $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //             $history->origin_state = $lastDocument->status;
    //             $history->stage = "Close-Done";
    //             $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //     } else {
    //         toastr()->error('E-signature Not match');
    //         return back();
    //     }
    // }
    // ========== requestmoreinfo_back_stage ==============
    // public function requestmoreinfo_back_stage(Request $request, $id)
    // {

    //     if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
    //         $changestage = DosierDocuments::find($id);
    //         $lastDocument = DosierDocuments::find($id);
    //         if ($changestage->stage == 2) {
    //             $changestage->stage = "1";
    //             $changestage->status = "Opened";
    //             $changestage->completed_by_pending_initial_assessment = Auth::user()->name;
    //             $changestage->completed_on_pending_initial_assessment = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_pending_initial_assessment = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_pending_initial_assessment;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Completed";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 3) {
    //             $changestage->stage = "2";
    //             $changestage->status = "Pending Initial Assessment & Lab Incident";
    //             $changestage->completed_by_under_phaseI_investigation = Auth::user()->name;
    //             $changestage->completed_on_under_phaseI_investigation = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_phaseI_investigation = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_phaseIB_investigation;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Lab Supervisor";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 4) {
    //             $changestage->stage = "3";
    //             $changestage->status = "Under Phase I Investigation";
    //             $changestage->completed_by_under_phaseI_investigation = Auth::user()->name;
    //             $changestage->completed_on_under_phaseI_investigation = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_phaseI_investigation = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_phaseIB_investigation;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Lab Supervisor";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 5) {
    //             $changestage->stage = "3";
    //             $changestage->status = "Under Phase I b Investigation";
    //             $changestage->status = "Under Phase I Investigation";
    //             $changestage->completed_by_under_phaseI_investigation = Auth::user()->name;
    //             $changestage->completed_on_under_phaseI_investigation = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_phaseI_investigation = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_phaseIB_investigation;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Lab Supervisor";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 6) {
    //             $changestage->stage = "5";
    //             $changestage->status = "Under Hypothesis Experient";
    //             $changestage->completed_by_under_hypothesis = Auth::user()->name;
    //             $changestage->completed_on_under_hypothesis = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_hypothesis = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_hypothesis;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Final Approval";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }

    //         if ($changestage->stage == 8) {
    //             $changestage->stage = "6";
    //             $changestage->status = "Under Hypothesis Experiment";
    //             $changestage->completed_by_under_phaseII_investigation = Auth::user()->name;
    //             $changestage->completed_on_under_phaseII_investigation = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_phaseII_investigation = $request->comment;
                
    //             $history = new DosierDocumentsAuditTrial();
    //             $history->DosierDocuments_id = $id;
    //             $history->activity_type = 'Activity Log';
    //             $history->current = $changestage->completed_by_under_phaseII_investigation;
    //             $history->comment = $request->comment;
    //             $history->user_id = Auth::user()->id;
    //             $history->user_name = Auth::user()->name;
    //             $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //             $history->origin_state = $lastDocument->status;
    //             $history->stage = "Under Phase II investigation";
    //             $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 9) {
    //             $changestage->stage = "8";
    //             $changestage->status = "under phase II Investigation";
    //             $changestage->completed_by_under_manufacturing_investigation_phaseIIA = Auth::user()->name;
    //             $changestage->completed_on_under_manufacturing_investigation_phaseIIA = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_manufacturing_investigation_phaseIIA = $request->comment;
                
    //             $history = new DosierDocumentsAuditTrial();
    //             $history->DosierDocuments_id = $id;
    //             $history->activity_type = 'Activity Log';
    //             $history->current = $changestage->completed_by_under_manufacturing_investigation_phaseIIA;
    //             $history->comment = $request->comment;
    //             $history->user_id = Auth::user()->id;
    //             $history->user_name = Auth::user()->name;
    //             $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //             $history->origin_state = $lastDocument->status;
    //             $history->stage = "Under Manufacturing Phase II b Additional Lab Investigation";
    //             $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 11) {
    //             $changestage->stage = "9";
    //             $changestage->status = "Under Manufacturing Phase II b Additional Lab Investigation";
    //             $changestage->completed_by_under_phaseIIB_additional_lab_investigation= Auth::user()->name;
    //             $changestage->completed_on_under_phaseIIB_additional_lab_investigation = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_phaseIIB_additional_lab_investigation = $request->comment;
                
    //             $history = new DosierDocumentsAuditTrial();
    //             $history->DosierDocuments_id = $id;
    //             $history->activity_type = 'Activity Log';
    //             $history->current = $changestage->completed_by_under_manufacturing_investigation_phaseIIA;
    //             $history->comment = $request->comment;
    //             $history->user_id = Auth::user()->id;
    //             $history->user_name = Auth::user()->name;
    //             $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //             $history->origin_state = $lastDocument->status;
    //             $history->stage = "Under Manufacturing Phase II b Additional Lab Investigation";
    //             $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 13) {
    //             $changestage->stage = "11";
    //             $changestage->status = "Under phase II b Additional Lab Investigation";
    //             $changestage->completed_by_under_phaseIII_investigation= Auth::user()->name;
    //             $changestage->completed_on_under_phaseIII_investigation = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_phaseIII_investigation = $request->comment;
                
    //             $history = new DosierDocumentsAuditTrial();
    //             $history->DosierDocuments_id = $id;
    //             $history->activity_type = 'Activity Log';
    //             $history->current = $changestage->completed_by_under_phaseIII_investigation;
    //             $history->comment = $request->comment;
    //             $history->user_id = Auth::user()->id;
    //             $history->user_name = Auth::user()->name;
    //             $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //             $history->origin_state = $lastDocument->status;
    //             $history->stage = "Under Manufacturing Phase II b Additional Lab Investigation";
    //             $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 14) {
    //             $changestage->stage = "13";
    //             $changestage->status = "Pending Final Approval Completed";
    //             $changestage->completed_by_approval_completed= Auth::user()->name;
    //             $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_approval_completed = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_phaseIII_investigation;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Approval Completed";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //     } else {
    //         toastr()->error('E-signature Not match');
    //         return back();
    //     }
    // }

    // public function assignable_send_stage(Request $request, $id)
    // {
    //     if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
    //         $changestage = DosierDocuments::find($id);
    //         $lastDocument = DosierDocuments::find($id);
    //         if ($changestage->stage == 3) {
    //             $changestage->stage = "4";
    //             $changestage->status = "Under Phase I Correction";
    //             $changestage->completed_by_under_phaseI_correction= Auth::user()->name;
    //             $changestage->completed_on_under_phaseI_correction = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_phaseI_correction = $request->comment;
    //                         $history = new DosierDocumentsAuditTrial();
    //                         $history->DosierDocuments_id = $id;
    //                         $history->activity_type = 'Activity Log';
    //                         $history->current = $changestage->completed_by_under_phaseI_correction;
    //                         $history->comment = $request->comment;
    //                         $history->user_id = Auth::user()->id;
    //                         $history->user_name = Auth::user()->name;
    //                         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                         $history->origin_state = $lastDocument->status;
    //                         $history->stage = "Lab Supervisor";
    //                         $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 4) {
    //             $changestage->stage = "14";
    //             $changestage->status = "Pending Final Approval Completed";
    //             $changestage->completed_by_approval_completed= Auth::user()->name;
    //             $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_approval_completed = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_phaseIII_investigation;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Approval Completed";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 6) {
    //             $changestage->stage = "7";
    //             $changestage->status = "Under Repeat Analysis";
    //             $changestage->completed_by_under_repeat_analysis= Auth::user()->name;
    //             $changestage->completed_on_under_repeat_analysis = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_repeat_analysis = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_repeat_analysis;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Under Repeat Analysis";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 7) {
    //             $changestage->stage = "14";
    //             $changestage->status = "Pending Final Approval Completed";
    //             $changestage->completed_by_approval_completed= Auth::user()->name;
    //             $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_approval_completed = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_phaseIII_investigation;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Approval Completed";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 9) {
    //             $changestage->stage = "10";
    //             $changestage->status = "Under PhaseIIA Correction";
    //             $changestage->completed_by_under_phaseIIA_correction= Auth::user()->name;
    //             $changestage->completed_on_under_phaseIIA_correction = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_phaseIIA_correction = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_phaseIIA_correction;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Approval Completed";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 10) {
    //             $changestage->stage = "12";
    //             $changestage->status = "Under Batch Disposition";
    //             $changestage->completed_by_under_batch_disposition= Auth::user()->name;
    //             $changestage->completed_on_under_batch_disposition = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_batch_disposition = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_batch_disposition;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Approval Completed";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }

    //         if ($changestage->stage == 11) {
    //             $changestage->stage = "12";
    //             $changestage->status = "Under Batch Disposition";
    //             $changestage->completed_by_under_batch_disposition= Auth::user()->name;
    //             $changestage->completed_on_under_batch_disposition = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_under_batch_disposition = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_batch_disposition;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Approval Completed";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //         if ($changestage->stage == 12) {
    //             $changestage->stage = "14";
    //             $changestage->status = "Pending Final Approval Completed";
    //             $changestage->completed_by_approval_completed= Auth::user()->name;
    //             $changestage->completed_on_approval_completed = Carbon::now()->format('d-M-Y');
    //             $changestage->comment_approval_completed = $request->comment;
    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->current = $changestage->completed_by_under_phaseIII_investigation;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state = $lastDocument->status;
    //                 $history->stage = "Approval Completed";
    //                 $history->save();
    //             $changestage->update();
    //             toastr()->success('Document Sent');
    //             return back();
    //         }
    //     } else {
    //         toastr()->error('E-signature Not match');
    //         return back();
    //     }
    // }
    // public function cancel_stage(Request $request, $id)
    // {
    //     if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
    //         $data = DosierDocuments::find($id);
    //         $lastDocument = DosierDocuments::find($id);
    //         $data->stage = "0";
    //         $data->status = "Closed-Cancelled";
    //         $data->cancelled_by = Auth::user()->name;
    //         $data->cancelled_on = Carbon::now()->format('d-M-Y');
    //         $data->comment_cancle = $request->comment;

    //                 $history = new DosierDocumentsAuditTrial();
    //                 $history->DosierDocuments_id = $id;
    //                 $history->activity_type = 'Activity Log';
    //                 $history->previous ="";
    //                 $history->current = $data->cancelled_by;
    //                 $history->comment = $request->comment;
    //                 $history->user_id = Auth::user()->id;
    //                 $history->user_name = Auth::user()->name;
    //                 $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
    //                 $history->origin_state =  $data->status;
    //                 $history->stage = 'Cancelled';
    //                 $history->save();
    //         $data->update();
    //         toastr()->success('Document Sent');
    //         return back();
    //     } else {
    //         toastr()->error('E-signature Not match');
    //         return back();
    //     }
    // }
//    public function reject_stage(Request $request, $id)
//     {

//         if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
//             $capa = Capa::find($id);
//             $lastDocument = Capa::find($id);


//             if ($capa->stage == 2) {
//                 $capa->stage = "1";
//                 $capa->status = "Opened";
//                 // $capa->rejected_by = Auth::user()->name;
//                 // $capa->rejected_on = Carbon::now()->format('d-M-Y');
//                 $capa->update();
//                 $history = new CapaHistory();
//                 $history->type = "Capa";
//                 $history->doc_id = $id;
//                 $history->user_id = Auth::user()->id;
//                 $history->user_name = Auth::user()->name;
//                 $history->stage_id = $capa->stage;
//                 $history->status = "Opened";
//                 // $list = Helpers::getInitiatorUserList();
//                 // foreach ($list as $u) {
//                 //     if($u->q_m_s_divisions_id == $capa->division_id){
//                 //     $email = Helpers::getInitiatorEmail($u->user_id);
//                 //     if ($email !== null) {
                       
//                 //         Mail::send(
//                 //             'mail.view-mail',
//                 //             ['data' => $capa],
//                 //             function ($message) use ($email) {
//                 //                 $message->to($email)
//                 //                     ->subject("More Info Required ".Auth::user()->name);
//                 //             }
//                 //         );
//                 //       }
//                 //     } 
//                 // }
//                 $history->save();

//                 toastr()->success('Document Sent');
//                 return back();
//             }
//             if ($capa->stage == 3) {
//                 $capa->stage = "2";
//                 $capa->status = "Pending CAPA Plan";
//                 $capa->qa_more_info_required_by = Auth::user()->name;
//                 $capa->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
//                         $history = new CapaAuditTrial();
//                         $history->capa_id = $id;
//                         $history->activity_type = 'Activity Log';
//                         $history->previous = "";
//                         $history->current = $capa->qa_more_info_required_by;
//                         $history->comment = $request->comment;
//                         $history->user_id = Auth::user()->id;
//                         $history->user_name = Auth::user()->name;
//                         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
//                         $history->origin_state = $lastDocument->status;
//                         $history->stage = 'Qa More Info Required';
//                         $history->save();   
//                 $capa->update();
//                 $history = new CapaHistory();
//                 $history->type = "Capa";
//                 $history->doc_id = $id;
//                 $history->user_id = Auth::user()->id;
//                 $history->user_name = Auth::user()->name;
//                 $history->stage_id = $capa->stage;
//                 $history->status = "Pending CAPA Plan<";
//                 $history->save();
//                 toastr()->success('Document Sent');
//                 return back();
//             }

//         } else {
//             toastr()->error('E-signature Not match');
//             return back();
//         }
//     }

    // public function cancel_record(Request $request, $id)
    // {
    //     $DosierDocuments_record = DosierDocuments::find($id);
    // }

    // public function AuditTrial($id)
    // {
    //     $audit = DosierDocumentsAuditTrial::where('DosierDocuments_id', $id)->orderByDesc('id')->paginate(5);
    //     $today = Carbon::now()->format('d-m-y');
    //     $document = DosierDocuments::where('id', $id)->first();
    //     $document->initiator = User::where('id', $document->initiator_id)->value('name');
    //     // dd($document);
    //     return view('frontend.DosierDocuments.comps.audit-trial', compact('audit', 'document', 'today'));
    // }

    // public function auditDetails($id)
    // {

    //     $detail = DosierDocumentsAuditTrial::find($id);

    //     $detail_data = DosierDocumentsAuditTrial::where('activity_type', $detail->activity_type)->where('DosierDocuments_id', $detail->id)->latest()->get();

    //     $doc = DosierDocuments::where('id', $detail->DosierDocuments_id)->first();
        

    //     $doc->origiator_name = User::find($doc->initiator_id);
        
    //     return view('frontend.DosierDocuments.comps.audit-trial-inner', compact('detail', 'doc', 'detail_data'));
    // }
    // public static function auditReport($id)
    // {
    //     $doc = DosierDocuments::find($id);
    //     if (!empty($doc)) {
    //         $doc->originator = User::where('id', $doc->initiator_id)->value('name');
    //         $data = DosierDocumentsAuditTrial::where('DosierDocuments_id', $id)->get();
    //         $pdf = App::make('dompdf.wrapper');
    //         $time = Carbon::now();
    //         $pdf = PDF::loadview('frontend.DosierDocuments.comps.auditReport', compact('data', 'doc'))
    //             ->setOptions([
    //                 'defaultFont' => 'sans-serif',
    //                 'isHtml5ParserEnabled' => true,
    //                 'isRemoteEnabled' => true,
    //                 'isPhpEnabled' => true,
    //             ]);
    //         $pdf->setPaper('A4');
    //         $pdf->render();
    //         $canvas = $pdf->getDomPDF()->getCanvas();
    //         $height = $canvas->get_height();
    //         $width = $canvas->get_width();
    //         $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
    //         $canvas->page_text($width / 4, $height / 2, $doc->status, null, 25, [0, 0, 0], 2, 6, -20);
    //         return $pdf->stream('DosierDocuments-Audit' . $id . '.pdf');
    //     }
    // }
    
    // public static function singleReport($id)
    // {
    //     $data = DosierDocuments::find($id);
    //     if (!empty($data)) {
    //         $data->info_product_materials = $data->grids()->where('identifier', 'info_product_material')->first();
    //         $data->details_stabilities = $data->grids()->where('identifier', 'details_stability')->first();
    //         $data->DosierDocuments_details = $data->grids()->where('identifier', 'DosierDocuments_detail')->first();
    //         $checklist_lab_invs = $data->grids()->where('identifier', 'checklist_lab_inv')->first();
    //         $DosierDocuments_capas = $data->grids()->where('identifier', 'DosierDocuments_capa')->first();
    //         $phase_two_invs = $data->grids()->where('identifier', 'phase_two_inv')->first();
    //         $DosierDocuments_conclusions = $data->grids()->where('identifier', 'DosierDocuments_conclusion')->first();
    //         $DosierDocuments_conclusion_reviews = $data->grids()->where('identifier', 'DosierDocuments_conclusion_review')->first();
    
    //         $data->originator = User::where('id', $data->initiator_id)->value('name');
    //         $pdf = App::make('dompdf.wrapper');
    //         $time = Carbon::now();
    //         $pdf = PDF::loadview('frontend.DosierDocuments.comps.singleReport', compact('data','checklist_lab_invs','phase_two_invs','DosierDocuments_capas','DosierDocuments_conclusions','DosierDocuments_conclusion_reviews'))
    //             ->setOptions([
    //                 'defaultFont' => 'sans-serif',
    //                 'isHtml5ParserEnabled' => true,
    //                 'isRemoteEnabled' => true,
    //                 'isPhpEnabled' => true,
    //             ]);
    //         $pdf->setPaper('A4');
    //         $pdf->render();
    //         $canvas = $pdf->getDomPDF()->getCanvas();
    //         $height = $canvas->get_height();
    //         $width = $canvas->get_width();
    //         $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
    //         $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
    //         return $pdf->stream('DosierDocuments Cemical' . $id . '.pdf');
    //     }
    // }
       
}
