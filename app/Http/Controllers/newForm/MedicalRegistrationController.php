<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use App\Models\MedicalDeviceRegistration;
use App\Models\MedicalDeviceAudit;
use App\Models\Medical_Device_Grid;
use App\Models\QMSDivision;
use App\Models\User;
use Helpers;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use Carbon\Carbon;

class MedicalRegistrationController extends Controller
{
    public function index()
    {
        $old_record = MedicalDeviceRegistration::select('id', 'division_id', 'record_number')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $division = QMSDivision::where('status', '1')->get();

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date_gi = $formattedDate->format('Y-m-d');
        $users = User::all();

        // $registrations = MedicalDeviceRegistration::all();
        return view('frontend.medical.medical_device_registration', compact('old_record','division','record_number','formattedDate','currentDate','due_date_gi','users'));
    }

    public function medicalCreate(Request $request)
    {

        // $recordCounter = RecordNumber::first();
        // $newRecordNumber = $recordCounter->counter + 1;
        // $recordCounter->counter = $newRecordNumber;
        // $recordCounter->save();
        // dd($request->all());

        $data = new MedicalDeviceRegistration();

        $data->record_number = ((RecordNumber::first()->value('counter')) + 1);

        $data->initiator_id= Auth::user()->id;
        $data->division_id = $request->division_id;
        $data->type = "Medical Device Registration";
        $data->date_of_initiation = $request->date_of_initiation;
        $data->assign_to = $request->assign_to;
        $data->due_date_gi = $request->due_date_gi;
        $data->due_date_gi = Carbon::now()->addDays(30)->format('d-m-y');
        $data->short_description= $request->short_description;
        $data->registration_type_gi = $request->registration_type_gi;
        $data->parent_record_number = $request->parent_record_number;
        $data->local_record_number = $request->local_record_number;
        $data->zone_departments  = $request->zone_departments;
        $data->country_number = $request->country_number;
        $data->regulatory_departments = $request->regulatory_departments;
        $data->registration_number = $request->registration_number;
        $data->risk_based_departments = $request->risk_based_departments;
        $data->device_approval_departments = $request->device_approval_departments;
        $data->marketing_auth_number = $request->marketing_auth_number;
        $data->manufacturer_number = $request->manufacturer_number;
        $data->audit_agenda_grid = $request->audit_agenda_grid;
        $data->manufacturing_description = $request->manufacturing_description;
        $data->dossier_number = $request->dossier_number;
        $data->dossier_departments = $request->dossier_departments;
        $data->description = $request->description;
        $data->planned_submission_date = $request->planned_submission_date;
        $data->actual_submission_date = $request->actual_submission_date;
        $data->actual_approval_date = $request->actual_approval_date;
        $data->actual_rejection_date = $request->actual_rejection_date;
        $data->renewal_departments = $request->renewal_departments;
        $data->next_renewal_date = $request->next_renewal_date;
        $data->stage = "1";
        $data->status = "Opened";

        if (!empty ($request->Audit_file)) {
            $files = [];
            if ($request->hasfile('Audit_file')) {
                foreach ($request->file('Audit_file') as $file) {
                    $name = $request->name . 'Audit_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $data->file_attachment_gi = json_encode($files);
        }

        $data->save();

        $record_number = RecordNumber::first();
        $record_number->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record_number->update();


        $packageGrid = Medical_Device_Grid::where(['mdg_id' => $data->id, 'identifier'=>'packagedetail'])->firstOrCreate();
        $packageGrid->mdg_id = $data->id;
                $packageGrid->identifier = 'packagedetail';
        $packageGrid->data = $request->packagedetail;
        //   dd($packageGrid);
        $packageGrid->save();

        if (!empty($request->dossier_departments)) {
            $validation2 = new MedicalDeviceAudit();
            $validation2->medical_id = $data->id;
            $validation2->activity_type = 'dossier_departments';
            $validation2->previous = "Null";
            $validation2->current = $request->dossier_departments;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Opened";
            $validation2->change_from = "Initiator";
            $validation2->action_name = 'Create';
            $validation2->save();
        }
        if (!empty($request->planned_submission_date)) {
            $validation2 = new MedicalDeviceAudit();
            $validation2->medical_id = $data->id;
            $validation2->activity_type = 'planned_submission_date';
            $validation2->previous = "Null";
            $validation2->current = $request->planned_submission_dater;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Opened";
            $validation2->change_from = "Initiator";
            $validation2->action_name = 'Create';
            $validation2->save();
        }
        if (!empty($request->actual_submission_date)) {
            $validation2 = new MedicalDeviceAudit();
            $validation2->medical_id = $data->id;
            $validation2->activity_type = 'actual_submission_date';
            $validation2->previous = "Null";
            $validation2->current = $request->actual_submission_date;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Opened";
            $validation2->change_from = "Initiator";
            $validation2->action_name = 'Create';
            $validation2->save();
        }

        if (!empty($request->actual_approval_date)) {
            $validation2 = new MedicalDeviceAudit();
            $validation2->medical_id = $data->id;
            $validation2->activity_type = 'actual_approval_date';
            $validation2->previous = "Null";
            $validation2->current = $request->actual_approval_date;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Opened";
            $validation2->change_from = "Initiator";
            $validation2->action_name = 'Create';
            $validation2->save();
        }

        if (!empty($request->actual_rejection_date)) {
            $validation2 = new MedicalDeviceAudit();
            $validation2->medical_id = $data->id;
            $validation2->activity_type = 'actual_rejection_date';
            $validation2->previous = "Null";
            $validation2->current = $request->actual_rejection_date;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Opened";
            $validation2->change_from = "Initiator";
            $validation2->action_name = 'Create';
            $validation2->save();
        }
        if (!empty($request->renewal_departments)) {
            $validation2 = new MedicalDeviceAudit();
            $validation2->medical_id = $data->id;
            $validation2->activity_type = 'renewal_departments';
            $validation2->previous = "Null";
            $validation2->current = $request->renewal_departments;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Opened";
            $validation2->change_from = "Initiator";
            $validation2->action_name = 'Create';
            $validation2->save();
        }


        if (!empty($request->next_renewal_date)) {
            $validation2 = new MedicalDeviceAudit();
            $validation2->medical_id = $data->id;
            $validation2->activity_type = 'next_renewal_date';
            $validation2->previous = "Null";
            $validation2->current = $request->next_renewal_date;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Opened";
            $validation2->change_from = "Initiator";
            $validation2->action_name = 'Create';
            $validation2->save();
        }


        if (!empty($request->manufacturer_number)) {
            $validation2 = new MedicalDeviceAudit();
            $validation2->medical_id = $data->id;
            $validation2->activity_type = 'manufacturer_number';
            $validation2->previous = "Null";
            $validation2->current = $request->manufacturer_number;
            $validation2->comment = "NA";
            $validation2->user_id = Auth::user()->id;
            $validation2->user_name = Auth::user()->name;
            $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

            $validation2->change_to =   "Opened";
            $validation2->change_from = "Initiator";
            $validation2->action_name = 'Create';
            $validation2->save();
        }


        if (!empty($request->short_description)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
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
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = ' Date of Initiation ';
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
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
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

            if (!empty($request->due_date_gi)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = ' Due Date';
                $validation2->previous = "Null";
                $validation2->current = $request->due_date_gi;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->registration_type_gi)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'Type';
                $validation2->previous = "Null";
                $validation2->current = $request->registration_type_gi;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->registration_number)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'registration_number';
                $validation2->previous = "Null";
                $validation2->current = $request->registration_number;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->manufacturing_description)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'manufacturing_description';
                $validation2->previous = "Null";
                $validation2->current = $request->manufacturing_description;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->dossier_number)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'Dossier Parts';
                $validation2->previous = "Null";
                $validation2->current = $request->dossier_number;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->file_attachment_gi)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'file_attachment_gi';
                $validation2->previous = "Null";
                $validation2->current = $request->file_attachment_gi;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            if (!empty($request->zone_departments)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'zone';
                $validation2->previous = "Null";
                $validation2->current = $request->zone_departments;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->description)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'Description';
                $validation2->previous = "Null";
                $validation2->current = $request->description;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->country_number)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'country';
                $validation2->previous = "Null";
                $validation2->current = $request->country_number;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->parent_record_number)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'Parent Record Name';
                $validation2->previous = "Null";
                $validation2->current = $request->parent_record_numbert;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->regulatory_departments)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'regulatory_departments';
                $validation2->previous = "Null";
                $validation2->current = $request->regulatory_departments;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->local_record_number)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'local_record_number';
                $validation2->previous = "Null";
                $validation2->current = $request->calibration_frequency;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->registration_number)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'Registration Number';
                $validation2->previous = "Null";
                $validation2->current = $request->registration_number;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->risk_based_departments)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'risk_based_departments';
                $validation2->previous = "Null";
                $validation2->current = $request->risk_based_departments;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            if (!empty($request->device_approval_departments)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'device_approval_departments';
                $validation2->previous = "Null";
                $validation2->current = $request->next_pm_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->marketing_auth_number)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'marketing_auth_Holder';
                $validation2->previous = "Null";
                $validation2->current = $request->marketing_auth_number;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            if (!empty($request->audit_agenda_grid)) {
                $validation2 = new MedicalDeviceAudit();
                $validation2->medical_id = $data->id;
                $validation2->activity_type = 'audit_agenda_grid';
                $validation2->previous = "Null";
                $validation2->current = $request->audit_agenda_grid;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiator";
                $validation2->action_name = 'Create';
                $validation2->save();
            }



        toastr()->success("Medical_Device _Grid is created succusfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    public function medicalEdit($id) {
        $data = MedicalDeviceRegistration::findOrFail($id);
        // $old_record = MedicalDeviceRegistration::select('id', 'division_id', 'record_number')->get();
        // $record_number = ((RecordNumber::first()->value('counter')) + 1);
        // $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        // $division = QMSDivision::where('status', '1')->get();


        // $gridData = Medical_Device_Grid::where('mdg_id', $id)->first();
        // dd($gridData);
        $division = QMSDivision::where('status', '1')->get();
        $users = User::all();
        $gridMedical = Medical_Device_Grid::where(['mdg_id' => $id, 'identifier'=>'packagedetail'])->first();
        //  dd($gridMedical);
// dd( $data);
        return view('frontend.medical.view_medical_registration', compact('data', 'users','division','gridMedical'));
    }


