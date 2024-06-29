<?php

use App\Http\Controllers\AdditionalTestingController;
use App\Http\Controllers\AnalystInterviewController;
use App\Http\Controllers\CabinateController;
use App\Http\Controllers\rcms\SupplierController;
use App\Http\Controllers\ChangeControlController;
use App\Http\Controllers\rcms\CountrySubDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentContentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentDetailsController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MytaskController;
use App\Http\Controllers\newForm\MedicalRegistrationController;
use App\Http\Controllers\OpenStageController;
use App\Http\Controllers\rcms\AuditeeController;
use App\Http\Controllers\rcms\AuditProgramController;
use App\Http\Controllers\rcms\CapaController;
use App\Http\Controllers\rcms\CCController;
use App\Http\Controllers\rcms\CustomerController;
use App\Http\Controllers\rcms\DesktopController;
use App\Http\Controllers\rcms\DeviationController;
use App\Http\Controllers\rcms\EffectivenessCheckController;
use App\Http\Controllers\rcms\ExtensionController;
use App\Http\Controllers\rcms\InternalauditController;
use App\Http\Controllers\rcms\LabIncidentController;
use App\Http\Controllers\rcms\ManagementReviewController;
use App\Http\Controllers\rcms\ObservationController;
use App\Http\Controllers\rcms\RcmsDashboardController;
use App\Http\Controllers\rcms\RootCauseController;
use App\Http\Controllers\RiskManagementController;
use App\Http\Controllers\tms\QuestionBankController;
use App\Http\Controllers\tms\QuestionController;
use App\Http\Controllers\tms\QuizeController;
use App\Http\Controllers\TMSController;
use App\Http\Controllers\UserLoginController;
use App\Imports\DocumentsImport;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ResamplingController;
use App\Http\Controllers\VerificationController;
use App\Models\AnalystInterview;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [UserLoginController::class, 'userlogin']);
Route::get('/login', [UserLoginController::class, 'userlogin'])->name('login');
Route::post('/logincheck', [UserLoginController::class, 'logincheck']);
Route::get('/logout', [UserLoginController::class, 'logout'])->name('logout');
Route::post('/rcms_check', [UserLoginController::class, 'rcmscheck']);
//Route::get('/', [UserLoginController::class, 'userlogin']);
Route::get('/error', function () {
    return view('error');
})->name('error.route');
Route::view('rcms_check', 'frontend.rcms.makePassword');

//!---------------- starting login  ---------------------------//

Route::get('/', [UserLoginController::class, 'userlogin']);
Route::view('forgot-password', 'frontend.forgot-password');
Route::get('reset-password/{token}', [UserLoginController::class, 'resetPage']);
Route::post('reset-password', [UserLoginController::class, 'UpdateNewPassword']);
Route::get('forgetPassword-user', [UserLoginController::class, 'forgetPassword']);

// Route::view('dashboard', 'frontend.dashboard');

