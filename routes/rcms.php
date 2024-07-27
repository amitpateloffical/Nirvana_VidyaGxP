<?php

use App\Http\Controllers\ctms\ClinicalSiteController;
use App\Http\Controllers\ctms\SubjectController;
use App\Http\Controllers\rcms\ActionItemController;
use App\Http\Controllers\rcms\AuditeeController;
use App\Http\Controllers\rcms\AuditProgramController;
use App\Http\Controllers\rcms\AuditTaskController;
use App\Http\Controllers\rcms\CapaController;
use App\Http\Controllers\rcms\CCController;
use App\Http\Controllers\rcms\DashboardController;
use App\Http\Controllers\rcms\DeviationController;
use App\Http\Controllers\rcms\EffectivenessCheckController;
use App\Http\Controllers\rcms\ExtensionController;
use App\Http\Controllers\rcms\FormDivisionController;
use App\Http\Controllers\rcms\InternalauditController;
use App\Http\Controllers\rcms\LabIncidentController;
use App\Http\Controllers\rcms\ManagementReviewController;
use App\Http\Controllers\rcms\ObservationController;
use App\Http\Controllers\rcms\RootCauseController;
use App\Http\Controllers\RiskManagementController;
use App\Http\Controllers\LabInvestigationController;
use App\Http\Controllers\rcms\DosierDocumentsController;
use App\Http\Controllers\rcms\PreventiveMaintenanceController;
use App\Http\Controllers\GcpStudyController;
use App\Http\Controllers\newForm\CalibrationController;
use App\Http\Controllers\newForm\EquipmentController;
use App\Http\Controllers\newForm\MonthlyWorkingController;
use App\Http\Controllers\newForm\NationalApprovalController;
use App\Http\Controllers\newForm\SanctionController;
use App\Http\Controllers\newForm\ValidationController;
use App\Http\Controllers\SupplierContractController;
use App\Http\Controllers\SubjectActionItemController;
use App\Http\Controllers\rcms\ViolationController;
use App\Http\Controllers\rcms\CTAAmendementController;
use App\Http\Controllers\rcms\CorrespondenceController;
use App\Http\Controllers\rcms\ContractTestingLabAuditController;
use App\Http\Controllers\rcms\FirstProductValidationController;
use App\Http\Controllers\UserLoginController;
use App\Models\EffectivenessCheck;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientInquiryController;
use App\Http\Controllers\MeetingManagementController;
use App\Http\Controllers\AdditionalInformationController;

use App\Http\Controllers\medicaldeviceController;
use App\Http\Controllers\MedicalDeviceController as ControllersMedicalDeviceController;
use App\Http\Controllers\PSURController;
use App\Http\Controllers\CommitmentController;

use App\Http\Controllers\MonitoringVisitController;
use App\Http\Controllers\RenewalController;

use App\Http\Controllers\AdditionalTestingController;
use App\Http\Controllers\AnalystInterviewController;
use App\Http\Controllers\ResamplingController;
use App\Http\Controllers\VerificationController;




// ============================================
//                   RCMS
//============================================

