<?php

namespace App\Http\Controllers\newForm;


use App\Models\QualityFollowup;
use App\Models\QualityAuditTrail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\RoleGroup;

// use App\Http\Controllers\newForm\User;
use Illuminate\Support\Facades\Auth;
use App\Models\RecordNumber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use PDF;

class QualityFollolwupController extends Controller
{
    public function index()
    {
        $old_record = QualityFollowup::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');



        // $registrations = MedicalDeviceRegistration::all();
        return view('frontend.New_forms.qualityFollowup', compact('old_record', 'record_number', 'formattedDate', 'currentDate', 'due_date'));
    }


    public function qualityFollowCreate(Request $request)
    {


        //dd($request);
        // $request->validate([
        //     'record_number' => 'required|string|max:255',
        //     'date_of_initiation' => 'required|date',
        //     'assign_to' => 'required|string|max:255',
        //     'due_date_gi' => 'required|date',
        //     'short_description' => 'nullable|string',
        //     'registration_type_gi' => 'required|string|max:255',
        //     'file_attachment_gi' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // example for file validation
        //     'parent_record_number' => 'nullable|string|max:255',
        //     'local_record_number' => 'nullable|string|max:255',
        //     'zone_departments' => 'nullable|string|max:255',
        //     'country_number' => 'nullable|string|max:255',
        //     'regulatory_departments' => 'nullable|string|max:255',
        //     'registration_number' => 'nullable|string|max:255',
        //     'risk_based_departments' => 'nullable|string|max:255',
        //     'device_approval_departments' => 'nullable|string|max:255',
        //     'marketing_auth_number' => 'nullable|string|max:255',
        //     'manufacturer_number' => 'nullable|string|max:255',show
        //     'audit_agenda_grid' => 'nullable|string|max:255',
        //     'manufacturing_description' => 'nullable|string|max:255',
        //     'dossier_number' => 'nullable|string|max:255',
        //     'dossier_departments' => 'nullable|string|max:255',
        //     'description' => 'nullable|string',
        //     'planned_submission_date' => 'nullable|date',
        //     'actual_submission_date' => 'nullable|date',
        //     'actual_approval_date' => 'nullable|date',
        //     'actual_rejection_date' => 'nullable|date',
        //     'renewal_departments' => 'nullable|string|max:255',
        //     'next_renewal_date' => 'nullable|date',
        // ]);



       $data = new  QualityFollowup();
       $data->type = "QualityFollowup";
       $data->record = ((RecordNumber::first()->value('counter')) + 1);
       $data->initiator_id = Auth::user()->id;


        if (!empty($request->attachment)) {
            $files = [];
            if ($request->hasfile('attachment')) {
                foreach ($request->file('attachment') as $file) {
                    $name = $request->name . 'attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $data->attachment = json_encode($files);
        }


        // dd($request->all());
        $data->initiator_id = Auth::user()->id;
        $data->division_id = $request->division_id;
        $data->stage = $request->stage;
        $data->status = $request->status;
        $data->acknowledge_by = $request->acknowledge_by;
        $data->acknowledge_on = $request->acknowledge_on;
        $data->type = "QualityFollowUp";

       // $data->record = $request->record;
        $data->date_of_initiation = $request->date_of_initiation;
        $data->product = $request->product;
        $data->assign_to = $request->assign_to;
        $data->due_date = $request->due_date;
        $data->short_description = $request->short_description;
        $data->product_type = $request->product_type;
        $data->priority_level = $request->priority_level;
        // $data->file_attachment_gi = $request->file_attachment_gi;
        $data->discription = $request->discription;
        $data->comments = $request->comments;
        if (is_array($request->scheduled_start_date)) {
            // Assuming you want to join the array elements into a single string
            $data->scheduled_start_date = implode(', ', $request->scheduled_start_date);
        } else {
            // Directly assign if it's already a string
            $data->scheduled_start_date = $request->scheduled_start_date;
        }
        if (is_array($request->scheduled_end_date)) {
            // Assuming you want to join the array elements into a single string
            $data->scheduled_start_date = implode(', ', $request->scheduled_end_date);
        } else {
            // Directly assign if it's already a string
            $data->scheduled_end_date = $request->scheduled_end_date;
        }

        $data->file_attachment = $request->file_attachment;
        $data->related_url = $request->related_url;
        $data->related_record = $request->related_record;
        $data->quality_follow_up_summary = $request->quality_follow_up_summary;






        if (!empty($request->file_attachment)) {
            $files = [];
            if ($request->hasfile('file_attachment')) {
                foreach ($request->file('file_attachment') as $file) {
                    $name = $request->name . 'file_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $data->file_attachment = json_encode($files);
        }

        // if (!empty ($request->file_attachment_gi)) {
        //     $files = [];

        //     if ($request->hasfile('file_attachment_gi')) {
        //         foreach ($request->file('file_attachment_gi') as $file) {
        //             $name = time() . '_' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        //             $file->move(public_path('upload'), $name);
        //             $files[] = $name;
        //         }
        //     }

        //     $data->file_attachment_gi = json_encode($files);
        // }
        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();
        $data->status = 'Opened';
        $data->stage = 1;
        $data->save();
        //  dd($data);



                // if (!empty($request->division_id)) {
                //     $history = new QualityAuditTrail();
                //     $history->root_id = $data->id;
                //     $history->activity_type = 'Division Id';
                //     $history->previous = "Null";
                //     $history->current = $data->division_id;
                //     $history->comment = "Not Applicable";
                //     $history->user_id = Auth::user()->id;
                //     $history->user_name = Auth::user()->name;
                //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                //     $history->origin_state = $data->status;
                //     $history->change_from ="Initiator";
                //     $history->change_to ="Opened";
                //     $history->action_name = "Create";
                //     $history->save();
                //     }

                if (!empty($data->short_description)) {
                    // dd($request->short_description);
                    $history = new QualityAuditTrail();
                    $history->root_id = $data->id;
                    $history->activity_type = 'Short Discription';
                    $history->previous = "Null";
                    $history->current = $data->short_description;
                    $history->comment = "Not Applicable";
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $data->status;
                     $history->change_from ="Initiation";
                     $history->change_to ="Opened";
                    $history->action_name = "Create";
                    $history->save();
                }


        if (!empty($data->record_number)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Record Number';
            $history->previous = "Null";
            $history->current = $data->record_number;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }


        if (!empty($data->assign_to)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Assign To';
            $history->previous = "Null";
            $history->current = $data->assign_to;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }




        if (!empty($data->due_date)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = $data->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }



        if (!empty($data->product_type)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Type Of Product';
            $history->previous = "Null";
            $history->current = $data->product_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }




        if (!empty($data->discription)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Discription';
            $history->previous = "Null";
            $history->current = $data->discription;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->comments)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Comments';
            $history->previous = "Null";
            $history->current = $data->comments;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->scheduled_start_date)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Scheduled Start Date';
            $history->previous = "Null";
            $history->current = $data->scheduled_start_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($data->scheduled_end_date)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Scheduled End Date';
            $history->previous = "Null";
            $history->current = $data->scheduled_end_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->file_attachment)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'File Attachment';
            $history->previous = "Null";
            $history->current = $data->file_attachment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->related_url)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Related Urls';
            $history->previous = "Null";
            $history->current = $data->related_url;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->related_record)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Related Record';
            $history->previous = "Null";
            $history->current = $data->related_record;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($data->product)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Product';
            $history->previous = "Null";
            $history->current = $data->product;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->priority_level)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Priority Level';
            $history->previous = "Null";
            $history->current = $data->priority_level;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }
        if (!empty($data->intiation_date)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = ' Date Of Intiation';
            $history->previous = "Null";
            $history->current = $data->intiation_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }

        if (!empty($data->quality_follow_up_summary)) {
            $history = new QualityAuditTrail();
            $history->root_id = $data->id;
            $history->activity_type = 'Quality Follow Up Summary';
            $history->previous = "Null";
            $history->current = $data->quality_follow_up_summary;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $data->status;
             $history->change_from ="Initiation";
             $history->change_to ="Opened";
            $history->action_name = "Create";
            $history->save();
        }

        toastr()->success("QualityFOllow Up is created succusfully");
        return redirect(url('rcms/qms-dashboard'));


    }


    public function qualityFollowShow($id)
    {
        // dd($id);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        $data = QualityFollowup::find($id);

        // dd($data);
        // $audit =QualityFollowup::where('parent_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $today = Carbon::now()->format('d-m-y');
        $document = QualityFollowup::where('id', $id)->first();
        $old_record = QualityFollowup::select('id', 'division_id', 'record_number')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        //  $document->initiator = User::where('id', $document->initiator_id)->value('name');
        return view('frontend.QualityFollowUp.view',  compact('data','old_record', 'record_number', 'formattedDate', 'currentDate', 'due_date'));
    }


    public function qualityfollowUpdate(Request $request, $id)
    {
        $lastData =  QualityFollowup::find($id);
        $data =  QualityFollowup::find($id);

        $data->initiator_id = Auth::user()->id;

        $data->division_id = $request->division_id;

        // $data->stage = $request->stage;
        // $data->status = $request->status;
        $data->acknowledge_by = $request->acknowledge_by;
        $data->acknowledge_on = $request->acknowledge_on;

       // $data->record_number = $request->record_number;
        $data->date_of_initiation = $request->date_of_initiation;
        $data->product = $request->product;
        $data->assign_to = $request->assign_to;
        $data->due_date = $request->due_date;
        $data->short_description = $request->short_description;
        $data->product_type = $request->product_type;
        $data->priority_level = $request->priority_level;
        // $data->file_attachment_gi = $request->file_attachment_gi;
        $data->discription = $request->discription;
        $data->comments = $request->comments;
        $data->scheduled_start_date = $request->scheduled_start_date;
        $data->scheduled_end_date = $request->scheduled_end_date;
      //  $data->file_attachment = $request->file_attachment;
        $data->related_url = $request->related_url;
        $data->related_record = $request->related_record;
        $data->quality_follow_up_summary = $request->quality_follow_up_summary;
        // if ($request->hasfile('attach_files1')) {
        //     $image = $request->file('attach_files1');
        //     $ext = $image->getClientOriginalExtension();
        //     $image_name = date('y-m-d') . '-' . rand() . '.' . $ext;
        //     $image->move('upload/document/', $image_name);
        //     $data->attach_files1 = $image_name;
        // }

        if ($request->hasFile('file_attachment')) {
            $attachments = [];
            foreach ($request->file('file_attachment') as $file) {
                $filename = $file->getClientOriginalName();
                $file->move(public_path('upload'), $filename);
                $attachments[] = $filename;
            }
            $data->file_attachment = json_encode($attachments);
        }

        // Save other data
        // $data->other_field = $request->other_field; // Add other fields as necessary






        // // $data->recomendation_capa_date_due = $request->recomendation_capa_date_due;
        // // $data->non_compliance = $request->non_compliance;
        // // $data->recommend_action = $request->recommend_action;
        // // $data->date_Response_due2 = $request->date_Response_due2;
        // // $data->capa_date_due = $request->capa_date_due11;
        // // $data->assign_to2 = $request->assign_to2;
        // // $data->cro_vendor = $request->cro_vendor;
        // // $data->comments = $request->comments;
        // // $data->impact = $request->impact;
        // // $data->impact_analysis = $request->impact_analysis;
        // // $data->severity_rate = $request->severity_rate;
        // // $data->occurrence = $request->occurrence;
        // // $data->detection = $request->detection;
        // // $data->analysisRPN = $request->analysisRPN;
        // // $data->actual_start_date = $request->actual_start_date;
        // // $data->actual_end_date = $request->actual_end_date;
        // // $data->action_taken = $request->action_taken;

        // //  $data->date_response_due1 = $request->date_Response_due22;
        // // // $data->date_response_due1 = $request->date_response_due1;
        // // $data->response_date = $request->response_date;
        // // // $data->attach_files2 = $request->attach_files2;
        // // $data->related_url = $request->related_url;
        // // $data->response_summary = $request->response_summary;

        // // // if ($request->hasfile('related_observations')) {
        // // //     $image = $request->file('related_observations');
        // // //     $ext = $image->getClientOriginalExtension();
        // // //     $image_name = date('y-m-d') . '-' . rand() . '.' . $ext;
        // // //     $image->move('upload/document/', $image_name);
        // // //     $data->related_observations = $image_name;
        // // // }
        // // if (!empty($request->related_observations)) {
        // //     $files = [];
        // //     if ($request->hasfile('related_observations')) {
        // //         foreach ($request->file('related_observations') as $file) {
        // //             $name = $request->name . 'related_observations' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        // //             $file->move('upload/', $name);
        // //             $files[] = $name;
        // //         }
        // //     }

        // //     $data->related_observations = json_encode($files);
        // // }
        // // // if ($request->hasfile('attach_files2')) {
        // // //     $image = $request->file('attach_files2');
        // // //     $ext = $image->getClientOriginalExtension();
        // // //     $image_name = date('y-m-d') . '-' . rand() . '.' . $ext;
        // // //     $image->move('upload/document/', $image_name);
        // // //     $data->attach_files2 = $image_name;
        // // // }
        // // if (!empty($request->attach_files2)) {
        // //     $files = [];
        // //     if ($request->hasfile('attach_files2')) {
        // //         foreach ($request->file('attach_files2') as $file) {
        // //             $name = $request->name . 'attach_files2' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
        // //             $file->move('upload/', $name);
        // //             $files[] = $name;
        // //         }
        // //     }

        // //     $data->attach_files2 = json_encode($files);
        // // }

        // $data->status = 'Opened';
        // $data->stage = 1;
        $data->update();
        // if ($lastData->division_id != $data->initiated_by || !empty ($request->comment)) {
        //     // return 'history';
        //     $history = new QualityAuditTrail;
        //     $history->root_id = $id;
        //     $history->activity_type = 'Division id';
        //     $history->previous = $lastData->division_id;
        //     $history->current = $data->division_id;
        //     $history->comment = $request->comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastData->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastData->status;
        //     $history->action_name = 'Update';
        //     $history->save();
        // }

        if ($lastData->short_description != $data->short_description || ! empty($request->short_description_comment)) {
            $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                ->where('activity_type', 'Short Description')
                ->exists();
            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id= $id;
                $history->activity_type = 'Short Description';
                $history->previous = $lastData->short_description;
                $history->current = $data->short_description;
                $history->comment = $request->short_description_comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to = 'Not Applicable';
                $history->change_from = $lastData->status;
                $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';

                $history->save();
        }

            if ($lastData->department_code != $data->department_code || ! empty($request->department_code_comment)) {
                $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Department Code')
                    ->exists();
            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id = $id;
            $history->activity_type = 'Department Code';
            $history->previous = $lastData->department_code;
            $history->current = $data->department_code;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
            $history->save();
        }


            if ($lastData->initiator_id != $data->initiator_id || ! empty($request->initiator_id_comment)) {
                $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Initiator')
                    ->exists();

            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id = $id;
            $history->activity_type = 'Initiator';
            $history->previous = $lastData->initiator_id;
            $history->current = $data->initiator_id;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
            $history->save();
        }


        //     if ($lastData->date_of_initiation != $data->date_of_initiation || ! empty($request->date_of_initiation_comment)) {
        //         $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
        //             ->where('activity_type', 'Date Of Initiation')
        //             ->exists();
        //     // return 'history';
        //     $history = new QualityAuditTrail;
        //     $history->root_id = $id;
        //     $history->activity_type = 'Date Of Initiation';
        //     $history->previous = $lastData->date_of_initiation;
        //     $history->current = $data->date_of_initiation;
        //     $history->comment = $request->comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastData->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastData->status;
        //     $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
        //     $history->save();
        // }


            if ($lastData->product != $data->product || ! empty($request->product_comment)) {
                $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Product')
                    ->exists();
            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id = $id;
            $history->activity_type = 'Product';
            $history->previous = $lastData->product;
            $history->current = $data->product;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
            $history->save();
        }


            if ($lastData->assign_to != $data->assign_to || ! empty($request->assign_to_comment)) {
                $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Assign To')
                    ->exists();
            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id = $id;
            $history->activity_type = 'Assign To';
            $history->previous = $lastData->assign_to;
            $history->current = $data->assign_to;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
            $history->save();
        }


            if ($lastData->due_date != $data->due_date || ! empty($request->due_date_comment)) {
                $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Due Date')
                    ->exists();
            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id = $id;
            $history->activity_type = 'Due Date';
            $history->previous = $lastData->due_date;
            $history->current = $data->due_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
            $history->save();
        }


            if ($lastData->product_type != $data->product_type || ! empty($request->product_type_comment)) {
                $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Type of Product')
                    ->exists();
            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id = $id;
            $history->activity_type = 'Type Of Product';
            $history->previous = $lastData->product_type;
            $history->current = $data->product_type;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
            $history->save();
        }


            if ($lastData->priority_level != $data->priority_level || ! empty($request->priority_level_comment)) {
                $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                    ->where('activity_type', 'priority Level')
                    ->exists();
            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id = $id;
            $history->activity_type = 'Priority Level';
            $history->previous = $lastData->priority_level;
            $history->current = $data->priority_level;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
            $history->save();
        }

            if ($lastData->comments != $data->comments || ! empty($request->comments_comment)) {
                $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Comments')
                    ->exists();
            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id = $id;
            $history->activity_type = 'Comments';
            $history->previous = $lastData->comments;
            $history->current = $data->comments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                    $history->save();
        }

            if ($lastData->scheduled_start_date != $data->scheduled_start_date || ! empty($request->comment)) {
                $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Scheduled Start Date')
                    ->exists();
            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id = $id;
            $history->activity_type = 'Scheduled Start Date';
            $history->previous = $lastData->scheduled_start_date;
            $history->current = $data->scheduled_start_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
               $history->save();
        }

            if ($lastData->scheduled_end_date  != $data->scheduled_end_date  || ! empty($request->comment)) {
                $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Scheduled End Date')
                    ->exists();
            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id = $id;
            $history->activity_type = 'Scheduled End Date';
            $history->previous = $lastData->scheduled_end_date;
            $history->current = $data->scheduled_end_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                        $history->save();
        }

        // if ($lastData->file_attachment != $data->file_attachment || !empty ($request->comment)) {
        //     // return 'history';
        //     $history = new QualityAuditTrail;
        //     $history->root_id = $id;
        //     $history->activity_type = 'HOD Attachments';
        //     $history->previous = $lastData->file_attachment;
        //     $history->current = $data->file_attachment;
        //     $history->comment = $request->comment;
        //     $history->user_id = Auth::user()->id;
        //     $history->user_name = Auth::user()->name;
        //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        //     $history->origin_state = $lastData->status;
        //     $history->change_to =   "Not Applicable";
        //     $history->change_from = $lastData->status;
        //     $history->action_name = 'Update';
        //     $history->save();
        // }


            if ($lastData->related_url  != $data->related_url  || ! empty($request->related_url_comment)) {
                $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Related URLs')
                    ->exists();
            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id = $id;
            $history->activity_type = 'Related URLs';
            $history->previous = $lastData->related_url;
            $history->current = $data->related_url;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                        $history->save();
        }

            if ($lastData->related_record  != $data->related_record  || ! empty($request->related_record_comment)) {
                $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Related Records')
                    ->exists();
            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id = $id;
            $history->activity_type = 'Related Records';
            $history->previous = $lastData->related_record;
            $history->current = $data->related_record;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                        $history->save();
        }

            if ($lastData->Remarks  != $data->Remarks  || ! empty($request->Remarks_comment)) {
                $lastDataAudittrail  = QualityAuditTrail::where('root_id', $data->id)
                    ->where('activity_type', 'Remark')
                    ->exists();
            // return 'history';
            $history = new QualityAuditTrail;
            $history->root_id = $id;
            $history->activity_type = ' Remark';
            $history->previous = $lastData->quality_follow_up_summary;
            $history->current = $data->quality_follow_up_summary;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastData->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastData->status;
            $history->action_name = $lastDataAudittrail  ? 'Update' : 'New';
                $history->save();
        }

        toastr()->success("QualityFOllow Up is created succusfully");
        return back();
    }





    public function quality_send_stage(Request $request, $id)
    {


        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $data = QualityFollowup::find($id);
            $lastData = QualityFollowup::find($id);

            if ($data->stage == 1) {
                $data->stage = "2";
                $data->status = "Work In Progress";
                $data->acknowledge_by = Auth::user()->name;
                $data->acknowledge_on = Carbon::now()->format('d-M-Y');

                    $history = new QualityAuditTrail();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action = 'Submit';
                $history->previous = $lastData->Approve_Sample_by;
                $history->current = $data->Approve_Sample_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to = 'Work In Progress';
                $history->change_from = $lastData->status;
                $history->action_name = 'Not Applicable';
                   $history->stage= "Submit";
            $history->action = "Submit";
            $history->save();
                //     $list = Helpers::getQAUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $data->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {


                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $data],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document sent ".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $data->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($data->stage == 2) {
                $data->stage = "3";
                $data->status = 'Pending Approval';
                $data->Complete_by = Auth::user()->name;
                $data->Complete_on = Carbon::now()->format('d-M-Y');

                $history = new QualityAuditTrail();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action = 'Submit';
                $history->previous = $lastData->Complete_by;
                $history->current = $data->Complete_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to = 'Pending Approval';
                $history->change_from = $lastData->status;
                $history->action_name = 'Not Applicable';
                $history->stage= "Submit";
                $history->action_name = "Submit";
            $history->save();

                //     $list = Helpers::getQAUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $root->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {


                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $root],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document sent ".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $data->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($data->stage == 3) {
                $data->stage = "4";
                $data->status = "Quality Approval";
                $data->Quality_Approval_by = Auth::user()->name;
                $data->Quality_Approval_on = Carbon::now()->format('d-M-Y');

                $history = new QualityAuditTrail();
                $history->root_id = $id;
                $history->activity_type = 'Activity Log';
                $history->action = 'Submit';
                $history->previous = $lastData->Quality_Approval_by;
                $history->current = $data->Quality_Approval_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastData->status;
                $history->change_to = 'Quality Approval';
                $history->change_from = $lastData->status;
                $history->action_name = 'Not Applicable';
                $history->stage= "Submit";
                $history->action_name = "Submit";
            $history->save();
                //     $list = Helpers::getQAUserList();
                //     foreach ($list as $u) {
                //         if($u->q_m_s_divisions_id == $root->division_id){
                //             $email = Helpers::getInitiatorEmail($u->user_id);
                //              if ($email !== null) {


                //               Mail::send(
                //                   'mail.view-mail',
                //                    ['data' => $root],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Document sent ".Auth::user()->name);
                //                 }
                //               );
                //             }
                //      }
                //   }
                $data->update();
                toastr()->success('Document Sent');
                return back();
            }
            // if ($root->stage == 4) {
            //     $root->stage = "5";
            //     $root->status = 'CFT Review';
            //     $root->report_result_by = Auth::user()->name;
            //     $root->report_result_on = Carbon::now()->format('d-M-Y');
            //     $history = new QualityAuditTrail();
            //     $history->root_id = $id;
            //     $history->activity_type = 'Activity Log';
            //     $history->previous = $lastDocument->submitted_by;
            //     $history->current = $root->submitted_by;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->stage='';
            //     $history->save();
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {


            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      }
            //   }
            // $data->update();
            // toastr()->success('Document Sent');
            // return back();
            // }
            // if ($root->stage == 5) {
            //     $root->stage = "6";
            //     $root->status = "QA Approve Review";
            //     $root->qA_review_complete_by = Auth::user()->name;
            //     $root->qA_review_complete_on = Carbon::now()->format('d-M-Y');
            //     $history = new QualityAuditTrail();
            //     $history->root_id = $id;
            //     $history->activity_type = 'Activity Log';
            //     $history->previous = $lastDocument->qA_review_complete_by;
            //     $history->current = $root->qA_review_complete_by;
            //     $history->comment = $request->comment;
            //     $history->user_id = Auth::user()->id;
            //     $history->user_name = Auth::user()->name;
            //     $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            //     $history->origin_state = $lastDocument->status;
            //     $history->stage='';
            //     $history->save();
            //     $list = Helpers::getQAUserList();
            //     foreach ($list as $u) {
            //         if($u->q_m_s_divisions_id == $root->division_id){
            //             $email = Helpers::getInitiatorEmail($u->user_id);
            //              if ($email !== null) {


            //               Mail::send(
            //                   'mail.view-mail',
            //                    ['data' => $root],
            //                 function ($message) use ($email) {
            //                     $message->to($email)
            //                         ->subject("Document sent ".Auth::user()->name);
            //                 }
            //               );
            //             }
            //      }
              }

            //  $data->update();
            // toastr()->success('Document Sent');
            // return back();
        }

        // $history->origin_state = $lastDocument->status;
        //         $history->stage='';
        //         $history->save();
        //         $list = Helpers::getQAUserList();
        //         foreach ($list as $u) {
        //             if($u->q_m_s_divisions_id == $data->division_id){
        //                 $email = Helpers::getInitiatorEmail($u->user_id);
        //                  if ($email !== null) {


        //                   Mail::send(
        //                       'mail.view-mail',
        //                        ['data' => $root],
        //                     function ($message) use ($email) {
        //                         $message->to($email)
        //                             ->subject("Document sent ".Auth::user()->name);
        //                     }
        //                   );
        //                 }
        //          }
        //       }
        //         $root->update();
        //         toastr()->success('Document Sent');
        //         return back();
          // }




    public function quality_send2(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $data = QualityFollowup::find($id);
            $lastData = QualityFollowup::find($id);


            if ($data->stage == 3) {
                $data->stage = "2";
                $data->status = "Reject";
               $data->Reject_by = Auth::user()->name;
               $data->Reject_by = Carbon::now()->format('d-M-Y');

               $history = new QualityAuditTrail();
               $history->root_id = $id;
               $history->activity_type = 'Activity Log';
               $history->action = 'Submit';
               $history->previous = $lastData->Reject_by;
               $history->current = $data->Reject_by;
               $history->comment = $request->comment;
               $history->user_id = Auth::user()->id;
               $history->user_name = Auth::user()->name;
               $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
               $history->origin_state = $lastData->status;
               $history->change_to = 'Reject';
               $history->change_from = $lastData->status;
               $history->action_name = 'Not Applicable';
               $history->stage= "Submit";
               $history->action_name = "Submit";
           $history->save();

            }

        }}
    public function QualityFollowupAuditTrialDetails($id)
    {
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');

        $audit = QualityAuditTrail::where('root_id', $id)->orderByDESC('id')->paginate(5);
        $today = Carbon::now()->format('d-m-y');
        $document = QualityFollowup::where('id', $id)->first();
        $document->originator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.QualityFollowUp.AuditTrailQualityFollowup', compact('audit', 'document', 'today'));
    }

    public function singleReports(Request $request, $id){
        $data = QualityFollowup::find($id);
        // $data = QualityFollowup::where(['id' => $id, 'identifier' => 'details'])->first();
        if (!empty($data)) {
            // $data->data = QualityFollowup::where('id', $id)->where('identifier', "details")->first();
            // $data->Instruments_Details = ErrataGrid::where('e_id', $id)->where('type', "Instruments_Details")->first();
            // $data->Material_Details = Erratagrid::where('e_id', $id)->where('type', "Material_Details")->first();
            // dd($data->all());
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.QualityFollowUp.singleReport', compact('data'))
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
            return $pdf->stream('errata' . $id . '.pdf');
        }
    }

    public function auditTrailPdf($id){
        $doc = QualityFollowup::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = QualityAuditTrail::where('root_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.QualityFollowUp.AuditTrail_pdf', compact('data', 'doc'))
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