Route::get('data-fields', function () {
    return view('frontend.change-control.data-fields');
});
Route::middleware(['auth', 'prevent-back-history', 'user-activity'])->group(function () {
    Route::resource('change-control', OpenStageController::class);
    Route::get('change-control-audit/{id}', [OpenStageController::class, 'auditTrial']);
    Route::get('change-control-audit-detail/{id}', [OpenStageController::class, 'auditDetails']);
    Route::post('division/change/{id}', [OpenStageController::class, 'division'])->name('division_change');
    Route::get('send-notification/{id}', [OpenStageController::class, 'notification']);
    Route::resource('documents', DocumentController::class);
    Route::post('revision/{id}', [DocumentController::class, 'revision']);
    Route::get('/documentExportPDF', [DocumentController::class, 'documentExportPDF'])->name('documentExportPDF');
    Route::get('/documentExportEXCEL', [DocumentController::class, 'documentExportEXCEL'])->name('documentExportEXCEL');
    Route::post('/import', [DocumentController::class, 'import'])->name('csv.import');
    Route::post('/importpdf', [ImportController::class, 'PDFimport']);
    Route::post('division_submit', [DocumentController::class, 'division'])->name('division_submit');
    //Route::post('set/division', [DocumentController::class, 'division'])->name('division_submit');
    Route::post('dcrDivision', [DocumentController::class, 'dcrDivision'])->name('dcrDivision_submit');
    Route::get('documents/generatePdf/{id}', [DocumentController::class, 'createPDF']);

    Route::get('documents/reviseCreate/{id}', [DocumentController::class, 'revise_create']);

    Route::get('documents/printPDF/{id}', [DocumentController::class, 'printPDF']);
    Route::get('documents/viewpdf/{id}', [DocumentController::class, 'viewPdf']);
    Route::resource('documentsContent', DocumentContentController::class);
    Route::get('doc-details/{id}', [DocumentDetailsController::class, 'viewdetails']);
    Route::put('sendforstagechanage', [DocumentDetailsController::class, 'sendforstagechanage']);
    Route::get('notification/{id}', [DocumentDetailsController::class, 'notification']);
    Route::get('/get-data', [DocumentDetailsController::class, 'getData'])->name('get.data');
    Route::post('/send-notification', [DocumentDetailsController::class, 'sendNotification']);
    Route::get('/search', [DocumentDetailsController::class, 'search']);
    Route::get('/advanceSearch', [DocumentDetailsController::class, 'searchAdvance']);
    Route::get('auditPrint/{id}', [DocumentDetailsController::class, 'printAudit']);
    Route::get('mytaskdata', [MytaskController::class, 'index']);
    Route::get('mydms', [CabinateController::class, 'index']);
    Route::get('email', [CabinateController::class, 'email']);
    Route::get('rev-details/{id}', [MytaskController::class, 'reviewdetails']);
    Route::post('send-change-control/{id}', [ChangeControlController::class, 'statechange']);
    Route::get('audit-trial/{id}', [DocumentDetailsController::class, 'auditTrial']);
    Route::get('audit-individual/{id}/{user}', [DocumentDetailsController::class, 'auditTrialIndividual']);
    Route::get('audit-detail/{id}', [DocumentDetailsController::class, 'auditDetails'])->name('audit-detail');
    Route::post('update-doc/{id}', [DocumentDetailsController::class, 'updatereviewers'])->name('update-doc');
    Route::get('audit-details/{id}', [DocumentDetailsController::class, 'getAuditDetail'])->name('audit-details');
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('analytics', [DashboardController::class, 'analytics']);
    Route::post('subscribe', [DashboardController::class, 'subscribe']);
    Route::resource('TMS', TMSController::class);
    Route::get('TMS-details/{id}/{sopId}', [TMSController::class, 'viewTraining']);
    Route::get('training/{id}/', [TMSController::class, 'training']);
    Route::get('trainingQuestion/{id}/', [TMSController::class, 'trainingQuestion']);
    Route::get('training-notification/{id}', [TMSController::class, 'notification']);
    Route::post('trainingComplete/{id}', [TMSController::class, 'trainingStatus']);
    //Route::post('trainingSubmitData/{id}', [TMSController::class, 'trainingSubmitData']);
    Route::get('tms-audit/{id}', [TMSController::class, 'auditTrial']);
    Route::get('tms-audit-detail/{id}', [TMSController::class, 'auditDetails']);
    // Route::post('import', function () {
    //     Excel::import(new DocumentsImport, request()->file('file'));
    //     return redirect()->back()->with('success', 'Data Imported Successfully');
    // });
    Route::get('example/{id}/', [TMSController::class, 'example']);

    // Questions Part
    Route::resource('question', QuestionController::class);
    Route::get('questiondata/{id}', [QuestionBankController::class, 'datag'])->name('questiondata');
    Route::resource('question-bank', QuestionBankController::class);
    Route::resource('quize', QuizeController::class);
    Route::get('data/{id}', [QuizeController::class, 'datag'])->name('data');
    Route::get('datag/{id}', [QuizeController::class, 'data'])->name('datag');
    //-----------------------QMS----------------
    // Route::get('qms-dashboard', [RcmsDashboardController::class, 'index']);
});

// =======================medicsl device //==============================

Route::middleware(['auth'])->group(function () {

Route::get('/medical_device_registration', [MedicalRegistrationController::class, 'index'])->name('auth');
Route::post('medicalstore',[MedicalRegistrationController::class,'medicalCreate'])->name('medical.store');
Route::get('medicalupdate/{id}/edit',[MedicalRegistrationController::class,'medicalEdit'])->name('medical_edit');
Route::put('medicalupdated/{id}',[MedicalRegistrationController::class,'medicalUpdate'])->name('medical.update');
    // Route::get('/your-route', [YourController::class, 'yourMethod']);
});

// ====================================Capa=======================
Route::get('capa', [CapaController::class, 'capa']);
Route::post('capastore', [CapaController::class, 'capastore'])->name('capastore');
Route::post('capaUpdate/{id}', [CapaController::class, 'capaUpdate'])->name('capaUpdate');
Route::get('capashow/{id}', [CapaController::class, 'capashow'])->name('capashow');
Route::post('capa/stage/{id}', [CapaController::class, 'capa_send_stage'])->name('capa_send_stage');
Route::post('capa/cancel/{id}', [CapaController::class, 'capaCancel'])->name('capaCancel');
Route::post('capa/reject/{id}', [CapaController::class, 'capa_reject'])->name('capa_reject');
Route::post('capa/Qa/{id}', [CapaController::class, 'capa_qa_more_info'])->name('capa_qa_more_info');
Route::get('CapaAuditTrial/{id}', [CapaController::class, 'CapaAuditTrial']);
Route::get('auditDetailsCapa/{id}', [CapaController::class, 'auditDetailsCapa'])->name('showCapaAuditDetails');
Route::post('capa_child/{id}', [CapaController::class, 'child_change_control'])->name('capa_child_changecontrol');
Route::post('effectiveness_check/{id}', [CapaController::class, 'effectiveness_check'])->name('capa_effectiveness_check');

// ==============================management review ==========================manage

