<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ActionItem;
use App\Models\Extension;
use App\Models\Validation;
use App\Models\ValidationAudit;
use App\Models\UserRole;

use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\RoleGroup;
use App\Models\User;

use App\Models\RecordNumber;
use App\Models\ValidationGrid;

class ValidationController extends Controller
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
            $validation->division_id = $request->division_id;
            $validation->divison_code = $request->divison_code;
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
            $validation->document_reason_type = $request->input('document_reason_type');
            $validation->purpose = $request->input('purpose');
            $validation->validation_category = $request->input('validation_category');
            $validation->validation_sub_category = $request->input('validation_sub_category');
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

            $validation->save();

            // Grid Start
            $validation_id = $validation->id;
            $newDataGridErrata = ValidationGrid::where(['validation_id' => $validation_id, 'identifier' => 'details'])->firstOrCreate();
            $newDataGridErrata->validation_id = $validation_id;
            $newDataGridErrata->identifier = 'details';
            $newDataGridErrata->data = $request->details;
            $newDataGridErrata->save();

            if (!empty($request->short_description)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->previous = "Null";
                $validation2->current = $request->short_description;
                $validation2->activity_type = 'Short Description';
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->intiation_date)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Intiation Date';
                $validation2->previous = "Null";
                $validation2->current = \Carbon\Carbon::parse($request->intiation_date)->format('d-M-Y');
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
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
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->assign_due_date)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = ' Assign Due Date';
                $validation2->previous = "Null";
                $validation2->current = \Carbon\Carbon::parse($request->assign_due_date)->format('d-M-Y');
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
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
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->validation_due_date)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Validation Due Date';
                $validation2->previous = "Null";
                $validation2->current = \Carbon\Carbon::parse($request->validation_due_date)->format('d-M-Y');
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
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
                $validation2->change_from = "Initiation";
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
                $validation2->change_from = "Initiation";
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
                $validation2->change_from = "Initiation";
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
                $validation2->change_from = "Initiation";
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
                $validation2->change_from = "Initiation";
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
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->file_attechment)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Download Templates';
                $validation2->previous = "Null";
                $validation2->current = json_encode($request->file_attechment);
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            if (!empty($request->items_attachment)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Items Attachment';
                $validation2->previous = "Null";
                $validation2->current = json_encode($request->items_attachment);
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
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
                $validation2->change_from = "Initiation";
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
                $validation2->change_from = "Initiation";
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
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->result_attachment)) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $validation->id;
                $validation2->activity_type = 'Results Attachment';
                $validation2->previous = "Null";
                $validation2->current = json_encode($request->result_attachment);
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
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
                $validation2->change_from = "Initiation";
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
                $validation2->change_from = "Initiation";
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

        $packagingDetails = ValidationGrid::where('validation_id', $id)->where('identifier', 'details')->first();

        $details = $packagingDetails ? json_decode($packagingDetails->data, true) : [];
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        return view('frontend.new_forms.updateValidation', compact('validation', 'details', 'due_date'));
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
            $lastDocument =  Validation::findOrFail($id);


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
            $validations->related_record = $request->input('related_record');
            $validations->document_link = $request->input('document_link');
            $validations->file_attechment = $request->file_attechment;


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

            $validations->tests_required = $request->input('tests_required');
            $validations->reference_document = $request->input('reference_document');
            $validations->reference_link = $request->input('reference_link');
            $validations->additional_references = $request->input('additional_references');


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

            $validations->update();

            $validation_id = $validations->id;
            $newDataGrid = ValidationGrid::where(['validation_id' => $validation_id, 'identifier' => 'details'])->firstOrCreate();
            $newDataGrid->validation_id = $validation_id;
            $newDataGrid->identifier = 'details';
            $newDataGrid->data = $request->details;
            $newDataGrid->save();

            if ($lastDocument->short_description != $request->short_description) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->previous = $lastDocument->short_description;
                $validation2->current = $request->short_description;
                $validation2->activity_type = 'Short Description';
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->short_description) || $lastDocument->short_description === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->intiation_date != $request->intiation_date) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Intiation Date';
                $validation2->previous = \Carbon\Carbon::parse($lastDocument->intiation_date)->format('d-M-Y');
                $validation2->current = \Carbon\Carbon::parse($request->intiation_date)->format('d-M-Y');
                $validation2->comment = "Not Applicable";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');


                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->intiation_date) || $lastDocument->intiation_date === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->assign_to != $request->assign_to) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Assign To';
                $validation2->previous = $lastDocument->assign_to;
                $validation2->current = $request->assign_to;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->assign_to) || $lastDocument->assign_to === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->assign_due_date != $request->assign_due_date) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = ' Assign Due Date';
                $validation2->previous = \Carbon\Carbon::parse($lastDocument->assign_due_date)->format('d-M-Y');
                $validation2->current = \Carbon\Carbon::parse($request->assign_due_date)->format('d-M-Y');
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->assign_due_date) || $lastDocument->assign_due_date === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }

                $validation2->save();
            }

            if ($lastDocument->validation_type != $request->validation_type) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Validation Type';
                $validation2->previous = $lastDocument->validation_type;
                $validation2->current = $request->validation_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->validation_type) || $lastDocument->validation_type === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }

                $validation2->save();
            }

            if ($lastDocument->validation_due_date != $request->validation_due_date) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Validation Due Date';
                $validation2->previous = \Carbon\Carbon::parse($lastDocument->validation_due_date)->format('d-M-Y');
                $validation2->current = \Carbon\Carbon::parse($request->validation_due_date)->format('d-M-Y');
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->validation_due_date) || $lastDocument->validation_due_date === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }

                $validation2->save();
            }

            if ($lastDocument->notify_type != $request->notify_type) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Notify Type';
                $validation2->previous = $lastDocument->notify_type;
                $validation2->current = $request->notify_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->notify_type) || $lastDocument->notify_type === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->phase_type != $request->phase_type) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Phase Level';
                $validation2->previous = $lastDocument->phase_type;
                $validation2->current = $request->phase_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;

                if (is_null($lastDocument->phase_type) || $lastDocument->phase_type === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->document_reason_type != $request->document_reason_type) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Document Reason';
                $validation2->previous = $lastDocument->document_reason_type;
                $validation2->current = $request->document_reason_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->document_reason_type) || $lastDocument->document_reason_type === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }


            if ($lastDocument->purpose != $request->purpose) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Purpose';
                $validation2->previous = $lastDocument->purpose;
                $validation2->current = $request->purpose;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->purpose) || $lastDocument->purpose === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->validation_category != $request->validation_category) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Validation Category';
                $validation2->previous = $lastDocument->validation_category;
                $validation2->current = $request->validation_category;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;

                if (is_null($lastDocument->validation_category) || $lastDocument->validation_category === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->validation_sub_category != $request->validation_sub_category) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Validation Sub Category';
                $validation2->previous = $lastDocument->validation_sub_category;
                $validation2->current = $request->validation_sub_category;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->validation_sub_category) || $lastDocument->validation_sub_category === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->file_attechment != $request->file_attechment) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Download Templates';
                $validation2->previous = json_encode($lastDocument->file_attechment);
                $validation2->current = json_encode($request->file_attechment);
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->file_attechment) || $lastDocument->file_attechment === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->items_attachment != $request->items_attechment) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Items Attachment';
                $validation2->previous = json_encode($lastDocument->items_attachment);
                $validation2->current = json_encode($request->items_attachment);
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->items_attachment) || $lastDocument->items_attachment === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->related_record != $request->related_record) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Related Records';
                $validation2->previous = $lastDocument->related_record;
                $validation2->current = $request->related_record;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->related_record) || $lastDocument->related_record === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->document_link != $request->document_link) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Document Link';
                $validation2->previous = $lastDocument->document_link;
                $validation2->current = $request->document_link;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->document_link) || $lastDocument->document_link === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->tests_required != $request->tests_required) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Tests Required';
                $validation2->previous = $lastDocument->tests_required;
                $validation2->current = $request->tests_required;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->tests_required) || $lastDocument->tests_required === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }


            if ($lastDocument->result_attachment != $request->result_attachment) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Download Templates';
                $validation2->previous = json_encode($lastDocument->result_attachment);
                $validation2->current = json_encode($request->result_attachment);
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;

                if (is_null($lastDocument->result_attachment) || $lastDocument->result_attachment === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->reference_document != $request->reference_document) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Refrence Document';
                $validation2->previous = $lastDocument->reference_document;
                $validation2->current = $request->reference_document;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;

                if (is_null($lastDocument->reference_document) || $lastDocument->reference_document === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->reference_link != $request->reference_link) {
                $validation2 = new ValidationAudit();
                $validation2->validation_id = $id;
                $validation2->activity_type = 'Refrence Link';
                $validation2->previous = $lastDocument->reference_link;
                $validation2->current = $request->reference_link;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;

                if (is_null($lastDocument->reference_link) || $lastDocument->reference_link === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
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
                $validation->submited_comment = $request->submited_comment;

                $validation1 = new ValidationAudit();

                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->submitted_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'Submit Protoco';
                $validation1->change_to = 'Review';
                $validation1->stage = 'Submited';
                $validation1->save();

                $validation->update();

                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 2) {
                $validation->stage = "3";
                $validation->status = "Protocol Approval";
                $validation->review_by = Auth::user()->name;
                $validation->review_on = Carbon::now()->format('d-M-Y');
                $validation->comment = $request->comment;

                $validation1 = new ValidationAudit();
                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->review_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'Review Approval';
                $validation1->change_to = 'Protocol Approval';
                $validation1->stage = 'Submited';
                $validation1->save();

                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 3) {
                $validation->stage = "4";
                $validation->status = "Test in Progress";
                $validation->approved_by = Auth::user()->name;
                $validation->approved_on = Carbon::now()->format('d-M-Y');
                $validation->comments = $request->comments;

                $validation1 = new ValidationAudit();
                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->approved_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'Approval';
                $validation1->change_to = 'Test in Progress';
                $validation1->stage = 'Submited';
                $validation1->save();

                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 4) {
                $validation->stage = "5";
                $validation->status = "Deviation in Progress";

                $validation->final_approved_by = Auth::user()->name;
                $validation->final_approved_on = Carbon::now()->format('d-M-Y');

                $validation1 = new ValidationAudit();
                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->final_approved_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'Deviation Occurred';
                $validation1->change_to = 'Deviation in Progress';
                $validation1->stage = 'Submited';

                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 5) {
                $validation->stage = "6";
                $validation->status = "Pending Completion";

                $validation->final_approved_by = Auth::user()->name;
                $validation->final_approved_on = Carbon::now()->format('d-M-Y');

                $validation1 = new ValidationAudit();
                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->final_approved_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'Deviation Occurred';
                $validation1->change_to = 'Deviation in Progress';
                $validation1->stage = 'Submited';

                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 6) {
                $validation->stage = "7";
                $validation->status = "Pending Approval";

                $validation->final_approved_by = Auth::user()->name;
                $validation->final_approved_on = Carbon::now()->format('d-M-Y');

                $validation1 = new ValidationAudit();
                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->final_approved_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'Deviation Occurred';
                $validation1->change_to = 'Deviation in Progress';
                $validation1->stage = 'Submited';

                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 7) {
                $validation->stage = "8";
                $validation->status = "Active Document";


                $validation->final_approved_by = Auth::user()->name;
                $validation->final_approved_on = Carbon::now()->format('d-M-Y');

                $validation1 = new ValidationAudit();
                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->final_approved_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'Deviation Occurred';
                $validation1->change_to = 'Deviation in Progress';
                $validation1->stage = 'Submited';

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
            $lastDocument = Validation::find($id);


            if ($validation->stage == 1) {
                $validation->stage = "0";
                $validation->status = "Closed-Cancelled";

                $validation->cancelled_by = Auth::user()->name;
                $validation->cancelled_on = Carbon::now()->format('d-M-Y');
                // $validation->comments = $request->comments;

                $validation1 = new ValidationAudit();

                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->cancelled_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'cancelled';
                $validation1->change_to = 'Closed-Cancelled';
                $validation1->stage = 'Cancelled';
                $validation1->save();

                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 3) {
                $validation->stage = "1";
                $validation->status = "Opened";

                $validation->cancelled_by = Auth::user()->name;
                $validation->cancelled_on = Carbon::now()->format('d-M-Y');
                // $validation->comments = $request->comments;

                $validation1 = new ValidationAudit();

                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->cancelled_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'cancelled';
                $validation1->change_to = 'Closed-Cancelled';
                $validation1->stage = 'Cancelled';
                $validation1->save();

                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ($validation->stage == 4) {
                $validation->stage = "6";
                $validation->status = "Protocol Approval";

                $validation->cancelled_by = Auth::user()->name;
                $validation->cancelled_on = Carbon::now()->format('d-M-Y');
                // $validation->comments = $request->comments;

                $validation1 = new ValidationAudit();

                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->cancelled_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'cancelled';
                $validation1->change_to = 'Closed-Cancelled';
                $validation1->stage = 'Cancelled';
                $validation1->save();

                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($validation->stage == 5) {
                $validation->stage = "4";
                $validation->status = "Test in Progress";

                $validation->cancelled_by = Auth::user()->name;
                $validation->cancelled_on = Carbon::now()->format('d-M-Y');
                // $validation->comments = $request->comments;

                $validation1 = new ValidationAudit();

                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->cancelled_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'cancelled';
                $validation1->change_to = 'Closed-Cancelled';
                $validation1->stage = 'Cancelled';
                $validation1->save();

                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($validation->stage == 6) {
                $validation->stage = "5";
                $validation->status = "Deviation in Progress";

                $validation->cancelled_by = Auth::user()->name;
                $validation->cancelled_on = Carbon::now()->format('d-M-Y');
                // $validation->comments = $request->comments;

                $validation1 = new ValidationAudit();

                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->cancelled_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'cancelled';
                $validation1->change_to = 'Closed-Cancelled';
                $validation1->stage = 'Cancelled';
                $validation1->save();

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

                $validation->cancelled_by = Auth::user()->name;
                $validation->cancelled_on = Carbon::now()->format('d-M-Y');
                // $validation->comments = $request->comments;

                $validation1 = new ValidationAudit();

                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->cancelled_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'cancelled';
                $validation1->change_to = 'Closed-Cancelled';
                $validation1->stage = 'Cancelled';
                $validation1->save();

                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($validation->stage == 8) {
                $validation->stage = "7";
                $validation->status = "Pending Approval";

                $validation->cancelled_by = Auth::user()->name;
                $validation->cancelled_on = Carbon::now()->format('d-M-Y');
                // $validation->comments = $request->comments;

                $validation1 = new ValidationAudit();

                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->cancelled_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'cancelled';
                $validation1->change_to = 'Closed-Cancelled';
                $validation1->stage = 'Cancelled';
                $validation1->save();

                $validation->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($validation->stage == 9) {
                $validation->stage = "8";
                $validation->status = "Active Document";

                $validation->cancelled_by = Auth::user()->name;
                $validation->cancelled_on = Carbon::now()->format('d-M-Y');
                // $validation->comments = $request->comments;

                $validation1 = new ValidationAudit();

                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->cancelled_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'cancelled';
                $validation1->change_to = 'Closed-Cancelled';
                $validation1->stage = 'Cancelled';
                $validation1->save();

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


    public function validation_reject(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $validation = Validation::find($id);
            $lastDocument = Validation::find($id);



            if ($validation->stage == 7) {
                $validation->stage = "9";
                $validation->status = "Closed-Done";
                $validation->cancelled_by = Auth::user()->name;
                $validation->cancelled_on = Carbon::now()->format('d-M-Y');
                // $validation->comments = $request->comments;

                $validation1 = new ValidationAudit();

                $validation1->validation_id = $id;
                $validation1->activity_type = 'Activity Log';
                $validation1->previous = "";
                $validation1->current = $validation->cancelled_by;
                $validation1->comment = $request->comment;
                $validation1->user_id = Auth::user()->id;
                $validation1->user_name = Auth::user()->name;
                $validation1->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation1->change_from = $lastDocument->status;
                $validation1->action = 'cancelled';
                $validation1->change_to = 'Closed-Cancelled';
                $validation1->stage = 'Cancelled';
                $validation1->save();

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

    public function stageChange()
    {
        return 'validation deviation';
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

    public function ValidationAuditTrialDetails($id)
    {

        $detail = ValidationAudit::find($id);
        $detail_data = ValidationAudit::where('activity_type', $detail->activity_type)->where('validation_id', $detail->validation_id)->latest()->get();
        $doc = ValidationAudit::where('id', $detail->validation_id)->first();
        $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.New_forms.auditDetails_validation', compact('detail', 'doc', 'detail_data'));
    }

    public function audit_pdf2($id)
    {
        $doc = Validation::findOrFail($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        } else {
            $datas = ActionItem::find($id);

            if (empty($datas)) {
                $datas = Extension::find($id);
                $doc = Validation::find($datas->validation_id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $doc->created_at = $datas->created_at;
            } else {
                $doc = Validation::find($datas->validation_id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $doc->created_at = $datas->created_at;
            }
        }
        $data = ValidationAudit::where('validation_id', $doc->id)->orderByDesc('id')->get();
        // pdf related work
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.New_forms.validation_audit_trail_pdf', compact('data', 'doc'))
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
