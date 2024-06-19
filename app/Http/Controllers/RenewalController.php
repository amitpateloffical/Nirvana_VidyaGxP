<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Renewal;
use App\Models\RecordNumber;
use App\Models\renewal_audit_trails;
use App\Models\RoleGroup;
use App\Models\Rgrid;

use Illuminate\Support\Facades\Auth; // Import Auth Facade
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

class RenewalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('frontend.new_forms.renewal');
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $renewal = new Renewal();
        $renewal->manufacturer = $request->input('manufacturer');
        $renewal->trade_name = $request->input('trade_name');
        $renewal->initiator = $request->input('initiator');
        $renewal->date_of_initiation = Carbon::today();
        $renewal->short_description = $request->input('short_description');
        $renewal->assign_to = $request->input('assign_to');
        $renewal->due_date = Carbon::today()->addDays(30);
        $renewal->documents = $request->input('documents');
        // $renewal->Attached_Files = $request->input('Attached_Files');
        $renewal->dossier_parts = $request->input('dossier_parts');
        $renewal->related_dossier_documents = $request->input('related_dossier_documents');
        $renewal->registration_status = $request->input('registration_status');
        $renewal->registration_number = $request->input('registration_number');
        $renewal->planned_submission_date = $request->input('planned_submission_date');
        $renewal->actual_submission_date = $request->input('actual_submission_date');
        $renewal->planned_approval_date = $request->input('planned_approval_date');
        $renewal->actual_approval_date = $request->input('actual_approval_date');
        $renewal->actual_withdrawn_date = $request->input('actual_withdrawn_date');
        $renewal->actual_rejection_date = $request->input('actual_rejection_date');
        $renewal->comments = $request->input('comments');
        $renewal->root_parent_trade_name = $request->input('root_parent_trade_name');
        $renewal->parent_local_trade_name = $request->input('parent_local_trade_name');
        $renewal->renewal_rule = $request->input('renewal_rule');
        $renewal->status ='Opened';
        $renewal->stage = '1';

       

        if (!empty ($request->Attached_files)) {
            $files = [];
            if ($request->hasfile('Attached_files')) {
                foreach ($request->file('Attached_files') as $file) {
                    $name = $request->name . 'Attached_files' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $renewal->Attached_files = json_encode($files);
        
        }
         $renewal->save();

         //-----------grid-----------
         $rgrids=$renewal->id;

         $rgrid=Rgrid::where(['renewal_id'=>$rgrids, 'identifir'=> 'product information'])->firstOrNew();
         $rgrid->renewal_id = $rgrids;
         $rgrid->identifir = 'product information';
         $rgrid->data =$request->productinfo;
         $rgrid->save();
        
        return redirect()->back()->with('success','Renewal created successfully!'); 
    

    //=========================audit-trail-store==================================//
        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
    
        // if(!empty($renewal->division_code)){
        //     $history = new renewal_audit_trails();
        //     $history->renewal_id = $renewal->id;
        //     $history->activity_type = 'Division Code';
        //     $history->previous = "Null";
        //     $history->current = $renewal->division_code;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $renewal->status;
        //     $history->change_from ="Initiator";
        //     $history->change_to ="Opened";
        //     $history->action_name ="Create";        
        //     $history->save();
        // }


        // if(!empty($renewal->record_number)){
        //     $history = new renewal_audit_trails();
        //     $history->renewal_id = $renewal->id;
        //     $history->activity_type = 'Record Number';
        //     $history->previous = "Null";
        //     $history->current = $renewal->record_number;
        //     $history->comment = "NA";
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $renewal->status;
        //     $history->change_from ="Initiator";
        //     $history->change_to ="Opened";
        //     $history->action_name ="Create";        
        //     $history->save();
        // }
        if(!empty($renewal->manufacturer)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = '(renewal Parent) Manufacturer';
            $history->previous = "Null";
            $history->current = $renewal->manufacturer;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->trade_name)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = '(renewal Parent)Trade Name';
            $history->previous = "Null";
            $history->current = $renewal->trade_name;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->initiator_show)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Initiator';
            $history->previous = "Null";
            $history->current = $renewal->initiator_show;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->date_of_initiation)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = "Null";
            $history->current = $renewal->date_of_initiation;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->short_description)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $renewal->short_description;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->assign_to)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Assigned To';
            $history->previous = "Null";
            $history->current = $renewal->assign_to;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->due_date)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Date Due';
            $history->previous = "Null";
            $history->current = $renewal->due_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->documents)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Documents';
            $history->previous = "Null";
            $history->current = $renewal->documents;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->Attached_Files)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Attached Files';
            $history->previous = "Null";
            $history->current = $renewal->Attached_Files;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->dossier_parts)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Dossier Parts';
            $history->previous = "Null";
            $history->current = $renewal->dossier_parts;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->related_dossier_documents)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Related Dossier Documents';
            $history->previous = "Null";
            $history->current = $renewal->related_dossier_documents;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->registration_status)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Registration Status';
            $history->previous = "Null";
            $history->current = $renewal->registration_status;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->registration_number)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Registration Number';
            $history->previous = "Null";
            $history->current = $renewal->registration_number;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->planned_submission_date)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Planned Submission Date';
            $history->previous = "Null";
            $history->current = $renewal->planned_submission_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->actual_submission_date)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Actual Submission Date';
            $history->previous = "Null";
            $history->current = $renewal->actual_submission_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->planned_approval_date)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Planed Approval Date';
            $history->previous = "Null";
            $history->current = $renewal->planned_approval_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->actual_approval_date)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Actual Approval Date';
            $history->previous = "Null";
            $history->current = $renewal->actual_approval_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->actual_withdrawn_date)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Actual Withdrawn Date';
            $history->previous = "Null";
            $history->current = $renewal->actual_withdrawn_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->actual_rejection_date)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Actual Rejection Date';
            $history->previous = "Null";
            $history->current = $renewal->actual_rejection_date;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->comments)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $renewal->comments;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->renewal_parent_trade_name)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = '(renewal Parent) Trade Name';
            $history->previous = "Null";
            $history->current = $renewal->renewal_parent_trade_name;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->parent_local_trade_name)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = '(Parent)Local Trade Name';
            $history->previous = "Null";
            $history->current = $renewal->parent_local_trade_name;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
        if(!empty($renewal->renewal_rule)){
            $history = new renewal_audit_trails();
            $history->renewal_id = $renewal->id;
            $history->activity_type = '(Parent) Renewal Rule';
            $history->previous = "Null";
            $history->current = $renewal->renewal_rule;
            $history->comment = "NA";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $renewal->status;
            $history->change_from ="Initiator";
            $history->change_to ="Opened";
            $history->action_name ="Submit";        
            $history->save();
        }
    }
    public function show($id)
    {
            // dd('dgfdd');
            $renewal = Renewal::findOrFail($id);
            // $renewal = Renewal::where(['id',$id])->first();
            // -------------grid-----------
            $repo = Rgrid::where(['renewal_id'=> $id , 'identifir'=>'product information'])->first();
            
            return view('frontend.new_forms.renewal-view',compact('repo','renewal'));
    }
    
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $renewal = Renewal::findOrFail($id);

    
            $renewal->manufacturer = $request->input('manufacturer');
            $renewal->trade_name = $request->input('trade_name');
            // $renewal->date_of_initiation = $request->input('date_of_initiation');
            $renewal->short_description = $request->input('short_description');
            $renewal->assign_to = $request->input('assign_to');
            // $renewal->due_date = Carbon::today()->addDays(39);
            $renewal->documents = $request->input('documents');
            // $renewal->Attached_Files = $request->input('Attached_Files');
            $renewal->dossier_parts = $request->input('dossier_parts');
            $renewal->related_dossier_documents = $request->input('related_dossier_documents');
            $renewal->registration_status = $request->input('registration_status');
            $renewal->registration_number = $request->input('registration_number');
            $renewal->planned_submission_date = $request->input('planned_submission_date');
            $renewal->actual_submission_date = $request->input('actual_submission_date');
            $renewal->planned_approval_date = $request->input('planned_approval_date');
            $renewal->actual_approval_date = $request->input('actual_approval_date');
            $renewal->actual_withdrawn_date = $request->input('actual_withdrawn_date');
            $renewal->actual_rejection_date = $request->input('actual_rejection_date');
            $renewal->comments = $request->input('comments');
            $renewal->root_parent_trade_name = $request->input('root_parent_trade_name');
            $renewal->parent_local_trade_name = $request->input('parent_local_trade_name');
            $renewal->renewal_rule = $request->input('renewal_rule');

            if ($request->hasFile('Attached_Files')) {
            // Delete existing files (if any)
            // Implement this logic based on your requirements
            // For example:
            // Storage::delete($renewal->Attached_Files);

            // Upload new files
            $newFiles = [];
            foreach ($request->file('Attached_Files') as $file) {
                $path = $file->store('uploads'); // Adjust the storage path as needed
                $newFiles[] = $path;
            }

                // Update the database record with new file information
            $renewal->Attached_Files = json_encode($newFiles);
            
            }
            $renewal->update();
            
            $rgrids=$renewal->id;

            $rgrid=Rgrid::where(['renewal_id'=>$rgrids, 'identifir'=> 'product information'])->firstOrNew();
            $rgrid->renewal_id = $rgrids;
            $rgrid->identifir = 'product information';
            $rgrid->data =$request->productinfo;
            $rgrid->save();

            return redirect()->back()->with('success', 'Renewal updated successfully!');
            
            // if ($lastDocument->division_code != $renewal->division_code || !empty($request->division_code_comment)) {

            //     $history = new renewal_audit_trails();
            //     $history->renewal_id = $id;
            //     $history->activity_type = 'Division Code';
            //     $history->previous = $lastDocument->division_code;
            //     $history->current = $renewal->division_code;
            //     $history->comment = $request->division_code_comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->save();
            // }
            // if ($lastDocument->record_number != $renewal->record_number || !empty($request->record_number_comment)) {

            //     $history = new renewal_audit_trails();
            //     $history->renewal_id = $id;
            //     $history->activity_type = 'Record Number';
            //     $history->previous = $lastDocument->record_number;
            //     $history->current = $renewal->record_number;
            //     $history->comment = $request->record_number_comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->save();
            // }
            if ($lastDocument->manufacturer != $renewal->manufacturer || !empty($request->manufacturer_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = '(renewal Parent) Manufacturer';
                $history->previous = $lastDocument->manufacturer;
                $history->current = $renewal->manufacturer;
                $history->comment = $request->manufacturer_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->trade_name != $renewal->trade_name || !empty($request->trade_name_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = '(renewal Parent)Trade Name';
                $history->previous = $lastDocument->trade_name;
                $history->current = $renewal->trade_name;
                $history->comment = $request->trade_name_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->initiator_show != $renewal->initiator_show || !empty($request->initiator_show_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Initiator';
                $history->previous = $lastDocument->initiator_show;
                $history->current = $renewal->initiator_show;
                $history->comment = $request->initiator_show_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->date_of_initiation != $renewal->date_of_initiation || !empty($request->date_of_initiation_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Date of Initiation';
                $history->previous = $lastDocument->date_of_initiation;
                $history->current = $renewal->date_of_initiation;
                $history->comment = $request->date_of_initiation_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->short_description != $renewal->short_description || !empty($request->short_description_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Short Description';
                $history->previous = $lastDocument->short_description;
                $history->current = $renewal->short_description;
                $history->comment = $request->short_description_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->assign_to != $renewal->assign_to || !empty($request->assign_to_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Assigned To';
                $history->previous = $lastDocument->assign_to;
                $history->current = $renewal->assign_to;
                $history->comment = $request->assign_to_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->due_date != $renewal->due_date || !empty($request->due_date_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Date Due';
                $history->previous = $lastDocument->due_date;
                $history->current = $renewal->due_date;
                $history->comment = $request->due_date_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->documents != $renewal->documents || !empty($request->documents_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Documents';
                $history->previous = $lastDocument->documents;
                $history->current = $renewal->documents;
                $history->comment = $request->documents_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->Attached_Files != $renewal->Attached_Files || !empty($request->Attached_Files_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Attached Files';
                $history->previous = $lastDocument->Attached_Files;
                $history->current = $renewal->Attached_Files;
                $history->comment = $request->Attached_Files_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->dossier_parts != $renewal->dossier_parts || !empty($request->dossier_parts_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Dossier Parts';
                $history->previous = $lastDocument->dossier_parts;
                $history->current = $renewal->dossier_parts;
                $history->comment = $request->dossier_parts_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->related_dossier_documents != $renewal->related_dossier_documents || !empty($request->related_dossier_documents_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Related Dossier Documents';
                $history->previous = $lastDocument->related_dossier_documents;
                $history->current = $renewal->related_dossier_documents;
                $history->comment = $request->related_dossier_documents_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->registration_status != $renewal->registration_status || !empty($request->registration_status_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Registration Status';
                $history->previous = $lastDocument->registration_status;
                $history->current = $renewal->registration_status;
                $history->comment = $request->registration_status_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->registration_number != $renewal->registration_number || !empty($request->registration_number_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Registration Number';
                $history->previous = $lastDocument->registration_number;
                $history->current = $renewal->registration_number;
                $history->comment = $request->registration_number_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->planned_submission_date != $renewal->planned_submission_date || !empty($request->planned_submission_date_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Planned Submission Date';
                $history->previous = $lastDocument->planned_submission_date;
                $history->current = $renewal->planned_submission_date;
                $history->comment = $request->planned_submission_date_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->actual_submission_date != $renewal->actual_submission_date || !empty($request->actual_submission_date_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Actual Submission Date';
                $history->previous = $lastDocument->actual_submission_date;
                $history->current = $renewal->actual_submission_date;
                $history->comment = $request->actual_submission_date_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->planned_approval_date != $renewal->planned_approval_date || !empty($request->planned_approval_date_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Planed Approval Date';
                $history->previous = $lastDocument->planned_approval_date;
                $history->current = $renewal->planned_approval_date;
                $history->comment = $request->planned_approval_date_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->actual_approval_date != $renewal->actual_approval_date || !empty($request->actual_approval_date_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Actual Approval Date';
                $history->previous = $lastDocument->actual_approval_date;
                $history->current = $renewal->actual_approval_date;
                $history->comment = $request->actual_approval_date_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->actual_withdrawn_date != $renewal->actual_withdrawn_date || !empty($request->actual_withdrawn_date_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Actual Withdrawn Date';
                $history->previous = $lastDocument->actual_withdrawn_date;
                $history->current = $renewal->actual_withdrawn_date;
                $history->comment = $request->actual_withdrawn_date_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->actual_rejection_date != $renewal->actual_rejection_date || !empty($request->actual_rejection_date_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Actual Rejection Date';
                $history->previous = $lastDocument->actual_rejection_date;
                $history->current = $renewal->actual_rejection_date;
                $history->comment = $request->actual_rejection_date_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->comments != $renewal->comments || !empty($request->comments_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Comments';
                $history->previous = $lastDocument->comments;
                $history->current = $renewal->comments;
                $history->comment = $request->comments_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->renewal_parent_trade_name != $renewal->renewal_parent_trade_name || !empty($request->renewal_parent_trade_name_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = '(renewal Parent) Trade Name';
                $history->previous = $lastDocument->renewal_parent_trade_name;
                $history->current = $renewal->renewal_parent_trade_name;
                $history->comment = $request->renewal_parent_trade_name_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->parent_local_trade_name != $renewal->parent_local_trade_name || !empty($request->parent_local_trade_name_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = '(Parent)Local Trade Name';
                $history->previous = $lastDocument->parent_local_trade_name;
                $history->current = $renewal->parent_local_trade_name;
                $history->comment = $request->parent_local_trade_name_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }
            if ($lastDocument->renewal_rule != $renewal->renewal_rule || !empty($request->renewal_rule_comment)) {

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = '(Parent) Renewal Rule';
                $history->previous = $lastDocument->renewal_rule;
                $history->current = $renewal->renewal_rule;
                $history->comment = $request->renewal_rule_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->save();
            }

            }
//===============================================cancel-stage===========================//

    public function renewal_cancel_stage(Request $request, $id ){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)){
            $renewalstage = Renewal::find($id);
            $lastDocument = Renewal::find($id);
                
                if ($renewalstage->stage = "0"){
                    $renewalstage->status = "Closed-Cancelled";
                    $renewalstage->cancelled_by = Auth::user()->name;
                    $renewalstage->cancelled_on = Carbon::now()->format('d-M-Y');
                    $renewalstage->cancelled_comment = $request->comment;
                    $renewalstage->update();
                    toastr()->success('Document Sent');
                    return back();
                }
                if ($renewalstage->stage == 2){
                    $renewalstage->stage = "0";
                    $renewalstage->status = "Opened";
                    $renewalstage->cancelled_by = Auth::user()->name;
                    $renewalstage->cancelled_on = Carbon::now()->format('d-M-Y');
                    $renewalstage->cancelled_comment = $request->comment;
                    $renewalstage->update();
                    toastr()->success('Document Sent');
                    return back();
                }
                if ($renewalstage->stage == 3){
                    $renewalstage->stage = "0";
                    $renewalstage->status = "Opened";
                    $renewalstage->cancelled_by = Auth::user()->name;
                    $renewalstage->cancelled_on = Carbon::now()->format('d-M-Y');
                    $renewalstage->cancelled_comment = $request->comment;
                    $renewalstage->update();
                    toastr()->success('Document Sent');
                    return back();
                }
                
            }
            else{
                toastr()->error('E-signature Not match');
                return back();
                }
            }
            
//========================================stage====================================//

    public function renewal_send_stage(Request $request, $id ){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)){
            $renewalstage = Renewal::find($id);
            $lastDocument = Renewal::find($id);
                
                
            if ($renewalstage->stage == 1) {
                $renewalstage->stage = "2";
                $renewalstage->status = "Submission Preparation";
                $renewalstage->submit_by = Auth::user()->name;
                $renewalstage->submit_on = Carbon::now()->format('d-M-Y');
                $renewalstage->submit_comment = $request->comment;

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->submit_by;
                $history->current = $renewalstage->submit_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();


                //     $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $capa->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //             if ($email !== null) {
                        
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $capa],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Submitted By ".Auth::user()->name);
                //                 }
                //             );
                //             }
                //     } 
                // }
                $renewalstage->update();
                toastr()->success('Document Sent');
                return back();
            }
                        
            if ($renewalstage->stage == 2) {
                $renewalstage->stage = "3";
                $renewalstage->status = "Pending Submission Review";
                $renewalstage->pending_submission_review_submit_by = Auth::user()->name;
                $renewalstage->pending_submission_review_submit_on = Carbon::now()->format('d-M-Y');
                $renewalstage->pending_submission_review_submit_comment = $request->comment;

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $renewalstage->submit_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'Submission Review';
                $history->save();


                //     $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $capa->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //             if ($email !== null) {
                        
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $capa],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Submitted By ".Auth::user()->name);
                //                 }
                //             );
                //             }
                //     } 
                // }
                $renewalstage->update();
                toastr()->success('Document Sent');
                return back();
            }
            
            if ($renewalstage->stage == 3) {
                $renewalstage->stage = "4";
                $renewalstage->status = "Authority Assessment";
                $renewalstage->authority_assessment_submit_by = Auth::user()->name;
                $renewalstage->authority_assessment_submit_on = Carbon::now()->format('d-M-Y');
                $renewalstage->authority_assessment_submit_comment = $request->comment;

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $renewalstage->submit_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'Authority Assessment';
                $history->save();


                //     $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $capa->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //             if ($email !== null) {
                        
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $capa],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Submitted By ".Auth::user()->name);
                //                 }
                //             );
                //             }
                //     } 
                // }
                $renewalstage->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($renewalstage->stage == 4) {
                $renewalstage->stage = "5";
                $renewalstage->status = "Closed - Withdrawn";
                $renewalstage->closed_withdrawn_submit_by = Auth::user()->name;
                $renewalstage->closed_withdrawn_submit_on = Carbon::now()->format('d-M-Y');
                $renewalstage->closed_withdrawn_submit_comment = $request->comment;

                $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $renewalstage->submit_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'Closed-Withdrawn';
                $history->save();


                //     $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $capa->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //             if ($email !== null) {
                        
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $capa],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Submitted By ".Auth::user()->name);
                //                 }
                //             );
                //             }
                //     } 
                // }
                $renewalstage->update();
                toastr()->success('Document Sent');
                return back();      
            }
            else{
                toastr()->error('E-signature Not match');
                return back();
            }
        }
        
    }
                         
//==========================================backword-stage==============================================//
    public function renewal_backword_stage(Request $request, $id ){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)){
            $renewalstage = Renewal::find($id);
            $lastDocument = Renewal::find($id);
        }
        if ($renewalstage->stage == 2) {
            $renewalstage->stage = "1";
            $renewalstage->status = "Opened";
            $renewalstage->closed_retiredd_submit_by = Auth::user()->name;
            $renewalstage->closed_retired_submit_on = Carbon::now()->format('d-M-Y');
            $renewalstage->closed_retired_submit_comment = $request->comment;
            $renewalstage->update();
            toastr()->success('Document Sent');
            return back();      
        }
        if ($renewalstage->stage == 3) {
            $renewalstage->stage = "1";
            $renewalstage->status = "Opened";
            $renewalstage->closed_retiredd_submit_by = Auth::user()->name;
            $renewalstage->closed_retired_submit_on = Carbon::now()->format('d-M-Y');
            $renewalstage->closed_retired_submit_comment = $request->comment;
            $renewalstage->update();
            toastr()->success('Document Sent');
            return back();      
        }
        else{
            toastr()->error('E-signature Not match');
            return back();
        }
    }
 //===================================forword===================================================//
    public function renewal_forword_close(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)){
            $renewalstage = Renewal::find($id);
            $lastDocument = Renewal::find($id);
        
        if ($renewalstage->stage == 4){
            $renewalstage->stage = "6";
            $renewalstage->status = "Closed – Not Approved";
            $renewalstage->closed_not_approved_by = Auth::user()->name;
            $renewalstage->closed_not_approved_on = Carbon::now()->format('d-M-Y');
            $renewalstage->closed_not_approved_comment = $request->comment;
            $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $renewalstage->submit_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'Closed-Not Approved';
                $history->save();


                //     $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $capa->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //             if ($email !== null) {
                        
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $capa],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Submitted By ".Auth::user()->name);
                //                 }
                //             );
                //             }
                //     } 
                // }
            $renewalstage->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($renewalstage->stage == 7){
            $renewalstage->stage = "8";
            $renewalstage->status = "Approved";
            $renewalstage->approved_by = Auth::user()->name;
            $renewalstage->approved_on = Carbon::now()->format('d-M-Y');
            $renewalstage->approved_comment = $request->comment;
            $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $renewalstage->submit_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'Approved';
                $history->save();


                //     $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $capa->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //             if ($email !== null) {
                        
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $capa],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Submitted By ".Auth::user()->name);
                //                 }
                //             );
                //             }
                //     } 
                // }
            $renewalstage->update();
            toastr()->success('Document Sent');
            return back();
        }
        else{
            toastr()->error('E-signature Not match');
            return back();
        }
    }
}
//=======================================================================//
   public function renewal_forword2_close(Request $request, $id){
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)){
        $renewalstage = Renewal::find($id);
        $lastDocument = Renewal::find($id);
    
        if ($renewalstage->stage == 4){
            $renewalstage->stage = "7";
            $renewalstage->status = "Pending Registration Update";
            $renewalstage->closed_not_approved_by = Auth::user()->name;
            $renewalstage->closed_not_approved_on = Carbon::now()->format('d-M-Y');
            $renewalstage->closed_not_approved_comment = $request->comment;
            $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $renewalstage->submit_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'Registration Update';
                $history->save();


                //     $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $capa->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //             if ($email !== null) {
                        
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $capa],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Submitted By ".Auth::user()->name);
                //                 }
                //             );
                //             }
                //     } 
                // }
            $renewalstage->update();
            toastr()->success('Document Sent');
            return back();
        }
        if ($renewalstage->stage == 7){
            $renewalstage->stage = "9";
            $renewalstage->status = "Registration Retired";
            $renewalstage->approved_by = Auth::user()->name;
            $renewalstage->approved_on = Carbon::now()->format('d-M-Y');
            $renewalstage->approved_comment = $request->comment;
            $history = new renewal_audit_trails();
                $history->renewal_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $renewalstage->submit_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'Registration Retired';
                $history->save();


                //     $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $capa->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //             if ($email !== null) {
                        
                //             Mail::send(
                //                 'mail.view-mail',
                //                 ['data' => $capa],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document is Submitted By ".Auth::user()->name);
                //                 }
                //             );
                //             }
                //     } 
                // }
            $renewalstage->update();
            toastr()->success('Document Sent');
            return back();
        }
        else{
            toastr()->error('E-signature Not match');
            return back();
        }
    }
}                      
//======================================child-stage=========================//    
   public function renewal_child_stage(Request $request, $id){
                        

        }
//===========================audit-trail=========================================/
    public function renewalAuditTrial($id){
        $audit = renewal_audit_trails::where('renewal_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = Renewal::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view("frontend.New_forms.renewal-audit-trail", compact('audit', 'document', 'today'));
    }
    //=====================================================single-report====================================================//
    public static function singleReport($id)
    {    
        $data = RenewalController::find($id);
        if (!empty($data)) {
            $data->originator_id = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.renewal-cause-analysis.singleReport', compact('data'))
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
            return $pdf->stream('renewal-cause' . $id . '.pdf');
        }
    }
//===================================audit-report==============================//
    public static function auditReport($id)
    {
        $doc = RenewalController::find($id);
        if (!empty($doc)) {
            $doc->originator_id = User::where('id', $doc->initiator_id)->value('name');
            $data = renewal_audit_trails::where('renewal_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.renewal-cause-analysis.auditReport', compact('data', 'doc'))
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
            $canvas->page_text($width / 4, $height / 2, $doc->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('renewal-Audit' . $id . '.pdf');
        }
    }
    public function destroy($id)
    {
        
    }

}




// public function LabIncidentShow($id)
//     {

//         $data = LabIncident::where('id', $id)->first();
//         $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
//         $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
//         $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
//         $report = lab_incidents_grid::where('labincident_id', $id)->first();
//         // foreach($report as $r){
//         //     return $r;
//         // }
//         $systemSutData = lab_incidents_grid::where(['labincident_id' => $id,'identifier' => 'Sutability'])->first();
//         $labnew =Labincident_Second::where(['lab_incident_id'=>$id])->first();
        
//         return view('frontend.labIncident.view', compact('data','report','systemSutData','labnew'));

//            }
