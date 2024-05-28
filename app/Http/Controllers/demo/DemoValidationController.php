<?php

namespace App\Http\Controllers\demo;

use App\Http\Controllers\Controller;
use App\Models\DemoValidation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\RecordNumber;
use Illuminate\Support\Facades\Auth;

class DemoValidationController extends Controller
{
    public function validationIndex(){
        $old_record = DemoValidation::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.New_forms.validation', compact('old_record','record_number','currentDate','formattedDate','due_date'));
       }
    public function store(Request $request)
{
    // dd($request);
    $validation = new DemoValidation();

    // General Information
    $validation->parent_id = $request->input('parent_id');
    $validation->parent_type = $request->input('parent_type');
    $validation->record = ((RecordNumber::first()->value('counter')) + 1);
    $validation->initiator_id = Auth::user()->id;
    $validation->initiation_date = $request->input('initiation_date');
    $validation->short_description = $request->input('short_description');
    $validation->assign_to= $request->input('assign_to');
    $validation->assign_due_date= $request->input('assign_due_date');
    $validation->validation_type= $request->input('validation_type');
    $validation->validation_due_date = $request->input('validation_due_date');
    $validation->notify_type = $request->input('notify_type');
    $validation->phase_type = $request->input('phase_type');
    // $validation->record = $request->input('record');
    $validation->document_reason_type =$request->input('document_reason_type');
    $validation->purpose = $request->input('purpose');
    $validation->validation_category = $request->input('validation_category');
    $validation->validation_sub_category = $request->input('validation_sub_category');
    // $validation->file_attechment = $request->input('file_attechment');
    $validation->related_record = $request->input('related_record');
    $validation->document_link = $request->input('document_link');
    $validation->file_attechment = $request->input('file_attechment');

    //file attachment
    if ($request->hasFile('file_attechment')) {
        $fileAttechmentPaths = [];
        foreach ($request->file('file_attechment') as $file) {
            $path = $file->store('attachments', 'public');
            $fileAttechmentPaths[] = $path;
        }
        $validation->file_attechment = json_encode($fileAttechmentPaths);
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

    // Attachments
    if ($request->hasFile('items_attachment')) {
        $itemsAttachmentPaths = [];
        foreach ($request->file('items_attachment') as $file) {
            $path = $file->store('attachments', 'public');
            $itemsAttachmentPaths[] = $path;
        }
        $validation->items_attachment = json_encode($itemsAttachmentPaths);
    }

    $validation->additional_attachment_items = $request->input('additional_attachment_items');


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

    // Test Results Attachment
    if ($request->hasFile('result_attachment')) {
        $resultAttachmentPaths = [];
        foreach ($request->file('result_attachment') as $file) {
            $path = $file->store('attachments', 'public');
            $resultAttachmentPaths[] = $path;
        }
        $validation->result_attachment = json_encode($resultAttachmentPaths);
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

    // return redirect()->back()->with('success', 'Validation saved successfully.');
    toastr()->success("Validation is created Successfully");
    return redirect(url('rcms/qms-dashboard'));
}

public function edit($id) {
    $data       = DemoValidation::findOrFail($id);
    $data->id = Auth::user()->id;
    return view('frontend.New_forms.updateValidation', compact('data'));
}

public function validationUpdate(Request $request, $id){
    if (!$request->short_description) {
        toastr()->info("Short Description is required");
        return redirect()->back()->withInput();
    }

    $validations =  DemoValidation::findOrFail($id);
      // General Information
    // $validation->parent_id = $request->input('parent_id');
    // $validation->parent_type = $request->input('parent_type');
    // $validations->initiator_id = Auth::user()->id;
    $validations->initiation_date = $request->input('initiation_date');
    $validations->short_description = $request->input('short_description');
    $validations->assign_to= $request->input('assign_to');
    $validations->assign_due_date= $request->input('assign_due_date');
    $validations->validation_type= $request->input('validation_type');
    $validations->validation_due_date = $request->input('validation_due_date');
    $validations->notify_type = $request->input('notify_type');
    $validations->phase_type = $request->input('phase_type');
    $validations->document_reason_type =$request->input('document_reason_type');
    $validations->purpose = $request->input('purpose');
    $validations->validation_category = $request->input('validation_category');
    $validations->validation_sub_category = $request->input('validation_sub_category');
    // $validation->file_attechment = $request->input('file_attechment');
    $validations->related_record = $request->input('related_record');
    $validations->document_link = $request->input('document_link');
    $validations->file_attechment = $request->input('file_attechment');

    //file attachment
    if ($request->hasFile('file_attechment')) {
        $fileAttechmentPaths = [];
        foreach ($request->file('file_attechment') as $file) {
            $path = $file->store('attachments', 'public');
            $fileAttechmentPaths[] = $path;
        }
        $validations->file_attechment = json_encode($fileAttechmentPaths);
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
    if ($request->hasFile('items_attachment')) {
        $itemsAttachmentPaths = [];
        foreach ($request->file('items_attachment') as $file) {
            $path = $file->store('attachments', 'public');
            $itemsAttachmentPaths[] = $path;
        }
        $validations->items_attachment = json_encode($itemsAttachmentPaths);
    }

    $validations->additional_attachment_items = $request->input('additional_attachment_items');

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
    if ($request->hasFile('result_attachment')) {
        $resultAttachmentPaths = [];
        foreach ($request->file('result_attachment') as $file) {
            $path = $file->store('attachments', 'public');
            $resultAttachmentPaths[] = $path;
        }
        $validations->result_attachment = json_encode($resultAttachmentPaths);
    }

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
    return redirect()->back()->with('success', 'Record Updated Succesfully' );

  }


 
  public function validationEdit($id)
  {
      $validation = DemoValidation::findOrFail($id);
      return view('frontend.new_forms.updateValidation', compact('validation'));
  }
// public function show($id)
// {
// $data = DemoValidation::find($id);
// $old_record = DemoValidation::select('id', 'id')->get();
// // $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
// $data->assign_to_name = User::where('id', $data->assign_to)->value('name');
// $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
// // $validationEffectAnalysis = DemoValidation::where('validation_id',$id)->where('type',"effect_analysis")->first();
// // $fishbone = DemoValidation::where('validation_id',$id)->where('type',"fishbone")->first();
// // $whyChart = DemoValidation::where('validation_id',$id)->where('type',"why_chart")->first();
// // $what_who_where = DemoValidation::where('validation_id',$id)->where('type',"what_who_where")->first();
// // $action_plan = DemoValidation::where('validation_id',$id)->where('type',"Action_Plan")->first();
// // $mitigation_plan_details = DemoValidation::where('validation_id',$id)->where('type',"Mitigation_Plan_Details")->first();

// return view('frontend.new_forms.updateValidation',compact('data','old_record'));
// }

}
