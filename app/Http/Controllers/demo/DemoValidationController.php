<?php

namespace App\Http\Controllers\demo;

use App\Http\Controllers\Controller;
use App\Models\Validation;
use App\Models\ValidationAudit;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\RoleGroup;
use App\Models\User;

use App\Models\RecordNumber;


class DemoValidationController extends Controller
{
    public function validationIndex()
    {
        $old_record = Validation::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.New_forms.validation', compact('old_record', 'record_number', 'currentDate', 'formattedDate', 'due_date'));
    }
    public function store(Request $request)
    {
       

        $request->validate([
            'file_attachment.*' => 'required|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        try {
            $recordCounter = RecordNumber::first();
            $newRecordNumber = $recordCounter->counter + 1;

            $recordCounter->counter = $newRecordNumber;
            $recordCounter->save();


            $validation = new Validation();

            // General Information
            $validation->stage = '1';
            $validation->status = 'Opened';
            $validation->parent_id = $request->parent_id;
            $validation->parent_type = $request->parent_type;
            $validation->record = $newRecordNumber;
            $validation->initiator_id = Auth::user()->id;
            $validation->user_name = Auth::user()->name;
            $validation->intiation_date = $request->intiation_date;
            $validation->short_description = $request->input('short_description');
            $validation->assign_to = $request->input('assign_to');
            $validation->assign_due_date = $request->assign_due_date;
            $validation->validation_type = $request->input('validation_type');
            $validation->validation_due_date = $request->input('validation_due_date');
            $validation->notify_type = $request->input('notify_type');
            $validation->phase_type = $request->input('phase_type');
            // $validation->record = $request->input('record');
            $validation->document_reason_type = $request->input('document_reason_type');
            $validation->purpose = $request->input('purpose');
            $validation->validation_category = $request->input('validation_category');
            $validation->validation_sub_category = $request->input('validation_sub_category');
            // $validation->file_attechment = $request->input('file_attechment');
            $validation->related_record = $request->input('related_record');
            $validation->document_link = $request->input('document_link');

            if (!empty($request->file_attechment)) {
                $files = [];
                if ($request->hasfile('file_attechment')) {
                    foreach ($request->file('file_attechment') as $file) {
                        $name = $request->name . 'file_attechment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $validation->file_attechment = json_encode($files);
            }


            // if (!empty($request->file_attechment)) {
            //     $files = [];
            //     if ($request->hasfile('file_attechment')) {
            //         foreach ($request->file('file_attechment') as $file) {
            //             $name = $request->name . 'file_attechment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            //             $file->move('upload/', $name);
            //             $files[] = $name;
            //         }
            //     }
            //     $validation->file_attechment = json_encode($files);
            // }

            // Tests Required Section
            $validation->tests_required = $request->input('tests_required');
            $validation->reference_document = $request->input('reference_document');
            $validation->reference_link = $request->input('reference_link');
            $validation->additional_references = $request->input('additional_references');

            // Affected Items Section
            $affectedItems = [
                'equipment' => $request->input('equipment'),
                'items' => $request->input('items'),
                'facilities' => $request->input('facilities')
            ];
            $validation->affected_items = json_encode($affectedItems);


            if (!empty($request->items_attachment)) {
                $files = [];
                if ($request->hasfile('items_attachment')) {
                    foreach ($request->file('items_attachment') as $file) {
                        $name = $request->name . 'items_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $validation->items_attachment = json_encode($files);
            }

            $equipmentNameCode = $request->input('equipment_name_code');
            $validation->equipment_name_code = is_array($equipmentNameCode) ? implode(', ', $equipmentNameCode) : $equipmentNameCode;

            $equipmentId = $request->input('equipment_id');
            $validation->equipment_id = is_array($equipmentId) ? implode(', ', $equipmentId) : $equipmentId;

            $assetNo = $request->input('asset_no');
            $validation->asset_no = is_array($assetNo) ? implode(', ', $assetNo) : $assetNo;

            $remarks = $request->input('remarks');
            $validation->remarks = is_array($remarks) ? implode(', ', $remarks) : $remarks;

            // Handle Affected Items
            $itemType = $request->input('item_type');
            $validation->item_type = is_array($itemType) ? implode(', ', $itemType) : $itemType;

            $itemName = $request->input('item_name');
            $validation->item_name = is_array($itemName) ? implode(', ', $itemName) : $itemName;

            $itemNo = $request->input('item_no');
            $validation->item_no = is_array($itemNo) ? implode(', ', $itemNo) : $itemNo;

            // Handle Affected Facilities
            $facilityLocation = $request->input('facility_location');
            $validation->facility_location = is_array($facilityLocation) ? implode(', ', $facilityLocation) : $facilityLocation;

            $facilityType = $request->input('facility_type');
            $validation->facility_type = is_array($facilityType) ? implode(', ', $facilityType) : $facilityType;

            $facilityName = $request->input('facility_name');
            $validation->facility_name = is_array($facilityName) ? implode(', ', $facilityName) : $facilityName;


            // Document Decision
            $validation->data_successfully_closed = $request->input('data_successfully_closed');
            $validation->document_summary = $request->input('document_summary');
            $validation->document_comments = $request->input('document_comments');



            // Test Information
            $validation->test_required = $request->input('test_required');
            $validation->test_start_date = $request->input('test_start_date');
            $validation->test_end_date = $request->input('test_end_date');
            $validation->test_responsible = $request->input('test_responsible');




            if (!empty($request->result_attachment)) {
                $files = [];
                if ($request->hasfile('result_attachment')) {
                    foreach ($request->file('result_attachment') as $file) {
                        $name = $request->name . 'result_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $validation->result_attachment = json_encode($files);
            }


            $validation->deviation_occurred = json_encode($request->input('deviation_Occured'));
            $validation->test_name = json_encode($request->input('test_name'));
            $validation->test_number = json_encode($request->input('test_number'));
            $validation->test_method = json_encode($request->input('test_method'));
            $validation->test_result = json_encode($request->input('test_result'));
            $validation->test_accepted = json_encode($request->input('test_accepted'));
            $validation->remarks = json_encode($request->input('remarks'));

            // Summary of Results
            $summaryOfResults = $request->input('summary_of_results');
            $validation->summary_of_results = json_encode($summaryOfResults);

            $validation->test_actions_comments = $request->input('test_actions_comments');

            // Record Type History
            $recordHistory = [
                'submitted_protocol' => [
                    'by' => $request->input('submitted_protocol_by'),
                    'on' => $request->input('submitted_protocol_on')
                ],
                'cancelled' => [
                    'by' => $request->input('cancelled_by'),
                    'on' => $request->input('cancelled_on')
                ],
                'review' => [
                    'by' => $request->input('review_by'),
                    'on' => $request->input('review_on')
                ],
                'final_approval_1' => [
                    'by' => $request->input('final_approval_1_by'),
                    'on' => $request->input('final_approval_1_on')
                ],
                'final_approval_2' => [
                    'by' => $request->input('final_approval_2_by'),
                    'on' => $request->input('final_approval_2_on')
                ],
                'report_reject' => [
                    'by' => $request->input('report_reject_by'),
                    'on' => $request->input('report_reject_on')
                ],
                'obsolete' => [
                    'by' => $request->input('obsolete_by'),
                    'on' => $request->input('obsolete_on')
                ]
            ];
            $validation->record_history = json_encode($recordHistory);

            $validation->save();

            if (!empty($request->short_description)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->previous = "Null";
                $validation2->current = $request->short_description;
                $validation2->activity_type = 'Short Description';
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                
                // dd($validation2->validation_id);
                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->comment = "Not Applicable";
                $validation2->save();
            }

            if (!empty($request->intiation_date)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Intiation Date';
                $validation2->previous = "Null";
                $validation2->current = $request->intiation_date;
                $validation2->comment = "Not Applicable";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->assign_to)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Assign To';
                $validation2->previous = "Null";
                $validation2->current = $request->assign_to;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->assign_due_date)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = ' Assign Due Date';
                $validation2->previous = "Null";
                $validation2->current = $request->assign_due_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->validation_type)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Validation Type';
                $validation2->previous = "Null";
                $validation2->current = $request->validation_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->validation_due_date)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Validation Due Date';
                $validation2->previous = "Null";
                $validation2->current = $request->validation_due_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->notify_type)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Notify Type';
                $validation2->previous = "Null";
                $validation2->current = $request->notify_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->phase_type)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Phase Type';
                $validation2->previous = "Null";
                $validation2->current = $request->phase_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->document_reason_type)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Document Reason';
                $validation2->previous = "Null";
                $validation2->current = $request->document_reason_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            if (!empty($request->purpose)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Purpose';
                $validation2->previous = "Null";
                $validation2->current = $request->purpose;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->validation_category)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Validation Category';
                $validation2->previous = "Null";
                $validation2->current = $request->validation_category;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->validation_sub_category)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Validation Sub Category';
                $validation2->previous = "Null";
                $validation2->current = $request->validation_sub_category;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->file_attechment)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Download Templates';
                $validation2->previous = "Null";
                $validation2->current = $request->file_attechment;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->related_record)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Related Records';
                $validation2->previous = "Null";
                $validation2->current = $request->related_record;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->document_link)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Document Link';
                $validation2->previous = "Null";
                $validation2->current = $request->document_link;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->tests_required)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Tests Required';
                $validation2->previous = "Null";
                $validation2->current = $request->tests_required;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->reference_document)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Refrence Document';
                $validation2->previous = "Null";
                $validation2->current = $request->reference_document;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            if (!empty($request->reference_link)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Refrence Link';
                $validation2->previous = "Null";
                $validation2->current = $request->reference_link;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            toastr()->success("Validation is created Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save validation: ' . $e->getMessage());
        }
    }



    public function validationEdit($id)
    {
        $validation = Validation::findOrFail($id);
        return view('frontend.new_forms.updateValidation', compact('validation'));
    }

    public function validationUpdate(Request $request, $id)
    {
        if (!$request->short_description) {
            toastr()->info("Short Description is required");
            return redirect()->back()->withInput();
        }
        try {
            $recordCounter = RecordNumber::first();
            $newRecordNumber = $recordCounter->counter + 1;

            $recordCounter->counter = $newRecordNumber;
            $recordCounter->save();

            $validations =  Validation::findOrFail($id);
            // General Information
            // $validation->parent_id = $request->input('parent_id');
            // $validation->parent_type = $request->input('parent_type');
            // $validations->initiator_id = Auth::user()->id;
            $validations->intiation_date = $request->intiation_date;
            $validations->short_description = $request->input('short_description');
            $validations->assign_to = $request->input('assign_to');
            $validations->assign_due_date = $request->input('assign_due_date');
            $validations->validation_type = $request->input('validation_type');
            $validations->validation_due_date = $request->input('validation_due_date');
            $validations->notify_type = $request->input('notify_type');
            $validations->phase_type = $request->input('phase_type');
            $validations->document_reason_type = $request->input('document_reason_type');
            $validations->purpose = $request->input('purpose');
            $validations->validation_category = $request->input('validation_category');
            $validations->validation_sub_category = $request->input('validation_sub_category');
            // $validation->file_attechment = $request->input('file_attechment');
            $validations->related_record = $request->input('related_record');
            $validations->document_link = $request->input('document_link');
            $validations->file_attechment = $request->file_attechment;


            //file attachment
            if (!empty($request->file_attechment)) {
                $files = [];
                if ($request->hasfile('file_attechment')) {
                    foreach ($request->file('file_attechment') as $file) {
                        $name = $request->name . 'file_attechment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $validations->file_attechment = json_encode($files);
            }

            // Tests Required Section
            $validations->tests_required = $request->input('tests_required');
            $validations->reference_document = $request->input('reference_document');
            $validations->reference_link = $request->input('reference_link');
            $validations->additional_references = $request->input('additional_references');

            // Affected Items Section
            $affectedItems = [
                'equipment' => $request->input('equipment'),
                'items' => $request->input('items'),
                'facilities' => $request->input('facilities')
            ];
            $validations->affected_items = json_encode($affectedItems);

            // Attachments
            if (!empty($request->items_attachment)) {
                $files = [];
                if ($request->hasfile('items_attachment')) {
                    foreach ($request->file('items_attachment') as $file) {
                        $name = $request->name . 'items_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $validations->items_attachment = json_encode($files);
            }

            $validations->additional_attachment_items = $request->input('additional_attachment_items');


            $equipmentNameCode = $request->input('equipment_name_code');
            $validations->equipment_name_code = is_array($equipmentNameCode) ? implode(', ', $equipmentNameCode) : $equipmentNameCode;

            $equipmentId = $request->input('equipment_id');
            $validations->equipment_id = is_array($equipmentId) ? implode(', ', $equipmentId) : $equipmentId;

            $assetNo = $request->input('asset_no');
            $validations->asset_no = is_array($assetNo) ? implode(', ', $assetNo) : $assetNo;

            $remarks = $request->input('remarks');
            $validations->remarks = is_array($remarks) ? implode(', ', $remarks) : $remarks;

            // Handle Affected Items
            $itemType = $request->input('item_type');
            $validations->item_type = is_array($itemType) ? implode(', ', $itemType) : $itemType;

            $itemName = $request->input('item_name');
            $validations->item_name = is_array($itemName) ? implode(', ', $itemName) : $itemName;

            $itemNo = $request->input('item_no');
            $validations->item_no = is_array($itemNo) ? implode(', ', $itemNo) : $itemNo;

            // Handle Affected Facilities
            $facilityLocation = $request->input('facility_location');
            $validations->facility_location = is_array($facilityLocation) ? implode(', ', $facilityLocation) : $facilityLocation;

            $facilityType = $request->input('facility_type');
            $validations->facility_type = is_array($facilityType) ? implode(', ', $facilityType) : $facilityType;

            $facilityName = $request->input('facility_name');
            $validations->facility_name = is_array($facilityName) ? implode(', ', $facilityName) : $facilityName;


            // Document Decision
            $validations->data_successfully_closed = $request->input('data_successfully_closed');
            $validations->document_summary = $request->input('document_summary');
            $validations->document_comments = $request->input('document_comments');

            // Test Information
            $validations->test_required = $request->input('test_required');
            $validations->test_start_date = $request->input('test_start_date');
            $validations->test_end_date = $request->input('test_end_date');
            $validations->test_responsible = $request->input('test_responsible');

            // Test Results Attachment
            if (!empty($request->items_attachment)) {
                $files = [];
                if ($request->hasfile('result_attachment')) {
                    foreach ($request->file('result_attachment') as $file) {
                        $name = $request->name . 'result_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $validations->result_attachment = json_encode($files);
            }

            $deviationOccurred = $request->input('deviation_occurred');
            $validations->deviation_occurred = is_array($deviationOccurred) ? implode(', ', $deviationOccurred) : $deviationOccurred;

            $testName = $request->input('test_name');
            $validations->test_name = is_array($testName) ? implode(', ', $testName) : $testName;

            $testNumber = $request->input('test_number');
            $validations->test_number = is_array($testNumber) ? implode(', ', $testNumber) : $testNumber;

            $testMethod = $request->input('test_method');
            $validations->test_method = is_array($testMethod) ? implode(', ', $testMethod) : $testMethod;

            $testResult = $request->input('test_result');
            $validations->test_result = is_array($testResult) ? implode(', ', $testResult) : $testResult;

            $testAccepted = $request->input('test_accepted');
            $validations->test_accepted = is_array($testAccepted) ? implode(', ', $testAccepted) : $testAccepted;

            $remarks = $request->input('remarks');
            $validations->remarks = is_array($remarks) ? implode(', ', $remarks) : $remarks;
            // $validations->deviation_occurred = json_encode($request->input('deviation_occurred'));
            // $validations->test_name = json_encode($request->input('test_name'));
            // $validations->test_number = json_encode($request->input('test_number'));
            // $validations->test_method = json_encode($request->input('test_method'));
            // $validations->test_result = json_encode($request->input('test_result'));
            // $validations->test_accepted = json_encode($request->input('test_accepted'));
            // $validations->remarks = json_encode($request->input('remarks'));

            // Summary of Results
            $summaryOfResults = $request->input('summary_of_results');
            $validations->summary_of_results = json_encode($summaryOfResults);

            $validations->test_actions_comments = $request->input('test_actions_comments');

            // Record Type History
            $recordHistory = [
                'submitted_protocol' => [
                    'by' => $request->input('submitted_protocol_by'),
                    'on' => $request->input('submitted_protocol_on')
                ],
                'cancelled' => [
                    'by' => $request->input('cancelled_by'),
                    'on' => $request->input('cancelled_on')
                ],
                'review' => [
                    'by' => $request->input('review_by'),
                    'on' => $request->input('review_on')
                ],
                'final_approval_1' => [
                    'by' => $request->input('final_approval_1_by'),
                    'on' => $request->input('final_approval_1_on')
                ],
                'final_approval_2' => [
                    'by' => $request->input('final_approval_2_by'),
                    'on' => $request->input('final_approval_2_on')
                ],
                'report_reject' => [
                    'by' => $request->input('report_reject_by'),
                    'on' => $request->input('report_reject_on')
                ],
                'obsolete' => [
                    'by' => $request->input('obsolete_by'),
                    'on' => $request->input('obsolete_on')
                ]
            ];
            $validations->record_history = json_encode($recordHistory);

            $validations->update();


            if (!empty($request->short_description)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->previous = "Null";
                $validation2->current = $request->short_description;
                $validation2->activity_type = 'Short Description';
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->comment = "Not Applicable";
                $validation2->save();
            }

            if (!empty($request->intiation_date)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Intiation Date';
                $validation2->previous = "Null";
                $validation2->current = $request->intiation_date;
                $validation2->comment = "Not Applicable";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if (!empty($request->assign_to)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Assign To';
                $validation2->previous = "Null";
                $validation2->current = $request->assign_to;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if (!empty($request->assign_due_date)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = ' Assign Due Date';
                $validation2->previous = "Null";
                $validation2->current = $request->assign_due_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';

                $validation2->save();
            }

            if (!empty($request->validation_type)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Validation Type';
                $validation2->previous = "Null";
                $validation2->current = $request->validation_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';

                $validation2->save();
            }

            if (!empty($request->validation_due_date)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Validation Due Date';
                $validation2->previous = "Null";
                $validation2->current = $request->validation_due_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';

                $validation2->save();
            }

            if (!empty($request->notify_type)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Notify Type';
                $validation2->previous = "Null";
                $validation2->current = $request->notify_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if (!empty($request->phase_type)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Phase Level';
                $validation2->previous = "Null";
                $validation2->current = $request->phase_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if (!empty($request->document_reason_type)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Document Reason';
                $validation2->previous = "Null";
                $validation2->current = $request->document_reason_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }


            if (!empty($request->purpose)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Purpose';
                $validation2->previous = "Null";
                $validation2->current = $request->purpose;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if (!empty($request->validation_category)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Validation Category';
                $validation2->previous = "Null";
                $validation2->current = $request->validation_category;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if (!empty($request->validation_sub_category)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Validation Sub Category';
                $validation2->previous = "Null";
                $validation2->current = $request->validation_sub_category;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if (!empty($request->file_attechment)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Download Templates';
                $validation2->previous = "Null";
                $validation2->current = $request->file_attechment;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if (!empty($request->related_record)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Related Records';
                $validation2->previous = "Null";
                $validation2->current = $request->related_record;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if (!empty($request->document_link)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Document Link';
                $validation2->previous = "Null";
                $validation2->current = $request->document_link;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if (!empty($request->tests_required)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Tests Required';
                $validation2->previous = "Null";
                $validation2->current = $request->tests_required;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            if (!empty($request->reference_document)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Refrence Document';
                $validation2->previous = "Null";
                $validation2->current = $request->reference_document;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }


            if (!empty($request->reference_link)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Refrence Link';
                $validation2->previous = "Null";
                $validation2->current = $request->reference_link;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                // $validation2->change_to =   "Opened";
                // $validation2->change_from = "Initiator";
                $validation2->action_name = 'Update';
                $validation2->save();
            }

            toastr()->success("Validation is Updated Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save validation: ' . $e->getMessage());
        }
    }



    function auditValidation($id)
    {
        $audit = ValidationAudit::where('validation_id', $id)->orderByDESC('id')->paginate(30);
        // dd($audit);
        $today = Carbon::now()->format('d-m-y');
        $validation = Validation::where('id', $id)->first();

        $validation->initiator = User::where('id', $validation->initiator_id)->value('name');
        return view('frontend.new_forms.auditValidation', compact('audit', 'validation', 'today'));
    }

    public function validation_send_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $validation = Validation::find($id);
            $lastDocument = Validation::find($id);

            if (!$validation) {
                toastr()->error('Validation not found');
                return back();
            }

            if ($validation->stage == 1) {
                $validation->stage = "2";
                $validation->status = "Review";
                $validation->submitted_by = Auth::user()->name;
                $validation->submitted_on = Carbon::now()->format('d-M-Y');
                // $validation->submit_comment = $request->comment;
                // $validation = new ValidationAudit();
                // $validation->validation_id = $id;
                // $validation->activity_type = 'Activity Log';
                // $validation->previous = "";
                // $validation->current = $validation->submit_by;
                // $validation->comment = $request->comment;
                // $validation->user_id = Auth::user()->id;
                // $validation->user_name = Auth::user()->name;
                // $validation->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                // // $validation->origin_state = $lastDocument->status;
                // $validation->stage = 'Plan Proposed';
                // $validation->save();

                // $list = Helpers::getHodUserList();
                // foreach ($list as $u) {
                    // if ($u->q_m_s_divisions_id == $validation->division_id) {
                    //     $email = Helpers::getInitiatorEmail($u->user_id);
                    //     if ($email !== null) {

                    //         Mail::send(
                    //             'mail.view-mail',
                    //             ['data' => $validation],
                    //             function ($message) use ($email) {
                    //                 $message->to($email)
                    //                     ->subject("Document is Submitted By " . Auth::user()->name);
                    //             }
                    //         );
                    //     }
                    // }
                // }

                $validation->update();
                // $validation->submitted_by = Auth::user()->name;
                // $validation->submitted_on = Carbon::now()->format('d-M-Y');
                // $validation->submit_comment = $request->comment;
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 2) {
                $validation->stage = "3";
                $validation->status = "Protocol Approval";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 3) {
                $validation->stage = "4";
                $validation->status = "Test in Progress";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 4) {
                if ($validation->test_required == "yes") {
                    $validation->stage = "5";
                    $validation->status = "Deviation in Progress";
                    $validation->update();
                    toastr()->success('Document Sent');
                    return back();
                } else {
                    $validation->stage = "6";
                    $validation->status = "Pending Completion";
                    $validation->update();
                    toastr()->success('Document Sent');
                    return back();
                }
            }

            if ($validation->stage == 5) {
                $validation->stage = "6";
                $validation->status = "Pending Completion";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 6) {
                $validation->stage = "7";
                $validation->status = "Pending Approval";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 7) {
                $validation->stage = "8";
                $validation->status = "Active Document";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 8) {
                $validation->stage = "9";
                $validation->status = "Closed - Done";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function validationCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $validation = Validation::find($id);



            if ($validation->stage == 2) {
                $validation->stage = "1";
                $validation->status = "Opened";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }



            if ($validation->stage == 3) {
                $validation->stage = "1";
                $validation->status = "Opened";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($validation->stage == 4) {
                $validation->stage = "3";
                $validation->status = "Protocol Approval";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($validation->stage == 5) {
                $validation->stage = "4";
                $validation->status = "Test in Progress";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($validation->stage == 6) {
                $validation->stage = "5";
                $validation->status = "Deviation in Progress";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($validation->stage == 7) {
                $validation->stage = "6";
                $validation->status = "Pending Completion";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 7) {
                $validation->stage = "9";
                $validation->status = "Closed – Done";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($validation->stage == 8) {
                $validation->stage = "7";
                $validation->status = "Pending Approval";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($validation->stage == 9) {
                $validation->stage = "8";
                $validation->status = "Active Document";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }
            toastr()->error('States not Defined');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function singleReport($id)
    {
        $data = Validation::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
    
            $doc = ValidationAudit::where('validation_id', $data->id)->first();
            $detail_data = ValidationAudit::where('activity_type', $data->activity_type)
                                          ->where('validation_id', $data->validation_id)
                                          ->latest()
                                          ->get();
    
            // pdf related work
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.New_forms.singleValidationReport', compact(
                'detail_data',
                'doc',
                'data'
            ))
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
    
            // Ensure that the text parameter is a string
            $text = 'Sample Watermark';  // Replace with actual text if needed
            // Ensure the color is an array of three integers
            $color = [0, 0, 0];  // RGB color array
    
            $canvas->page_text(
                $width / 4,
                $height / 2,
                $text,
                null, // Font
                25,   // Font size
                $color, // Color array
                2, // Word spacing
                6, // Character spacing
                -20 // Angle
            );
    
            return $pdf->stream('SOP' . $id . '.pdf');
        }
    
        // Handle the case where the $data is empty or not found
        return redirect()->back()->with('error', 'Validation not found.');
    }
    
    


    public function ValidationAuditTrialDetails($id) {
    
        $detail = ValidationAudit::find($id);
        $detail_data = ValidationAudit::where('activity_type', $detail->activity_type)->where('validation_id', $detail->validation_id)->latest()->get();
        $doc = ValidationAudit::where('id', $detail->validation_id)->first();
        $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.New_forms.auditDetails_validation', compact('detail', 'doc', 'detail_data'));
    }

}