Route::post('managestore', [ManagementReviewController::class, 'managestore'])->name('managestore');
Route::post('manageUpdate/{id}', [ManagementReviewController::class, 'manageUpdate'])->name('manageUpdate');
Route::get('manageshow/{id}', [ManagementReviewController::class, 'manageshow'])->name('manageshow');
Route::post('manage/stage/{id}', [ManagementReviewController::class, 'manage_send_stage'])->name('manage_send_stage');
Route::post('manage/cancel/{id}', [ManagementReviewController::class, 'manageCancel'])->name('manageCancel');
Route::post('manage/reject/{id}', [ManagementReviewController::class, 'manage_reject'])->name('manage_reject');
Route::post('manage/Qa/{id}', [ManagementReviewController::class, 'manage_qa_more_info'])->name('manage_qa_more_info');
Route::get('ManagementReviewAuditTrial/{id}', [ManagementReviewController::class, 'ManagementReviewAuditTrial']);
Route::get('ManagementReviewAuditDetails/{id}', [ManagementReviewController::class, 'ManagementReviewAuditDetails']);

// ==============================end ==============================
//! ============================================
//!                    Risk Management
//! ============================================
Route::get('risk-management', [RiskManagementController::class, 'risk']);
Route::get('RiskManagement/{id}', [RiskManagementController::class, 'show'])->name('showRiskManagement');
Route::post('risk_store', [RiskManagementController::class, 'store'])->name('risk_store');
Route::post('riskAssesmentUpdate/{id}', [RiskManagementController::class, 'riskUpdate'])->name('riskUpdate');
Route::post('riskAssesmentStateChange{id}', [RiskManagementController::class, 'riskAssesmentStateChange'])->name('riskAssesmentStateUpdate');
Route::post('reject_Risk/{id}', [RiskManagementController::class, 'RejectStateChange'])->name('reject_Risk');

Route::get('riskAuditTrial/{id}', [RiskManagementController::class, 'riskAuditTrial']);
Route::get('auditDetailsrisk/{id}', [RiskManagementController::class, 'auditDetailsrisk'])->name('showriskAuditDetails');
Route::post('child/{id}', [RiskManagementController::class, 'child'])->name('riskAssesmentChild');

// ======================================================
//============================Supplier Observation by pramod=======================================
Route::get('supplier-observation',[SupplierController::class,'supplier']);
Route::post('supplierstore',[SupplierController::class,'supplier_store'])->name('supplier_store');
Route::put('supplierUpdate/{id}',[SupplierController::class,'supplier_update'])->name('supplier_update');
Route::get('suppliershow/{id}',[SupplierController::class,'supplier_show'])->name('supplier_show');
Route::post('supplier/stage/{id}',[SupplierController::class,'supplier_send_stage'])->name('supplier_send_stage');
Route::post('supplier/cancle/{id}',[SupplierController::class,'supplier_Cancle'])->name('supplier_Cancle');
Route::post('supplier/reject/{id}',[SupplierController::class,'supplier_reject'])->name('supplier_reject');
Route::get('supplierAuditTrail/{id}',[SupplierController::class,'supplierAuditTrail']);
Route::get('auditDetailsSupplier/{id}',[SupplierController::class,'auditDetailsSupplier'])->name('showsupplierAuditDetails');

// ======================================================
//============================Supplier Observation by pramod=======================================

Route::get('country_sub_data',[CountrySubDataController::class,'country_submission']);
Route::post('countrystore',[CountrySubDataController::class,'country_store'])->name('country_store');
Route::put('countrySubUpdate/{id}',[CountrySubDataController::class,'country_update'])->name('country_update');
Route::get('countryshow/{id}',[CountrySubDataController::class,'country_show'])->name('country_show');
Route::post('country/stage/{id}',[CountrySubDataController::class,'country_send_stage'])->name('country_send_stage');
Route::post('country/cancle/{id}',[CountrySubDataController::class,'country_Cancle'])->name('country_Cancle');
Route::get('countryAuditTrail/{id}',[CountrySubDataController::class,'countryAuditTrail']);

// =================QRM fORM=====================================
Route::view('qrm', 'frontend.QRM.qrm');

// ====================================root cause analysis=======================
Route::get('root-cause-analysis', [RootCauseController::class, 'rootcause']);
Route::post('rootstore', [RootCauseController::class, 'root_store'])->name('root_store');
Route::post('rootUpdate/{id}', [RootCauseController::class, 'root_update'])->name('root_update');
Route::get('rootshow/{id}', [RootCauseController::class, 'root_show'])->name('root_show');
Route::post('root/stage/{id}', [RootCauseController::class, 'root_send_stage'])->name('root_send_stage');
Route::post('root/cancel/{id}', [RootCauseController::class, 'root_Cancel'])->name('root_Cancel');
Route::post('root/reject/{id}', [RootCauseController::class, 'root_reject'])->name('root_reject');
Route::get('rootAuditTrial/{id}', [RootCauseController::class, 'rootAuditTrial']);
Route::get('auditDetailsRoot/{id}', [RootCauseController::class, 'auditDetailsroot'])->name('showrootAuditDetails');

