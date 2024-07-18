<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CTAAmendement;
use App\Models\RecordNumber;
use App\Models\User;
use App\Models\RoleGroup;
use App\Models\QMSDivision;
use App\Models\CTAAmendementGrid;
use App\Models\CTAAmendementAuditTrail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use PDF;

class CTAAmendementController extends Controller
{

           public function index(){

                    $old_record = CTAAmendement::select('id', 'division_id', 'record')->get();
                    $record_number = ((RecordNumber::first()->value('counter')) + 1);
                    $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
                    $users = User::all();
                    $qmsDevisions = QMSDivision::all();
                    //dd($qmsDevisions);

                    //due date
                    $currentDate = Carbon::now();
                    $formattedDate = $currentDate->addDays(30);
                    $due_date = $formattedDate->format('Y-m-d');

                    return view('frontend.ctms.cta_amendement',compact('old_record','record_number','users','qmsDevisions','due_date'));
                 }

           public function store(Request $request){
                //dd($request->all());

                    $recordCounter = RecordNumber::first();
                    $newRecordNumber = $recordCounter->counter + 1;

                    $recordCounter->counter = $newRecordNumber;
                    $recordCounter->save();

                    $amendement = new CTAAmendement();
                    $amendement->form_type = "CTA-Amendement";
                    $amendement->record = $newRecordNumber;
                    $amendement->initiator_id = Auth::user()->id;
                    $amendement->division_id = $request->division_id;
                    $amendement->division_code = $request->division_code;
                    $amendement->intiation_date = $request->intiation_date;
                    $amendement->due_date = $request->due_date;
                    $amendement->parent_id = $request->parent_id;
                    $amendement->parent_type = $request->parent_type;
                    $amendement->short_description = $request->short_description;
                    $amendement->assigned_to = $request->assigned_to;
                    $amendement->type = $request->type;
                    $amendement->other_type = $request->other_type;

                    if (!empty ($request->attached_files)) {
                        $files = [];
                        if ($request->hasfile('attached_files')) {
                            foreach ($request->file('attached_files') as $file) {
                                $name = $request->name . 'attached_files' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                                $file->move('upload/', $name);
                                $files[] = $name;
                            }
                        }


                        $amendement->attached_files = $files;
                    }

                    $amendement->description = $request->description;
                    $amendement->zone = $request->zone;
                    $amendement->country = $request->country;
                    $amendement->state = $request->state;
                    $amendement->city = $request->city;

                    //Amendement Information
                    $amendement->procedure_number = $request->procedure_number;
                    $amendement->project_code = $request->project_code;
                    $amendement->registration_number = $request->registration_number;
                    $amendement->other_authority = $request->other_authority;
                    $amendement->authority_type = $request->authority_type;
                    $amendement->authority = $request->authority;
                    $amendement->year = $request->year;
                    $amendement->registration_status = $request->registration_status;
                    $amendement->car_clouser_time_weight = $request->car_clouser_time_weight;
                    $amendement->outcome = $request->outcome;
                    $amendement->trade_name = $request->trade_name;
                    $amendement->estimated_man_hours = $request->estimated_man_hours;
                    $amendement->comments = $request->comments;

                    //Product Information
                    $amendement->manufacturer = $request->manufacturer;

                    //Important Dates
                    $amendement->actual_submission_date = $request->actual_submission_date;
                    $amendement->actual_rejection_date = $request->actual_rejection_date;
                    $amendement->actual_withdrawn_date = $request->actual_withdrawn_date;
                    $amendement->car_clouser_time_weight = $request->car_clouser_time_weight;
                    $amendement->inquiry_date = $request->inquiry_date;
                    $amendement->planned_submission_date = $request->planned_submission_date;
                    $amendement->planned_date_sent_to_affiliate = $request->planned_date_sent_to_affiliate;
                    $amendement->effective_date = $request->effective_date;

                    //Person Involved
                    $amendement->additional_assignees = $request->additional_assignees;
                    $amendement->additional_investigators = $request->additional_investigators;
                    $amendement->approvers = $request->approvers;
                    $amendement->negotiation_team = $request->negotiation_team;
                    $amendement->trainer = $request->trainer;

                    //Root Cause
                    $amendement->root_cause_description = $request->root_cause_description;
                    $amendement->reason_for_non_approval = $request->reason_for_non_approval;
                    $amendement->reason_for_withdrawal = $request->reason_for_withdrawal;
                    $amendement->justification_rationale = $request->justification_rationale;
                    $amendement->meeting_minutes = $request->meeting_minutes;
                    $amendement->rejection_reason = $request->rejection_reason;
                    $amendement->effectiveness_check_summary = $request->effectiveness_check_summary;
                    $amendement->decision = $request->decision;
                    $amendement->summary = $request->summary;
                    $amendement->documents_affected = $request->documents_affected;
                    $amendement->actual_time_spend = $request->actual_time_spend;
                    $amendement->documents = $request->documents;
                    $amendement->stage = '1';
                    $amendement->status = 'Opened';

                    $amendement->save();


                    //Grid Store

                    $g_id = $amendement->id;
                    $newDataGridAmendement = CTAAmendementGrid::where(['cta_amendement_id' => $g_id, 'identifier' => 'product_material'])->firstOrCreate();
                    $newDataGridAmendement->cta_amendement_id = $g_id;
                    $newDataGridAmendement->identifier = 'product_material';
                    $newDataGridAmendement->data = $request->product_material;
                    $newDataGridAmendement->save();


                //Audit Trail Store Start

                if(!empty($request->short_description)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->short_description;
                    $history->activity_type = 'Short Description';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->assigned_to)){

                    $assigned_to_name = User::where('id', $request->assigned_to)->value('name');

                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $assigned_to_name;
                    $history->activity_type = 'Assigned To';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->due_date)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = date('d-M-Y', strtotime($request->due_date));
                    $history->activity_type = 'Date Due';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->type)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->type;
                    $history->activity_type = 'Type';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->other_type)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->other_type;
                    $history->activity_type = 'Other Type';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($amendement->attached_files)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = json_encode($amendement->attached_files);
                    $history->activity_type = 'Attached Files';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->description)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->description;
                    $history->activity_type = 'Description';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->zone)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->zone;
                    $history->activity_type = 'Zone';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->country)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->country;
                    $history->activity_type = 'Country';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->state)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->state;
                    $history->activity_type = 'State/District';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->city)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->city;
                    $history->activity_type = 'City';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->procedure_number)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->procedure_number;
                    $history->activity_type = 'Procedure Number';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->project_code)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->project_code;
                    $history->activity_type = 'Project Code';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->registration_number)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->registration_number;
                    $history->activity_type = 'Registration Number';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->other_authority)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->other_authority;
                    $history->activity_type = 'Other Authority';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->authority_type)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->authority_type;
                    $history->activity_type = 'Authority Type';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->authority)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->authority;
                    $history->activity_type = 'Authority';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->year)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->year;
                    $history->activity_type = 'Year';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->registration_status)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->registration_status;
                    $history->activity_type = 'Registration Status';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->car_clouser_time_weight)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->car_clouser_time_weight;
                    $history->activity_type = 'CAR Clouser Time Weight';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->outcome)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->outcome;
                    $history->activity_type = 'Outcome';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->trade_name)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->trade_name;
                    $history->activity_type = 'Trade Name';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->estimated_man_hours)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->estimated_man_hours;
                    $history->activity_type = 'Estimated Man-Hours';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->comments)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->comments;
                    $history->activity_type = 'Comments';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->manufacturer)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->manufacturer;
                    $history->activity_type = 'Manufacturer';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->actual_submission_date)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->actual_submission_date;
                    $history->activity_type = 'Actual Submission Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->actual_rejection_date)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->actual_rejection_date;
                    $history->activity_type = 'Actual Rejection Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->actual_withdrawn_date)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->actual_withdrawn_date;
                    $history->activity_type = 'Actual Withdrawn Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->inquiry_date)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->inquiry_date;
                    $history->activity_type = 'Inquiry Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->planned_submission_date)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->planned_submission_date;
                    $history->activity_type = 'Planned Submission Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->planned_date_sent_to_affiliate)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->planned_date_sent_to_affiliate;
                    $history->activity_type = 'Planned Date Sent To Affiliate';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->effective_date)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->effective_date;
                    $history->activity_type = 'Effective Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->additional_assignees)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->additional_assignees;
                    $history->activity_type = 'Additional Assignees';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->additional_investigators)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->additional_investigators;
                    $history->activity_type = 'Additional Investigators';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->approvers)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->approvers;
                    $history->activity_type = 'Approvers';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->negotiation_team)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->negotiation_team;
                    $history->activity_type = 'Negotiation Team';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->trainer)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->trainer;
                    $history->activity_type = 'Trainer';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->root_cause_description)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->root_cause_description;
                    $history->activity_type = 'Root Cause Description';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->reason_for_non_approval)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->reason_for_non_approval;
                    $history->activity_type = 'Reason for Non-Approval';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->reason_for_withdrawal)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->reason_for_withdrawal;
                    $history->activity_type = 'Reason for Withdrawal';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->justification_rationale)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->justification_rationale;
                    $history->activity_type = 'Justification/Rationale';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->meeting_minutes)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->meeting_minutes;
                    $history->activity_type = 'Meeting Minutes';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->rejection_reason)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->rejection_reason;
                    $history->activity_type = 'Rejection Reason';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->effectiveness_check_summary)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->effectiveness_check_summary;
                    $history->activity_type = 'Effectiveness Check Summary';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->decision)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->decision;
                    $history->activity_type = 'Decision';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->summary)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->summary;
                    $history->activity_type = 'Summary';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->documents_affected)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->documents_affected;
                    $history->activity_type = 'Documents Affected';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->actual_time_spend)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->actual_time_spend;
                    $history->activity_type = 'Actual Time Spend';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->documents)){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = "Null";
                    $history->current = $request->documents;
                    $history->activity_type = 'Documents';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiation";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                    toastr()->success("Record is created Successfully");
                    return redirect(url('rcms/qms-dashboard'));
           }

           public function edit($id){

                    $amendement_data = CTAAmendement::findORFail($id);

                    $old_record = CTAAmendement::select('id', 'division_id', 'record')->get();
                    $record_number = ((RecordNumber::first()->value('counter')) + 1);
                    $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
                    $users = User::all();
                    $qmsDevisions = QMSDivision::all();
                    //dd($qmsDevisions);

                    //due date
                    $currentDate = Carbon::now();
                    $formattedDate = $currentDate->addDays(30);
                    $due_date = $formattedDate->format('Y-m-d');

                    $g_id = $amendement_data->id;
                    $grid_Data = CTAAmendementGrid::where(['cta_amendement_id' => $g_id, 'identifier' => 'product_material'])->first();
                    //dd($grid_Data);

                    return view('frontend.ctms.cta_amendement_view',compact('amendement_data','old_record','record_number','users','qmsDevisions','due_date','grid_Data'));
            }

           public function update(Request $request, $id){
                //dd($request->all());

                    $amendement_data = CTAAmendement::findORFail($id);

                    $amendement = CTAAmendement::findORFail($id);

                    $amendement->form_type = "CTA-Amendement";
                    //$amendement->record = ((RecordNumber::first()->value('counter')) + 1);
                    $amendement->initiator_id = Auth::user()->id;
                    $amendement->division_id = $request->division_id;
                    $amendement->division_code = $request->division_code;
                    $amendement->intiation_date = $request->intiation_date;
                    $amendement->due_date = $request->due_date;
                    $amendement->parent_id = $request->parent_id;
                    $amendement->parent_type = $request->parent_type;
                    $amendement->short_description = $request->short_description;
                    $amendement->assigned_to = $request->assigned_to;
                    $amendement->type = $request->type;
                    $amendement->other_type = $request->other_type;

                    if (!empty ($request->attached_files)) {
                        $files = [];
                        if ($request->hasfile('attached_files')) {
                            foreach ($request->file('attached_files') as $file) {
                                $name = $request->name . 'attached_files' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                                $file->move('upload/', $name);
                                $files[] = $name;
                            }
                        }


                        $amendement->attached_files = $files;
                    }

                    $amendement->description = $request->description;
                    $amendement->zone = $request->zone;
                    $amendement->country = $request->country;
                    $amendement->state = $request->state;
                    $amendement->city = $request->city;

                    //Amendement Information
                    $amendement->procedure_number = $request->procedure_number;
                    $amendement->project_code = $request->project_code;
                    $amendement->registration_number = $request->registration_number;
                    $amendement->other_authority = $request->other_authority;
                    $amendement->authority_type = $request->authority_type;
                    $amendement->authority = $request->authority;
                    $amendement->year = $request->year;
                    $amendement->registration_status = $request->registration_status;
                    $amendement->car_clouser_time_weight = $request->car_clouser_time_weight;
                    $amendement->outcome = $request->outcome;
                    $amendement->trade_name = $request->trade_name;
                    $amendement->estimated_man_hours = $request->estimated_man_hours;
                    $amendement->comments = $request->comments;

                    //Product Information
                    $amendement->manufacturer = $request->manufacturer;

                    //Important Dates
                    $amendement->actual_submission_date = $request->actual_submission_date;
                    $amendement->actual_rejection_date = $request->actual_rejection_date;
                    $amendement->actual_withdrawn_date = $request->actual_withdrawn_date;
                    $amendement->car_clouser_time_weight = $request->car_clouser_time_weight;
                    $amendement->inquiry_date = $request->inquiry_date;
                    $amendement->planned_submission_date = $request->planned_submission_date;
                    $amendement->planned_date_sent_to_affiliate = $request->planned_date_sent_to_affiliate;
                    $amendement->effective_date = $request->effective_date;

                    //Person Involved
                    $amendement->additional_assignees = $request->additional_assignees;
                    $amendement->additional_investigators = $request->additional_investigators;
                    $amendement->approvers = $request->approvers;
                    $amendement->negotiation_team = $request->negotiation_team;
                    $amendement->trainer = $request->trainer;

                    //Root Cause
                    $amendement->root_cause_description = $request->root_cause_description;
                    $amendement->reason_for_non_approval = $request->reason_for_non_approval;
                    $amendement->reason_for_withdrawal = $request->reason_for_withdrawal;
                    $amendement->justification_rationale = $request->justification_rationale;
                    $amendement->meeting_minutes = $request->meeting_minutes;
                    $amendement->rejection_reason = $request->rejection_reason;
                    $amendement->effectiveness_check_summary = $request->effectiveness_check_summary;
                    $amendement->decision = $request->decision;
                    $amendement->summary = $request->summary;
                    $amendement->documents_affected = $request->documents_affected;
                    $amendement->actual_time_spend = $request->actual_time_spend;
                    $amendement->documents = $request->documents;
                    $amendement->save();


                    //Grid Update

                    $g_id = $amendement->id;
                    $newDataGridAmendement = CTAAmendementGrid::where(['cta_amendement_id' => $g_id, 'identifier' => 'product_material'])->firstOrCreate();
                    $newDataGridAmendement->cta_amendement_id = $g_id;
                    $newDataGridAmendement->identifier = 'product_material';
                    $newDataGridAmendement->data = $request->product_material;
                    $newDataGridAmendement->save();


               if($amendement_data->short_description != $amendement->short_description){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->short_description;
                    $history->current = $amendement->short_description;
                    $history->activity_type = 'Short Description';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->short_description) || $amendement_data->short_description === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->assigned_to != $amendement->assigned_to){

                    $previous_assigned_to_name = User::where('id', $amendement_data->assigned_to)->value('name');
                    $current_assigned_to_name = User::where('id', $amendement->assigned_to)->value('name');

                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $previous_assigned_to_name;
                    $history->current = $current_assigned_to_name;
                    $history->activity_type = 'Assigned To';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->assigned_to) || $amendement_data->assigned_to === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->due_date != $amendement->due_date){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->due_date;
                    $history->current = $amendement->due_date;
                    $history->activity_type = 'Date Due';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->due_date) || $amendement_data->due_date === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->type != $amendement->type){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->type;
                    $history->current = $amendement->type;
                    $history->activity_type = 'Type';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->type) || $amendement_data->type === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->other_type != $amendement->other_type){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->other_type;
                    $history->current = $amendement->other_type;
                    $history->activity_type = 'Other Type';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->other_type) || $amendement_data->other_type === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->attached_files != $amendement->attached_files){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = json_encode($amendement_data->attached_files);
                    $history->current = json_encode($amendement->attached_files);
                    $history->activity_type = 'Attached Files';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->attached_files) || $amendement_data->attached_files === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->description != $amendement->description){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->description;
                    $history->current = $amendement->description;
                    $history->activity_type = 'Description';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->description) || $amendement_data->description === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->zone != $amendement->zone){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->zone;
                    $history->current = $amendement->zone;
                    $history->activity_type = 'Zone';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->zone) || $amendement_data->zone === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->country != $amendement->country){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->country;
                    $history->current = $amendement->country;
                    $history->activity_type = 'Country';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->country) || $amendement_data->country === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->state != $amendement->state){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->state;
                    $history->current = $amendement->state;
                    $history->activity_type = 'State/District';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->state) || $amendement_data->state === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->city != $amendement->city){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->city;
                    $history->current = $amendement->city;
                    $history->activity_type = 'City';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->city) || $amendement_data->city === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->procedure_number != $amendement->procedure_number){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->procedure_number;
                    $history->current = $amendement->procedure_number;
                    $history->activity_type = 'Procedure Number';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->procedure_number) || $amendement_data->procedure_number === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->project_code != $amendement->project_code){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->project_code;
                    $history->current = $amendement->project_code;
                    $history->activity_type = 'Project Code';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->project_code) || $amendement_data->project_code === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->registration_number != $amendement->registration_number){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->registration_number;
                    $history->current = $amendement->registration_number;
                    $history->activity_type = 'Registration Number';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->registration_number) || $amendement_data->registration_number === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->other_authority != $amendement->other_authority){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->other_authority;
                    $history->current = $amendement->other_authority;
                    $history->activity_type = 'Other Authority';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->other_authority) || $amendement_data->other_authority === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->authority_type != $amendement->authority_type){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->authority_type;
                    $history->current = $amendement->authority_type;
                    $history->activity_type = 'Authority Type';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->authority_type) || $amendement_data->authority_type === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->authority != $amendement->authority){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->authority;
                    $history->current = $amendement->authority;
                    $history->activity_type = 'Authority';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->authority) || $amendement_data->authority === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->year != $amendement->year){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->year;
                    $history->current = $amendement->year;
                    $history->activity_type = 'Year';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->year) || $amendement_data->year === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->registration_status != $amendement->registration_status){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->registration_status;
                    $history->current = $amendement->registration_status;
                    $history->activity_type = 'Registration Status';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->registration_status) || $amendement_data->registration_status === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->car_clouser_time_weight != $amendement->car_clouser_time_weight){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->car_clouser_time_weight;
                    $history->current = $amendement->car_clouser_time_weight;
                    $history->activity_type = 'CAR Clouser Time Weight';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->car_clouser_time_weight) || $amendement_data->car_clouser_time_weight === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->outcome != $amendement->outcome){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->outcome;
                    $history->current = $amendement->outcome;
                    $history->activity_type = 'Outcome';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->outcome) || $amendement_data->outcome === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->trade_name != $amendement->trade_name){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->trade_name;
                    $history->current = $amendement->trade_name;
                    $history->activity_type = 'Trade Name';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->trade_name) || $amendement_data->trade_name === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->estimated_man_hours != $amendement->estimated_man_hours){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->estimated_man_hours;
                    $history->current = $amendement->estimated_man_hours;
                    $history->activity_type = 'Estimated Man-Hours';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->estimated_man_hours) || $amendement_data->estimated_man_hours === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->comments != $amendement->comments){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->comments;
                    $history->current = $amendement->comments;
                    $history->activity_type = 'Comments';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->comments) || $amendement_data->comments === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->manufacturer != $amendement->manufacturer){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->manufacturer;
                    $history->current = $amendement->manufacturer;
                    $history->activity_type = 'Manufacturer';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->manufacturer) || $amendement_data->manufacturer === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->actual_submission_date != $amendement->actual_submission_date){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->actual_submission_date;
                    $history->current = $amendement->actual_submission_date;
                    $history->activity_type = 'Actual Submission Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->actual_submission_date) || $amendement_data->actual_submission_date === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->actual_rejection_date != $amendement->actual_rejection_date){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->actual_rejection_date;
                    $history->current = $amendement->actual_rejection_date;
                    $history->activity_type = 'Actual Rejection Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->actual_rejection_date) || $amendement_data->actual_rejection_date === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->actual_withdrawn_date != $amendement->actual_withdrawn_date){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->actual_withdrawn_date;
                    $history->current = $amendement->actual_withdrawn_date;
                    $history->activity_type = 'Actual Withdrawn Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->actual_withdrawn_date) || $amendement_data->actual_withdrawn_date === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->inquiry_date != $amendement->inquiry_date){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->inquiry_date;
                    $history->current = $amendement->inquiry_date;
                    $history->activity_type = 'Inquiry Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->inquiry_date) || $amendement_data->inquiry_date === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->planned_submission_date != $amendement->planned_submission_date){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->planned_submission_date;
                    $history->current = $amendement->planned_submission_date;
                    $history->activity_type = 'Planned Submission Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->planned_submission_date) || $amendement_data->planned_submission_date === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->planned_date_sent_to_affiliate != $amendement->planned_date_sent_to_affiliate){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->planned_date_sent_to_affiliate;
                    $history->current = $amendement->planned_date_sent_to_affiliate;
                    $history->activity_type = 'Planned Date Sent To Affiliate';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->planned_date_sent_to_affiliate) || $amendement_data->planned_date_sent_to_affiliate === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->effective_date != $amendement->effective_date){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->effective_date;
                    $history->current = $amendement->effective_date;
                    $history->activity_type = 'Effective Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->effective_date) || $amendement_data->effective_date === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->additional_assignees != $amendement->additional_assignees){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->additional_assignees;
                    $history->current = $amendement->additional_assignees;
                    $history->activity_type = 'Additional Assignees';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->additional_assignees) || $amendement_data->additional_assignees === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->additional_investigators != $amendement->additional_investigators){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->additional_investigators;
                    $history->current = $amendement->additional_investigators;
                    $history->activity_type = 'Additional Investigators';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->additional_investigators) || $amendement_data->additional_investigators === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->approvers != $amendement->approvers){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->approvers;
                    $history->current = $amendement->approvers;
                    $history->activity_type = 'Approvers';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->approvers) || $amendement_data->approvers === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->negotiation_team != $amendement->negotiation_team){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->negotiation_team;
                    $history->current = $amendement->negotiation_team;
                    $history->activity_type = 'Negotiation Team';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->negotiation_team) || $amendement_data->negotiation_team === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->trainer != $amendement->trainer){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->trainer;
                    $history->current = $amendement->trainer;
                    $history->activity_type = 'Trainer';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->trainer) || $amendement_data->trainer === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->root_cause_description != $amendement->root_cause_description){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->root_cause_description;
                    $history->current = $amendement->root_cause_description;
                    $history->activity_type = 'Root Cause Description';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->root_cause_description) || $amendement_data->root_cause_description === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->reason_for_non_approval != $amendement->reason_for_non_approval){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->reason_for_non_approval;
                    $history->current = $amendement->reason_for_non_approval;
                    $history->activity_type = 'Reason for Non-Approval';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->reason_for_non_approval) || $amendement_data->reason_for_non_approval === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->reason_for_withdrawal != $amendement->reason_for_withdrawal){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->reason_for_withdrawal;
                    $history->current = $amendement->reason_for_withdrawal;
                    $history->activity_type = 'Reason for Withdrawal';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->reason_for_withdrawal) || $amendement_data->reason_for_withdrawal === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->justification_rationale != $amendement->justification_rationale){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->justification_rationale;
                    $history->current = $amendement->justification_rationale;
                    $history->activity_type = 'Justification/Rationale';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->justification_rationale) || $amendement_data->justification_rationale === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->meeting_minutes != $amendement->meeting_minutes){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->meeting_minutes;
                    $history->current = $amendement->meeting_minutes;
                    $history->activity_type = 'Meeting Minutes';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->meeting_minutes) || $amendement_data->meeting_minutes === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->rejection_reason != $amendement->rejection_reason){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->rejection_reason;
                    $history->current = $amendement->rejection_reason;
                    $history->activity_type = 'Rejection Reason';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->rejection_reason) || $amendement_data->rejection_reason === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->effectiveness_check_summary != $amendement->effectiveness_check_summary){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->effectiveness_check_summary;
                    $history->current = $amendement->effectiveness_check_summary;
                    $history->activity_type = 'Effectiveness Check Summary';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->effectiveness_check_summary) || $amendement_data->effectiveness_check_summary === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->decision != $amendement->decision){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->decision;
                    $history->current = $amendement->decision;
                    $history->activity_type = 'Decision';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->decision) || $amendement_data->decision === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->summary != $amendement->summary){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->summary;
                    $history->current = $amendement->summary;
                    $history->activity_type = 'Summary';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->summary) || $amendement_data->summary === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->documents_affected != $amendement->documents_affected){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->documents_affected;
                    $history->current = $amendement->documents_affected;
                    $history->activity_type = 'Documents Affected';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->documents_affected) || $amendement_data->documents_affected === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->actual_time_spend != $amendement->actual_time_spend){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->actual_time_spend;
                    $history->current = $amendement->actual_time_spend;
                    $history->activity_type = 'Actual Time Spend';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->actual_time_spend) || $amendement_data->actual_time_spend === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }

                if($amendement_data->documents != $amendement->documents){
                    $history = new CTAAmendementAuditTrail();
                    $history->cta_amendement_id = $amendement->id;
                    $history->previous = $amendement_data->documents;
                    $history->current = $amendement->documents;
                    $history->activity_type = 'Documents';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_from =   $amendement_data->status;
                    $history->change_to = "Not Applicable";
                    if (is_null($amendement_data->documents) || $amendement_data->documents === '') {
                        $history->action_name = 'New';
                    } else {
                        $history->action_name = 'Update';
                    }
                    $history->comment = "Not Applicable";
                    $history->save();

                }
                    toastr()->success("Record is created Successfully");
                    return back();
           }

           public function CTA_Amendement_send_stage(Request $request, $id){

                if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                    $amendement_data = CTAAmendement::find($id);
                    $lastDocument = CTAAmendement::find($id);

                    if ($amendement_data->stage == 1) {
                            $amendement_data->stage = "2";
                            $amendement_data->status = "Dossier Finalization";
                            $amendement_data->submit_by = Auth::user()->name;
                            $amendement_data->submit_on = Carbon::now()->format('d-M-Y');
                            $amendement_data->submit_comment = $request->comment;
                            $amendement_data->save();

                            $history = new CTAAmendementAuditTrail();
                            $history->cta_amendement_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Opened";
                            $history->change_to = "Dossier Finalization";
                            $history->action = "Submission";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();

                    }

                    elseif ($amendement_data->stage == 2) {
                            $amendement_data->stage = "3";
                            $amendement_data->status = "Submitted for Authority";
                            $amendement_data->finalize_dossier_by = Auth::user()->name;
                            $amendement_data->finalize_dossier_on = Carbon::now()->format('d-M-Y');
                            $amendement_data->finalize_dossier_comment = $request->comment;
                            $amendement_data->save();

                            $history = new CTAAmendementAuditTrail();
                            $history->cta_amendement_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Dossier Finalization";
                            $history->change_to = "Submitted for Authority";
                            $history->action = "Finalize Dossier";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                    }

                    elseif($amendement_data->stage == 3) {
                            $amendement_data->stage = "7";
                            $amendement_data->status = "Closed-Approved";
                            $amendement_data->approve_by = Auth::user()->name;
                            $amendement_data->approve_on = Carbon::now()->format('d-M-Y');
                            $amendement_data->approve_comment = $request->comment;
                            $amendement_data->save();

                            $history = new CTAAmendementAuditTrail();
                            $history->cta_amendement_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Submitted for Authority";
                            $history->change_to = "Closed-Approved";
                            $history->action = "Approved";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                    }
                    elseif ($amendement_data->stage == 6) {
                        if($request->type == 'early_termination'){
                            $amendement_data->stage = "11";
                            $amendement_data->status = "Closed-Terminated";
                            $amendement_data->early_termination_by = Auth::user()->name;
                            $amendement_data->early_termination_on = Carbon::now()->format('d-M-Y');
                            $amendement_data->early_termination_comment = $request->comment;
                            $amendement_data->save();

                            $history = new CTAAmendementAuditTrail();
                            $history->cta_amendement_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "RA Review of Response to Comments";
                            $history->change_to = "Closed-Terminated";
                            $history->action = "Early Termination";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                        }else{
                            $amendement_data->stage = "5";
                            $amendement_data->status = "Pending Comments";
                            $amendement_data->more_comments_by = Auth::user()->name;
                            $amendement_data->more_comments_on = Carbon::now()->format('d-M-Y');
                            $amendement_data->more_comments_comment = $request->comment;
                            $amendement_data->save();

                            $history = new CTAAmendementAuditTrail();
                            $history->cta_amendement_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "RA Review of Response to Comments";
                            $history->change_to = "Pending Comments";
                            $history->action = "More Comments";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                        }

                    }

                }
                else
                {
                toastr()->error('E-signature Not match');
                    return back();
                }
            }

           public function CTA_Amendement_cancel(Request $request, $id){

                if ($request->username == Auth::user()->email && Hash::check($request->password,  Auth::user()->password)) {
                    $amendement_data = CTAAmendement::find($id);
                    $lastDocument = CTAAmendement::find($id);

                    if ($amendement_data->stage == 1) {
                    if($request->type == 'cancel'){
                        $amendement_data->stage = "0";
                        $amendement_data->status = "Closed-Cancelled";
                        $amendement_data->cancel_by = Auth::user()->name;
                        $amendement_data->cancel_on = Carbon::now()->format('d-M-Y');
                        $amendement_data->cancel_comment = $request->comment;
                        $amendement_data->save();

                        $history = new CTAAmendementAuditTrail();
                        $history->cta_amendement_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Opened";
                        $history->change_to = "Closed-Cancelled";
                        $history->action = "Cancel";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
                    }else{
                        $amendement_data->stage = "8";
                        $amendement_data->status = "Closed-Notified";
                        $amendement_data->notification_by = Auth::user()->name;
                        $amendement_data->notification_on = Carbon::now()->format('d-M-Y');
                        $amendement_data->notification_comment = $request->comment;
                        $amendement_data->save();

                        $history = new CTAAmendementAuditTrail();
                        $history->cta_amendement_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Opened";
                        $history->change_to = "Closed-Notified";
                        $history->action = "Notification Only";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();
                    }
                    }elseif($amendement_data->stage == 2){
                        $amendement_data->stage = "9";
                        $amendement_data->status = "Closed-Witdrawn";
                        $amendement_data->withdraw_by = Auth::user()->name;
                        $amendement_data->withdraw_on = Carbon::now()->format('d-M-Y');
                        $amendement_data->withdraw_comment = $request->comment;
                        $amendement_data->save();

                        $history = new CTAAmendementAuditTrail();
                        $history->cta_amendement_id = $id;
                        $history->activity_type = 'Activity Log';
                        $history->previous = "";
                        $history->current = "";
                        $history->comment = $request->comment;
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from = "Dossier Finalization";
                        $history->change_to = "Closed-Witdrawn";
                        $history->action = "Withdraw";
                        $history->stage = 'Plan Approved';
                        $history->save();

                        return back();

                    }elseif($amendement_data->stage == 3){
                        if($request->type == 'not_approved'){
                         $amendement_data->stage = "10";
                         $amendement_data->status = "Closed-Not Approved";
                         $amendement_data->not_approved_by = Auth::user()->name;
                         $amendement_data->not_approved_on = Carbon::now()->format('d-M-Y');
                         $amendement_data->not_approved_comment = $request->comment;
                         $amendement_data->save();

                         $history = new CTAAmendementAuditTrail();
                         $history->cta_amendement_id = $id;
                         $history->activity_type = 'Activity Log';
                         $history->previous = "";
                         $history->current = "";
                         $history->comment = $request->comment;
                         $history->user_id = Auth::user()->id;
                         $history->user_name = Auth::user()->name;
                         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                         $history->change_from = "Submitted for Authority";
                         $history->change_to = "Closed-Not Approved";
                         $history->action = "Not Approved";
                         $history->stage = 'Plan Approved';
                         $history->save();

                            return back();
                        }else{
                         $amendement_data->stage = "9";
                         $amendement_data->status = "Closed-Witdrawn";
                         $amendement_data->management_withdraw_by = Auth::user()->name;
                         $amendement_data->management_withdraw_on = Carbon::now()->format('d-M-Y');
                         $amendement_data->management_withdraw_comment = $request->comment;
                         $amendement_data->save();

                         $history = new CTAAmendementAuditTrail();
                         $history->cta_amendement_id = $id;
                         $history->activity_type = 'Activity Log';
                         $history->previous = "";
                         $history->current = "";
                         $history->comment = $request->comment;
                         $history->user_id = Auth::user()->id;
                         $history->user_name = Auth::user()->name;
                         $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                         $history->change_from = "Submitted for Authority";
                         $history->change_to = "Closed-Witdrawn";
                         $history->action = "Withdraw";
                         $history->stage = 'Plan Approved';
                         $history->save();

                         return back();
                        }

                    }


                }else{
                        toastr()->error('E-signature Not match');
                        return back();
                }
            }

           public function CTA_Amendement_send(Request $request, $id){

                if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                    $amendement_data = CTAAmendement::find($id);
                    $lastDocument = CTAAmendement::find($id);

                    if ($amendement_data->stage == 3) {
                            $amendement_data->stage = "4";
                            $amendement_data->status = "Approved with Comments/Conditions";
                            $amendement_data->management_approved_by = Auth::user()->name;
                            $amendement_data->management_approved_on = Carbon::now()->format('d-M-Y');
                            $amendement_data->management_approved_comment = $request->comment;
                            $amendement_data->save();

                            $history = new CTAAmendementAuditTrail();
                            $history->cta_amendement_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Submitted for Authority";
                            $history->change_to = "Approved with Comments/Conditions";
                            $history->action = "Approved with Conditions/Comments";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();

                    }

                    elseif ($amendement_data->stage == 4) {
                        if($request->type == 'no_condition'){
                            $amendement_data->stage = "7";
                            $amendement_data->status = "Closed-Approved";
                            $amendement_data->no_conditions_by = Auth::user()->name;
                            $amendement_data->no_conditions_on = Carbon::now()->format('d-M-Y');
                            $amendement_data->no_conditions_comment = $request->comment;
                            $amendement_data->save();

                            $history = new CTAAmendementAuditTrail();
                            $history->cta_amendement_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Approved with Comments/Conditions";
                            $history->change_to = "Closed-Approved";
                            $history->action = "No Conditions to Fulfill Before FPI";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                        }else{
                            $amendement_data->stage = "5";
                            $amendement_data->status = "Pending Comments";
                            $amendement_data->conditions_by = Auth::user()->name;
                            $amendement_data->conditions_on = Carbon::now()->format('d-M-Y');
                            $amendement_data->conditions_comment = $request->comment;
                            $amendement_data->save();

                            $history = new CTAAmendementAuditTrail();
                            $history->cta_amendement_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Approved with Comments/Conditions";
                            $history->change_to = "Pending Comments";
                            $history->action = "Conditions to Fulfill BeforeFPI";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                        }

                    }

                    elseif ($amendement_data->stage == 5) {
                            $amendement_data->stage = "6";
                            $amendement_data->status = "RA Review of Response to Comments";
                            $amendement_data->submit_response_by = Auth::user()->name;
                            $amendement_data->submit_response_on = Carbon::now()->format('d-M-Y');
                            $amendement_data->submit_response_comment = $request->comment;
                            $amendement_data->save();

                            $history = new CTAAmendementAuditTrail();
                            $history->cta_amendement_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Pending Comments";
                            $history->change_to = "RA Review of Response to Comments";
                            $history->action = "Submit response";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                    }
                    elseif ($amendement_data->stage == 6) {
                            $amendement_data->stage = "7";
                            $amendement_data->status = "Closed-Approved";
                            $amendement_data->all_conditions_by = Auth::user()->name;
                            $amendement_data->all_conditions_on = Carbon::now()->format('d-M-Y');
                            $amendement_data->all_conditions_comment = $request->comment;
                            $amendement_data->save();

                            $history = new CTAAmendementAuditTrail();
                            $history->cta_amendement_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "RA Review of Response to Comments";
                            $history->change_to = "Closed-Approved";
                            $history->action = "All Conditions/Comments are met";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                    }
                }
                else
                {
                toastr()->error('E-signature Not match');
                    return back();
                }
            }

           //Single Report Start

           public function CTA_AmendementSingleReport(Request $request, $id){

                $amendement_data = CTAAmendement::find($id);
                //$users = User::all();
                 $grid_Data = CTAAmendementGrid::where(['cta_amendement_id' => $id, 'identifier' => 'product_material'])->first();

                    if (!empty($amendement_data)) {
                        $amendement_data->data = CTAAmendementGrid::where('cta_amendement_id', $id)->where('identifier', "product_material")->first();

                        $amendement_data->originator = User::where('id', $amendement_data->initiator_id)->value('name');
                        $amendement_data->assign_to_gi = User::where('id', $amendement_data->assigned_to)->value('name');
                        $pdf = App::make('dompdf.wrapper');
                        $time = Carbon::now();
                        $pdf = PDF::loadview('frontend.ctms.cta_amendementSingleReport', compact('amendement_data','grid_Data'))
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
                        $canvas->page_text($width / 4, $height / 2, $amendement_data->status, null, 25, [0, 0, 0], 2, 6, -20);
                        return $pdf->stream('CTA_Amendement' . $id . '.pdf');
                    }
            }


            //Audit Trail Start

           public function CTA_AmendementAuditTrial($id){

                        $audit = CTAAmendementAuditTrail::where('cta_amendement_id', $id)->orderByDESC('id')->paginate(5);
                        // dd($audit);
                        $today = Carbon::now()->format('d-m-y');
                        $document = CTAAmendement::where('id', $id)->first();
                        $document->originator = User::where('id', $document->initiator_id)->value('name');
                        // dd($document);

                        return view('frontend.ctms.cta_amendementAuditTrail',compact('document','audit','today'));
            }

            //Audit Trail Report Start

           public function CTA_AmendementAuditTrailPdf($id)
                {
                    $doc = CTAAmendement::find($id);
                    $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                    $data = CTAAmendementAuditTrail::where('cta_amendement_id', $doc->id)->orderByDesc('id')->get();
                    $pdf = App::make('dompdf.wrapper');
                    $time = Carbon::now();
                    $pdf = PDF::loadview('frontend.ctms.cta_amendementAuditTrailPdf', compact('data', 'doc'))
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
