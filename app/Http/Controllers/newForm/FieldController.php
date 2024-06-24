<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use App\Models\FieldInquiry;
use App\Models\FieldInquiryAudit;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\User;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FieldController extends Controller
{

    public function index()
    {

        $old_record = FieldInquiry::select('id', 'division_id', 'record_number')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        // $division = QMSDivision::where('status', '1')->get();

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.field.field-inquiry', compact('old_record', 'record_number', 'currentDate', 'formattedDate', 'due_date'));
    }


    public function store(Request $request)

    {
        $recordCounter = RecordNumber::first();
        $newRecordNumber = $recordCounter->counter + 1;
        $recordCounter->counter = $newRecordNumber;
        $recordCounter->save();

               $field = new FieldInquiry();
               $field->record_number = $newRecordNumber;
               $field->initiator_id = Auth::user()->id;
               $field->division_id = $request->division_id;
               $field->originator_id = Auth::user()->id;
               $field->assigned_to = $request->assigned_to;
               $field->short_description = $request->short_description;
               $field->initiation_date = $request->initiation_date;
               $field->submitted_by = $request->submitted_by;
               $field->description = $request->description;
               $field->customer_name = $request->customer_name;
               $field->type = $request->type;
               $field->priority_level = $request->priority_level;
               $field->related_urls = $request->related_urls;
               $field->due_date = $request->due_date;
               $field->country = $request->country;
               $field->city = $request->city;
               $field->state = $request->state;
               $field->zone_type = $request->zone_type;
               $field->division_code = $request->division_code;
               $field->account_type = $request->account_type;
               $field->business_area= $request->business_area;
               $field->category = $request->category;
               $field->sub_category = $request->sub_category;
               $field->broker_id = $request->broker_id;
               $field->related_inquiries = $request->related_inquiries;
               $field->comments = $request->comments;
               $field->action_taken = $request->action_taken;
               $field->status = 'Opened';
               $field->stage = 1;

               for ($i = 1; $i <= 5; $i++) {
                $documentNumberKey = "question_$i";
                $trainingDateKey = "response_$i";
                $remarkKey = "remark_$i";

                $question = $request->input($documentNumberKey) ?? $request->input(str_replace('_', '-', $documentNumberKey));
                $response = $request->input($trainingDateKey) ?? $request->input(str_replace('_', '-', $trainingDateKey));
                $remark = $request->input($remarkKey) ?? $request->input(str_replace('_', '-', $remarkKey));

                $field->$documentNumberKey = $question;
                $field->$trainingDateKey = $response;
                $field->$remarkKey = $remark;
            }

            if (!empty($request->file_attachment)) {
                $files = [];
                if ($request->hasfile('file_attachment')) {
                    foreach ($request->file('file_attachment') as $file) {
                        $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $field->file_attachment = json_encode($files);
            }

            // if (!empty($request->file_attachment)) {
            //     $files = [];
            //     if ($request->hasfile('file_attachment')) {
            //         foreach ($request->file('file_attachment') as $file) {
            //             $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
            //             $file->move('upload/', $name);
            //             $files[] = $name;
            //         }
            //     }
            //     $field->file_attachment = json_encode($files);
            // }

                $field->save();


                if (!empty($request->short_description)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'short_description';
                    $field2->previous = "Null";
                    $field2->current = $request->short_description;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->assigned_to)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'assigned_to';
                    $field2->previous = "Null";
                    $field2->current = $request->assigned_to;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }



                if (!empty($request->description)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'description';
                    $field2->previous = "Null";
                    $field2->current = $request->description;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->submitted_by)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'submitted_by';
                    $field2->previous = "Null";
                    $field2->current = $request->submitted_by;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->customer_name)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'customer_name';
                    $field2->previous = "Null";
                    $field2->current = $request->customer_name;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->type)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'type';
                    $field2->previous = "Null";
                    $field2->current = $request->type;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->related_urls)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'related_urls';
                    $field2->previous = "Null";
                    $field2->current = $request->related_urls;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }


                if (!empty($request->priority_level)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'priority_level';
                    $field2->previous = "Null";
                    $field2->current = $request->priority_level;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->country)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'country';
                    $field2->previous = "Null";
                    $field2->current = $request->country;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->due_date)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'due_date';
                    $field2->previous = "Null";
                    $field2->current = $request->due_date;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->city)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'city';
                    $field2->previous = "Null";
                    $field2->current = $request->city;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }


                if (!empty($request->state)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'state';
                    $field2->previous = "Null";
                    $field2->current = $request->state;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->zone_type)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'zone_type';
                    $field2->previous = "Null";
                    $field2->current = $request->zone_type;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }


                if (!empty($request->account_type)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'account_type';
                    $field2->previous = "Null";
                    $field2->current = $request->account_type;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->business_area)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'business_area';
                    $field2->previous = "Null";
                    $field2->current = $request->business_area;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->category)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'category';
                    $field2->previous = "Null";
                    $field2->current = $request->category;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->sub_category)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'sub_category';
                    $field2->previous = "Null";
                    $field2->current = $request->sub_category;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->broker_id)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'broker_id';
                    $field2->previous = "Null";
                    $field2->current = $request->broker_id;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }


                if (!empty($request->comments)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'comments';
                    $field2->previous = "Null";
                    $field2->current = $request->comments;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }


                if (!empty($request->related_inquiries)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'related_inquiries';
                    $field2->previous = "Null";
                    $field2->current = $request->related_inquiries;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                if (!empty($request->action_taken)) {
                    $field2 = new FieldInquiryAudit();
                    $field2->field_id = $field->id;
                    $field2->activity_type = 'action_taken';
                    $field2->previous = "Null";
                    $field2->current = $request->action_taken;
                    $field2->comment = "NA";
                    $field2->user_id = Auth::user()->id;
                    $field2->user_name = Auth::user()->name;
                    $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $field2->change_to =   "Opened";
                    $field2->change_from = "Initiator";
                    $field2->action_name = 'Create';
                    $field2->save();
                }

                toastr()->success("Lab Test is created succusfully");
                return redirect(url('rcms/qms-dashboard'));
        }


        // return view('frontend.field.field-inquiry');

        public function view($id){


            $field = FieldInquiry::findOrFail($id);
            $record_number = str_pad($field->record_number, 4, '0', STR_PAD_LEFT);
           return view('frontend.field.view-field-inquiry', compact('field','record_number'));
          }

    public function fieldUpdate(Request $request,$id)
    {

       $field1 = FieldInquiry::findOrFail($id);
       $field1->initiator_id = Auth::user()->id;
       $field1->division_id = $request->division_id;
       $field1->originator_id = Auth::user()->id;
       $field1->assigned_to = $request->assigned_to;
       $field1->short_description = $request->short_description;
       $field1->initiation_date = $request->initiation_date;
       $field1->submitted_by = $request->submitted_by;
       $field1->description = $request->description;
       $field1->customer_name = $request->customer_name;
       $field1->type = $request->type;
       $field1->priority_level = $request->priority_level;
       $field1->related_urls = $request->related_urls;
       $field1->due_date = $request->due_date;
       $field1->country = $request->country;
       $field1->city = $request->city;
       $field1->state = $request->state;
       $field1->zone_type = $request->zone_type;
       $field1->division_code = $request->division_code;
       $field1->account_type = $request->account_type;
       $field1->business_area= $request->business_area;
       $field1->category = $request->category;
       $field1->sub_category = $request->sub_category;
       $field1->broker_id = $request->broker_id;
       $field1->related_inquiries = $request->related_inquiries;
       $field1->comments = $request->comments;
       $field1->action_taken = $request->action_taken;


        for ($i = 1; $i <= 5; $i++) {
         $documentNumberKey = "question_$i";
         $trainingDateKey = "response_$i";
         $remarkKey = "remark_$i";

         $question = $request->input($documentNumberKey) ?? $request->input(str_replace('_', '-', $documentNumberKey));
         $response = $request->input($trainingDateKey) ?? $request->input(str_replace('_', '-', $trainingDateKey));
         $remark = $request->input($remarkKey) ?? $request->input(str_replace('_', '-', $remarkKey));

        $field1->$documentNumberKey = $question;
        $field1->$trainingDateKey = $response;
        $field1->$remarkKey = $remark;
     }

     if (!empty($request->file_attachment)) {
        $files = [];
        if ($request->hasfile('file_attachment')) {
            foreach ($request->file('file_attachment') as $file) {
                $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }
        $field1->file_attachment = json_encode($files);
    }

    //  if (!empty($request->file_attachment)) {
    //      $files = [];
    //      if ($request->hasfile('file_attachment')) {
    //          foreach ($request->file('file_attachment') as $file) {
    //              $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
    //              $file->move('upload/', $name);
    //              $files[] = $name;
    //          }
    //      }
    //     $field1->file_attachment = json_encode($files);
    //  }

        $field1->update();

        if (!empty($request->short_description)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'short_description';
            $field2->previous = "Null";
            $field2->current = $request->short_description;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->assigned_to)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'assigned_to';
            $field2->previous = "Null";
            $field2->current = $request->assigned_to;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }



        if (!empty($request->description)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'description';
            $field2->previous = "Null";
            $field2->current = $request->description;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->submitted_by)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'submitted_by';
            $field2->previous = "Null";
            $field2->current = $request->submitted_by;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->customer_name)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'customer_name';
            $field2->previous = "Null";
            $field2->current = $request->customer_name;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->type)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'type';
            $field2->previous = "Null";
            $field2->current = $request->type;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->related_urls)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'related_urls';
            $field2->previous = "Null";
            $field2->current = $request->related_urls;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }


        if (!empty($request->priority_level)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'priority_level';
            $field2->previous = "Null";
            $field2->current = $request->priority_level;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->country)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'country';
            $field2->previous = "Null";
            $field2->current = $request->country;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->due_date)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'due_date';
            $field2->previous = "Null";
            $field2->current = $request->due_date;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->city)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'city';
            $field2->previous = "Null";
            $field2->current = $request->city;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }


        if (!empty($request->state)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'state';
            $field2->previous = "Null";
            $field2->current = $request->state;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->zone_type)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'zone_type';
            $field2->previous = "Null";
            $field2->current = $request->zone_type;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }


        if (!empty($request->account_type)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'account_type';
            $field2->previous = "Null";
            $field2->current = $request->account_type;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->business_area)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'business_area';
            $field2->previous = "Null";
            $field2->current = $request->business_area;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->category)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'category';
            $field2->previous = "Null";
            $field2->current = $request->category;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->sub_category)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'sub_category';
            $field2->previous = "Null";
            $field2->current = $request->sub_category;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->broker_id)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'broker_id';
            $field2->previous = "Null";
            $field2->current = $request->broker_id;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }


        if (!empty($request->comments)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'comments';
            $field2->previous = "Null";
            $field2->current = $request->comments;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }


        if (!empty($request->related_inquiries)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'related_inquiries';
            $field2->previous = "Null";
            $field2->current = $request->related_inquiries;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }

        if (!empty($request->action_taken)) {
            $field2 = new FieldInquiryAudit();
            $field2->field_id = $field1->id;
            $field2->activity_type = 'action_taken';
            $field2->previous = "Null";
            $field2->current = $request->action_taken;
            $field2->comment = "NA";
            $field2->user_id = Auth::user()->id;
            $field2->user_name = Auth::user()->name;
            $field2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $field2->change_to =   "Not Applicable";
            $field2->change_from =  $field1->status;
            $field2->action_name = 'Update';
            $field2->save();
        }



         toastr()->success("Lab Test is updated succusfully");
         return redirect(url('rcms/qms-dashboard'));

    }




    public function field_sends_stage(Request $request,$id){


        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $field2 = FieldInquiry::find($id);
            $lastDocument = FieldInquiry::find($id);

        if ( $field2->stage == 1) {
            $field2->stage = "2";
            $field2->status = "  Supervisor Review";
            $field2->begin_reviewed_by = Auth::user()->name;
            $field2->begin_reviewed_on = Carbon::now()->format('d-m-y');
            $field2->reviewd_comment = $request->comment;



            $field2->update();
            toastr()->success('Document Sent');
            return back();
        }


        if ( $field2->stage == 2) {
            $field2->stage = "3";
            $field2->status = "  Closed - Complete";
            $field2->completed_by = Auth::user()->name;
            $field2->completed_on = Carbon::now()->format('d-m-y');
            $field2->completed_comment = $request->comment;

            $field2->update();
            toastr()->success('Document Sent');
            return back();
        }
        else {
            toastr()->error('E-signature Not match');
            return back();
        }
     }

    }



    public function field_Cancel(Request $request,$id){

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
             $field2 = FieldInquiry::find($id);
            $lastDocument = FieldInquiry::find($id);

            if ( $field2->stage == 1) {
                 $field2->stage = "0";
                 $field2->status = "Closed-Cancelled";
                 $field2->cancel_by = Auth::user()->name;
                 $field2->cancel_on = Carbon::now()->format('d-m-y');
                 $field2->viewcomment = $request->comment;

                 $field2->update();
                toastr()->success('Document Sent');
                return back();
            }

            if ( $field2->stage == 2) {
                 $field2->stage = "3";
                 $field2->status = "Closed - Done";
                 $field2->closed_by = Auth::user()->name;
                 $field2->closed_on = Carbon::now()->format('d-m-y');

                 $field2->update();
                toastr()->success('Document Sent');
                return back();
            }

        }
    }



    public function fieldAuditTrail($id){

        $audit = FieldInquiryAudit::where('field_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = FieldInquiry::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');
        return view('frontend.field.field_inquiry_auditTrail', compact('audit', 'document', 'today'));

    }


    public function fieldauditReport($id)
    {


        $doc = FieldInquiry::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = FieldInquiryAudit::where('field_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.field.field_auditReport', compact('data', 'doc'))
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


    public function fieldAuditDetails($id){

        $detail = FieldInquiryAudit::find($id);
        $detail_data = FieldInquiryAudit::where('activity_type', $detail->activity_type)->where('field_id', $detail->field_id)->latest()->get();
        $doc = FieldInquiry::where('id', $detail->field_id)->first();
        // $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.field.field_inquiry_auditDetails', compact('detail', 'doc', 'detail_data'));

    }

    public function fieldauditSingleReport($id){
            $data = FieldInquiry::find($id);

            if (!empty($data)) {
                $data->originator = User::where('id', $data->initiator_id)->value('name');

                $doc = FieldInquiryAudit::where('field_id', $data->id)->first();
                $detail_data = FieldInquiryAudit::where('activity_type', $data->activity_type)
                    ->where('field_id', $data->field_id)
                    ->latest()
                    ->get();

                // pdf related work
                $pdf = App::make('dompdf.wrapper');
                $time = Carbon::now();
                $pdf = PDF::loadview('frontend.field.field_singleReport', compact(
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
                    return $pdf->stream('Field Inquiry' . $id . '.pdf');

            }

            return redirect()->back()->with('error', 'Field Inquiry not found.');
        }


    }