// ====================================InternalauditController=======================
Route::post('internalauditreject/{id}', [InternalauditController::class, 'RejectStateChange']);
Route::post('InternalAuditCancel/{id}', [InternalauditController::class, 'InternalAuditCancel']);
Route::post('InternalAuditChild/{id}', [InternalauditController::class, 'internal_audit_child'])->name('internal_audit_child');

// external audit----------------------------

Route::get('show/{id}', [AuditeeController::class, 'show'])->name('showExternalAudit');
Route::post('auditee_store', [AuditeeController::class, 'store'])->name('auditee_store');
Route::post('update/{id}', [AuditeeController::class, 'update'])->name('updateExternalAudit');
Route::post('ExternalAuditStateChange/{id}', [AuditeeController::class, 'ExternalAuditStateChange'])->name('externalAuditStateChange');
Route::post('RejectStateAuditee/{id}', [AuditeeController::class, 'RejectStateChange'])->name('RejectStateAuditee');
Route::post('CancelStateExternalAudit/{id}', [AuditeeController::class, 'externalAuditCancel'])->name('CancelStateExternalAudit');
Route::get('ExternalAuditTrialShow/{id}', [AuditeeController::class, 'AuditTrialExternalShow'])->name('ShowexternalAuditTrial');
Route::get('ExternalAuditTrialDetails/{id}', [AuditeeController::class, 'AuditTrialExternalDetails'])->name('ExternalAuditTrialDetailsShow');
Route::post('child_external/{id}', [AuditeeController::class, 'child_external'])->name('childexternalaudit');

//----------------------Lab Incident view-----------------
Route::get('lab-incident', [LabIncidentController::class, 'labincident']);
//Route::post('RejectStateChange/{id}', [RootCauseController::class, 'RejectStateChange'])->name('RejectStateChange');
// Route::post('RejectStateChange/{id}', [LabIncidentController::class, 'RejectStateChange']);
// Route::post('LabIncidentStateChange/{id}', [LabIncidentController::class, 'LabIncidentStateChange'])->name('StageChangeLabIncident');
Route::post('RejectStateChange/{id}', [LabIncidentController::class, 'RejectStateChange']);
Route::post('StageChangeLabIncident/{id}', [LabIncidentController::class, 'LabIncidentStateChange']);
Route::post('LabIncidentCancel/{id}', [LabIncidentController::class, 'LabIncidentCancelStage']);

Route::get('audit-program', [AuditProgramController::class, 'auditprogram']);

Route::get('data-fields', function () {
    return view('frontend.data-fields');
});
Route::view('emp', 'emp');

Route::view('tasks', 'frontend.tasks');
Route::view('tasks', 'frontend.T');
Route::view('review-details', 'frontend.documents.review-details');
Route::view('audit-trial-inner', 'frontend.documents.audit-trial-inner');
Route::view('new-pdf', 'frontend.documents.new-pdf');
Route::view('new-login', 'frontend.new-login');

// ============================================
//                    TMS
// ============================================

Route::view('helpdesk-personnel', 'frontend.helpdesk-personnel');

// Route::view('send-notification', 'frontend.send-notification');

Route::view('designate-proxy', 'frontend.designate-proxy');

Route::view('person-details', 'frontend.person-details');

Route::view('basic-search', 'frontend.basic-search');
//! ============================================ //
//!                    TMS
//! ============================================ //

Route::view('create-training', 'frontend.TMS.create-training');

Route::view('example', 'frontend.TMS.example');

Route::view('create-quiz', 'frontend.TMS.create-quiz');

Route::view('document-view', 'frontend.TMS.document-view');

Route::view('training-page', 'frontend.TMS.training-page');

Route::view('question-training', 'frontend.TMS.question-training');

Route::view('edit-question', 'frontend.TMS.edit-question');

Route::view('change-control-list', 'frontend.change-control.change-control-list');
Route::view('auditReport', 'frontend.deviation_report.auditReport');

Route::view('change-control-list-print', 'frontend.change-control.change-control-list-print');

Route::view('change-control-view', 'frontend.change-control.change-control-view');

Route::view('reviewer-panel', 'frontend.change-control.reviewer-panel');

Route::view('change-control-form', 'frontend.change-control.data-fields');

//Route::view('new-change-control', 'frontend.change-control.new-change-control');
Route::get('new-change-control', [CCController::class, 'changecontrol']);

Route::view('audit-pdf', 'frontend.documents.audit-pdf');

//! ============================================
//!                    RCMS
//! ============================================
Route::get('chart-data', [DesktopController::class, 'fetchChartData']);
Route::get('chart-data-releted', [DesktopController::class, 'fetchChartDataDepartmentReleted']);
Route::get('chart-data-initialDeviationCategory', [DesktopController::class, 'fetchChartDataInitialDeviationCategory']);
Route::get('chart-data-postCategorizationOfDeviation', [DesktopController::class, 'fetchChartDataPostCategorizationOfDeviation']);
Route::get('chart-data-capa', [DesktopController::class, 'fetchChartDataCapa']);

