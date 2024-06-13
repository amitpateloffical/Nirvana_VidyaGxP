<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use App\Models\ProductRecall;
use App\Models\RoleGroup;
use App\Models\User;
use App\Models\ProductRecallAuditTrail;
use App\Models\Department;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use PDF;
use Illuminate\Support\Facades\Hash;

class ProductRecallController extends Controller
{
    public function index(Request $request){
        $record_number = (RecordNumber::first()->value('counter')) + 1;
        $users = User::all();
        $department = Department::all();
        $record_numbers = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        return view('frontend.product-recall.product-recall-new', compact('record_number','record_numbers', 'users', 'department'));
    }

    public function store(Request $request){
        $productRecall = new ProductRecall();

        $productRecall->record = DB::table('record_numbers')->value('counter') + 1;
        $productRecall->parent_id = $request->parent_id;
        $productRecall->parent_type = $request->parent_type;
        $productRecall->division_id = $request->division_id;
        $productRecall->initiator_id = Auth::user()->id;
        $productRecall->intiation_date = Carbon::now()->format('d-M-Y');
        $productRecall->product_name = $request->product_name;
        $productRecall->short_description = $request->short_description;
        $productRecall->assign_to = $request->assign_to;
        $productRecall->due_date = Carbon::now()->addDays(30)->format('d-M-Y');
        $productRecall->recalled_from = $request->recalled_from;
        $productRecall->priority_level = $request->priority_level;
        $productRecall->recalled_by = $request->recalled_by;

        $productRecall->contact_person = $request->contact_person;
        $productRecall->related_product = $request->related_product;
        $productRecall->recall_reason = $request->recall_reason;
        $productRecall->schedule_start_date = $request->schedule_start_date;
        $productRecall->schedule_end_date = $request->schedule_end_date;
        $productRecall->department_code = implode(',', $request->department_code);
        $productRecall->team_members = implode(',', $request->team_members);

        $productRecall->bussiness_area = $request->bussiness_area;
        $productRecall->estimate_man_hours = $request->estimate_man_hours;
        $productRecall->related_urls = $request->related_urls;
        $productRecall->reference_record = implode(',', $request->reference_record);
        $productRecall->comments = $request->comments;

        $productRecall->franchise_store_manager = $request->franchise_store_manager;
        $productRecall->warehouse_manager = $request->warehouse_manager;
        $productRecall->ena_store_manager = $request->ena_store_manager;
        $productRecall->ab_store_manager = $request->ab_store_manager;

        if (!empty($request->Attachment)) {
            $files = [];
            if ($request->hasfile('Attachment')) {
                foreach ($request->file('Attachment') as $file) {
                    $name = "PR" . '-Attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $productRecall->Attachment = json_encode($files);
        }

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        $productRecall->status = 'Opened';
        $productRecall->stage = 1;
        $productRecall->save(); 

        /* Product Recall Audit Trail Code Starts */

            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Initiator';
            $history->previous = "Null";
            $history->current = Auth::user()->name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();

            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = "Null";
            $history->current = Carbon::now()->format('d-M-Y');
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();

        if (!empty ($request->product_name)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Product Name';
            $history->previous = "Null";
            $history->current = $productRecall->product_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->short_description)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $productRecall->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->assign_to)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Assign To';
            $history->previous = "Null";
            $history->current = $productRecall->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->due_date)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = $productRecall->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->recalled_from)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Recalled From';
            $history->previous = "Null";
            $history->current = $productRecall->recalled_from;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->priority_level)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Priority Level';
            $history->previous = "Null";
            $history->current = $productRecall->priority_level;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->recalled_by)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Recalled By';
            $history->previous = "Null";
            $history->current = $productRecall->recalled_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->contact_person)) {
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Contact Person';
            $history->previous = "Null";
            $history->current = $productRecall->contact_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->related_product)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Other Related Products';
            $history->previous = "Null";
            $history->current = $productRecall->related_product;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->recall_reason)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Reason For Recall';
            $history->previous = "Null";
            $history->current = $productRecall->recall_reason;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->schedule_start_date)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Scheduled Start Date';
            $history->previous = "Null";
            $history->current = $productRecall->schedule_start_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->schedule_end_date)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Scheduled End Date';
            $history->previous = "Null";
            $history->current = $productRecall->schedule_end_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (is_array($request->department_code) && $request->department_code[0] !== null){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Department Code';
            $history->previous = "Null";
            $history->current = $productRecall->department_code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (is_array($request->team_members) && $request->team_members[0] !== null){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Team Members';
            $history->previous = "Null";
            $history->current = $productRecall->team_members;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->bussiness_area)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Business Area';
            $history->previous = "Null";
            $history->current = $productRecall->bussiness_area;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->estimate_man_hours)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Estimated Man-Hours';
            $history->previous = "Null";
            $history->current = $productRecall->estimate_man_hours;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->related_url)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Related URLs';
            $history->previous = "Null";
            $history->current = $productRecall->related_url;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (is_array($request->reference_record) && $request->reference_record[0] !== null){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Related Records';
            $history->previous = "Null";
            $history->current = $productRecall->reference_record;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->comments)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $productRecall->comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        if (!empty ($request->product_name)){
            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $productRecall->id;
            $history->activity_type = 'Product Name';
            $history->previous = "Null";
            $history->current = $productRecall->product_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }

        /* Product Recall Audit Trail Code Ends */

        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function show(Request $request, $id){
    
        $old_record = ProductRecall::select('id', 'division_id', 'record')->get();
        $data = ProductRecall::find($id);
        $users = User::all();        
        $department = Department::all();
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        return view('frontend.product-recall.product-recall-view', compact('old_record', 'department', 'data', 'users'));
    }

    public function update(Request $request, $id){
       
        $productRecall = ProductRecall::find($id);
        $lastDocument = ProductRecall::find($id); 

        $productRecall->division_id = $request->division_id;
        $productRecall->intiation_date = $request->intiation_date;
        $productRecall->product_name = $request->product_name;
        $productRecall->short_description = $request->short_description;
        $productRecall->assign_to = $request->assign_to;
        $productRecall->recalled_from = $request->recalled_from;
        $productRecall->priority_level = $request->priority_level;
        $productRecall->recalled_by = $request->recalled_by;

        $productRecall->contact_person = $request->contact_person;
        $productRecall->related_product = $request->related_product;
        $productRecall->recall_reason = $request->recall_reason;
        $productRecall->schedule_start_date = $request->schedule_start_date;
        $productRecall->schedule_end_date = $request->schedule_end_date;
        $productRecall->department_code = implode(',', $request->department_code);
        $productRecall->team_members = implode(',', $request->team_members);

        $productRecall->bussiness_area = $request->bussiness_area;
        $productRecall->estimate_man_hours = $request->estimate_man_hours;
        $productRecall->related_urls = $request->related_urls;
        $productRecall->reference_record = implode(',', $request->reference_record);
        $productRecall->comments = $request->comments;

        $productRecall->franchise_store_manager = $request->franchise_store_manager;
        $productRecall->warehouse_manager = $request->warehouse_manager;
        $productRecall->ena_store_manager = $request->ena_store_manager;
        $productRecall->ab_store_manager = $request->ab_store_manager;

        if (!empty ($request->Attachment)) {
            $files = [];
            if ($productRecall->Attachment) {
                $files = is_array(json_decode($productRecall->Attachment)) ? $productRecall->Attachment : [];
            }
            if ($request->hasfile('Attachment')) {
                foreach ($request->file('Attachment') as $file) {
                    $name = "PR" . '-Attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $productRecall->Attachment = json_encode($files);
        }

        $productRecall->update();

        if ($lastDocument->product_name != $productRecall->product_name) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Product Name';
            $history->previous = $lastDocument->product_name;
            $history->current = $productRecall->product_name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->short_decription != $productRecall->short_decription) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Short Description';
            $history->previous = $lastDocument->short_decription;
            $history->current = $productRecall->short_decription;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->assign_to != $productRecall->assign_to) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Assign To';
            $history->previous = $lastDocument->assign_to;
            $history->current = $productRecall->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->recalled_from != $productRecall->recalled_from) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Recalled From';
            $history->previous = $lastDocument->recalled_from;
            $history->current = $productRecall->recalled_from;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->priority_level != $productRecall->priority_level) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Priority Level';
            $history->previous = $lastDocument->priority_level;
            $history->current = $productRecall->priority_level;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->recalled_by != $productRecall->recalled_by) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Recalled By';
            $history->previous = $lastDocument->recalled_by;
            $history->current = $productRecall->recalled_by;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->contact_person != $productRecall->contact_person) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Contact Person';
            $history->previous = $lastDocument->contact_person;
            $history->current = $productRecall->contact_person;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->related_product != $productRecall->related_product) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Other Related Products';
            $history->previous = $lastDocument->related_product;
            $history->current = $productRecall->related_product;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->recall_reason  != $productRecall->recall_reason) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Reason For Recall';
            $history->previous = $lastDocument->recall_reason;
            $history->current = $productRecall->recall_reason;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->scheduled_start_date != $productRecall->scheduled_start_date) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Scheduled Start Date';
            $history->previous = $lastDocument->scheduled_start_date;
            $history->current = $productRecall->scheduled_start_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->scheduled_end_date != $productRecall->scheduled_end_date) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Scheduled End Date';
            $history->previous = $lastDocument->scheduled_end_date;
            $history->current = $productRecall->scheduled_end_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->department_code != $productRecall->department_code) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Department Code';
            $history->previous = $lastDocument->department_code;
            $history->current = $productRecall->department_code;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->team_members != $productRecall->team_members) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Team Members';
            $history->previous = $lastDocument->team_members;
            $history->current = $productRecall->team_members;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->bussiness_area != $productRecall->bussiness_area) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Business Area';
            $history->previous = $lastDocument->bussiness_area;
            $history->current = $productRecall->bussiness_area;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->estimate_man_hours != $productRecall->estimate_man_hours) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Estimated Man-Hours';
            $history->previous = $lastDocument->estimate_man_hours;
            $history->current = $productRecall->estimate_man_hours;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->related_urls != $productRecall->related_urls) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Related URLs';
            $history->previous = $lastDocument->related_urls;
            $history->current = $productRecall->related_urls;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->reference_record != $productRecall->reference_record) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Related Records';
            $history->previous = $lastDocument->reference_record;
            $history->current = $productRecall->reference_record;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->comments != $productRecall->comments) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Comments';
            $history->previous = $lastDocument->comments;
            $history->current = $productRecall->comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->franchise_store_manager != $productRecall->franchise_store_manager) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Franchise Store Manager';
            $history->previous = $lastDocument->franchise_store_manager;
            $history->current = $productRecall->franchise_store_manager;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->warehouse_manager != $productRecall->warehouse_manager) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'Warehouse Manager';
            $history->previous = $lastDocument->warehouse_manager;
            $history->current = $productRecall->warehouse_manager;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->ena_store_manager != $productRecall->ena_store_manager) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'ENA Store Manager';
            $history->previous = $lastDocument->ena_store_manager;
            $history->current = $productRecall->ena_store_manager;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        if ($lastDocument->ab_store_manager != $productRecall->ab_store_manager) {
            $history = new ProductRecallAuditTrail;
            $history->product_recall_id = $id;
            $history->activity_type = 'AB Store Manager';
            $history->previous = $lastDocument->ab_store_manager;
            $history->current = $productRecall->ab_store_manager;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDocument->status;
            $history->action_name = "Update";
            $history->save();
        }

        toastr()->success('Record is Update Successfully');
        return back();
    }

    public function auditTrail(Request $request, $id){
        $audit = ProductRecallAuditTrail::where('product_recall_id', $id)->orderByDesc('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = ProductRecall::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.product-recall.audit-trail', compact('audit', 'document', 'today'));
    }

    public function auditTrailPdf(Request $request, $id){
        $doc = ProductRecall::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = ProductRecallAuditTrail::where('product_recall_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.product-recall.audit-trail-pdf', compact('data', 'doc'))
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

    public function singleReport(Request $request, $id){
        $data = ProductRecall::find($id);
        if (!empty ($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.product-recall.single-report', compact('data'))
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
            return $pdf->stream('Product-Recall' . $id . '.pdf');
        }
    }

    public function productRecallStage(Request $request, $id)
    {
        try {
            if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                $productRecall = ProductRecall::find($id);
                $lastDocument = ProductRecall::find($id);

                if ($productRecall->stage == 1) {

                    $productRecall->stage = "2";
                    $productRecall->status = "Pending Review";
                    $productRecall->submitted_by = Auth::user()->name;
                    $productRecall->submitted_on = Carbon::now()->format('d-M-Y');
                    $productRecall->submitted_comment = $request->comments;

                    $history = new ProductRecallAuditTrail();
                    $history->product_recall_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->action='Submit';
                    $history->current = $productRecall->submitted_by;
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Pending Review";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Proposed';
                    $history->save();


                    // $list = Helpers::getHodUserList();
                    // foreach ($list as $u) {
                    //     if ($u->q_m_s_divisions_id == $productRecall->division_id) {
                    //         $email = Helpers::getInitiatorEmail($u->user_id);
                    //         if ($email !== null) {

                    //             try {
                    //                 Mail::send(
                    //                     'mail.view-mail',
                    //                     ['data' => $productRecall],
                    //                     function ($message) use ($email) {
                    //                         $message->to($email)
                    //                             ->subject("Activity Performed By " . Auth::user()->name);
                    //                     }
                    //                 );
                    //             } catch (\Exception $e) {
                    //                 //log error
                    //             }
                    //         }
                    //     }
                    // }

                    // $list = Helpers::getHeadoperationsUserList();
                    // foreach ($list as $u) {
                    //     if ($u->q_m_s_divisions_id == $productRecall->division_id) {
                    //         $email = Helpers::getInitiatorEmail($u->user_id);
                    //         if ($email !== null) {

                    //             Mail::send(
                    //                 'mail.Categorymail',
                    //                 ['data' => $productRecall],
                    //                 function ($message) use ($email) {
                    //                     $message->to($email)
                    //                         ->subject("Activity Performed By " . Auth::user()->name);
                    //                 }
                    //             );
                    //         }
                    //     }
                    // }
                    // dd($productRecall);
                    $productRecall->update();
                    return back();
                }
                if ($productRecall->stage == 2) {

                    $productRecall->stage = "3";
                    $productRecall->status = "Memo Initiation In Progress";
                    $productRecall->pending_review_by = Auth::user()->name;
                    $productRecall->pending_review_on = Carbon::now()->format('d-M-Y');
                    $productRecall->pending_review_comment = $request->comments;

                    $history = new ProductRecallAuditTrail();
                    $history->product_recall_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->current = $productRecall->pending_review_by;
                    $history->comment = $request->comments;
                    $history->action= 'Acknowledge';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Memo Initiation In Progress";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Plan Approved';
                    $history->save();
                    // dd($history->action);
                    // $list = Helpers::getQAUserList();
                    // foreach ($list as $u) {
                    //     if ($u->q_m_s_divisions_id == $productRecall->division_id) {
                    //         $email = Helpers::getInitiatorEmail($u->user_id);
                    //         if ($email !== null) {
                    //             try {
                    //                 Mail::send(
                    //                     'mail.view-mail',
                    //                     ['data' => $productRecall],
                    //                     function ($message) use ($email) {
                    //                         $message->to($email)
                    //                             ->subject("Activity Performed By " . Auth::user()->name);
                    //                     }
                    //                 );
                    //             } catch (\Exception $e) {
                    //                 //log error
                    //             }
                    //         }
                    //     }
                    // }


                    $productRecall->update();
                    toastr()->success('Document Sent');
                    return back();
                }
                if ($productRecall->stage == 3) {

                    $productRecall->stage = "4";
                    $productRecall->status = "Notification In Progress";
                    $productRecall->memo_initiation_by = Auth::user()->name;
                    $productRecall->memo_initiation_on = Carbon::now()->format('d-M-Y');
                    $productRecall->memo_initiation_comment = $request->comments;

                    $history = new ProductRecallAuditTrail();
                    $history->product_recall_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->action= 'Memo Initiation Complete';
                    $history->current = $productRecall->memo_initiation_by;
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->change_to =   "Notification In Progress";
                    $history->change_from = $lastDocument->status;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = 'Completed';
                    $history->save();
                    // $list = Helpers::getQAUserList();
                    // foreach ($list as $u) {
                    //     if ($u->q_m_s_divisions_id == $productRecall->division_id) {
                    //         $email = Helpers::getInitiatorEmail($u->user_id);
                    //         if ($email !== null) {
                    //             try {
                    //                 Mail::send(
                    //                     'mail.view-mail',
                    //                     ['data' => $productRecall],
                    //                     function ($message) use ($email) {
                    //                         $message->to($email)
                    //                             ->subject("Activity Performed By " . Auth::user()->name);
                    //                     }
                    //                 );
                    //             } catch (\Exception $e) {
                    //                 //log error
                    //             }
                    //         }
                    //     }
                    // }

                    $productRecall->update();
                    toastr()->success('Document Sent');
                    return back();
                }
                if ($productRecall->stage == 4) {

                    $productRecall->stage = "5";
                    $productRecall->status = "Recall In Progress";
                    $productRecall->notification_by = Auth::user()->name;
                    $productRecall->notification_on = Carbon::now()->format('d-M-Y');
                    $productRecall->notification_comment = $request->comments;

                    $history = new ProductRecallAuditTrail();
                    $history->product_recall_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->action= 'Notification Complete';
                    $history->current = $productRecall->notification_by;
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->change_to =   "Recall In Progress";
                    $history->change_from = $lastDocument->status;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->stage = 'Completed';
                    $history->save();
                    // $list = Helpers::getQAUserList();
                    // foreach ($list as $u) {
                    //     if ($u->q_m_s_divisions_id == $productRecall->division_id) {
                    //         $email = Helpers::getInitiatorEmail($u->user_id);
                    //         if ($email !== null) {
                    //             try {
                    //                 Mail::send(
                    //                     'mail.view-mail',
                    //                     ['data' => $productRecall],
                    //                     function ($message) use ($email) {
                    //                         $message->to($email)
                    //                             ->subject("Activity Performed By " . Auth::user()->name);
                    //                     }
                    //                 );
                    //             } catch (\Exception $e) {
                    //                 //log error
                    //             }
                    //         }
                    //     }
                    // }

                    $productRecall->update();
                    toastr()->success('Document Sent');
                    return back();
                }

                if ($productRecall->stage == 5) {

                    $productRecall->stage = "6";
                    $productRecall->status = "Awaiting Feedback";
                    $productRecall->recall_inprogress_by = Auth::user()->name;
                    $productRecall->recall_inprogress_on = Carbon::now()->format('d-M-Y');
                    $productRecall->recall_inprogress_comment = $request->comments;

                    $history = new ProductRecallAuditTrail();
                    $history->product_recall_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->current = $productRecall->recall_inprogress_by;
                    $history->comment = $request->comments;
                    $history->action ='Third Party Involved';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Awaiting Feedback";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Approved';
                    $history->save();
                    // $list = Helpers::getQAUserList();
                    // foreach ($list as $u) {
                    //     if ($u->q_m_s_divisions_id == $productRecall->division_id) {
                    //         $email = Helpers::getInitiatorEmail($u->user_id);
                    //         if ($email !== null) {
                    //             try {
                    //                 Mail::send(
                    //                     'mail.view-mail',
                    //                     ['data' => $productRecall],
                    //                     function ($message) use ($email) {
                    //                         $message->to($email)
                    //                             ->subject("Activity Performed By " . Auth::user()->name);
                    //                     }
                    //                 );
                    //             } catch (\Exception $e) {
                    //                 //log error
                    //             }
                    //         }
                    //     }
                    // }
                    $productRecall->update();
                    toastr()->success('Document Sent');
                    return back();
                }
                if ($productRecall->stage == 6) {

                    $productRecall->stage = "7";
                    $productRecall->status = "Pending Final Approval";
                    $productRecall->awaiting_feedback_by = Auth::user()->name;
                    $productRecall->awaiting_feedback_on = Carbon::now()->format('d-M-Y');
                    $productRecall->awaiting_feedback_comment = $request->comments;

                    $history = new ProductRecallAuditTrail();
                    $history->product_recall_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->action ='Feedback Complete';
                    $history->current = $productRecall->awaiting_feedback_by;
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Pending Final Approval";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Completed';
                    $history->save();
                    // $list = Helpers::getQAUserList();
                    // foreach ($list as $u) {
                    //     if ($u->q_m_s_divisions_id == $productRecall->division_id) {
                    //         $email = Helpers::getInitiatorEmail($u->user_id);
                    //         if ($email !== null) {
                    //             try {
                    //                 Mail::send(
                    //                     'mail.view-mail',
                    //                     ['data' => $productRecall],
                    //                     function ($message) use ($email) {
                    //                         $message->to($email)
                    //                             ->subject("Activity Performed By " . Auth::user()->name);
                    //                     }
                    //                 );
                    //             } catch (\Exception $e) {
                    //                 //log error
                    //             }
                    //         }
                    //     }
                    // }
                    $productRecall->update();
                    toastr()->success('Document Sent');
                    return back();
                }
                if ($productRecall->stage == 7) {

                    $productRecall->stage = "8";
                    $productRecall->status = "Closed - Done";
                    $productRecall->pending_final_approval_by = Auth::user()->name;
                    $productRecall->pending_final_approval_on = Carbon::now()->format('d-M-Y');
                    $productRecall->pending_final_approval_comment = $request->comments;

                    $history = new ProductRecallAuditTrail();
                    $history->product_recall_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->action ='Final Approval';
                    $history->current = $productRecall->pending_initiator_approved_by;
                    $history->comment = $request->comments;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "Closed - Done";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Completed';
                    $history->save();
                    // $list = Helpers::getQAUserList();
                    // foreach ($list as $u) {
                    //     if ($u->q_m_s_divisions_id == $productRecall->division_id) {
                    //         $email = Helpers::getInitiatorEmail($u->user_id);
                    //         if ($email !== null) {
                    //             try {
                    //                 Mail::send(
                    //                     'mail.view-mail',
                    //                     ['data' => $productRecall],
                    //                     function ($message) use ($email) {
                    //                         $message->to($email)
                    //                             ->subject("Activity Performed By " . Auth::user()->name);
                    //                     }
                    //                 );
                    //             } catch (\Exception $e) {
                    //                 //log error
                    //             }
                    //         }
                    //     }
                    // }
                    $productRecall->update();
                    toastr()->success('Document Sent');
                    return back();
                }
            } else {
                toastr()->error('E-signature Not match');
                return back();
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function sendToInitiator(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $productRecall = ProductRecall::find($id);
            $lastDocument = ProductRecall::find($id);

            $productRecall->stage = "1";
            $productRecall->status = "Opened";
            $productRecall->send_to_initator_by = Auth::user()->name;
            $productRecall->send_to_initator_on = Carbon::now()->format('d-M-Y');
            $productRecall->send_to_initator_comment = $request->comments;

            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = "";
            $history->current = $productRecall->send_to_initator_by;
            $history->comment = $request->comments;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->stage = 'Initator';
            $history->change_to =   "Opened";
            $history->change_from = $lastDocument->status;
            $history->save();

            // $list = Helpers::getInitiatorUserList();
            // foreach ($list as $u) {
            //     if ($u->q_m_s_divisions_id == $productRecall->division_id) {
            //         $email = Helpers::getInitiatorEmail($u->user_id);
            //         if ($email !== null) {

            //             try {
            //                 Mail::send(
            //                     'mail.view-mail',
            //                     ['data' => $productRecall],
            //                     function ($message) use ($email) {
            //                         $message->to($email)
            //                             ->subject("Activity Performed By " . Auth::user()->name);
            //                     }
            //                 );
            //             } catch (\Exception $e) {
            //                 //log error
            //             }
            //         }
            //     }
            // }

            $productRecall->update();
            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function sendToRecallProgress(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $productRecall = ProductRecall::find($id);
            $lastDocument = ProductRecall::find($id);

            $productRecall->stage = "5";
            $productRecall->status = "Recall In Progress";
            $productRecall->send_to_initator_by = Auth::user()->name;
            $productRecall->send_to_initator_on = Carbon::now()->format('d-M-Y');
            $productRecall->send_to_initator_comment = $request->comments;

            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = "";
            $history->current = $productRecall->send_to_initator_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->stage = 'Recall In Progress';
            $history->change_to =   "Recall In Progress";
            $history->change_from = $lastDocument->status;
            $history->save();

            // $list = Helpers::getInitiatorUserList();
            // foreach ($list as $u) {
            //     if ($u->q_m_s_divisions_id == $productRecall->division_id) {
            //         $email = Helpers::getInitiatorEmail($u->user_id);
            //         if ($email !== null) {

            //             try {
            //                 Mail::send(
            //                     'mail.view-mail',
            //                     ['data' => $productRecall],
            //                     function ($message) use ($email) {
            //                         $message->to($email)
            //                             ->subject("Activity Performed By " . Auth::user()->name);
            //                     }
            //                 );
            //             } catch (\Exception $e) {
            //                 //log error
            //             }
            //         }
            //     }
            // }

            $productRecall->update();
            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function sendToCloseRejected(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $productRecall = ProductRecall::find($id);
            $lastDocument = ProductRecall::find($id);

            $productRecall->stage = "9";
            $productRecall->status = "Closed - Rejected";
            $productRecall->reject_recall_by = Auth::user()->name;
            $productRecall->reject_recall_on = Carbon::now()->format('d-M-Y');
            $productRecall->reject_recall_comment = $request->comments;

            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = "";
            $history->current = $productRecall->reject_recall_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->stage = 'Closed - Rejected';
            $history->change_to =   "Closed - Rejected";
            $history->change_from = $lastDocument->status;
            $history->save();

            // $list = Helpers::getInitiatorUserList();
            // foreach ($list as $u) {
            //     if ($u->q_m_s_divisions_id == $productRecall->division_id) {
            //         $email = Helpers::getInitiatorEmail($u->user_id);
            //         if ($email !== null) {

            //             try {
            //                 Mail::send(
            //                     'mail.view-mail',
            //                     ['data' => $productRecall],
            //                     function ($message) use ($email) {
            //                         $message->to($email)
            //                             ->subject("Activity Performed By " . Auth::user()->name);
            //                     }
            //                 );
            //             } catch (\Exception $e) {
            //                 //log error
            //             }
            //         }
            //     }
            // }

            $productRecall->update();
            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function recallCompleted(Request $request, $id){
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $productRecall = ProductRecall::find($id);
            $lastDocument = ProductRecall::find($id);

            $productRecall->stage = "7";
            $productRecall->status = "Pending Final Approval";
            $productRecall->recall_completed_by = Auth::user()->name;
            $productRecall->recall_completed_on = Carbon::now()->format('d-M-Y');
            $productRecall->recall_completed_comment = $request->comments;

            $history = new ProductRecallAuditTrail();
            $history->product_recall_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = "";
            $history->current = $productRecall->recall_completed_by;
            $history->comment = $request->comments;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $productRecall->status;
            $history->stage = 'Pending Final Approval';
            $history->change_to =   "Pending Final Approval";
            $history->change_from = $lastDocument->status;
            $history->save();

            // $list = Helpers::getInitiatorUserList();
            // foreach ($list as $u) {
            //     if ($u->q_m_s_divisions_id == $productRecall->division_id) {
            //         $email = Helpers::getInitiatorEmail($u->user_id);
            //         if ($email !== null) {

            //             try {
            //                 Mail::send(
            //                     'mail.view-mail',
            //                     ['data' => $productRecall],
            //                     function ($message) use ($email) {
            //                         $message->to($email)
            //                             ->subject("Activity Performed By " . Auth::user()->name);
            //                     }
            //                 );
            //             } catch (\Exception $e) {
            //                 //log error
            //             }
            //         }
            //     }
            // }

            $productRecall->update();
            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
}