public function medicalUpdate(Request $request, $id) {
// dd($request->all());
    $data = MedicalDeviceRegistration::findOrFail($id);
    $data->initiator_id= Auth::user()->id;

    // $data->record_number = $request->record_number;
    $data->date_of_initiation = $request->date_of_initiation;
    $data->assign_to= $request->assign_to;
    $data->due_date_gi = $request->due_date_gi;
    $data->short_description= $request->short_description;
    $data->registration_type_gi = $request->registration_type_gi;
    // $data->file_attachment_gi = $request->file_attachment_gi;
    $data->parent_record_number = $request->parent_record_number;
    $data->local_record_number = $request->local_record_number;
    $data->zone_departments  = $request->zone_departments;
    $data->country_number = $request->country_number;
    $data->regulatory_departments = $request->regulatory_departments;
    $data->registration_number = $request->registration_number;
    $data->risk_based_departments = $request->risk_based_departments;
    $data->device_approval_departments = $request->device_approval_departments;
    $data->marketing_auth_number = $request->marketing_auth_number;
    $data->manufacturer_number = $request->manufacturer_number;
    $data->audit_agenda_grid = $request->audit_agenda_grid;
    $data->manufacturing_description = $request->manufacturing_description;
    $data->dossier_number = $request->dossier_number;
    $data->dossier_departments = $request->dossier_departments;
    $data->description = $request->description;
    $data->planned_submission_date = $request->planned_submission_date;
    $data->actual_submission_date = $request->actual_submission_date;
    $data->actual_approval_date = $request->actual_approval_date;
    $data->actual_rejection_date = $request->actual_rejection_date;
    $data->renewal_departments = $request->renewal_departments;
    $data->next_renewal_date = $request->next_renewal_date;
    $data->division_id = $request->division_id;

    if (!empty ($request->Audit_file)) {
        $files = [];
        if ($request->hasfile('Audit_file')) {
            foreach ($request->file('Audit_file') as $file) {
                $name = $request->name . 'Audit_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                $file->move('upload/', $name);
                $files[] = $name;
            }
        }


        $data->file_attachment_gi = json_encode($files);
    }


    // dd($data->manufacturer_number);
    $data->update();
    $packagegrid = Medical_Device_Grid::where([ 'mdg_id' => $data->id,  'identifier' => 'packagedetail'  ])->firstOrNew();

    $packagegrid->mdg_id = $data->id;
    $packagegrid->identifier = 'packagedetail';
    $packagegrid->data = $request->packagedetail;
    $packagegrid->update();

    toastr()->success("Record is updated succusfully");
    return back();

}