Route::get('chart-data-dep', [DesktopController::class, 'fetchChartDataDepartment']);
Route::get('chart-data-statuswise', [DesktopController::class, 'fatchStatuswise']);

Route::view('rcms_login', 'frontend.rcms.login');

Route::view('rcms_dashboard', 'frontend.rcms.dashboard');
Route::get('rcms_desktop', [DesktopController::class, 'rcms_desktop']);
Route::post('dashboard_search', [DesktopController::class, 'dashboard_search'])->name('dashboard_search');
Route::post('dashboard_search', [DesktopController::class, 'main_dashboard_search'])->name('main_dashboard_search');
// Route::view('rcms_desktop', 'frontend.rcms.desktop');

Route::view('rcms_reports', 'frontend.rcms.reports');

Route::view('Quality-Dashboard-Report', 'frontend.rcms.Quality-Dashboard');

Route::view('Supplier-Dashboard-Report', 'frontend.rcms.Supplier-Dashboard');

Route::view('QMSDashboardFormat', 'frontend.rcms.QMSDashboardFormat');

//! ============================================
//!                    FORMS
//! ============================================


Route::view('deviation', 'frontend.forms.deviation');
Route::post('deviation_child/{id}', [DeviationController::class, 'deviation_child_1'])->name('deviation_child_1');
Route::get('DeviationAuditTrial/{id}', [DeviationController::class, 'DeviationAuditTrial']);
Route::get('DeviationAuditTrialDetails/{id}', [DeviationController::class, 'DeviationAuditTrialDetails']);
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');

Route::view('extension_form', 'frontend.forms.extension');

Route::view('cc-form', 'frontend.forms.change-control');

Route::view('audit-management', 'frontend.forms.audit-management');

Route::view('out-of-specification', 'frontend.forms.out-of-specification');

// Route::view('risk-management', 'frontend.forms.risk-management');

Route::view('action-item', 'frontend.forms.action-item');

// Route::view('effectiveness-check', 'frontend.forms.effectiveness-check');
Route::get('effectiveness-check', [EffectivenessCheckController::class, 'effectiveness_check']);

Route::view('quality-event', 'frontend.forms.quality-event');

Route::view('vendor-entity', 'frontend.forms.vendor-entity');
Route::view('deviation_new', 'frontend.forms.deviation_new');

// -------------------------------------ehs---------forms--------
Route::view('recurring_commitment', 'frontend.ehs.recurring_commitment');
Route::view('sanction', 'frontend.ehs.sanction');
Route::view('monthly_working', 'frontend.ehs.monthly_working');

Route::view('investigation', 'frontend.ehs.investigation');

Route::view('environmental_task', 'frontend.ehs.environmental_task');
Route::view('ehs_event', 'frontend.ehs.ehs_event');
Route::view('effectiveness', 'frontend.ehs.effectiveness');
Route::view('capa', 'frontend.ehs.capa');
Route::view('action_item', 'frontend.ehs.action_item');

// --------------------------------------ctms-------forms-------

Route::view('violation', 'frontend.ctms.violation');
Route::view('subject', 'frontend.ctms.subject');
Route::view('subject_action_item', 'frontend.ctms.subject_action_item');

Route::view('study', 'frontend.ctms.study');

Route::view('serious_adverse_event', 'frontend.ctms.serious_adverse_event');
Route::view('monitoring_visit', 'frontend.ctms.monitoring_visit');
Route::view('investigational_nda_anda', 'frontend.ctms.investigational_nda_anda');
Route::view('cta_amendement', 'frontend.ctms.cta_amendement');
// Route::view('country_sub_data', 'frontend.ctms.country_sub_data');
Route::view('clinical_site', 'frontend.ctms.clinical_site');

Route::view('cta_submission', 'frontend.ctms.cta_submission');
Route::view('masking', 'frontend.ctms.masking');
Route::view('randomization', 'frontend.ctms.randomization');
Route::view('regulatory_quary_managment', 'frontend.ctms.regulatory_quary_managment');
Route::view('regulatory_notification', 'frontend.ctms.regulatory_notification');

// ----------------------------------------------------------------------New Forms ------------------------------
Route::view('complaint', 'frontend.new_forms.complaint');
// Route::view('supplier-observation', 'frontend.new_forms.supplier-observation');
Route::view('preventive-maintenance', 'frontend.new_forms.preventive-maintenance');
Route::view('equipment', 'frontend.new_forms.equipment');
Route::view('production-line-audit', 'frontend.new_forms.production-line-audit');
Route::view('renewal', 'frontend.new_forms.renewal');
Route::view('validation', 'frontend.new_forms.validation');
Route::view('qualityFollowUp', 'frontend.new_forms.qualityFollowUp');
Route::view('product-recall', 'frontend.new_forms.product-recall');
Route::view('field-inquiry', 'frontend.new_forms.field-inquiry');
Route::view('medical-device', 'frontend.new_forms.medical-device');
Route::view('risk-management', 'frontend.new_forms.risk-management');
Route::view('training_course', 'frontend.New_forms.training_course');
Route::view('lab_test', 'frontend.New_forms.lab_test');
Route::view('client_inquiry', 'frontend.New_forms.client_inquiry');
Route::view('lab_investigation', 'frontend.New_forms.lab_investigation');
Route::view('GCP_study', 'frontend.new_forms.GCP_study');
Route::view('calibration', 'frontend.new_forms.calibration');
Route::view('self-inspection', 'frontend.new_forms.self-inspection');
Route::view('meeting-management', 'frontend.new_forms.meeting-management');

