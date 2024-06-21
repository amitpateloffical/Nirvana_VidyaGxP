<?php

namespace App\Http\Controllers;
use App\Models\GcpStudy;
use App\Models\GCPStudyGrid;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RecordNumber;
use App\Models\User;
use App\Models\RoleGroup;
use App\Models\GcpStudyAuditTrail;
use App\Models\QMSDivision;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;

class GcpStudyController extends Controller
{
        public function index(){

            $old_record = GcpStudy::select('id', 'division_id', 'record')->get();
            $record_number = ((RecordNumber::first()->value('counter')) + 1);
            $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
            $users = User::all();
            $qmsDevisions = QMSDivision::all();
            //dd($qmsDevisions);

            //due date
            $currentDate = Carbon::now();
            $formattedDate = $currentDate->addDays(30);
            $due_date = $formattedDate->format('Y-m-d');

            return view('frontend.new_forms.GCP_study',compact('old_record','record_number','users','qmsDevisions','due_date'));
        }
        public function store(Request $request){
            //dd($request->all());
                $study = new GcpStudy();
                $study->form_type = "Gcp_Study";
                $study->record = ((RecordNumber::first()->value('counter')) + 1);
                $study->initiator_id = Auth::user()->id;
                $study->division_id = $request->division_id;
                $study->division_code = $request->division_code;
                $study->intiation_date = $request->intiation_date;
                $study->due_date = $request->due_date;
                $study->parent_id = $request->parent_id;
                $study->parent_type = $request->parent_type;
                $study->short_description_gi = $request->short_description_gi;
                $study->assign_to_gi = $request->assign_to_gi;
                $study->department_gi = $request->department_gi;
                $study->study_number_sd = $request->study_number_sd;
                $study->name_of_product_sd = $request->name_of_product_sd;
                $study->study_title_sd = $request->study_title_sd;
                $study->study_type_sd = $request->study_type_sd;
                $study->study_protocol_number_sd = $request->study_protocol_number_sd;
                $study->description_sd = $request->description_sd;
                $study->comments_sd = $request->comments_sd;
                $study->related_studies_ai = $request->related_studies_ai;
                $study->document_link_ai = $request->document_link_ai;
                $study->appendiceis_ai = $request->appendiceis_ai;
                $study->related_audits_ai = $request->related_audits_ai;

                //GCP Details
                $study->generic_product_name_gcpd = $request->generic_product_name_gcpd;
                $study->indication_name_gcpd = $request->indication_name_gcpd;
                $study->clinical_study_manager_gcpd = $request->clinical_study_manager_gcpd;
                $study->clinical_expert_gcpd = $request->clinical_expert_gcpd;
                $study->phase_level_gcpd = $request->phase_level_gcpd;
                $study->therapeutic_area_gcpd = $request->therapeutic_area_gcpd;
                $study->ind_no_gcpd = $request->ind_no_gcpd;
                $study->number_of_centers_gcpd = $request->number_of_centers_gcpd;
                $study->of_subjects_gcpd = $request->of_subjects_gcpd;

                //Important Date
                $study->initiation_date_i = $request->initiation_date_i;
                $study->study_start_date = $request->study_start_date;
                $study->study_end_date = $request->study_end_date;
                $study->study_protocol=$request->study_protocol;
                $study->first_subject_in = $request->first_subject_in;
                $study->last_subject_out = $request->last_subject_out;
                $study->databse_lock = $request->databse_lock;
                $study->integrated_ctr = $request->integrated_ctr;

                $study->save();

                //grid store
                $g_id = $study->id;
                $newDataGridStudy = GCPStudyGrid::where(['gcp_study_id' => $g_id, 'identifier' => 'audit_site_information'])->firstOrCreate();
                $newDataGridStudy->gcp_study_id = $g_id;
                $newDataGridStudy->identifier = 'audit_site_information';
                $newDataGridStudy->data = $request->audit_site_information;
                $newDataGridStudy->save();

                $g_id = $study->id;
                $newDataGridStudy = GCPStudyGrid::where(['gcp_study_id' => $g_id, 'identifier' => 'study_site_information'])->firstOrCreate();
                $newDataGridStudy->gcp_study_id = $g_id;
                $newDataGridStudy->identifier = 'study_site_information';
                $newDataGridStudy->data = $request->study_site_information;
                $newDataGridStudy->save();

                //Audit Trail store start

                if(!empty($request->short_description_gi)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->short_description_gi;
                    $history->activity_type = 'Short Description';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->assign_to_gi)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->assign_to_gi;
                    $history->activity_type = 'Assigned To';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->due_date)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->due_date;
                    $history->activity_type = 'Date Due';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->department_gi)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->department_gi;
                    $history->activity_type = 'Department';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->study_number_sd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->study_number_sd;
                    $history->activity_type = 'Study Number';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->name_of_product_sd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->name_of_product_sd;
                    $history->activity_type = 'Name of Product';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->study_title_sd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->study_title_sd;
                    $history->activity_type = 'Study Title';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->study_type_sd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->study_type_sd;
                    $history->activity_type = 'Study type';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->study_protocol_number_sd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->study_protocol_number_sd;
                    $history->activity_type = 'Study Protocol Number';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->description_sd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->description_sd;
                    $history->activity_type = 'Description';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->comments_sd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->comments_sd;
                    $history->activity_type = 'Comments';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->related_studies_ai)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->related_studies_ai;
                    $history->activity_type = 'Related studies';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->document_link_ai)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->document_link_ai;
                    $history->activity_type = 'Document Link';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                if(!empty($request->appendiceis_ai)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->appendiceis_ai;
                    $history->activity_type = 'Appendiceis';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->related_audits_ai)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->related_audits_ai;
                    $history->activity_type = 'Related Audits';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                //GCP Details

                if(!empty($request->generic_product_name_gcpd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->generic_product_name_gcpd;
                    $history->activity_type = 'Generic Product Name';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->indication_name_gcpd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->indication_name_gcpd;
                    $history->activity_type = 'Indication Name';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->clinical_study_manager_gcpd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->clinical_study_manager_gcpd;
                    $history->activity_type = 'Clinical Study Manager';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->clinical_expert_gcpd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->clinical_expert_gcpd;
                    $history->activity_type = 'Clinical Expert';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->phase_level_gcpd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->phase_level_gcpd;
                    $history->activity_type = 'Phase Level';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->therapeutic_area_gcpd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->therapeutic_area_gcpd;
                    $history->activity_type = 'Therapeutic Area';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->ind_no_gcpd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->ind_no_gcpd;
                    $history->activity_type = 'IND No';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->number_of_centers_gcpd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->number_of_centers_gcpd;
                    $history->activity_type = 'Number of Centers';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->of_subjects_gcpd)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->of_subjects_gcpd;
                    $history->activity_type = 'of Subjects';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                //Important Date

                if(!empty($request->initiation_date_i)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->initiation_date_i;
                    $history->activity_type = 'Initiation Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->study_start_date)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->study_start_date;
                    $history->activity_type = 'Study Start Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->study_end_date)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->study_end_date;
                    $history->activity_type = 'Study End Date';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->study_protocol)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->study_protocol;
                    $history->activity_type = 'Study Protocol';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->first_subject_in)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->first_subject_in;
                    $history->activity_type = 'First Subject in';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->last_subject_out)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->last_subject_out;
                    $history->activity_type = 'Last Subject Out';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->databse_lock)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->databse_lock;
                    $history->activity_type = 'Data Base Lock';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }
                if(!empty($request->integrated_ctr)){
                    $history = new GcpStudyAuditTrail();
                    $history->gcp_study_id = $study->id;
                    $history->previous = "Null";
                    $history->current = $request->integrated_ctr;
                    $history->activity_type = 'Integrated CTR';
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->change_to =   "Opened";
                    $history->change_from = "Initiator";
                    $history->action_name = 'Create';
                    $history->comment = "Not Applicable";
                    $history->save();
                }

                    toastr()->success("Record is created Successfully");
                    return redirect(url('rcms/qms-dashboard'));

        }
              public function edit($id){

                    $study_data = GcpStudy::findOrFail($id);
                    //dd($study_data);
                    $old_record = GcpStudy::select('id', 'division_id', 'record')->get();
                    $record_number = ((RecordNumber::first()->value('counter')) + 1);
                    $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
                    $users = User::all();
                    //$qmsDevisions = QMSDivision::all();
                    $divisionName = DB::table('q_m_s_divisions')->where('id', $study_data->division_id)->value('name');

                    //due date
                    $currentDate = Carbon::now();
                    $formattedDate = $currentDate->addDays(30);
                    $due_date = $formattedDate->format('Y-m-d');

                    //gridfetch

                    $g_id = $study_data->id;
                    $grid_DataA = GcpStudyGrid::where(['gcp_study_id' => $g_id, 'identifier' => 'audit_site_information'])->first();
                    $grid_DataS = GcpStudyGrid::where(['gcp_study_id' => $g_id, 'identifier' => 'study_site_information'])->first();

                    return view('frontend.new_forms.GCP_study_view',compact('study_data','old_record','record_number','users','due_date','grid_DataA','grid_DataS','divisionName'));
                }

              public function update(Request $request, $id){

                    $study_data = GcpStudy::findOrFail($id);

                    $study = GcpStudy::findOrFail($id);

                    $study->form_type = "Gcp_Study";
                    $study->record = ((RecordNumber::first()->value('counter')) + 1);
                    $study->initiator_id = Auth::user()->id;
                    $study->division_id = $request->division_id;
                    $study->division_code = $request->division_code;
                    $study->intiation_date = $request->intiation_date;
                    $study->due_date = $request->due_date;
                    $study->parent_id = $request->parent_id;
                    $study->parent_type = $request->parent_type;
                    $study->short_description_gi = $request->short_description_gi;
                    $study->assign_to_gi = $request->assign_to_gi;
                    $study->department_gi = $request->department_gi;
                    $study->study_number_sd = $request->study_number_sd;
                    $study->name_of_product_sd = $request->name_of_product_sd;
                    $study->study_title_sd = $request->study_title_sd;
                    $study->study_type_sd = $request->study_type_sd;
                    $study->study_protocol_number_sd = $request->study_protocol_number_sd;
                    $study->description_sd = $request->description_sd;
                    $study->comments_sd = $request->comments_sd;
                    $study->related_studies_ai = $request->related_studies_ai;
                    $study->document_link_ai = $request->document_link_ai;
                    $study->appendiceis_ai = $request->appendiceis_ai;
                    $study->related_audits_ai = $request->related_audits_ai;

                    //GCP Details
                    $study->generic_product_name_gcpd = $request->generic_product_name_gcpd;
                    $study->indication_name_gcpd = $request->indication_name_gcpd;
                    $study->clinical_study_manager_gcpd = $request->clinical_study_manager_gcpd;
                    $study->clinical_expert_gcpd = $request->clinical_expert_gcpd;
                    $study->phase_level_gcpd = $request->phase_level_gcpd;
                    $study->therapeutic_area_gcpd = $request->therapeutic_area_gcpd;
                    $study->ind_no_gcpd = $request->ind_no_gcpd;
                    $study->number_of_centers_gcpd = $request->number_of_centers_gcpd;
                    $study->of_subjects_gcpd = $request->of_subjects_gcpd;

                    //Important Date
                    $study->initiation_date_i = $request->initiation_date_i;
                    $study->study_start_date = $request->study_start_date;
                    $study->study_end_date = $request->study_end_date;
                    $study->study_protocol=$request->study_protocol;
                    $study->first_subject_in = $request->first_subject_in;
                    $study->last_subject_out = $request->last_subject_out;
                    $study->databse_lock = $request->databse_lock;
                    $study->integrated_ctr = $request->integrated_ctr;

                    $study->save();

                    //grid update

                    $g_id = $study->id;
                    $newDataGridStudy = GCPStudyGrid::where(['gcp_study_id' => $g_id, 'identifier' => 'audit_site_information'])->firstOrCreate();
                    $newDataGridStudy->gcp_study_id = $g_id;
                    $newDataGridStudy->identifier = 'audit_site_information';
                    $newDataGridStudy->data = $request->audit_site_information;
                    $newDataGridStudy->update();

                    $g_id = $study->id;
                    $newDataGridStudy = GCPStudyGrid::where(['gcp_study_id' => $g_id, 'identifier' => 'study_site_information'])->firstOrCreate();
                    $newDataGridStudy->gcp_study_id = $g_id;
                    $newDataGridStudy->identifier = 'study_site_information';
                    $newDataGridStudy->data = $request->study_site_information;
                    $newDataGridStudy->update();

                    //audit trail update

                    if($study_data->short_description_gi != $study->short_description_gi){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->short_description_gi;
                        $history->current = $study->short_description_gi;
                        $history->activity_type = 'Short Description';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($study_data->assign_to_gi != $study->assign_to_gi){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->assign_to_gi;
                        $history->current = $study->assign_to_gi;
                        $history->activity_type = 'Assigned To';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->due_date != $study->due_date){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->due_date;
                        $history->current = $study->due_date;
                        $history->activity_type = 'Date Due';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->department_gi != $study->department_gi){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->department_gi;
                        $history->current = $study->department_gi;
                        $history->activity_type = 'Department(s)';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->study_number_sd != $study->study_number_sd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->study_number_sd;
                        $history->current = $study->study_number_sd;
                        $history->activity_type = 'Study Number';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->name_of_product_sd != $study->name_of_product_sd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->name_of_product_sd;
                        $history->current = $study->name_of_product_sd;
                        $history->activity_type = 'Name of Product';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->study_title_sd != $study->study_title_sd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->study_title_sd;
                        $history->current = $study->study_title_sd;
                        $history->activity_type = 'Study Title';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->study_type_sd != $study->study_type_sd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->study_type_sd;
                        $history->current = $study->study_type_sd;
                        $history->activity_type = 'Study type';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->study_protocol_number_sd != $study->study_protocol_number_sd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->study_protocol_number_sd;
                        $history->current = $study->study_protocol_number_sd;
                        $history->activity_type = 'Study Protocol Number';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->description_sd != $study->description_sd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->description_sd;
                        $history->current = $study->description_sd;
                        $history->activity_type = 'Description';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->comments_sd != $study->comments_sd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->comments_sd;
                        $history->current = $study->comments_sd;
                        $history->activity_type = 'Comments';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->related_studies_ai != $study->related_studies_ai){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->related_studies_ai;
                        $history->current = $study->related_studies_ai;
                        $history->activity_type = 'Related studies';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->document_link_ai != $study->document_link_ai){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->document_link_ai;
                        $history->current = $study->document_link_ai;
                        $history->activity_type = 'Document Link';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->appendiceis_ai != $study->appendiceis_ai){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->appendiceis_ai;
                        $history->current = $study->appendiceis_ai;
                        $history->activity_type = 'Appendiceis';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->related_audits_ai != $study->related_audits_ai){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->related_audits_ai;
                        $history->current = $study->related_audits_ai;
                        $history->activity_type = 'Related Audits';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                     //GCP Details

                    if($study_data->generic_product_name_gcpd != $study->generic_product_name_gcpd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->generic_product_name_gcpd;
                        $history->current = $study->generic_product_name_gcpd;
                        $history->activity_type = 'Generic Product Name';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->indication_name_gcpd != $study->indication_name_gcpd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->indication_name_gcpd;
                        $history->current = $study->indication_name_gcpd;
                        $history->activity_type = 'Indication Name';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    if($study_data->clinical_study_manager_gcpd != $study->clinical_study_manager_gcpd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->clinical_study_manager_gcpd;
                        $history->current = $study->clinical_study_manager_gcpd;
                        $history->activity_type = 'Clinical Study Manager';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->clinical_expert_gcpd != $study->clinical_expert_gcpd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->clinical_expert_gcpd;
                        $history->current = $study->clinical_expert_gcpd;
                        $history->activity_type = 'Clinical Expert';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->phase_level_gcpd != $study->phase_level_gcpd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->phase_level_gcpd;
                        $history->current = $study->phase_level_gcpd;
                        $history->activity_type = 'Phase Level';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->therapeutic_area_gcpd != $study->therapeutic_area_gcpd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->therapeutic_area_gcpd;
                        $history->current = $study->therapeutic_area_gcpd;
                        $history->activity_type = 'Therapeutic Area';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->ind_no_gcpd != $study->ind_no_gcpd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->ind_no_gcpd;
                        $history->current = $study->ind_no_gcpd;
                        $history->activity_type = 'IND No';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->number_of_centers_gcpd != $study->number_of_centers_gcpd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->number_of_centers_gcpd;
                        $history->current = $study->number_of_centers_gcpd;
                        $history->activity_type = 'Number of Centers';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->of_subjects_gcpd != $study->of_subjects_gcpd){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->of_subjects_gcpd;
                        $history->current = $study->of_subjects_gcpd;
                        $history->activity_type = 'of Subjects';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    //Important Date

                    if($study_data->initiation_date_i != $study->initiation_date_i){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->initiation_date_i;
                        $history->current = $study->initiation_date_i;
                        $history->activity_type = 'Initiation Date';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->study_start_date != $study->study_start_date){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->study_start_date;
                        $history->current = $study->study_start_date;
                        $history->activity_type = 'Study Start Date';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->study_end_date != $study->study_end_date){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->study_end_date;
                        $history->current = $study->study_end_date;
                        $history->activity_type = 'Study End Date';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->study_protocol != $study->study_protocol){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->study_protocol;
                        $history->current = $study->study_protocol;
                        $history->activity_type = 'Study Protocol';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->first_subject_in != $study->first_subject_in){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->first_subject_in;
                        $history->current = $study->first_subject_in;
                        $history->activity_type = 'First Subject in';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->last_subject_out != $study->last_subject_out){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->last_subject_out;
                        $history->current = $study->last_subject_out;
                        $history->activity_type = 'Last Subject Out';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->databse_lock != $study->databse_lock){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->databse_lock;
                        $history->current = $study->databse_lock;
                        $history->activity_type = 'Data Base Lock';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }
                    if($study_data->integrated_ctr != $study->integrated_ctr){
                        $history = new GcpStudyAuditTrail();
                        $history->gcp_study_id = $study->id;
                        $history->previous = $study_data->integrated_ctr;
                        $history->current = $study->integrated_ctr;
                        $history->activity_type = 'Integrated CTR';
                        $history->user_id = Auth::user()->id;
                        $history->user_name = Auth::user()->name;
                        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                        $history->change_from =   $study_data->status;
                        $history->change_to = "Not Applicable";
                        $history->action_name = 'Update';
                        $history->comment = "Not Applicable";
                        $history->save();

                    }

                    toastr()->success("Record is updated Successfully");
                    return back();


            }


                  //workflow

            public function GCP_study_send_stage(Request $request, $id){

                 if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                        $study_data = GcpStudy::find($id);
                        $lastDocument = GcpStudy::find($id);

                    if ($study_data->stage == 1) {
                            $study_data->stage = "2";
                            $study_data->status = "Study In Progress";
                            $study_data->initiate_by = Auth::user()->name;
                            $study_data->initiate_on = Carbon::now()->format('d-M-Y');
                            $study_data->initiate_comment = $request->comment;
                            $study_data->save();

                            $history = new GcpStudyAuditTrail();
                            $history->gcp_study_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Opened";
                            $history->change_to = "Study In Progress";
                            $history->action_name = "Submit";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();

                    }

                    elseif ($study_data->stage == 2) {
                            $study_data->stage = "3";
                            $study_data->status = "Pending Report Issuance";
                            $study_data->study_complete_by = Auth::user()->name;
                            $study_data->study_complete_on = Carbon::now()->format('d-M-Y');
                            $study_data->study_complete_comment = $request->comment;
                            $study_data->save();

                            $history = new GcpStudyAuditTrail();
                            $history->gcp_study_id = $id;
                            $history->activity_type = 'Activity Log';
                            $history->previous = "";
                            $history->current = "";
                            $history->comment = $request->comment;
                            $history->user_id = Auth::user()->id;
                            $history->user_name = Auth::user()->name;
                            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                            $history->change_from = "Study In Progress";
                            $history->change_to = "Pending Report Issuance";
                            $history->action_name = "Submit";
                            $history->stage = 'Plan Approved';
                            $history->save();

                            return back();
                    }

                     elseif($study_data->stage == 3) {
                        //dd($request->type);
                            if ($request->type == "issue_report") {
                                $study_data->stage = "4";
                                $study_data->status = "Closed-Done";
                                $study_data->issue_report_by = Auth::user()->name;
                                $study_data->issue_report_on = Carbon::now()->format('d-M-Y');
                                $study_data->issue_report_comment = $request->comment;
                                $study_data->save();
                            } else{
                                $study_data->stage = "4";
                                $study_data->status = "Closed-Done";
                                $study_data->no_report_require_by = Auth::user()->name;
                                $study_data->no_report_require_on = Carbon::now()->format('d-M-Y');
                                $study_data->no_report_require_comment = $request->comment;
                                $study_data->save();
                            }

                                $history = new GcpStudyAuditTrail();
                                $history->gcp_study_id = $id;
                                $history->activity_type = 'Activity Log';
                                $history->previous = "";
                                $history->current = "";
                                $history->comment = $request->comment;
                                $history->user_id = Auth::user()->id;
                                $history->user_name = Auth::user()->name;
                                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                                $history->change_from = "Pending Report Issuance";
                                $history->change_to = "Closed-Done";
                                $history->action_name = "Submit";
                                $history->stage = 'Plan Approved';
                                $history->save();

                                return back();
                        }

                    }
                    else {
                            toastr()->error('E-signature Not match');
                            return back();
                        }
            }

                    public function GCP_study_cancel(Request $request, $id){

                        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
                            $study_data = GcpStudy::find($id);
                            $lastDocument = GcpStudy::find($id);

                            if ($study_data->stage == 1) {
                                $study_data->stage = "0";
                                $study_data->status = "Closed-Cancelled";
                                $study_data->initiate_cancel_by = Auth::user()->name;
                                $study_data->initiate_cancel_on = Carbon::now()->format('d-M-Y');
                                $study_data->initiate_cancel_comment = $request->comment;
                                $study_data->save();

                                $history = new GcpStudyAuditTrail();
                                $history->gcp_study_id = $id;
                                $history->activity_type = 'Activity Log';
                                $history->previous = "";
                                $history->current = "";
                                $history->comment = $request->comment;
                                $history->user_id = Auth::user()->id;
                                $history->user_name = Auth::user()->name;
                                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                                $history->change_from = "Opened";
                                $history->change_to = "Closed-Cancelled";
                                $history->action_name = "Submit";
                                $history->stage = 'Plan Approved';
                                $history->save();
                                return back();
                            }
                            elseif ($study_data->stage == 2) {
                                $study_data->stage = "0";
                                $study_data->status = "Closed-Cancelled";
                                $study_data->person_cancel_by = Auth::user()->name;
                                $study_data->person_cancel_on = Carbon::now()->format('d-M-Y');
                                $study_data->person_cancel_comment = $request->comment;
                                $study_data->save();

                                $history = new GcpStudyAuditTrail();
                                $history->gcp_study_id = $id;
                                $history->activity_type = 'Activity Log';
                                $history->previous = "";
                                $history->current = "";
                                $history->comment = $request->comment;
                                $history->user_id = Auth::user()->id;
                                $history->user_name = Auth::user()->name;
                                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                                $history->change_from = "Study In Progress";
                                $history->change_to = "Closed-Cancelled";
                                $history->action_name = "Submit";
                                $history->stage = 'Plan Approved';
                                $history->save();
                                return back();
                            }
                          }
                            else {
                                toastr()->error('E-signature Not match');
                                return back();
                            }
                }

                //Audit child button

               public function GCP_study_child(Request $request, $id){

                    $study_data = GcpStudy::find($id);

                    if($study_data->stage == 2){

                        //return redirect(route('supplier_contract.index'));
                    }

             }


                    //single Report start

                    public function GCP_studySingleReport(Request $request, $id){

                        $study_data = GcpStudy::find($id);
                        //$users = User::all();
                        $grid_DataA = GCPStudyGrid::where(['gcp_study_id' => $id, 'identifier' => 'audit_site_information'])->first();
                        $grid_DataS = GCPStudyGrid::where(['gcp_study_id' => $id, 'identifier' => 'study_site_information'])->first();
                        if (!empty($study_data)) {
                            $study_data->data = GCPStudyGrid::where('gcp_study_id', $id)->where('identifier', "audit_site_information")->first();
                            $study_data->data = GCPStudyGrid::where('gcp_study_id', $id)->where('identifier', "study_site_information")->first();

                            $study_data->originator = User::where('id', $study_data->initiator_id)->value('name');
                            $study_data->assign_to_gi = User::where('id', $study_data->assign_to_gi)->value('name');
                            $pdf = App::make('dompdf.wrapper');
                            $time = Carbon::now();
                            $pdf = PDF::loadview('frontend.new_forms.GCP_studySingleReport', compact('study_data','grid_DataA','grid_DataS'))
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
                            $canvas->page_text($width / 4, $height / 2, $study_data->status, null, 25, [0, 0, 0], 2, 6, -20);
                            return $pdf->stream('GCP_study' . $id . '.pdf');
                        }
                    }


                    //Audit Trail Start

                    public function GCP_studyAuditTrial($id){

                        $audit = GcpStudyAuditTrail::where('gcp_study_id', $id)->orderByDESC('id')->paginate(5);
                        // dd($audit);
                        $today = Carbon::now()->format('d-m-y');
                        $document = GcpStudy::where('id', $id)->first();
                        $document->originator = User::where('id', $document->initiator_id)->value('name');
                        // dd($document);

                        return view('frontend.new_forms.GCP_studyAuditTrail',compact('document','audit','today'));
                    }

                    //Audit Trail Report Start
                    public function GCP_study_AuditTrailPdf($id)
                    {
                        $doc = GcpStudy::find($id);
                        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                        $data = GcpStudyAuditTrail::where('gcp_study_id', $doc->id)->orderByDesc('id')->get();
                        $pdf = App::make('dompdf.wrapper');
                        $time = Carbon::now();
                        $pdf = PDF::loadview('frontend.new_forms.GCP_studyAuditTrailPdf', compact('data', 'doc'))
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




