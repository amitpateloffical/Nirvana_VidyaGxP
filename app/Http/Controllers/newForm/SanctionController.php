<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\Extension;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\Sanction;
use App\Models\SanctionAudit;
use App\Models\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class SanctionController extends Controller
{
    public function index()
    {

        $old_record = Sanction::select('id', 'division_id', 'record')->get();
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.New_forms.sanction.sanction', compact('old_record', 'record_number', 'currentDate', 'formattedDate', 'due_date'));
    }

    public function sanctionStore(Request $request)
    {

        try {
            $recordCounter = RecordNumber::first();
            $newRecordNumber = $recordCounter->counter + 1;

            $recordCounter->counter = $newRecordNumber;
            $recordCounter->save();

            $sanction = new Sanction();

            $sanction->stage = '1';
            $sanction->status = 'Opened';
            $sanction->form_type = 'Sanction';
            $sanction->parent_id = $request->parent_id;
            $sanction->parent_type = $request->parent_type;
            $sanction->record = $newRecordNumber;

            $sanction->initiator_id = Auth::user()->id;
            $sanction->user_name = Auth::user()->name;
            $sanction->initiator = $request->initiator;
            $sanction->initiation_date = $request->initiation_date;
            $sanction->short_description = $request->short_description;
            $sanction->originator = Auth::user()->name;
            $sanction->assign_to = $request->assign_to;
            $sanction->due_date = $request->due_date;

            if (!empty($request->file_attach)) {
                $files = [];
                if ($request->hasfile('file_attach')) {
                    foreach ($request->file('file_attach') as $file) {
                        $name = $request->name . 'file_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $sanction->file_attach = json_encode($files);
            }

            $sanction->sanction_type = $request->sanction_type;
            $sanction->description = $request->description;
            $sanction->authority_type = $request->authority_type;
            $sanction->authority = $request->authority;
            $sanction->fine = $request->fine;
            $sanction->currency = $request->currency;

            $sanction->save();

            //===========audit trails ===========//


            if (!empty($request->short_description)) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->previous = "Null";
                $validation2->current = $request->short_description;
                $validation2->activity_type = 'Short Description';
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                // $validation2->comment = "Not Applicable";
                $validation2->save();
            }

            if (!empty($request->originator)) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Originator';
                $validation2->previous = "Null";
                $validation2->current = $request->originator;
                $validation2->comment = "Not Applicable";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->assign_to)) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
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

            if (!empty($request->due_date)) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Due Date';
                $validation2->previous = "Null";
                $validation2->current = $request->due_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to = "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->sanction_type)) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Type of Sanction';
                $validation2->previous = "Null";
                $validation2->current = $request->sanction_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->file_attach)) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'File Attachments';
                $validation2->previous = "Null";
                $validation2->current = json_encode($request->file_attach);
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';

                $validation2->save();
            }

            if (!empty($request->description)) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Description';
                $validation2->previous = "Null";
                $validation2->current = $request->description;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->authority_type)) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Authority Type';
                $validation2->previous = "Null";
                $validation2->current = $request->authority_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->authority)) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Authority';
                $validation2->previous = "Null";
                $validation2->current = $request->authority;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            if (!empty($request->fine)) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Fine';
                $validation2->previous = "Null";
                $validation2->current = $request->fine;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }

            if (!empty($request->currency)) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Currency';
                $validation2->previous = "Null";
                $validation2->current = $request->currency;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Opened";
                $validation2->change_from = "Initiation";
                $validation2->action_name = 'Create';
                $validation2->save();
            }


            toastr()->success("Sanction is created Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to save Sanction : ' . $e->getMessage());
        }
    }

    public function sanctionEdit($id)
    {
        $sanction = Sanction::findOrFail($id);

        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('Y-m-d');
        return view('frontend.New_forms.sanction.sanctionUpdate', compact('sanction', 'due_date'));
    }

    public function sanctionUpdate(Request $request, $id)
    {
        try {
            // $recordCounter = RecordNumber::first();

            // $newRecordNumber = $recordCounter->counter + 1;

            // $recordCounter->counter = $newRecordNumber;
            // $recordCounter->save();
            $lastDocument = Sanction::find($id);
            $sanction = Sanction::findOrFail($id);

            $sanction->form_type = 'Sanction';
            $sanction->parent_id = $request->parent_id;
            $sanction->parent_type = $request->parent_type;
            // $sanction->record = $newRecordNumber;

            $sanction->initiator_id = Auth::user()->id;
            $sanction->user_name = Auth::user()->name;
            // $sanction->initiator = $request->initiator;
            // $sanction->initiation_date = $request->initiation_date;
            $sanction->short_description = $request->short_description;
            // $sanction->originator = Auth::user()->name;
            $sanction->assign_to = $request->assign_to;
            // $sanction->due_date = $request->due_date;

            $sanction->sanction_type = $request->sanction_type;
            $sanction->description = $request->description;
            $sanction->authority_type = $request->authority_type;
            $sanction->authority = $request->authority;
            $sanction->fine = $request->fine;
            $sanction->currency = $request->currency;

            if (!empty($request->file_attach)) {
                $files = [];
                if ($request->hasfile('file_attach')) {
                    foreach ($request->file('file_attach') as $file) {
                        $name = $request->name . 'file_attach' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }
                $sanction->file_attach = json_encode($files);
            }

            $sanction->update();


            //===========audit trails update===========//


            if ($lastDocument->short_description != $request->short_description) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->previous = "Null";
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

            if ($lastDocument->originator != $request->originator) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Originator';
                $validation2->previous = "Null";
                $validation2->current = $request->originator;
                $validation2->comment = "Not Applicable";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->originator) || $lastDocument->originator === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->assign_to != $request->assign_to) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Assign To';
                $validation2->previous = "Null";
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

            if ($lastDocument->due_date != $request->due_date) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Due Date';
                $validation2->previous = "Null";
                $validation2->current = $request->due_date;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->due_date) || $lastDocument->due_date === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->sanction_type != $request->sanction_type) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Type of Sanction';
                $validation2->previous = "Null";
                $validation2->current = $request->sanction_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->sanction_type) || $lastDocument->sanction_type === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->file_attach != $request->file_attach) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'File Attachments';
                $validation2->previous = json_encode($lastDocument->file_attach);
                $validation2->current = json_encode($request->file_attach);
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;

                if (is_null($lastDocument->file_attach) || $lastDocument->file_attach === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }

                $validation2->save();
            }

            if ($lastDocument->description != $request->description) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Description';
                $validation2->previous = "Null";
                $validation2->current = $request->description;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->description) || $lastDocument->description === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->authority_type != $request->authority_type) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Authority Type';
                $validation2->previous = "Null";
                $validation2->current = $request->authority_type;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->authority_type) || $lastDocument->authority_type === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->authority != $request->authority) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Authority';
                $validation2->previous = "Null";
                $validation2->current = $request->authority;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->authority) || $lastDocument->authority === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }


            if ($lastDocument->fine != $request->fine) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Fine';
                $validation2->previous = "Null";
                $validation2->current = $request->fine;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->fine) || $lastDocument->fine === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            if ($lastDocument->currency != $request->currency) {
                $validation2 = new SanctionAudit();
                $validation2->sanction_id = $sanction->id;
                $validation2->activity_type = 'Currency';
                $validation2->previous = "Null";
                $validation2->current = $request->currency;
                $validation2->comment = "NA";
                $validation2->user_id = Auth::user()->id;
                $validation2->user_name = Auth::user()->name;
                $validation2->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');

                $validation2->change_to =   "Not Applicable";
                $validation2->change_from = $lastDocument->status;
                if (is_null($lastDocument->currency) || $lastDocument->currency === '') {
                    $validation2->action_name = 'New';
                } else {
                    $validation2->action_name = 'Update';
                }
                $validation2->save();
            }

            toastr()->success("Sanction is Update Successfully");
            return redirect(url('rcms/qms-dashboard'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Failed to update Sanction : ' . $e->getMessage());
        }
    }

    public function sanctionCancel(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $equipment = Sanction::find($id);

            if ($equipment->stage == 1) {
                $equipment->stage = "2";
                $equipment->status = "Closed";
                $equipment->update();
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

    public function audit_Sanction($id)
    {
        $sanction = Sanction::find($id);
        $audit = SanctionAudit::where('sanction_id', $id)->orderByDESC('id')->paginate(15);
        // dd($audit);
        $today = Carbon::now()->format('d-m-y');
        $document = Sanction::where('id', $id)->first();
        $document->originator = User::where('id', $document->initiator_id)->value('name');

        return view('frontend.New_forms.sanction.audit_sanction', compact('document', 'audit', 'today', 'sanction'));
    }

    public function sanctionAuditTrialDetails($id)
    {
        $detail = SanctionAudit::find($id);
        $detail_data = SanctionAudit::where('activity_type', $detail->activity_type)->where('sanction_id', $detail->sanction_id)->latest()->get();
        $doc = Sanction::where('id', $detail->sanction_id)->first();
        // $doc->origiator_name =  User::where('id', $document->initiator_id)->value('name');
        return view('frontend.New_forms.sanction.sanction_audit_details', compact('detail', 'doc', 'detail_data'));
    }

    public function singleReport($id)
    {
        $data = Sanction::find($id);
        if (!empty($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');

            $doc = SanctionAudit::where('sanction_id', $data->id)->first();
            $detail_data = SanctionAudit::where('activity_type', $data->activity_type)
                ->where('sanction_id', $data->sanction_id)
                ->latest()
                ->get();

            // pdf related work
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.New_forms.sanction.singleSanctionReport', compact(
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
            return $pdf->stream('Sanction' . $id . '.pdf');
        }

        return redirect()->back()->with('error', 'Sanction not found.');
    }

    public function audit2_pdf($id)
    {
        $doc = Sanction::find($id);
        if (!empty($doc)) {
            $doc->originator = User::where('id', $doc->initiator_id)->value('name');
        } else {
            $datas = ActionItem::find($id);

            if (empty($datas)) {
                $datas = Extension::find($id);
                $doc = Sanction::find($datas->sanction_id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $doc->created_at = $datas->created_at;
            } else {
                $doc = Sanction::find($datas->sanction_id);
                $doc->originator = User::where('id', $doc->initiator_id)->value('name');
                $doc->created_at = $datas->created_at;
            }
        }
        $data = SanctionAudit::where('sanction_id', $doc->id)->orderByDesc('id')->get();
        // pdf related work
        $pdf = App::make('dompdf.wrapper');
        $time = Carbon::now();
        $pdf = PDF::loadview('frontend.New_forms.sanction.sanction_audit_trail_pdf', compact('data', 'doc'))
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

        return $pdf->stream('Sanction' . $id . '.pdf');
    }
}