public function medical_registration_send_stage(Request $request, $id)
{
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $medical = MedicalDeviceRegistration::find($id);
        $lastDocument = MedicalDeviceRegistration::find($id);

        if (!$medical) {
            toastr()->error('Medical Registration not found');
            return back();
        }

        if ($medical->stage == 1) {
            $medical->stage = "2";
            $medical->status = " Device and Directive Classification";
            $medical->assign_by = Auth::user()->name;
            $medical->assign_on = Carbon::now()->format('d-m-y');
            $medical->comment = $request->comment;



            $medical->update();
            toastr()->success('Document Sent');
            return back();
        }

        if ($medical->stage == 2) {
            $medical->stage = "3";
            $medical->status = "Dossier Finalization";
            $medical->classify_by = Auth::user()->name;
            $medical->classify_on = Carbon::now()->format('d-m-y');
            $medical->classify_comment = $request->comment;



            $medical->update();
            toastr()->success('Document Sent');
            return back();
        }

        if ($medical->stage == 3) {
            $medical->stage = "4";
            $medical->status = " Pending Registration Approval";
            $medical->submit_by = Auth::user()->name;
            $medical->submit_on = Carbon::now()->format('d-m-y');
            $medical->submit_comment = $request->comment;


            $medical->update();
            toastr()->success('Document Sent');
            return back();
        }

        if ($medical->stage == 4) {
            $medical->stage = "7";
            $medical->status = " Pending Registration Approval";
            $medical->received_by = Auth::user()->name;
            $medical->received_on = Carbon::now()->format('d-m-y');
            $medical->received_comment = $request->comment;


    } else {
        toastr()->error('E-signature Not match');
        return back();
    }
    }
}