Route::group(['prefix' => 'rcms'], function () {
    Route::view('rcms', 'frontend.rcms.main-screen');
    Route::get('rcms_login', [UserLoginController::class, 'userlogin']);
    Route::view('rcms_dashboard', 'frontend.rcms.dashboard');
    Route::view('form-division', 'frontend.forms.form-division');
    Route::get('/logout', [UserLoginController::class, 'rcmslogout'])->name('rcms.logout');

    Route::middleware(['rcms'])->group(
        function () {

            Route::resource('CC', CCController::class);
            Route::resource('actionItem', ActionItemController::class);
            Route::post('action-stage-cancel/{id}', [ActionItemController::class, 'actionStageCancel']);
            Route::get('action-item-audittrialshow/{id}', [ActionItemController::class, 'actionItemAuditTrialShow'])->name('showActionItemAuditTrial');
            Route::get('action-item-audittrialdetails/{id}', [ActionItemController::class, 'actionItemAuditTrialDetails'])->name('showaudittrialactionItem');
            Route::get('actionitemSingleReport/{id}', [ActionItemController::class, 'singleReport'])->name('actionitemSingleReport');
            Route::get('actionitemAuditReport/{id}', [ActionItemController::class, 'auditReport'])->name('actionitemAuditReport');
            Route::get('effective-audit-trial-show/{id}', [EffectivenessCheckController::class, 'effectiveAuditTrialShow'])->name('show_effective_AuditTrial');
            Route::get('effective-audit-trial-details/{id}', [EffectivenessCheckController::class, 'effectiveAuditTrialDetails'])->name('show_audittrial_effective');
            Route::get('effectiveSingleReport/{id}', [EffectivenessCheckController::class, 'singleReport'])->name('effectiveSingleReport');
            Route::get('effectiveAuditReport/{id}', [EffectivenessCheckController::class, 'auditReport'])->name('effectiveAuditReport');

            // ------------------extension _child---------------------------
            Route::post('extension_child/{id}', [ExtensionController::class, 'extension_child'])->name('extension_child');
            Route::resource('extension', ExtensionController::class);
            Route::post('send-extension/{id}', [ExtensionController::class, 'stageChange']);
            Route::post('send-reject-extention/{id}', [ExtensionController::class, 'stagereject']);
            Route::post('send-cancel-extention/{id}', [ExtensionController::class, 'stagecancel']);
            Route::get('extension-audit-trial/{id}', [ExtensionController::class, 'extensionAuditTrial']);
            Route::get('extension-audit-trial-details/{id}', [ExtensionController::class, 'extensionAuditTrialDetails']);
            Route::get('extensionSingleReport/{id}', [ExtensionController::class, 'singleReport'])->name('extensionSingleReport');
            Route::get('extensionAuditReport/{id}', [ExtensionController::class, 'auditReport'])->name('extensionAuditReport');

            Route::post('send-At/{id}', [ActionItemController::class, 'stageChange']);
            Route::post('send-rejection-field/{id}', [CCController::class, 'stagereject']);
            Route::post('send-cft-field/{id}', [CCController::class, 'stageCFTnotReq']);

            Route::post('send-cancel/{id}', [CCController::class, 'stagecancel']);
            Route::post('send-cc/{id}', [CCController::class, 'stageChange']);
            Route::post('child/{id}', [CCController::class, 'child']);
            Route::get('qms-dashboard', [DashboardController::class, 'index']);
            Route::get('qms-dashboard/{id}/{process}', [DashboardController::class, 'dashboard_child']);
            Route::get('qms-dashboard_new/{id}/{process}', [DashboardController::class, 'dashboard_child_new']);
            Route::get('audit-trial/{id}', [CCController::class, 'auditTrial']);
            Route::get('audit-detail/{id}', [CCController::class, 'auditDetails']);
            Route::get('summary/{id}', [CCController::class, 'summery_pdf']);
            Route::get('audit/{id}', [CCController::class, 'audit_pdf']);




            Route::get('ccView/{id}/{type}', [DashboardController::class, 'ccView'])->name('ccView');
            Route::view('summary_pdf', 'frontend.change-control.summary_pdf');
            Route::view('audit_trial_pdf', 'frontend.change-control.audit_trial_pdf');
            Route::view('change_control_single_pdf', 'frontend.change-control.change_control_single_pdf');
            Route::get('change_control_family_pdf', [CCController::class, 'parent_child']);

            Route::get('change_control_single_pdf/{id}', [CCController::class, 'single_pdf']);
            Route::get('eCheck/{id}', [CCController::class, 'eCheck']);
            Route::resource('effectiveness', EffectivenessCheckController::class);
            Route::post('send-effectiveness/{id}', [EffectivenessCheckController::class, 'stageChange']);
            Route::post('effectiveness-reject/{id}', [EffectivenessCheckController::class, 'reject']);
            Route::post('cancel/{id}', [EffectivenessCheckController::class, 'cancel'])->name('moreinfo_effectiveness');
            Route::view('helpdesk-personnel', 'frontend.rcms.helpdesk-personnel');
            Route::view('send-notification', 'frontend.rcms.send-notification');
            Route::get('new-change-control', [CCController::class, 'changecontrol']);

            //----------------------------------------------By Pankaj-----------------------

            Route::post('audit', [InternalauditController::class, 'create'])->name('createInternalAudit');
            Route::get('internalAuditShow/{id}', [InternalauditController::class, 'internalAuditShow'])->name('showInternalAudit');
            Route::post('update/{id}', [InternalauditController::class, 'update'])->name('updateInternalAudit');
            Route::post('InternalAuditStateChange/{id}', [InternalauditController::class, 'InternalAuditStateChange'])->name('AuditStateChange');
            Route::get('InternalAuditTrialShow/{id}', [InternalauditController::class, 'InternalAuditTrialShow'])->name('ShowInternalAuditTrial');
            Route::get('InternalAuditTrialDetails/{id}', [InternalauditController::class, 'InternalAuditTrialDetails'])->name('showaudittrialinternalaudit');

            //-------------------------

            Route::post('labcreate', [LabIncidentController::class, 'create'])->name('labIncidentCreate');
            Route::get('LabIncidentShow/{id}', [LabIncidentController::class, 'LabIncidentShow'])->name('ShowLabIncident');
            Route::post('LabIncidentStateChange/{id}', [LabIncidentController::class, 'LabIncidentStateChange'])->name('StageChangeLabIncident');
            Route::post('RejectStateChangeEsign/{id}', [LabIncidentController::class, 'RejectStateChange'])->name('RejectStateChange');
            Route::post('updateLabIncident/{id}', [LabIncidentController::class, 'updateLabIncident'])->name('LabIncidentUpdate');
            Route::post('LabIncidentCancel/{id}', [LabIncidentController::class, 'LabIncidentCancel'])->name('LabIncidentCancel');
            Route::post('LabIncidentChildCapa/{id}', [LabIncidentController::class, 'lab_incident_capa_child'])->name('lab_incident_capa_child');
            Route::post('LabIncidentChildRoot/{id}', [LabIncidentController::class, 'lab_incident_root_child'])->name('lab_incident_root_child');
            Route::get('LabIncidentAuditTrial/{id}', [LabIncidentController::class, 'LabIncidentAuditTrial'])->name('audittrialLabincident');
            Route::get('auditDetailsLabIncident/{id}', [LabIncidentController::class, 'auditDetailsLabIncident'])->name('LabIncidentauditDetails');
            Route::post('root_cause_analysis/{id}', [LabIncidentController::class, 'root_cause_analysis'])->name('Child_root_cause_analysis');
            Route::get('LabIncidentSingleReport/{id}', [LabIncidentController::class, 'singleReport'])->name('LabIncidentSingleReport');
            Route::get('LabIncidentAuditReport/{id}', [LabIncidentController::class, 'auditReport'])->name('LabIncidentAuditReport');
            //------------------------------------

            Route::post('create', [AuditProgramController::class, 'create'])->name('createAuditProgram');
            Route::get('AuditProgramShow/{id}', [AuditProgramController::class, 'AuditProgramShow'])->name('ShowAuditProgram');
            Route::post('AuditStateChange/{id}', [AuditProgramController::class, 'AuditStateChange'])->name('StateChangeAuditProgram');
            Route::post('AuditRejectStateChange/{id}', [AuditProgramController::class, 'AuditRejectStateChange'])->name('AuditProgramStateRecject');
            Route::post('UpdateAuditProgram/{id}', [AuditProgramController::class, 'UpdateAuditProgram'])->name('AuditProgramUpdate');
            Route::get('AuditProgramTrialShow/{id}', [AuditProgramController::class, 'AuditProgramTrialShow'])->name('showAuditProgramTrial');
            Route::get('auditProgramDetails/{id}', [AuditProgramController::class, 'auditProgramDetails'])->name('auditProgramAuditTrialDetails');
            Route::post('child_audit_program/{id}', [AuditProgramController::class, 'child_audit_program'])->name('auditProgramChild');
            Route::post('AuditProgramCancel/{id}', [AuditProgramController::class, 'AuditProgramCancel'])->name('AuditProgramCancel');
            Route::get('auditProgramSingleReport/{id}', [AuditProgramController::class, 'singleReport'])->name('auditProgramSingleReport');
            Route::get('auditProgramAuditReport/{id}', [AuditProgramController::class, 'auditReport'])->name('auditProgramAuditReport');

            Route::get('observationshow/{id}', [ObservationController::class, 'observationshow'])->name('showobservation');
            Route::post('observationstore', [ObservationController::class, 'observationstore'])->name('observationstore');
            Route::post('observationupdate/{id}', [ObservationController::class, 'observationupdate'])->name('observationupdate');
            Route::post('observation_send_stage/{id}', [ObservationController::class, 'observation_send_stage'])->name('observation_change_stage');
            Route::post('RejectStateChange/{id}', [ObservationController::class, 'RejectStateChange'])->name('RejectStateChangeObservation');
            Route::post('observation_child/{id}', [ObservationController::class, 'observation_child'])->name('observationchild');
            Route::post('boostStage/{id}', [ObservationController::class, 'boostStage'])->name('updatestageobservation');
            Route::get('ObservationAuditTrialShow/{id}', [ObservationController::class, 'ObservationAuditTrialShow'])->name('ShowObservationAuditTrial');
            Route::get('ObservationAuditTrialDetails/{id}', [ObservationController::class, 'ObservationAuditTrialDetails'])->name('showaudittrialobservation');

            //----------------------------------------------By PRIYA SHRIVASTAVA------------------
            Route::post('formDivision', [FormDivisionController::class, 'formDivision'])->name('formDivision');
            Route::get('ExternalAuditSingleReport/{id}', [AuditeeController::class, 'singleReport'])->name('ExternalAuditSingleReport');
            Route::get('ExternalAuditTrialReport/{id}', [AuditeeController::class, 'auditReport'])->name('ExternalAuditTrialReport');
            Route::get('capaSingleReport/{id}', [CapaController::class, 'singleReport'])->name('capaSingleReport');
            Route::get('capaAuditReport/{id}', [CapaController::class, 'auditReport'])->name('capaAuditReport');
            Route::get('riskSingleReport/{id}', [RiskManagementController::class, 'singleReport'])->name('riskSingleReport');
            Route::get('riskAuditReport/{id}', [RiskManagementController::class, 'auditReport'])->name('riskAuditReport');
            Route::get('rootSingleReport/{id}', [RootCauseController::class, 'singleReport'])->name('rootSingleReport');
            Route::get('rootAuditReport/{id}', [RootCauseController::class, 'auditReport'])->name('rootAuditReport');
            Route::get('managementReview/{id}', [ManagementReviewController::class, 'managementReport'])->name('managementReport');
            Route::get('managementReviewReport/{id}', [ManagementReviewController::class, 'managementReviewReport'])->name('managementReviewReport');
            Route::post('child_management_Review/{id}', [ManagementReviewController::class, 'child_management_Review'])->name('childmanagementReview');
            Route::get('internalSingleReport/{id}', [InternalauditController::class, 'singleReport'])->name('internalSingleReport');
            Route::get('internalauditReport/{id}', [InternalauditController::class, 'auditReport'])->name('internalauditReport');

            //Route::resource('deviation', DeviationController::class);
            Route::get('devshow/{id}', [DeviationController::class, 'devshow'])->name('devshow');
            Route::post('deviation/stage/{id}', [DeviationController::class, 'deviation_send_stage'])->name('deviation_send_stage');
            Route::post('deviation/cancel/{id}', [DeviationController::class, 'deviationCancel'])->name('deviationCancel');
            // Route::post('deviation/cftnotrequired/{id}', [DeviationController::class, 'deviationIsCFTRequired'])->name('deviationIsCFTRequired');
            Route::post('deviation/reject/{id}', [DeviationController::class, 'deviation_reject'])->name('deviation_reject');
            Route::post('deviation/check/{id}', [DeviationController::class, 'check'])->name('check');
            Route::post('deviation/check2/{id}', [DeviationController::class, 'check2'])->name('check2');
            Route::post('deviation/check3/{id}', [DeviationController::class, 'check3'])->name('check3');
            Route::post('deviation/cftnotreqired/{id}', [DeviationController::class, 'cftnotreqired'])->name('cftnotreqired');
            Route::post('deviation/checkcft/{id}', [DeviationController::class, 'checkcft'])->name('checkcft');
            Route::post('deviation/Qa/{id}', [DeviationController::class, 'deviation_qa_more_info'])->name('deviation_qa_more_info');
            Route::post('deviationstore', [DeviationController::class, 'store'])->name('deviationstore');
            Route::post('deviationupdate/{id}', [DeviationController::class, 'update'])->name('deviationupdate');
            Route::get('deviation', [DeviationController::class, 'deviation']);
            Route::get('deviationSingleReport/{id}', [DeviationController::class, 'singleReport'])->name('deviationSingleReport');
            Route::get('deviationparentchildReport/{id}', [DeviationController::class, 'parentchildReport'])->name('deviationparentchildReport');
            // --------------------- By Suneel  ------------------
            // Route::get('auditValidation/{id}', [DemoValidationController::class, 'auditValidation']);
            Route::post('send-child/{id}', [ValidationController::class, 'stageChange'])->name('stageChange');
            Route::post('validation/stage/{id}', [ValidationController::class, 'validation_send_stage'])->name('validation_send_stage');
            Route::post('validation_rejects', [ValidationController::class, 'validation_reject'])->name('validation_reject');
            Route::post('validation/cancel/{id}', [ValidationController::class, 'validationCancel'])->name('validationCancel');
            Route::post('validation/check/{id}', [ValidationController::class, 'check'])->name('validation_check');
            Route::post('validation/check2/{id}', [ValidationController::class, 'check2'])->name('validation_check2');
            Route::post('validation/check3/{id}', [ValidationController::class, 'check3'])->name('validation_check3');
            Route::get('validationSingleReport/{id}', [ValidationController::class, 'singleReport'])->name('validationSingleReport');
            Route::get('/audit_validationPdf/{id}', [ValidationController::class, 'audit_pdf2']);

            Route::get('vali_summary/{id}', [ValidationController::class, 'valiSummery_pdf']);
            Route::get('vali_audit/{id}', [ValidationController::class, 'valiAudit_pdf']);

            
            //  Route::post('send-vali/{id}',[DemoValidationController::class,'stageChange'])->name('stageChange');
            Route::post('equipment/stage/{id}', [EquipmentController::class, 'equipment_send_stage'])->name('equipment_send_stage');
            Route::post('equipment_rejects', [EquipmentController::class, 'equipment_reject'])->name('equipment_reject');
            Route::post('equipment/cancel/{id}', [EquipmentController::class, 'equipmentCancel'])->name('equipmentCancel');
            Route::post('equipment/check/{id}', [EquipmentController::class, 'check'])->name('equipment_check');
            Route::post('equipment/check2/{id}', [EquipmentController::class, 'check2'])->name('equipment_check2');
            Route::post('equipment/check3/{id}', [EquipmentController::class, 'check3'])->name('equipment_check3');
            Route::get('equipmentSingleReport/{id}', [EquipmentController::class, 'singleReport'])->name('equipmentSingleReport');
            Route::get('/audit_pdf/{id}', [EquipmentController::class, 'audit_pdf1']);


            Route::post('calibration/stage/{id}', [CalibrationController::class, 'calibration_send_stage'])->name('calibration_send_stage');
            Route::post('calibration_rejects', [CalibrationController::class, 'calibration_reject'])->name('calibration_reject');
            Route::post('calibration/cancel/{id}', [CalibrationController::class, 'calibrationCancel'])->name('calibrationCancel');
            Route::post('calibration/check/{id}', [CalibrationController::class, 'check'])->name('calibration_check');
            Route::post('calibration/check2/{id}', [CalibrationController::class, 'check2'])->name('calibration_check2');
            Route::post('calibration/check3/{id}', [CalibrationController::class, 'check3'])->name('calibration_check3');
            Route::get('calibrationSingleReport/{id}', [CalibrationController::class, 'singleReport'])->name('calibrationSingleReport');
            Route::get('/calibration_audit/{id}', [CalibrationController::class, 'audit_pdf']);

            //============National Approval ============
            Route::post('national_approval/stage/{id}', [NationalApprovalController::class, 'nationalApproval_send_stage'])->name('national_approval_send_stage');
            Route::post('national_approval_rejects', [NationalApprovalController::class, 'nationalApproval_reject'])->name('nationalApprovalReject');
            Route::post('national_approval/cancel/{id}', [NationalApprovalController::class, 'national_approvalCancel'])->name('nationalApprovalCancel');
            Route::post('national_approval/check/{id}', [NationalApprovalController::class, 'check'])->name('national_approval_check');
            Route::post('np_qa_more_info/{id}', [NationalApprovalController::class, 'np_qa_more_info'])->name('np_qa_more_info');
            Route::post('national_approval/check2/{id}', [NationalApprovalController::class, 'check2'])->name('national_approval_check2');
            Route::post('national_approval/check3/{id}', [NationalApprovalController::class, 'check3'])->name('national_approval_check3');
            Route::get('national_approvalSingleReport/{id}', [NationalApprovalController::class, 'singleReport'])->name('national_approvalSingleReport');
            Route::get('/np_audit/{id}', [NationalApprovalController::class, 'audit1_pdf']);


            //============ Sanction =============
            Route::post('sanction/stage/{id}', [SanctionController::class, 'sanction_send_stage'])->name('sanction_send_stage');
            Route::post('sanction', [SanctionController::class, 'sanction_reject'])->name('sanctionReject');
            Route::post('sanction/cancel/{id}', [SanctionController::class, 'sanctionCancel'])->name('sanctionCancel');
            Route::post('sanction/check/{id}', [SanctionController::class, 'check'])->name('sanction_check');
            Route::post('sanction_qa_more_info/{id}', [SanctionController::class, 'sanction_qa_more_info'])->name('sanction_qa_more_info');
            Route::post('sanction/check2/{id}', [SanctionController::class, 'check2'])->name('sanction_check2');
            Route::post('sanction/check3/{id}', [SanctionController::class, 'check3'])->name('sanction_check3');
            Route::get('sanctionSingleReport/{id}', [SanctionController::class, 'singleReport'])->name('sanctionSingleReport');
            Route::get('/sanction_audit/{id}', [SanctionController::class, 'audit2_pdf']);


            //============ Sanction =============
            Route::post('monthly', [MonthlyWorkingController::class, 'monthly_reject'])->name('monthlyReject');
            Route::post('monthly/cancel/{id}', [MonthlyWorkingController::class, 'monthlynCancel'])->name('monthlyCancel');
            Route::post('monthly/check/{id}', [MonthlyWorkingController::class, 'check'])->name('monthly_check');
            Route::post('monthly_qa_more_info/{id}', [MonthlyWorkingController::class, 'monthly_qa_more_info'])->name('monthly_qa_more_info');
            Route::post('monthly/check2/{id}', [MonthlyWorkingController::class, 'check2'])->name('monthly_check2');
            Route::post('monthly/check3/{id}', [MonthlyWorkingController::class, 'check3'])->name('monthly_check3');
            Route::post('monthlyWorking/stage/{id}', [MonthlyWorkingController::class, 'monthly_send_stage'])->name('monthly_send_stage');
            Route::get('monthlySingleReport/{id}', [MonthlyWorkingController::class, 'singleReport'])->name('monthlySingleReport');
            Route::get('/monthly_audit/{id}', [MonthlyWorkingController::class, 'audit2_pdf']);
        });
            //-------------------- By  Monika GCP Study Route Start-------------------//
            
            Route::get('/GCP_study', [GcpStudyController::class, 'index'])->name('GCP_study.index')->middleware('auth');
            Route::post('/GCP_study_store', [GcpStudyController::class, 'store'])->name('GCP_study.store')->middleware('auth');;
            Route::get('/GCP_study_edit/{id}', [GcpStudyController::class, 'edit'])->name('GCP_study.edit')->middleware('auth');;
            Route::post('/GCP_study_update/{id}', [GcpStudyController::class, 'update'])->name('GCP_study.update')->middleware('auth');;

            //workflow
            Route::post('/GCP_study_stage/{id}', [GcpStudyController::class, 'GCP_study_send_stage'])->name('GCP_study_send_stage');
            Route::post('/GCP_study_cancel/{id}', [GcpStudyController::class, 'GCP_study_cancel'])->name('GCP_study_cancel');
            Route::post('/GCP_study_child/{id}', [GcpStudyController::class, 'GCP_study_child'])->name('GCP_child');

            //singlereport
            Route::get('GCP_study/SingleReport/{id}', [GcpStudyController::class, 'GCP_studySingleReport'])->name('GCP_studySingleReport');

            //audittrail
            Route::get('GCP_study/AuditTrail/{id}', [GcpStudyController::class, 'GCP_studyAuditTrial'])->name('GCP_study_audit_trail');
            Route::get('GCP_study/AuditTrailPdf/{id}', [GcpStudyController::class, 'GCP_study_AuditTrailPdf'])->name('GCP_study_AuditTrailPdf');

            //form
            Route::get('/supplier_contract', [SupplierContractController::class, 'index'])->name('supplier_contract.index')->middleware('auth');
            Route::post('/supplier_contract_store', [SupplierContractController::class, 'store'])->name('supplier_contract.store')->middleware('auth');
            Route::get('/supplier_contract_edit/{id}', [SupplierContractController::class, 'edit'])->name('supplier_contract.edit')->middleware('auth');
            Route::post('/supplier_contract_update/{id}', [SupplierContractController::class, 'update'])->name('supplier_contract.update')->middleware('auth');

            ////workflow
            Route::post('/supplier_send_stage/{id}', [SupplierContractController::class, 'Supplier_contract_send_stage'])->name('Supplier_contract.send_stage');
            Route::post('/supplier_contract_cancel/{id}', [SupplierContractController::class, 'Supplier_contract_cancel'])->name('Supplier_contract.cancel');
            Route::post('/supplier_contract_reject/{id}', [SupplierContractController::class, 'Reject_stage'])->name('Supplier_contract.reject');
            Route::post('/supplier_contract_child/{id}', [SupplierContractController::class, 'Supplier_contract_child'])->name('Supplier_contract.child');

            //singlereport
            Route::get('supplier_contract/SingleReport/{id}', [SupplierContractController::class, 'Supplier_Contract_SingleReport'])->name('Supplier_Contract.SingleReport');

            ////audittrail
            Route::get('supplier_contract/AuditTrail/{id}', [SupplierContractController::class, 'Supplier_ContractAuditTrial'])->name('Supplier_contract.audit_trail');
            Route::get('supplier_contract/AuditTrailPdf/{id}', [SupplierContractController::class, 'Supplier_Contract_AuditTrailPdf'])->name('Supplier_contract.auditTrailPdf');

            //-------------------------------- Subject Action Item Route Strat ---------------------------------------

            //form
            Route::get('/subject_action_item', [SubjectActionItemController::class, 'index'])->name('subject_action_item.index');
            Route::post('/subject_action_item_store', [SubjectActionItemController::class, 'store'])->name('subject_action_item.store');
            Route::get('/subject_action_item_edit/{id}', [SubjectActionItemController::class, 'edit'])->name('subject_action_item.edit')->middleware('auth');;
            Route::post('/subject_action_item_update/{id}', [SubjectActionItemController::class, 'update'])->name('subject_action_item.update')->middleware('auth');


            ////workflow
            Route::post('/subject_action_item_stage_send/{id}', [SubjectActionItemController::class, 'Subject_action_item_send_stage'])->name('subject_action_item.send_stage');
            Route::post('/subject_action_item_cancel/{id}', [SubjectActionItemController::class, 'Subject_action_item_cancel'])->name('subject_action_item.cancel');
            Route::post('/subject_action_item_child/{id}', [SubjectActionItemController::class, 'Subject_action_item_child'])->name('subjec_action_item.child');

            //singlereport
            Route::get('subject_action_item/SingleReport/{id}', [SubjectActionItemController::class, 'Suject_Action_ItemSingleReport'])->name('subject_action_item.SingleReport');

            ////audittrail
            Route::get('subject_action_item/AuditTrail/{id}', [SubjectActionItemController::class, 'Subject_Action_ItemAuditTrial'])->name('subject_action_item.audit_trail');
            Route::get('subject_action_item/AuditTrailPdf/{id}', [SubjectActionItemController::class, 'Subject_Action_ItemAuditTrailPdf'])->name('subject_action_item.auditTrailPdf');
         //-------------------------------- Violation Route Strat ---------------------------------------

            //form
            Route::get('/violation', [ViolationController::class, 'index'])->name('violation.index');
            Route::post('/violation_store', [ViolationController::class, 'store'])->name('violation.store');
            Route::get('/violation_edit/{id}', [ViolationController::class, 'edit'])->name('violation.edit')->middleware('auth');;
            Route::post('/violation_update/{id}', [ViolationController::class, 'update'])->name('violation.update')->middleware('auth');

        ////workflow
            Route::post('/violation_stage_send/{id}', [ViolationController::class, 'Violation_send_stage'])->name('violation.send_stage');
            Route::post('/violation_cancel/{id}', [ViolationController::class, 'Violation_cancel'])->name('violation.cancel');
            //Route::post('/supplier_contract_reject/{id}', [ViolationController::class, 'Reject_stage'])->name('Supplier_contract.reject');

            //singlereport
            Route::get('Violation/SingleReport/{id}', [ViolationController::class, 'ViolationSingleReport'])->name('violation.SingleReport');

            ////audittrail
            Route::get('Violation/AuditTrail/{id}', [ViolationController::class, 'ViolationAuditTrial'])->name('violation.audit_trail');
            Route::get('Violation/AuditTrailPdf/{id}', [ViolationController::class, 'ViolationAuditTrailPdf'])->name('violation.auditTrailPdf');
            //-------------------------------- CTA Amendement Route Strat ---------------------------------------

            //form
            Route::get('/cta_amendement', [CTAAmendementController::class, 'index'])->name('cta_amendement.index');
            Route::post('/cta_amendement_store', [CTAAmendementController::class, 'store'])->name('cta_amendement.store');
            Route::get('/cta_amendement_edit/{id}', [CTAAmendementController::class, 'edit'])->name('cta_amendement.edit')->middleware('auth');
            Route::post('/cta_amendement_update/{id}', [CTAAmendementController::class, 'update'])->name('cta_amendement.update')->middleware('auth');


            ////workflow
            Route::post('/cta_amendement_stage_send/{id}', [CTAAmendementController::class, 'CTA_Amendement_send_stage'])->name('cta_amendement.send_stage');
            Route::post('/cta_amendement_cancel/{id}', [CTAAmendementController::class, 'CTA_Amendement_cancel'])->name('cta_amendement.cancel');
            Route::post('/cta_amendement_send/{id}', [CTAAmendementController::class, 'CTA_Amendement_send'])->name('cta_amendement.send');


            //singlereport
            Route::get('CTA_Amendement/SingleReport/{id}', [CTAAmendementController::class, 'CTA_AmendementSingleReport'])->name('cta_amendement.SingleReport');

            ////audittrail
            Route::get('CTA_Amendement/AuditTrail/{id}', [CTAAmendementController::class, 'CTA_AmendementAuditTrial'])->name('cta_amendement.audit_trail');
            Route::get('CTA_Amendement/AuditTrailPdf/{id}', [CTAAmendementController::class, 'CTA_AmendementAuditTrailPdf'])->name('cta_amendement.auditTrailPdf');

            //-------------------------------- Correspondence Route Strat ---------------------------------------

            //form
            Route::get('/correspondence', [CorrespondenceController::class, 'index'])->name('correspondence.index');
            Route::post('/correspondence_store', [CorrespondenceController::class, 'store'])->name('correspondence.store');
            Route::get('/correspondence_edit/{id}', [CorrespondenceController::class, 'edit'])->name('correspondence.edit')->middleware('auth');
            Route::post('/correspondence_update/{id}', [CorrespondenceController::class, 'update'])->name('correspondence.update')->middleware('auth');


            ////workflow
            Route::post('/correspondence_send_stage/{id}', [CorrespondenceController::class, 'Correspondence_send_stage'])->name('correspondence.send_stage');
            Route::post('/correspondence_cancel/{id}', [CorrespondenceController::class, 'Correspondence_cancel'])->name('correspondence.cancel');
            Route::post('/correspondence_child/{id}', [CorrespondenceController::class, 'Correspondence_child'])->name('correspondence.child');

            //singlereport
            Route::get('correspondence/SingleReport/{id}', [CorrespondenceController::class, 'CorrespondenceSingleReport'])->name('correspondence.SingleReport');

            ////audittrail
            Route::get('correspondence/AuditTrail/{id}', [CorrespondenceController::class, 'CorrespondenceAuditTrial'])->name('correspondence.audit_trail');
            Route::get('correspondence/AuditTrailPdf/{id}', [CorrespondenceController::class, 'CorrespondenceAuditTrailPdf'])->name('correspondence.auditTrailPdf');

            //-------------------------------- Contract Testing Lab Audit Route Strat ---------------------------------------

            //form
            Route::get('/ctl_audit', [ContractTestingLabAuditController::class, 'index'])->name('contract_testing_lab_audit.index');
            Route::post('/ctl_audit_store', [ContractTestingLabAuditController::class, 'store'])->name('contract_testing_lab_audit.store');
            Route::get('/ctl_audit_edit/{id}', [ContractTestingLabAuditController::class, 'edit'])->name('contract_testing_lab_audit.edit')->middleware('auth');
            Route::post('/ctl_audit_update/{id}', [ContractTestingLabAuditController::class, 'update'])->name('contract_testing_lab_audit.update')->middleware('auth');


            ////workflow
            Route::post('/ctl_audit_send_stage/{id}', [ContractTestingLabAuditController::class, 'CTL_Audit_send_stage'])->name('ctl_audit.send_stage');
            Route::post('/ctl_audit_cancel/{id}', [ContractTestingLabAuditController::class, 'CTL_Audit_cancel'])->name('ctl_audit.cancel');
            Route::post('/ctl_audit_reject/{id}', [ContractTestingLabAuditController::class, 'CTL_Audit_reject'])->name('ctl_audit.reject');
            Route::post('/ctl_audit_child/{id}', [ContractTestingLabAuditController::class, 'CTL_Audit_child'])->name('ctl_audit.child');

            //singlereport
            Route::get('ctl_audit/SingleReport/{id}', [ContractTestingLabAuditController::class, 'CTL_auditSingleReport'])->name('ctl_audit.SingleReport');

            ////audittrail
            Route::get('ctl_audit/AuditTrail/{id}', [ContractTestingLabAuditController::class, 'CTL_AuditTrial'])->name('ctl_audit.audit_trail');
            Route::get('ctl_audit/AuditTrailPdf/{id}', [ContractTestingLabAuditController::class, 'CTL_AuditTrailPdf'])->name('ctl_audit.auditTrailPdf');

            //-------------------------------- first_product_validation Route Strat ---------------------------------------

            //form
            Route::get('/first_product_validation', [FirstProductValidationController::class, 'index'])->name('first_product_validation.index');
            Route::post('/first_product_validation_store', [FirstProductValidationController::class, 'store'])->name('first_product_validation.store');
            Route::get('/first_product_validation_edit/{id}', [FirstProductValidationController::class, 'edit'])->name('first_product_validation.edit')->middleware('auth');;
            Route::post('/first_product_validation_update/{id}', [FirstProductValidationController::class, 'update'])->name('first_product_validation.update')->middleware('auth');


            //////workflow
            Route::post('/first_product_validation_stage_send/{id}', [FirstProductValidationController::class, 'FirstProductValidation_Send_Stage'])->name('first_product_validation.send_stage');
            Route::post('/first_product_validation_cancel/{id}', [FirstProductValidationController::class, 'First_product_validation_cancel'])->name('first_product_validation.cancel');
            Route::post('/first_product_validation_analysis/{id}', [FirstProductValidationController::class, 'First_product_validation_analysis'])->name('first_product_validation.analysis');
            Route::post('/first_product_validation_reject/{id}', [FirstProductValidationController::class, 'First_product_validation_reject'])->name('first_product_validation.reject');

            //singlereport
            //Route::get('Violation/SingleReport/{id}', [FirstProductValidationController::class, 'ViolationSingleReport'])->name('violation.SingleReport');

            ////audittrail
            //Route::get('Violation/AuditTrail/{id}', [FirstProductValidationController::class, 'ViolationAuditTrial'])->name('violation.audit_trail');
            //Route::get('Violation/AuditTrailPdf/{id}', [FirstProductValidationController::class, 'ViolationAuditTrailPdf'])->name('violation.auditTrailPdf');


            //  =========== Ashish   lab_investigation ================

            Route::get('lab_investigation', [LabInvestigationController::class, 'index'])->name('index');
            Route::post('lab_invest_store', [LabInvestigationController::class, 'store'])->name('lab_invest_store');
            Route::get('lab_invest_edit/{id}', [LabInvestigationController::class, 'edit'])->name('lab_invest_edit');
            Route::post('lab_invest_update/{id}', [LabInvestigationController::class, 'update'])->name('lab_invest_update');
            
            Route::post('lab_investi_stage/{id}',[LabInvestigationController::class,'lab_send_stage'])->name('labStage');
            Route::post('lab_investi_reject/{id}', [LabInvestigationController::class, 'lab_reject'])->name('lab_reject');
    
            Route::post('lab_investi_cancel/{id}', [LabInvestigationController::class, 'lab_cancel'])->name('lab_cancel');
            Route::get('lab_singleReport/{id}', [LabInvestigationController::class, 'singleReport'])->name('labSingleReport');
            Route::get('lab_auditReport/{id}', [LabInvestigationController::class, 'auditReport'])->name('labAuditReport');
                  
            //  Route::get('clinetauditTrailPdf/{id}', [ClinicalSiteController::class, 'auditTrailPdf'])->name('clinicalsiteTrailPdf');
            Route::get('pdf/{id}', [ClinicalSiteController::class, 'pdf']);
            Route::get('pdf-report/{id}', [ClinicalSiteController::class, 'singleReport']);
            
            // ================================================subject ==================
            Route::get('subjectindex', [SubjectController::class, 'index']);
            Route::post('subjectinsert', [SubjectController::class, 'store'])->name('subjectstore');
            Route::get('subjectupdate/{id}', [SubjectController::class, 'show'])->name('subjectshow');
            Route::put('subjectsaveupdate/{id}', [SubjectController::class, 'update'])->name('subjectupdate');
            Route::post('subjectstagechange/{id}', [SubjectController::class, 'subjectStateChange'])->name('subject_stagechange');
            //  ========= By suneel =============

            // Route::get('auditValidation/{id}', [DemoValidationController::class, 'auditValidation']);
            Route::post('send-child/{id}', [ValidationController::class, 'stageChange'])->name('stageChange');
            Route::post('validation/stage/{id}', [ValidationController::class, 'validation_send_stage'])->name('validation_send_stage');
            Route::post('validation_rejects', [ValidationController::class, 'validation_reject'])->name('validation_reject');
            Route::post('validation/cancel/{id}', [ValidationController::class, 'validationCancel'])->name('validationCancel');
            Route::post('validation/check/{id}', [ValidationController::class, 'check'])->name('validation_check');
            Route::post('validation/check2/{id}', [ValidationController::class, 'check2'])->name('validation_check2');
            Route::post('validation/check3/{id}', [ValidationController::class, 'check3'])->name('validation_check3');
            Route::get('validationSingleReport/{id}', [ValidationController::class, 'singleReport'])->name('validationSingleReport');
            Route::get('/audit_validationPdf/{id}', [ValidationController::class, 'audit_pdf2']);

            Route::get('vali_summary/{id}', [ValidationController::class, 'valiSummery_pdf']);
            Route::get('vali_audit/{id}', [ValidationController::class, 'valiAudit_pdf']);


            //  Route::post('send-vali/{id}',[DemoValidationController::class,'stageChange'])->name('stageChange');
            Route::post('equipment/stage/{id}', [EquipmentController::class, 'equipment_send_stage'])->name('equipment_send_stage');
            Route::post('equipment_rejects', [EquipmentController::class, 'equipment_reject'])->name('equipment_reject');
            Route::post('equipment/cancel/{id}', [EquipmentController::class, 'equipmentCancel'])->name('equipmentCancel');
            Route::post('equipment/check/{id}', [EquipmentController::class, 'check'])->name('equipment_check');
            Route::post('equipment/check2/{id}', [EquipmentController::class, 'check2'])->name('equipment_check2');
            Route::post('equipment/check3/{id}', [EquipmentController::class, 'check3'])->name('equipment_check3');
            Route::get('equipmentSingleReport/{id}', [EquipmentController::class, 'singleReport'])->name('equipmentSingleReport');
            Route::get('/audit_pdf/{id}', [EquipmentController::class, 'audit_pdf1']);


            Route::post('calibration/stage/{id}', [CalibrationController::class, 'calibration_send_stage'])->name('calibration_send_stage');
            Route::post('calibration_rejects', [CalibrationController::class, 'calibration_reject'])->name('calibration_reject');
            Route::post('calibration/cancel/{id}', [CalibrationController::class, 'calibrationCancel'])->name('calibrationCancel');
            Route::post('calibration/check/{id}', [CalibrationController::class, 'check'])->name('calibration_check');
            Route::post('calibration/check2/{id}', [CalibrationController::class, 'check2'])->name('calibration_check2');
            Route::post('calibration/check3/{id}', [CalibrationController::class, 'check3'])->name('calibration_check3');
            Route::get('calibrationSingleReport/{id}', [CalibrationController::class, 'singleReport'])->name('calibrationSingleReport');
            Route::get('/calibration_audit/{id}', [CalibrationController::class, 'audit_pdf']);

            //============National Approval ============
            Route::post('national_approval/stage/{id}', [NationalApprovalController::class, 'nationalApproval_send_stage'])->name('national_approval_send_stage');
            Route::post('national_approval_rejects', [NationalApprovalController::class, 'nationalApproval_reject'])->name('nationalApprovalReject');
            Route::post('national_approval/cancel/{id}', [NationalApprovalController::class, 'national_approvalCancel'])->name('nationalApprovalCancel');
            Route::post('national_approval/check/{id}', [NationalApprovalController::class, 'check'])->name('national_approval_check');
            Route::post('np_qa_more_info/{id}', [NationalApprovalController::class, 'np_qa_more_info'])->name('np_qa_more_info');
            Route::post('national_approval/check2/{id}', [NationalApprovalController::class, 'check2'])->name('national_approval_check2');
            Route::post('national_approval/check3/{id}', [NationalApprovalController::class, 'check3'])->name('national_approval_check3');
            Route::get('national_approvalSingleReport/{id}', [NationalApprovalController::class, 'singleReport'])->name('national_approvalSingleReport');
            Route::get('/np_audit/{id}', [NationalApprovalController::class, 'audit1_pdf']);


            //============ Sanction =============
            Route::post('sanction/stage/{id}', [SanctionController::class, 'sanction_send_stage'])->name('sanction_send_stage');
            Route::post('sanction', [SanctionController::class, 'sanction_reject'])->name('sanctionReject');
            Route::post('sanction/cancel/{id}', [SanctionController::class, 'sanctionCancel'])->name('sanctionCancel');
            Route::post('sanction/check/{id}', [SanctionController::class, 'check'])->name('sanction_check');
            Route::post('sanction_qa_more_info/{id}', [SanctionController::class, 'sanction_qa_more_info'])->name('sanction_qa_more_info');
            Route::post('sanction/check2/{id}', [SanctionController::class, 'check2'])->name('sanction_check2');
            Route::post('sanction/check3/{id}', [SanctionController::class, 'check3'])->name('sanction_check3');
            Route::get('sanctionSingleReport/{id}', [SanctionController::class, 'singleReport'])->name('sanctionSingleReport');
            Route::get('/sanction_audit/{id}', [SanctionController::class, 'audit2_pdf']);


            //============ Sanction =============
            Route::post('monthly', [MonthlyWorkingController::class, 'monthly_reject'])->name('monthlyReject');
            Route::post('monthly/cancel/{id}', [MonthlyWorkingController::class, 'monthlynCancel'])->name('monthlyCancel');
            Route::post('monthly/check/{id}', [MonthlyWorkingController::class, 'check'])->name('monthly_check');
            Route::post('monthly_qa_more_info/{id}', [MonthlyWorkingController::class, 'monthly_qa_more_info'])->name('monthly_qa_more_info');
            Route::post('monthly/check2/{id}', [MonthlyWorkingController::class, 'check2'])->name('monthly_check2');
            Route::post('monthly/check3/{id}', [MonthlyWorkingController::class, 'check3'])->name('monthly_check3');
            Route::post('monthlyWorking/stage/{id}', [MonthlyWorkingController::class, 'monthly_send_stage'])->name('monthly_send_stage');
            Route::get('monthlySingleReport/{id}', [MonthlyWorkingController::class, 'singleReport'])->name('monthlySingleReport');
            Route::get('/monthly_audit/{id}', [MonthlyWorkingController::class, 'audit2_pdf']);
            
            // ===========By kshitij ================
            Route::get('clientInquiryAuditReport/{id}', [ClientInquiryController::class, 'auditReport'])->name('deviationparentchildReport');
            Route::get('clientinquarySingleReport/{id}', [ClientInquiryController::class, 'SingleReport'])->name('clientinquarySingleReport');
            //  Route::get('auditDetailsClientInquiry/{id}', [ClientInquiryController::class, 'auditDetailsClientInquiry'])->name('CLientInquiryauditDetails');
            Route::get('meetingManagementAuditReport/{id}', [MeetingManagementController::class, 'meetingauditReport'])->name('deviationparentchildReport');
            Route::get('meetingmanagementSingleReport/{id}', [MeetingManagementController::class, 'SingleReport'])->name('meetingmanagementSingleReport');

            Route::get('additionalinformationAuditReport/{id}', [AdditionalInformationController::class, 'additionalauditReport'])->name('deviationparentchildReport');
            Route::get('additionalinformationSingleReport/{id}', [AdditionalInformationController::class, 'additionalSingleReport'])->name('additionalSingleReport');

            Route::get('audittaskAuditReport/{id}', [AuditTaskController::class, 'audittaskauditReport'])->name('deviationparentchildReport');
            Route::get('audittaskSingleReport/{id}', [AuditTaskController::class, 'auditSingleReport'])->name('auditSingleReport');
            // ============== shruti ==============
            Route::get('PSURSingleReport/{id}', [PSURController::class, 'singleReport'])->name('PSURSingleReport');
            Route::get('Psur_audit/{id}', [PSURController::class, 'auditTrailPdf'])->name('Psuraudit.pdf');
            Route::get('psur_auditpdf/{id}', [PSURController::class, 'auditReport'])->name('psurauditpdf');


            Route::get('medicaldevice_audit/{id}', [MedicalDeviceController::class, 'auditTrailPdf'])->name('medicaldeviceaudit.pdf');
            Route::get('medicalSingleReport/{id}', [MedicalDeviceController::class, 'singleReport'])->name('medicalSingleReport');

            Route::get('CommitmentSingleReport/{id}', [CommitmentController::class, 'singleReport'])->name('CommitmentSingleReport');
            Route::get('Commitment_audit/{id}', [CommitmentController::class, 'auditTrailPdf'])->name('Commitmentaudit.pdf');
            Route::get('Commitmentaudit.pdf/{id}', [CommitmentController::class, 'auditReport'])->name('Commitmentaudit.pdf');
            // ============By  navneet =============
            Route::get('MonitoringVisitSingleReport/{id}', [MonitoringVisitController::class, 'SingleReport'])->name('MonitoringVisitSingleReport');
            Route::get('MonitoringVisitAuditReport/{id}', [MonitoringVisitController::class, 'AuditReport'])->name('MonitoringVisitAuditReport');
            
            // ----------------------- By Juned -------------------

            Route::get('recomended_audit/{id}', [ReccomendedController::class, 'auditTrailPdf'])->name('RcomendedAuditTrail.pdf');
            Route::get('reccomended_singleReports/{id}',[ReccomendedController::class, 'singleReports'])->name('singleReports');
           
            Route::get('production_singleReports/{id}',[Product_ValidationController::class, 'singleReports'])->name('singleReports');
            
            Route::get('quality_singleReports/{id}',[QualityFollolwupController::class, 'singleReports'])->name('singleReports');
            Route::get('quality_audit/{id}', [QualityFollolwupController::class, 'auditTrailPdf'])->name('QualityAuditTrail.pdf');
            //  ---------------------- By Sheetal ----------------------------------
            
            Route::get('renewal/AuditTrial/{id}', [RenewalController::class, 'renewalAuditTrial'])->name('renewalAuditTrial');
           
            //  ---------------------- By Payal ----------------------------------
            //  -------------------VERIFICATION------------------------------------------------
             Route::get('Vaudit_report/{id}', [VerificationController::class, 'auditReport'])->name('Vaudit_report');
             Route::get('Vsingle_report/{id}', [VerificationController::class, 'singleReport'])->name('Vsingle_report');
             Route::get('AuditTrial/{id}', [VerificationController::class, 'AuditTrial'])->name('Vaudit_trial');
             
            // ---------------------Analyst Interview---------------------------------------------------------------
             Route::get('AIaudit_report/{id}', [AnalystInterviewController::class, 'auditReport'])->name('AIaudit_report');
             Route::get('AIsingle_report/{id}', [AnalystInterviewController::class, 'singleReport'])->name('AIsingle_report');
             Route::get('AuditTrial/{id}', [AnalystInterviewController::class, 'AuditTrial'])->name('AIaudit_trial');
             Route::view('analyst_interview','analystInterview.analystInterview_new')->name('analyst_interview');
             // Route::get('AuditTrial/{id}', [AnalystInterviewController::class, 'AuditTrial'])->name('AIaudit_trial');
 
             // ---------------------Additional Testing---------------------------------------------------------------
 
             Route::get('auditDetails/{id}', [AdditionalTestingController::class, 'auditDetails'])->name('ATaudit_details');
             Route::get('ATaudit_report/{id}', [AdditionalTestingController::class, 'auditReport'])->name('ATaudit_report');
             Route::get('ATsingle_report/{id}', [AdditionalTestingController::class, 'singleReport'])->name('ATsingle_report');
             Route::get('AuditTrial/{id}', [AdditionalTestingController::class, 'AuditTrial'])->name('ATaudit_trial');
 
            //  ---------------------- By sonali ----------------------------------
            /**  ---------- DosierDocumentsController--------  */
            Route::group(['prefix' => 'dosierdocuments', 'as' => 'dosierdocuments.'], function () {

                Route::get('/', [DosierDocumentsController::class, 'index'])->name('index');
                Route::post('/store', [DosierDocumentsController::class, 'store'])->name('store');
                Route::get('view/{id}', [DosierDocumentsController::class, 'show'])->name('view');
                Route::post('update/{id}', [DosierDocumentsController::class, 'update'])->name('update');

                Route::post('sendstage/{id}', [DosierDocumentsController::class, 'send_stage'])->name('send_stage');
                Route::post('requestmoreinfo_back_stage/{id}', [DosierDocumentsController::class, 'requestmoreinfo_back_stage'])->name('requestmoreinfo_back_stage');
                Route::post('cancel_stage/{id}', [DosierDocumentsController::class, 'cancel_stage'])->name('cancel_stage');;
                Route::post('thirdStage/{id}', [DosierDocumentsController::class, 'stageChange'])->name('thirdStage');
                Route::get('AuditTrial/{id}', [DosierDocumentsController::class, 'AuditTrial'])->name('audit_trial');
                Route::post('AuditTrial/{id}', [DosierDocumentsController::class, 'store_audit_review'])->name('store_audit_review');
                Route::get('auditDetails/{id}', [DosierDocumentsController::class, 'auditDetails'])->name('audit_details');

                Route::get('audit_report/{id}', [DosierDocumentsController::class, 'auditReport'])->name('audit_report');
                Route::get('single_report/{id}', [DosierDocumentsController::class, 'singleReport'])->name('single_report');
            });
            /**  --------- PreventiveMaintenanceController----------- */
            Route::group(['prefix' => 'preventivemaintenance', 'as' => 'preventivemaintenance.'], function () {

                Route::get('/', [PreventiveMaintenanceController::class, 'index'])->name('index');
                Route::post('/store', [PreventiveMaintenanceController::class, 'store'])->name('store');
                Route::get('view/{id}', [PreventiveMaintenanceController::class, 'show'])->name('view');
                Route::post('update/{id}', [PreventiveMaintenanceController::class, 'update'])->name('update');

                Route::post('sendstage/{id}', [PreventiveMaintenanceController::class, 'send_stage'])->name('send_stage');
                Route::post('requestmoreinfo_back_stage/{id}', [PreventiveMaintenanceController::class, 'requestmoreinfo_back_stage'])->name('requestmoreinfo_back_stage');
                Route::post('cancel_stage/{id}', [PreventiveMaintenanceController::class, 'cancel_stage'])->name('cancel_stage');;
                Route::post('thirdStage/{id}', [PreventiveMaintenanceController::class, 'stageChange'])->name('thirdStage');
                Route::get('AuditTrial/{id}', [PreventiveMaintenanceController::class, 'AuditTrial'])->name('audit_trial');
                Route::post('AuditTrial/{id}', [PreventiveMaintenanceController::class, 'store_audit_review'])->name('store_audit_review');
                Route::get('auditDetails/{id}', [PreventiveMaintenanceController::class, 'auditDetails'])->name('audit_details');
                Route::get('audit_report/{id}', [PreventiveMaintenanceController::class, 'auditReport'])->name('audit_report');
                Route::get('single_report/{id}', [PreventiveMaintenanceController::class, 'singleReport'])->name('single_report');
            });

});
