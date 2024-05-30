<?php

namespace App\Http\Controllers\demo;

use App\Http\Controllers\Controller;
use App\Models\Validation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Helpers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use App\Models\User;
use App\Models\RecordNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            $validation->intiation_date = $request->intiation_date;
            $validation->short_description = $request->input('short_description');
            $validation->assign_to = $request->input('assign_to');
            $validation->assign_due_date = $request->input('assign_due_date');
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




            if (!empty($request->items_attachment)) {
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


            $validation->deviation_occurred = json_encode($request->input('DeviationOccured'));
            $validation->test_name = json_encode($request->input('Test-Name'));
            $validation->test_number = json_encode($request->input('Test-Number'));
            $validation->test_method = json_encode($request->input('Test-Method'));
            $validation->test_result = json_encode($request->input('Test-Result'));
            $validation->test_accepted = json_encode($request->input('Test-Accepted'));
            $validation->remarks = json_encode($request->input('Remarks'));

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
            $validations->file_attechment = $request->input('file_attechment');


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

            $validations->deviation_occurred = json_encode($request->input('DeviationOccured'));
            $validations->test_name = json_encode($request->input('Test-Name'));
            $validations->test_number = json_encode($request->input('Test-Number'));
            $validations->test_method = json_encode($request->input('Test-Method'));
            $validations->test_result = json_encode($request->input('Test-Result'));
            $validations->test_accepted = json_encode($request->input('Test-Accepted'));
            $validations->remarks = json_encode($request->input('Remarks'));

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

            toastr()->success("Validation is Updated Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save validation: ' . $e->getMessage());
        }
    }



    function auditValidation($id)
    {
        $audit = Validation::where('initiator_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $today = Carbon::now()->format('d-m-y');
        $validation = Validation::where('id', $id)->first();
        // $document->doctype = DocumentType::where('id', $document->document_type_id)->value('typecode');
        // $document->division = Division::where('id', $document->division_id)->value('name');
        // $document->process = Process::where('id', $document->process_id)->value('process_name');
        // $validation->originator = User::where('id', $document->originator_id)->value('name');
        // $validation['year'] = Carbon::parse($document->created_at)->format('Y');
        // $validation['document_type_name'] = DocumentType::where('id', $document->document_type_id)->value('name');
        return view('frontend.new_forms.auditValidation', compact('audit', 'validation', 'today'));
    }

    public function validation_send_stage(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $validation = Validation::find($id);
            $lastDocument = Validation::find($id);
            if ($validation->stage == 1) {
                $validation->stage = "2";
                $validation->status = "Review";
                $validation->update();
                // $validation->submitted_by=Auth::user()->name;
                // $validation->submitted_on=Carbon::now()->format('d-M-Y');
                toastr()->success('Document Sent');
                return back();


                // $validation->submit_by = Auth::user()->name;
                //     $validation->submit_on = Carbon::now()->format('d-M-Y');
                //     $validation->submit_comment = $request->comment;
                //     $validation = new Validation();
                //     $validation->deviation_id = $id;
                //     $validation->activity_type = 'Activity Log';
                //     $validation->previous = "";
                //     $validation->current = $validation->submit_by;
                //     $validation->comment = $request->comment;
                //     $validation->user_id = Auth::user()->id;
                //     $validation->user_name = Auth::user()->name;
                //     // $validation->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                //     $validation->origin_state = $lastDocument->status;
                //     $validation->stage = 'Plan Proposed';
                //     $validation->save();

                //     $list = Helpers::getHodUserList();
                //     foreach ($list as $u) {
                //         if ($u->q_m_s_divisions_id == $validation->division_id) {
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //             if ($email !== null) {

                //                 Mail::send(
                //                     'mail.view-mail',
                //                     ['data' => $validation],
                //                     function ($message) use ($email) {
                //                         $message->to($email)
                //                             ->subject("Document is Submitted By " . Auth::user()->name);
                //                     }
                //                 );
                //             }
                //         }
                //     }


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
                $validation->stage = "5";
                $validation->status = "Deviation in Progress";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            // if($validation->training_required =="yes"){
            if ($validation->stage == 5) {
                $validation->stage = "6";
                $validation->status = "Pending Completion";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            // }
            // else{
            //     if($validation->stage == 5){
            //         $validation->stage = "7";
            //         $validation->status = "Pending Approval";
            //         $validation->update();
            //         toastr()->success('Document Sent');
            //         return back();
            //     }


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
                $validation->status = "Closed – Done";
                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
}