public function medical_deviceCancel(Request $request, $id)
{
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $medical = MedicalDeviceRegistration::find($id);
        $lastDocument = MedicalDeviceRegistration::find($id);

        if ($medical->stage == 1) {
            $medical->stage = "0";
            $medical->status = "Closed-Cancelled";
            $medical->cancel_by = Auth::user()->name;
            $medical->cancel_on = Carbon::now()->format('d-m-y');
            $medical->cancel_comment = $request->comment;



            $medical->update();
            toastr()->success('Document Sent');
            return back();
        }

        if ($medical->stage == 3) {
            $medical->stage = "0";
            $medical->status = "Closed-Cancelled";
            $medical->cancelled_by = Auth::user()->name;
            $medical->cancelled_on = Carbon::now()->format('d-m-y');
            $medical->cancelled_comment = $request->comment;



            $medical->update();
            toastr()->success('Document Sent');
            return back();
        }



            if ($medical->stage == 4) {
                $medical->stage = "5";
                $medical->status = " Closed - Withdrawn";

                $medical->withdraw_by = Auth::user()->name;
                $medical->withdraw_on = Carbon::now()->format('d-m-y');
                $medical->withdraw_comment = $request->comment;



                $medical->update();
                toastr()->success('Document Sent');
                return back();
            }
            // if ($medical->stage == 4) {
            //     $medical->stage = "6";
            //     $medical->status = "Closed – Not Approved";

            //     $medical->refused_by = Auth::user()->name;
            //     $medical->refused_on = Carbon::now()->format('d-m-y');
            //     $medical->refused_comment = $request->comment;

            //     $medical->update();
            //     toastr()->success('Document Sent');
            //     return back();
            // }

            if ($medical->stage == 4) {
                $medical->stage = "7";
                $medical->status = "Closed - Approved";
                $medical->received_by = Auth::user()->name;
                $medical->received_on = Carbon::now()->format('d-m-y');
                $medical->received_comment = $request->comment;




                $medical->update();
                toastr()->success('Document Sent');
                return back();
            }




        } else {
            toastr()->error('E-signature Not match');
            return back();
        }

}