// ------------------------------R T Form--------------------//
Route::view('national-approval', 'frontend.Registration-Tracking.national-approval');
Route::view('variation', 'frontend.Registration-Tracking.variation');
Route::view('PSUR', 'frontend.Registration-Tracking.PSUR');
Route::view('dosier-documents', 'frontend.Registration-Tracking.dosier-documents');
Route::view('commit
ment', 'frontend.Registration-Tracking.commitment');

//--------------------------------ERRATA-----form---------------//
Route::view('errata', 'frontend.ERRATA.errata');

//--------------------------------OOC-----form---------------//

Route::view('out_of_calibration', 'frontend.OOC.out_of_calibration');

//--------------------------------Incident-----form---------------//

Route::view('incident', 'frontend.Incident.incident');

// -------------------------OOS-----------------
Route::view('oos-form', 'frontend.OOS.oos-form');

Route::view('supplier_contract', 'frontend.New_forms.supplier_contract');
Route::view('supplier_audit', 'frontend.New_forms.supplier_audit');
Route::view('correspondence', 'frontend.New_forms.correspondence');
Route::view('first_product_validation', 'frontend.New_forms.first_product_validation');
Route::view('read_and_understand', 'frontend.New_forms.read_and_understand');
// Route::view('medical_device_registration', 'frontend.New_forms.medical_device_registration');
// Route::view('auditee', 'frontend.forms.auditee');
Route::get('auditee', [AuditeeController::class, 'external_audit']);

Route::get('meeting', [ManagementReviewController::class, 'meeting']);

Route::view('market-complaint', 'frontend.forms.market-complaint');

//Route::view('lab-incident', 'frontend.forms.lab-incident');

Route::view('classroom-training', 'frontend.forms.classroom-training');

Route::view('employee', 'frontend.forms.employee');

Route::view('requirement-template', 'frontend.forms.requirement-template');

Route::view('scar', 'frontend.forms.scar');

Route::view('external-audit', 'frontend.forms.external-audit');

Route::view('contract', 'frontend.forms.contract');

Route::view('supplier', 'frontend.forms.supplier');

Route::view('supplier-initiated-change', 'frontend.forms.supplier-initiated-change');

Route::view('supplier-investigation', 'frontend.forms.supplier-investigation');

Route::view('supplier-issue-notification', 'frontend.forms.supplier-issue-notification');

// Route::view('audit', 'frontend.forms.audit');
Route::get('audit', [InternalauditController::class, 'internal_audit']);

Route::view('supplier-questionnaire', 'frontend.forms.supplier-questionnaire');

Route::view('substance', 'frontend.forms.substance');

Route::view('supplier-action-item', 'frontend.forms.supplier-action-item');

Route::view('registration-template', 'frontend.forms.registration-template');

Route::view('project', 'frontend.forms.project');

Route::get('extension', [ExtensionController::class, 'extension_child']);

//Route::view('observation', 'frontend.forms.observation');
Route::get('observation', [ObservationController::class, 'observation']);
Route::get('deviation', [DeviationController::class, 'deviation']);

Route::view('new-root-cause-analysis', 'frontend.forms.new-root-cause-analysis');

Route::view('help-desk-incident', 'frontend.forms.help-desk-incident');

Route::view('review-management-report', 'frontend.review-management.review-management-report');

//! ============================================
//!                    External Audit
//! ============================================

// ===============OOt form==========================\
Route::view('OOT_form', 'frontend.OOT.OOT_form');

//====-------------- Resampling Form------------=========

// Route::view('resampling_new','frontend.OOS.resampling_new');
// Route::view('resampling_view','frontend.OOS.resampling_view');

// Route::post('resampling_new',[ResamplingController::class,'store']);
// Route::get('create',[ResamplingController::class,'create'])->name('resampling_create');
// Route::get('resampling_view/{id}/edit',[ResamplingController::class,'edit'])->name('resampling_edit');
// Route::post('resampling_updated/{id}',[ResamplingController::class,'update'])->name('resampling_update');

Route::get('resampling_new',[ResamplingController::class,'create']);
Route::post('resamplingStore',[ResamplingController::class,'resampling_store'])->name('resampling_store');
Route::put('resamplingUpdate/{id}',[ResamplingController::class,'resampling_update'])->name('resampling_update');
Route::get('resamplingshow/{id}',[ResamplingController::class,'resampling_show'])->name('resampling_show');
Route::post('resampling/stage/{id}',[ResamplingController::class,'resampling_send_stage'])->name('resampling_send_stage');
Route::post('resampling/cancle/{id}',[ResamplingController::class,'resampling_Cancle'])->name('resampling_Cancle');
Route::post('resampling/reject/{id}',[ResamplingController::class,'resampling_reject'])->name('resampling_reject');
Route::get('resamplingAuditTrail/{id}',[ResamplingController::class,'resamplingAuditTrail'])->name('resamplingAuditTrail');
Route::get('resampling/auditDetails/{id}',[ResamplingController::class,'auditDetails'])->name('auditDetails');

//!============================== Verification form  =============================================
// Route::get('oos_micro', [OOSMicroController::class, 'index'])->name('oos_micro.index');
// Route::post('oos_micro_store', [OOSMicroController::class, 'store'])->name('oos_micro.store');
// Route::get('oos_micro_edit/{id}',[OOSMicroController::class, 'edit'])->name('oos_micro.edit');
// Route::post('oos_micro_update/{id}',[OOSMicroController::class, 'update'])->name('oos_micro.update');

Route::view('verification', 'frontend.verification.verification')->name('verification');
Route::post('verification_store', [VerificationController::class, 'store'])->name('verification_store');
Route::get('verification_edit/{id}',[VerificationController::class, 'edit'])->name('verification_edit');
Route::post('verification_update/{id}',[VerificationController::class, 'update'])->name('verification_update');

Route::post('Vsendstage/{id}',[VerificationController::class,'send_stage'])->name('Vsend_stage');
Route::post('sendstage2/{id}',[VerificationController::class,'Vsend_stage2'])->name('Vsend_stage2');

Route::post('Vrequestmoreinfo_back_stage/{id}',[VerificationController::class,'requestmoreinfo_back_stage'])->name('Vrequestmoreinfo_back_stage');
Route::post('cancel_stage/{id}', [VerificationController::class, 'cancel_stage'])->name('Vcancel_stage');;
Route::post('thirdStage/{id}', [VerificationController::class, 'stageChange'])->name('thirdStage');
Route::post('Vstore_audit_review/{id}', [VerificationController::class, 'store_audit_review'])->name('Vstore_audit_review');
Route::get('Vaudit_details/{id}', [VerificationController::class, 'auditDetails'])->name('Vaudit_details');

Route::get('Vaudit_report/{id}', [VerificationController::class, 'auditReport'])->name('Vaudit_report');
Route::get('Vsingle_report/{id}', [VerificationController::class, 'singleReport'])->name('Vsingle_report');
Route::get('Vaudit_trial/{id}', [VerificationController::class, 'AuditTrial'])->name('Vaudit_trial');



//============================= Analyst Interview  =====================================================

Route::view('analyst_interview','analystInterview.analystInterview_new');
Route::view('analyst_interview','analystInterview.analystInterview_new')->name('analyst_interview');

Route::post('analystinterview_store', [AnalystInterviewController::class, 'store'])->name('analystinterview_store');
Route::get('analystinterview_edit/{id}',[AnalystInterviewController::class, 'edit'])->name('analystinterview_edit');
Route::post('analystinterview_update/{id}',[AnalystInterviewController::class, 'update'])->name('analystinterview_update');

Route::post('sendstage/{id}',[AnalystInterviewController::class,'send_stage'])->name('AIsend_stage');
Route::post('requestmoreinfo_back_stage/{id}',[AnalystInterviewController::class,'requestmoreinfo_back_stage'])->name('AIrequestmoreinfo_back_stage');
Route::post('cancel_stage/{id}', [AnalystInterviewController::class, 'cancel_stage'])->name('AIcancel_stage');;
Route::post('thirdStage/{id}', [AnalystInterviewController::class, 'stageChange'])->name('thirdStage');
Route::post('AuditTrial/{id}', [AnalystInterviewController::class, 'store_audit_review'])->name('AIstore_audit_review');
Route::get('auditDetails/{id}', [AnalystInterviewController::class, 'auditDetails'])->name('AIaudit_details');
Route::get('AIaudit_report/{id}', [AnalystInterviewController::class, 'auditReport'])->name('AIaudit_report');
Route::get('AIsingle_report/{id}', [AnalystInterviewController::class, 'singleReport'])->name('AIsingle_report');
Route::get('AIAuditTrial/{id}', [AnalystInterviewController::class, 'AuditTrial'])->name('AIaudit_trial');

// ===============Additional Testing==========================\
Route::view("additional_testing", 'frontend.additional-testing.additional_testing')->name('additional_testing');
Route::post('additionaltesting_store', [AdditionalTestingController::class, 'store'])->name('additionaltesting_store');
Route::get('additionaltesting_edit/{id}',[AdditionalTestingController::class, 'edit'])->name('additionaltesting_edit');
Route::post('additionaltesting_update/{id}',[AdditionalTestingController::class, 'update'])->name('additionaltesting_update');

Route::post('sendstageat/{id}',[AdditionalTestingController::class,'send_stage'])->name('ATsend_stage');
Route::post('request_more_info_back_stage/{id}',[AdditionalTestingController::class,'requestmoreinfo_back_stage'])->name('ATrequest_more_info_back_stage');

Route::post('send_back_stage_to4/{id}',[AdditionalTestingController::class,'send_stageto4'])->name('send_stageto4');

Route::post('cancel_stages/{id}', [AdditionalTestingController::class, 'cancel_stages'])->name('ATcancel_stages');
Route::post('thirdStage/{id}', [AdditionalTestingController::class, 'stageChange'])->name('thirdStage');
Route::post('AuditTrial/{id}', [AdditionalTestingController::class, 'store_audit_review'])->name('ATstore_audit_review');
Route::get('auditDetails_at/{id}', [AdditionalTestingController::class, 'auditDetails'])->name('auditDetails_at');
Route::get('ATaudit_report/{id}', [AdditionalTestingController::class, 'auditReport'])->name('ATaudit_report');
Route::get('ATsingle_report/{id}', [AdditionalTestingController::class, 'singleReport'])->name('ATsingle_report');
Route::get('AuditTrial/{id}', [AdditionalTestingController::class, 'AuditTrial'])->name('ATaudit_trial');



// Route::get('/additional_testing_view/{id}', [AdditionalTestingController::class, 'edit']);
// Route::view("additional_testing_view", 'frontend.additional-testing.additional_testing_view');
// Route::post('additional_testing_store', [AdditionalTestingController::class, 'store'])->name('at_store');
// Route::get('additional_testing/{id}', [AdditionalTestingController::class, 'edit'])->name('at_edit');

// Route::view('/additional_testing_view','frontend.additional-testing.additional_testing_view')->name('at_update');
Route::post('additional_testing_update/{id}', [AdditionalTestingController::class, 'update'])->name('at_update');





// Route::post('sendstage/{id}',[DosierDocumentsController::class,'send_stage'])->name('send_stage');
// Route::post('requestmoreinfo_back_stage/{id}',[DosierDocumentsController::class,'requestmoreinfo_back_stage'])->name('requestmoreinfo_back_stage');
// Route::post('cancel_stage/{id}', [DosierDocumentsController::class, 'cancel_stage'])->name('cancel_stage');;
// Route::post('thirdStage/{id}', [DosierDocumentsController::class, 'stageChange'])->name('thirdStage');
// Route::get('AuditTrial/{id}', [DosierDocumentsController::class, 'AuditTrial'])->name('audit_trial');
// Route::post('AuditTrial/{id}', [DosierDocumentsController::class, 'store_audit_review'])->name('store_audit_review');
// Route::get('auditDetails/{id}', [DosierDocumentsController::class, 'auditDetails'])->name('audit_details');

// Route::get('audit_report/{id}', [DosierDocumentsController::class, 'auditReport'])->name('audit_report');
// Route::get('single_report/{id}', [DosierDocumentsController::class, 'singleReport'])->name('single_report');





// Route::post('oos_micro/requestmoreinfo_back_stage/{id}',[OOSMicroController::class,'requestmoreinfo_back_stage'])->name('requestmoreinfo_back_stage');
// Route::post('oos_micro/assignable_send_stage/{id}',[OOSMicroController::class,'assignable_send_stage'])->name('assignable_send_stage');
// Route::post('oos_micro/cancel_stage/{id}', [OOSMicroController::class, 'cancel_stage'])->name('cancel_stage');;
// Route::post('oos_micro/thirdStage/{id}', [OOSMicroController::class, 'stageChange'])->name('thirdStage');
// Route::post('oos_micro/reject_stage/{id}', [OOSMicroController::class, 'reject_stage'])->name('reject_stage');
// Route::get('oos_micro/AuditTrial/{id}', [OOSMicroController::class, 'AuditTrial'])->name('audit_trial');
// Route::get('oos_micro/auditDetails/{id}', [OOSMicroController::class, 'auditDetails'])->name('audit_details');
//==================================================================================
// Route::post('medicalstore',[MedicalRegistrationController::class,'medicalCreate'])->name('medical.store');
// Route::get('medicalupdate/{id}/edit',[MedicalRegistrationController::class,'medicalEdit'])->name('medical_edit');
// Route::put('medicalupdated/{id}',[MedicalRegistrationController::class,'medicalUpdate'])->name('medical.update');



// Route::view('deviation', 'frontend.forms.deviation');
// Route::post('deviation_child/{id}', [DeviationController::class, 'deviation_child_1'])->name('deviation_child_1');
// Route::get('DeviationAuditTrial/{id}', [DeviationController::class, 'DeviationAuditTrial']);
// Route::get('DeviationAuditTrialDetails/{id}', [DeviationController::class, 'DeviationAuditTrialDetails']);
// Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
// Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');





// ========recommended action===============
Route::view('recommended_action_new', 'frontend.OOS.recommended_action');

// ========follow up task===============
Route::view('follow_up_task', 'frontend.newform.follow_up_task');


// ========Hypothesis ===============
Route::view('hypothesis', 'frontend.newform.hypothesis');
