<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use App\Models\LabTest;
use App\Http\Controllers\newForm\update_lab_test;
use App\Http\Controllers\newForm\audit_lab_test;
use App\Models\LabTestAudit;
use App\Models\RoleGroup;
use App\Models\User;
use App\Models\RecordNumber;
use Helpers;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LabController extends Controller
{
    public function index()
    {

        $old_record = LabTest::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        // $division = QMSDivision::where('status', '1')->get();

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.lab.lab_test', compact('old_record','record_number','currentDate','formattedDate','due_date'));
    }


    public function store(Request $request){
        //dd($request->all());

        $recordCounter = RecordNumber::first();
            $newRecordNumber = $recordCounter->counter + 1;
            $recordCounter->counter = $newRecordNumber;
            $recordCounter->save();

        $lab = new LabTest();

        $lab->record = $newRecordNumber;

        $lab->initiator_id = Auth::user()->id;
        $lab->parent_id = $request->parent_id;
        $lab->parent_type = $request->parent_type;
        $lab->intiation_date = $request->intiation_date;
        $lab->division_id = $request->division_id;
        $lab->originator_id = Auth::user()->id;
        // $lab->user_name = Auth::user()->name;
        // $lab->initiator_id = $request->initiator_id;
        $lab->short_description = $request->short_description;
        $lab->divison_code = $request->divison_code;
       // $lab->record = $request->record;
        $lab->general_initiator_group = $request->general_initiator_group;
        $lab->initiator_group_code = $request->initiator_group_code;
        $lab->form_type = $request->form_type;
        $lab->product = $request->product;
        $lab->assigned_to = $request->assigned_to;
        $lab->due_date = $request->due_date;
        $lab->priority_level = $request->priority_level;
        $lab->type_of_product = $request->type_of_product;
        $lab->internal_product_test_info = $request->internal_product_test_info;
        $lab->comments = $request->comments;
        $lab->internal_test_conclusion = $request->internal_test_conclusion;
        $lab->reviewer_comments = $request->reviewer_comments;
        $lab->action_summary = $request->action_summary;
        $lab->lab_test_summary = $request->lab_test_summary;
        $lab->related_urls = $request->related_urls;
        $lab->related_records = $request->related_records;
        $lab->stage = "1";
        $lab->status = "Opened";

        if (!empty($request->file_attachment)) {
            $files = [];
            if ($request->hasfile('file_attachment')) {
                foreach ($request->file('file_attachment') as $file) {
                    $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $lab->file_attachment = json_encode($files);
        }

            $lab->save();

            // $record = RecordNumber::first();
            // $record-> counter = ((RecordNumber::first()->value('counter')+1));
            // $record->update();



            if (!empty($request->short_description)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'short_description';
                $lab3->previous = "Null";
                $lab3->current = $request->short_description;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }

            if (!empty($request->product)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'product';
                $lab3->previous = "Null";
                $lab3->current = $request->product;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }

            if (!empty($request->due_date)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'due_date';
                $lab3->previous = "Null";
                $lab3->current = $request->due_date;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }

            if (!empty($request->priority_level)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'priority_level';
                $lab3->previous = "Null";
                $lab3->current = $request->priority_level;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }

            if (!empty($request->assigned_to)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'assigned_to';
                $lab3->previous = "Null";
                $lab3->current = $request->assigned_to;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }

            if (!empty($request->type_of_product)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'type_of_product';
                $lab3->previous = "Null";
                $lab3->current = $request->type_of_product;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }

            if (!empty($request->internal_product_test_info)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'internal_product_test_info';
                $lab3->previous = "Null";
                $lab3->current = $request->internal_product_test_info;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }

            if (!empty($request->comments)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'comments';
                $lab3->previous = "Null";
                $lab3->current = $request->comments;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }

            if (!empty($request->internal_test_conclusion)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'internal_test_conclusion';
                $lab3->previous = "Null";
                $lab3->current = $request->internal_test_conclusion;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }

            if (!empty($request->reviewer_comments)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'reviewer_comments';
                $lab3->previous = "Null";
                $lab3->current = $request->reviewer_comments;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }

            if (!empty($request->action_summary)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'action_summary';
                $lab3->previous = "Null";
                $lab3->current = $request->action_summary;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }

            if (!empty($request->lab_test_summary)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'lab_test_summary';
                $lab3->previous = "Null";
                $lab3->current = $request->lab_test_summary;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }

            // if (!empty($request->file_attachment)) {
            //     $lab3 = new LabTestAudit();
            //     $lab3->lab_id = $lab->id;
            //     $lab3->activity_type = 'file_attachment';
            //     $lab3->previous = "Null";
            //     $lab3->current = $request->file_attachment;
            //     $lab3->comment = "NA";
            //     $lab3->user_id = Auth::user()->id;
            //     $lab3->user_name = Auth::user()->name;
            //     $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            //     $lab3->change_to =   "Opened";
            //     $lab3->change_from = "Initiator";
            //     $lab3->action_name = 'Create';
            //     $lab3->save();
            // }

            if (!empty($request->related_urls)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'related_urls';
                $lab3->previous = "Null";
                $lab3->current = $request->related_urls;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }

            if (!empty($request->related_records)) {
                $lab3 = new LabTestAudit();
                $lab3->lab_id = $lab->id;
                $lab3->activity_type = 'related_records';
                $lab3->previous = "Null";
                $lab3->current = $request->related_records;
                $lab3->comment = "NA";
                $lab3->user_id = Auth::user()->id;
                $lab3->user_name = Auth::user()->name;
                $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $lab3->change_to =   "Opened";
                $lab3->change_from = "Initiator";
                $lab3->action_name = 'Create';
                $lab3->save();
            }


            toastr()->success("Lab Test is created succusfully");
            return redirect(url('rcms/qms-dashboard'));
    }



    public function show($id)
    {

        $lab = LabTest::findOrFail($id);
        $record_number = str_pad($lab->record, 4, '0', STR_PAD_LEFT);
        return view('frontend.lab.update_lab_test', compact('lab','record_number'));
    }


    public function labUpdate(Request $request, $id)
    {
        //    dd($request->all());

        $lab1 =  LabTest::find($id);

        $lab1->initiator_id = Auth::user()->id;
        $lab1->parent_id = $request->parent_id;
        $lab1->parent_type = $request->parent_type;
        $lab1->intiation_date = $request->intiation_date;
        $lab1->division_id = $request->division_id;
        $lab1->originator_id = Auth::user()->id;
        // $lab1->user_name = Auth::user()->name;
        //    $lab1->initiator_id = $request->initiator_id;
        $lab1->short_description = $request->short_description;
        $lab1->divison_code = $request->divison_code;
       // $lab1->record = $request->record;
        $lab1->general_initiator_group = $request->general_initiator_group;
        $lab1->initiator_group_code = $request->initiator_group_code;
        $lab1->form_type = $request->form_type;
        $lab1->product = $request->product;
        $lab1->assigned_to = $request->assigned_to;
        $lab1->due_date = $request->due_date;
        $lab1->priority_level = $request->priority_level;
        $lab1->type_of_product = $request->type_of_product;
        $lab1->internal_product_test_info = $request->internal_product_test_info;
        $lab1->comments = $request->comments;
        $lab1->internal_test_conclusion = $request->internal_test_conclusion;
        $lab1->reviewer_comments = $request->reviewer_comments;
        $lab1->action_summary = $request->action_summary;
        $lab1->lab_test_summary = $request->lab_test_summary;
        $lab1->related_urls = $request->related_urls;
        $lab1->related_records = $request->related_records;

        if (!empty($request->file_attachment)) {
            $files = [];
            if ($request->hasfile('file_attachment')) {
                foreach ($request->file('file_attachment') as $file) {
                    $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $lab1->file_attachment = json_encode($files);
        }
        $lab1->update();


        if (!empty($request->short_description)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'short_description';
            $lab3->previous = "Null";
            $lab3->current = $request->short_description;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }

        if (!empty($request->product)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'product';
            $lab3->previous = "Null";
            $lab3->current = $request->product;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }

        if (!empty($request->due_date)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'due_date';
            $lab3->previous = "Null";
            $lab3->current = $request->due_date;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }

        if (!empty($request->priority_level)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'priority_level';
            $lab3->previous = "Null";
            $lab3->current = $request->priority_level;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }

        if (!empty($request->assigned_to)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'assigned_to';
            $lab3->previous = "Null";
            $lab3->current = $request->assigned_to;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }

        if (!empty($request->type_of_product)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'type_of_product';
            $lab3->previous = "Null";
            $lab3->current = $request->type_of_product;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }

        if (!empty($request->internal_product_test_info)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'internal_product_test_info';
            $lab3->previous = "Null";
            $lab3->current = $request->internal_product_test_info;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }

        if (!empty($request->comments)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'comments';
            $lab3->previous = "Null";
            $lab3->current = $request->comments;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }

        if (!empty($request->internal_test_conclusion)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'internal_test_conclusion';
            $lab3->previous = "Null";
            $lab3->current = $request->internal_test_conclusion;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }

        if (!empty($request->reviewer_comments)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'reviewer_comments';
            $lab3->previous = "Null";
            $lab3->current = $request->reviewer_comments;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }

        if (!empty($request->action_summary)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'action_summary';
            $lab3->previous = "Null";
            $lab3->current = $request->action_summary;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }

        if (!empty($request->lab_test_summary)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'lab_test_summary';
            $lab3->previous = "Null";
            $lab3->current = $request->lab_test_summary;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }

        // if (!empty($request->file_attachment)) {
        //     $lab3 = new LabTestAudit();
        //     $lab3->lab_id = $lab->id;
        //     $lab3->activity_type = 'file_attachment';
        //     $lab3->previous = "Null";
        //     $lab3->current = $request->file_attachment;
        //     $lab3->comment = "NA";
        //     $lab3->user_id = Auth::user()->id;
        //     $lab3->user_name = Auth::user()->name;
        //     $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

        //     $lab3->change_to =   "Opened";
        //     $lab3->change_from = "Initiator";
        //     $lab3->action_name = 'Create';
        //     $lab3->save();
        // }

        if (!empty($request->related_urls)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'related_urls';
            $lab3->previous = "Null";
            $lab3->current = $request->related_urls;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }

        if (!empty($request->related_records)) {
            $lab3 = new LabTestAudit();
            $lab3->lab_id = $lab1->id;
            $lab3->activity_type = 'related_records';
            $lab3->previous = "Null";
            $lab3->current = $request->related_records;
            $lab3->comment = "NA";
            $lab3->user_id = Auth::user()->id;
            $lab3->user_name = Auth::user()->name;
            $lab3->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $lab3->change_to =   "Not Applicable";
            $lab3->change_from = $lab1->status;
            $lab3->action_name = 'Update';
            $lab3->save();
        }


        toastr()->success("Lab Test is updated succusfully");
        return redirect(url('rcms/qms-dashboard'));
    }




    public function lab_sends_stage(Request $request, $id)
{
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $lab2 = LabTest::find($id);
        $lastDocument = LabTest::find($id);

        if ($lab2->stage == 1) {
            $lab2->stage = "2";
            $lab2->status = "Pending Internal Report";
            $lab2->submitted_by = Auth::user()->name;
            $lab2->submitted_on = Carbon::now()->format('d-m-y');
            $lab2->comment = $request->comment;

            $history = new LabTestAudit();
            $history->lab_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = $lastDocument->submitted_by;
            $history->current = $lab2->submitted_on;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            // Remove or comment out the line below if the column is not needed
            // $history->origin_state = $lastDocument->status;
            $history->change_from = 'old_value';
            $history->change_to = 'new_value';
            $history->stage = 'Submitted';
            $history->action_name = 'Submitted';
            $history->save();

            $list = Helpers::getHodUserList();
            foreach ($list as $u) {
                if ($u->q_m_s_divisions_id == $lab2->division_id) {
                    $email = Helpers::getInitiatorEmail($u->user_id);
                    if ($email !== null) {
                        Mail::send(
                            'mail.view-mail',
                            ['data' => $lab2],
                            function ($message) use ($email) {
                                $message->to($email)
                                    ->subject("Document is Submitted By " . Auth::user()->name);
                            }
                        );
                    }
                }
            }

            $lab2->update();
            toastr()->success('Document Sent');
            return back();
        }


            if ($lab2->stage == 2) {
                $lab2->stage = "3";
                $lab2->internal_product_test_submitted_by = Auth::user()->name;
                $lab2->internal_product_test_submitted_on = Carbon::now()->format('d-m-y');
                $lab2->comment_internal_product = $request->comment;
                $lab2->status = "Draw Internal Test Conclusions";

                $history = new LabTestAudit();
                $history->lab_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->internal_product_test_submitted_by;
                $history->current = $lab2->internal_product_test_submitted_on;
                // $history->comment_internal_product = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
               // $history->origin_state = $lastDocument->status;
                 $history->change_from = 'old_value';
                 $history->change_to = 'new_value';
                $history->stage='Submitted';
                $history->action_name ='Submitted';
                $history->save();
                $list = Helpers::getHodUserList();
                    foreach ($list as $u) {

                        if($u->q_m_s_divisions_id == $lab2->division_id){
                            $email = Helpers::getInitiatorEmail($u->user_id);
                             if ($email !== null) {

                              Mail::send(
                                  'mail.view-mail',
                                   ['data' => $lab2],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Document is Submitted By ".Auth::user()->name);
                                }
                              );
                            }
                     }
                  }

                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }


            if ($lab2->stage == 3) {
                $lab2->stage = "4";
                $lab2->status = "Pending Conclusion";
                $lab2->ok_external_testing_submitted_by = Auth::user()->name;
                $lab2->ok_external_testing_submitted_on = Carbon::now()->format('d-m-y');
                $lab2->ok_external_testing_comment = $request->comment;

                $history = new LabTestAudit();
                $history->lab_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->ok_external_testing_submitted_by;
                $history->current = $lab2->ok_external_testing_submitted_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                //$history->origin_state = $lastDocument->status;
                $history->change_from = 'old_value';
                $history->change_to = 'new_value';
                $history->stage='Submitted';
                $history->action_name ='Submitted';
                $history->save();
                $list = Helpers::getHodUserList();
                    foreach ($list as $u) {

                        if($u->q_m_s_divisions_id == $lab2->division_id){
                            $email = Helpers::getInitiatorEmail($u->user_id);
                             if ($email !== null) {

                              Mail::send(
                                  'mail.view-mail',
                                   ['data' => $lab2],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Document is Submitted By ".Auth::user()->name);
                                }
                              );
                            }
                     }
                  }

                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }



            if ($lab2->stage == 4) {
                $lab2->stage = "6";
                $lab2->status = " Pending Review";
                $lab2->product_Quality_Validated_submitted_by = Auth::user()->name;
                $lab2->product_Quality_Validated_submitted_on = Carbon::now()->format('d-m-y');
                $lab2->product_quality_validated_comment = $request->comment;

                $history = new LabTestAudit();
                $history->lab_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->product_Quality_Validated_submitted_by;
                $history->current = $lab2->product_Quality_Validated_submitted_on;
              // $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
               // $history->origin_state = $lastDocument->status;

               $history->change_from = 'old_value';
                $history->change_to = 'new_value';
                $history->stage='Submitted';
                $history->action_name ='Submitted';
                $history->save();
                $list = Helpers::getHodUserList();
                    foreach ($list as $u) {

                        if($u->q_m_s_divisions_id == $lab2->division_id){
                            $email = Helpers::getInitiatorEmail($u->user_id);
                             if ($email !== null) {

                              Mail::send(
                                  'mail.view-mail',
                                   ['data' => $lab2],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Document is Submitted By ".Auth::user()->name);
                                }
                              );
                            }
                     }
                  }

                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }





            if ($lab2->stage == 5) {
                $lab2->stage = "6";
                $lab2->status = "  Pending Review";
                $lab2->conduct_product_conclusion_submitted_by = Auth::user()->name;
                $lab2->conduct_product_conclusion_submitted_on = Carbon::now()->format('d-m-y');
                $lab2->conduct_product_conclusion_comment = $request->comment;

                $history = new LabTestAudit();
                $history->lab_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->conduct_product_conclusion_submitted_by;
                $history->current = $lab2->conduct_product_conclusion_submitted_on;
                //$history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
               // $history->origin_state = $lastDocument->status;

               $history->change_from = 'old_value';
                $history->change_to = 'new_value';
                $history->stage='Submitted';
                $history->action_name ='Submitted';
                $history->save();
                $list = Helpers::getHodUserList();
                    foreach ($list as $u) {

                        if($u->q_m_s_divisions_id == $lab2->division_id){
                            $email = Helpers::getInitiatorEmail($u->user_id);
                             if ($email !== null) {

                              Mail::send(
                                  'mail.view-mail',
                                   ['data' => $lab2],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Document is Submitted By ".Auth::user()->name);
                                }
                              );
                            }
                     }
                  }

                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }


            if ($lab2->stage == 6) {
                $lab2->stage = "7";
                $lab2->status = " Closed - Done";
                $lab2->reviewed_closed_by = Auth::user()->name;
                $lab2->reviewed_closed_on = Carbon::now()->format('d-m-y');
                $lab2->reviewed_closed_comment = $request->comment;

                $history = new LabTestAudit();
                $history->lab_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = $lastDocument->reviewed_closed_by;
                $history->current = $lab2->reviewed_closed_on;
                //$history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
              //  $history->origin_state = $lastDocument->status;

              $history->change_from = 'old_value';
                $history->change_to = 'new_value';
                $history->stage='Submitted';
                $history->action_name ='Submitted';
                $history->save();
                $list = Helpers::getHodUserList();
                    foreach ($list as $u) {

                        if($u->q_m_s_divisions_id == $lab2->division_id){
                            $email = Helpers::getInitiatorEmail($u->user_id);
                             if ($email !== null) {

                              Mail::send(
                                  'mail.view-mail',
                                   ['data' => $lab2],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Document is Submitted By ".Auth::user()->name);
                                }
                              );
                            }
                     }
                  }

                $lab2->update();
                toastr()->success('Document Sent');
                return back();

            } else {
                toastr()->error('E-signature Not match');
                return back();
            }
        }
    }

    public function lab_Cancel(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $lab2 = LabTest::find($id);

            if ($lab2->stage == 1) {
                $lab2->stage = "0";
                $lab2->status = "Closed-Cancelled";
                $lab2->cancel_by = Auth::user()->name;
                $lab2->cancel_on = Carbon::now()->format('d-m-y');
                $lab2->cancel_comment = $request->cancel_comment;

                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }



            if ($lab2->stage == 3) {
                $lab2->stage = "8";
                $lab2->status = "Closed - Unsuccessful Products";
                $lab2->not_ok_cancel_by = Auth::user()->name;
                $lab2->not_ok_cancel_on = Carbon::now()->format('d-m-y');
                $lab2->not_ok_cancel_comment = $request->comment;
                $lab2->update();
                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($lab2->stage == 6) {
                $lab2->stage = "7";
                $lab2->status = "Closed - Done";
                $lab2->reviewed_closed_by = Auth::user()->name;
                $lab2->reviewed_closed_on = Carbon::now()->format('d-m-y');
                $lab2->reviewed_closed_comment = $request->comment;
                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }


    public function lab_qa_more_info(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $lab2 = LabTest::find($id);

            if ($lab2->stage == 4) {
                $lab2->stage = "5";
                $lab2->status = "Pending CEQ Action";
                $lab2->action_needed_submitted_by = Auth::user()->name;
                $lab2->action_needed_submitted_on = Carbon::now()->format('d-m-y');
                $lab2->action_needed_comment = $request->comment;
                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }


    public function lab_test_reject(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $lab2 = LabTest::find($id);

            if ($lab2->stage == 3) {
                $lab2->stage = "1";
                $lab2->status = " Opened";
                $lab2->demand_product_improvement_rejected_by = Auth::user()->name;
                $lab2->demand_product_improvement_rejected_on = Carbon::now()->format('d-m-y');
                $lab2->demand_improvement_comment = $request->comment;

                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($lab2->stage == 4) {
                $lab2->stage = "1";
                $lab2->status = " Opened";
                $lab2->demand_product_improvement_rejected_by = Auth::user()->name;
                $lab2->demand_product_improvement_rejected_on = Carbon::now()->format('d-m-y');
                $lab2->demand_product_comment = $request->comment;
                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($lab2->stage == 6) {
                $lab2->stage = "1";
                $lab2->status = " Opened";
                $lab2->demand_product_improvement_rejected_by = Auth::user()->name;
                $lab2->demand_product_improvement_rejected_on = Carbon::now()->format('d-m-y');
                $lab2->demand_product_improvement_comment = $request->comment;
                $lab2->update();
                toastr()->success('Document Sent');
                return back();
            }
        }
    }



    public function labAudit($id)
    {

        // $audit = LabTestAudit::where('lab_id', $id)->orderByDESC('id')->get();

        $audit = LabTestAudit::where('lab_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = LabTest::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        return view('frontend.lab.audit_lab_trail', compact('audit', 'document', 'today'));
    }


    public function auditReport($id)
    {
        $doc = LabTest::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = LabTestAudit::where('lab_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.lab.audit_lab_test', compact('data', 'doc'))
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



    public function labAuditDetails($id){

        $detail = LabTestAudit::find($id);
        $detail_data =LabTestAudit::where('activity_type', $detail->activity_type)->where('lab_id', $detail->lab_id)->latest()->get();
        $doc = LabTest::where('id', $detail->lab_id)->first();
        // $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.lab.lab_testAuditDetails', compact('detail', 'doc', 'detail_data'));
    }

    public function singleReport($id){
        $data = LabTest::find($id);

        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');

            $doc = LabTestAudit::where('lab_id', $data->id)->first();
            $detail_data = LabTestAudit::where('activity_type', $data->activity_type)
                ->where('lab_id', $data->lab_id)
                ->latest()
                ->get();

            // pdf related work
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.lab.lab_singleReport', compact(
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
                $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
                return $pdf->stream('Lab test' . $id . '.pdf');

        }

        return redirect()->back()->with('error', 'Lab test not found.');
    }


}