public function canceltwo(Request $request,$id){
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $medical = MedicalDeviceRegistration::find($id);
        $lastDocument = MedicalDeviceRegistration::find($id);


            if ($medical->stage == 4) {
                $medical->stage = "6";
                $medical->status = "Closed – Not Approved";

                $medical->refused_by = Auth::user()->name;
                $medical->refused_on = Carbon::now()->format('d-m-y');
                $medical->refused_comment = $request->comment;



                $medical->update();
                toastr()->success('Document Sent');
                return back();
            }
    }

}

// public function cancelthree(Request $request,$id){
//     if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
//         $medical = MedicalDeviceRegistration::find($id);


//             if ($medical->stage == 4) {
//                 $medical->stage = "7";
//                 $medical->status = "Closed – Approved";

//                 $medical->received_by = Auth::user()->name;
//                 $medical->received_on = Carbon::now()->format('d-m-y');
//                 $medical->received_comment = $request->comment;

//                 $medical->update();
//                 toastr()->success('Document Sent');
//                 return back();
//             }
//     }

// }

public function medical_device_reject(Request $request, $id){
    if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $medical =  MedicalDeviceRegistration::find($id);
        $lastDocument = MedicalDeviceRegistration::find($id);

        if ($medical->stage == 2) {
            $medical->stage = "1";
            $medical->status = "Opened";
            $medical->reject_by = Auth::user()->name;
            $medical->reject_on = Carbon::now()->format('d-m-y');
            $medical->reject_comment = $request->comment;


            $medical->update();
            toastr()->success('Document Sent');
            return back();
        }
    }

}


public function CorrespondenceChild(Request $request,$id){
    if($request->revision =="correspondence"){
    return view ('frontend.New_forms.correspondence');
}
    if($request->revision == "variation"){
    return view('frontend.Registration-Tracking.variation');
}

return redirect()->back()->with('error', 'Invalid revision type.');

}

public function medicalAudit($id){

    $audit = MedicalDeviceAudit::where('medical_id', $id)->orderByDESC('id')->get()->unique('activity_type');
    $today = Carbon::now()->format('d-m-y');
    $document = MedicalDeviceRegistration::where('id', $id)->first();
    $document->initiator = User::where('id', $document->initiator_id)->value('name');
    return view('frontend.medical.medical_RegistrationAudit', compact('audit', 'document', 'today'));
}


 public function medicalauditReport($id){

        $doc = MedicalDeviceRegistration::find($id);
        $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        $data = MedicalDeviceAudit::where('medical_id', $doc->id)->orderByDesc('id')->get();
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.medical.medicalRegister_auditReport', compact('data', 'doc'))
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

public function medicalAuditDetails($id){

    $detail = MedicalDeviceAudit::find($id);
    $detail_data = MedicalDeviceAudit::where('activity_type', $detail->activity_type)->where('medical_id', $detail->medical_id)->latest()->get();
    $doc = MedicalDeviceRegistration::where('id', $detail->medical_id)->first();
    $doc->origiator_name = User::find($doc->initiator_id);
    return view('frontend.medical.medical_RegistrationAuditDetails', compact('detail', 'doc', 'detail_data'));
}


public function medicalauditSingleReport($id){

    $data = MedicalDeviceRegistration::find($id);


    if (!empty($data)) {
        $data->originator = User::where('id', $data->initiator_id)->value('name');

        $doc = MedicalDeviceAudit::where('medical_id', $data->id)->first();
        $detail_data = MedicalDeviceAudit::where('activity_type', $data->activity_type)
            ->where('medical_id', $data->field_id)
            ->latest()
            ->get();

        // pdf related work
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.medical.medical_registrationSingleReport', compact(
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
            return $pdf->stream('Medical Device Registration' . $id . '.pdf');

    }

    return redirect()->back()->with('error', 'medical device registration not found.');
}


}




