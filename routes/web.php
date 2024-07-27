<?php

use App\Http\Controllers\CabinateController;
use App\Http\Controllers\ChangeControlController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\demo\DemoValidationController;
use App\Http\Controllers\DocumentContentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentDetailsController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MonitoringVisitController;
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
use App\Http\Controllers\ctms\ClinicalSiteController;
use App\Imports\DocumentsImport;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
// use App\Http\Controllers\newForm\MedicalRegistrationController;
use App\Http\Controllers\newForm\ReccomendedController;
use App\Http\Controllers\newForm\QualityFollolwupController;
use App\Http\Controllers\Product_ValidationController;
use App\Http\Controllers\TMSController;

use App\Http\Controllers\medicaldeviceController;
use App\Http\Controllers\MedicalDeviceController as ControllersMedicalDeviceController;
use App\Http\Controllers\PSURController;
use App\Http\Controllers\CommitmentController;

use App\Http\Controllers\newForm\CalibrationController;
use App\Http\Controllers\newForm\EquipmentController;
use App\Http\Controllers\newForm\MonthlyWorkingController;
use App\Http\Controllers\newForm\NationalApprovalController;
use App\Http\Controllers\newForm\SanctionController;
use App\Http\Controllers\newForm\ValidationController;

use App\Http\Controllers\ClientInquiryController;
use App\Http\Controllers\MeetingManagementController;
use App\Http\Controllers\AdditionalInformationController;
use App\Http\Controllers\rcms\AuditTaskController;

use App\Http\Controllers\RenewalController;
use App\Http\Controllers\HypoController;

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
    Route::post('medicalstore', [MedicalRegistrationController::class, 'medicalCreate'])->name('medical.store');
    Route::get('medicalupdate/{id}/edit', [MedicalRegistrationController::class, 'medicalEdit'])->name('medical_edit');
    Route::put('medicalupdated/{id}', [MedicalRegistrationController::class, 'medicalUpdate'])->name('medical.update');
});


//================================ Juned Recccomended Action =======================================================================================================================================


Route::middleware(['auth'])->group(function () {

    Route::get('reccomendedAction_page',[ReccomendedController::class, 'index'])->name('auth');
     Route::post('reccomendedstore',[ReccomendedController::class,'ReccomendedCreate'])->name('reccomended.store');
     Route::get('ReccomendationShow/{id}',[ReccomendedController::class,'ReccomendationShow'])->name('Reccomendation_show');
    //  Route::get('qualityupdate/{id}/edit',[QualityFollolwupController::class,'qualityfollowEdit'])->name('quality_edit');
      Route::put('reccomendedUpdate/{id}',[ReccomendedController::class,'ReccomendedUpdate'])->name('reccomended.update');
      // Route::get('/your-route', [YourController::class, 'yourMethod']);
     Route::post('reccomend_send_stage/{id}',[ReccomendedController::class,'reccomended_send_stage'])->name('reccomend_send_stage');

     });
     Route::post('reccomend_send_stage2/{id}',[ReccomendedController::class, 'renewal_forword2'])->name('reccomend_send_stage2');

    // Route::post('quality_send2/{id}',[QualityFollolwupController::class,'quality_send2'])->name('quality_send2');
    Route::get('RecommendedAuditTrialDetails/{id}',[ReccomendedController::class,'RecommendedAuditTrialDetails'])->name('RecommendedAuditTrialDetails');
    //  Route::get('reccomended_singleReports/{id}',[ReccomendedController::class, 'singleReports'])->name('singleReports');

    // =======================  QualityFollow Up //==============================

    Route::middleware(['auth'])->group(function () {

    Route::get('qualityfollowup_page', [QualityFollolwupController::class, 'index'])->name('auth');
    Route::post('qualitystore', [QualityFollolwupController::class, 'qualityFollowCreate'])->name('quality.store');
    Route::get('qualityshow/{id}', [QualityFollolwupController::class, 'qualityFollowShow'])->name('quality_show');
    Route::get('qualityupdate/{id}/edit', [QualityFollolwupController::class, 'qualityfollowEdit'])->name('quality_edit');
    Route::put('qualityupdated/{id}', [QualityFollolwupController::class, 'qualityfollowUpdate'])->name('quality.update');
  });

        Route::post('quality_send_stage/{id}', [QualityFollolwupController::class, 'quality_send_stage'])->name('quality_send_stage');
        Route::post('quality_send2/{id}', [QualityFollolwupController::class, 'quality_send2'])->name('quality_send2');


        Route::get('rcms/QualityFollowupAuditTrialDetails/{id}', [QualityFollolwupController::class, 'QualityFollowupAuditTrialDetails'])->name('QualityFollowupAuditTrialDetails');
        Route::get('rcms/singleReports/{id}', [QualityFollolwupController::class, 'singleReports'])->name('singleReports');
        Route::get('quality_audit/{id}', [QualityFollolwupController::class, 'auditTrailPdf'])->name('QualityAuditTrail.pdf');



        //========================================================Production Validation===============================================================

        Route::middleware(['auth'])->group(function () {

            Route::get('production_page', [Product_ValidationController::class, 'index'])->name('auth');
            Route::post('productionstore', [Product_ValidationController::class, 'ProductionValidationCreate'])->name('production.store');
            Route::get('productionshow/{id}', [Product_ValidationController::class, 'ProductionShow'])->name('production_show');
            Route::get('ProductionValidationupdate/{id}/edit', [Product_ValidationController::class, 'ProductionValidationfollowEdit'])->name('quality_edit');
            Route::put('ProductionValidationfollowupdated/{id}', [Product_ValidationController::class, 'ProductionValidationfollowUpdate'])->name('ProductionValidationfollow.update');
            // //     // Route::get('/your-route', [YourController::class, 'yourMethod']);
        });

        Route::post('production_send_stage/{id}', [Product_ValidationController::class, 'production_send_stage'])->name('production_send_stage');
        Route::post('rejectstateproductionValidation/{id}', [Product_ValidationController::class, 'RejectStateChange'])->name('rejectstateproductionValidation');
        Route::post('rejectstateproductionValidation2/{id}', [Product_ValidationController::class, 'RejectStateChange2'])->name('rejectstateproductionValidation2');



        Route::get('ProductionAuditTrialDetails/{id}', [Product_ValidationController::class, 'ProductionAuditTrialDetails'])->name('ProductionAuditTrialDetails');
        Route::get('rcms/singleReports/{id}', [Product_ValidationController::class, 'singleReports'])->name('singleReports');
        Route::get('rcms/production_audit/{id}', [Product_ValidationController::class, 'auditTrailPdf'])->name('productionAuditTrail.pdf');


    //========================================================== Stages=====================================================



    Route::post('renewal/forword/{id}', [Product_ValidationController::class, 'renewal_forword_close'])->name('renewal_forword_close');
    Route::post('renewal/forword2/{id}', [Product_ValidationController::class, 'renewal_forword2_close'])->name('renewal_forword2_close');
    //  Route::post('renewal/child/{id}', [RenewalController::class, 'renewal_child_stage'])->name('renewal_child_stage');


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

//! ========================= Risk Management ====================================
Route::get('risk-management', [RiskManagementController::class, 'risk']);
Route::get('RiskManagement/{id}', [RiskManagementController::class, 'show'])->name('showRiskManagement');
Route::post('risk_store', [RiskManagementController::class, 'store'])->name('risk_store');
Route::post('riskAssesmentUpdate/{id}', [RiskManagementController::class, 'riskUpdate'])->name('riskUpdate');
Route::post('riskAssesmentStateChange{id}', [RiskManagementController::class, 'riskAssesmentStateChange'])->name('riskAssesmentStateUpdate');
Route::post('reject_Risk/{id}', [RiskManagementController::class, 'RejectStateChange'])->name('reject_Risk');

Route::get('riskAuditTrial/{id}', [RiskManagementController::class, 'riskAuditTrial']);
Route::get('auditDetailsrisk/{id}', [RiskManagementController::class, 'auditDetailsrisk'])->name('showriskAuditDetails');
Route::post('child/{id}', [RiskManagementController::class, 'child'])->name('riskAssesmentChild');

// =================QRM fORM=====================================
Route::view('qrm', 'frontend.QRM.qrm');
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

//-----------------monitoring_visit--------------------

Route::get('monitoring_visit', [MonitoringVisitController::class, 'index'])->name('monitoring_visit');
Route::post('monitoring_visit_store', [MonitoringVisitController::class, 'store'])->name('monitoring_visit_store');
Route::put('monitoring_visit_update/{id}', [MonitoringVisitController::class, 'update'])->name('monitoring_visit_update');
Route::get('monitoring_visit_view/{id}', [MonitoringVisitController::class, 'show'])->name('monitoring_visit_view');
Route::post('monitoring_visit_stage_change/{id}', [MonitoringVisitController::class, 'StageChange'])->name('MVStage_Change');
Route::post('Violation_item', [MonitoringVisitController::class, 'ViolationChild'])->name('violation_item_show');
Route::post('MVstages_change/{id}', [MonitoringVisitController::class, 'MonitoringVisitCancel'])->name('MVstages_change');
Route::get('Monitoring_Visit_AuditTrial/{id}', [MonitoringVisitController::class, 'MonitoringVisitAuditTrial'])->name('Monitoring_Visit_AuditTrial');
// Route::get('MonitoringVisitSingleReport/{id}', [MonitoringVisitController::class, 'MonitoringVisitSingleReport'])->name('MonitoringVisitSingleReport');

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


Route::view('investigation', 'frontend.ehs.investigation');

Route::view('environmental_task', 'frontend.ehs.environmental_task');
Route::view('ehs_event', 'frontend.ehs.ehs_event');
Route::view('effectiveness', 'frontend.ehs.effectiveness');
Route::view('capa', 'frontend.ehs.capa');
Route::view('action_item', 'frontend.ehs.action_item');

// --------------------------------------ctms-------forms-------

//Route::view('violation', 'frontend.ctms.violation');
Route::view('subject', 'frontend.ctms.subject');
//Route::view('subject_action_item', 'frontend.ctms.subject_action_item');

Route::view('study', 'frontend.ctms.study');

Route::view('serious_adverse_event', 'frontend.ctms.serious_adverse_event');
// Route::view('monitoring_visit', 'frontend.ctms.monitoring_visit');
Route::view('investigational_nda_anda', 'frontend.ctms.investigational_nda_anda');
//Route::view('cta_amendement', 'frontend.ctms.cta_amendement');
Route::view('country_sub_data', 'frontend.ctms.country_sub_data');
// Route::view('clinical_site', 'frontend.ctms.clinical_site');

Route::view('cta_submission', 'frontend.ctms.cta_submission');
Route::view('masking', 'frontend.ctms.masking');
Route::view('randomization', 'frontend.ctms.randomization');
Route::view('regulatory_quary_managment', 'frontend.ctms.regulatory_quary_managment');
Route::view('regulatory_notification', 'frontend.ctms.regulatory_notification');

// ----------------------------------------------------------------------New Forms ------------------------------
Route::view('complaint', 'frontend.new_forms.complaint');
Route::view('supplier-observation', 'frontend.new_forms.supplier-observation');
Route::view('preventive-maintenance', 'frontend.new_forms.preventive-maintenance');
// Route::view('equipment', 'frontend.new_forms.equipment');
Route::view('production-line-audit', 'frontend.new_forms.production-line-audit');
Route::view('renewal', 'frontend.new_forms.renewal');
Route::view('validation', 'frontend.new_forms.validation');
// Route::view('qualityFollowUp', 'frontend.new_forms.qualityFollowUp');
Route::view('product-recall', 'frontend.new_forms.product-recall');
Route::view('field-inquiry', 'frontend.new_forms.field-inquiry');
Route::view('medical-device', 'frontend.new_forms.medical-device');
Route::view('risk-management', 'frontend.new_forms.risk-management');
Route::view('training_course', 'frontend.New_forms.training_course');
Route::view('lab_test', 'frontend.New_forms.lab_test');
Route::view('client-inquiry', 'frontend.New_forms.client-inquiry');
Route::view('lab_investigation', 'frontend.New_forms.lab_investigation');
//Route::view('GCP_study', 'frontend.new_forms.GCP_study');
Route::view('calibration', 'frontend.new_forms.calibration');
Route::view('self-inspection', 'frontend.new_forms.self-inspection');
Route::view('meeting-management', 'frontend.new_forms.meeting-management');

// ------------------------------R T Form--------------------//
// Route::view('national-approval', 'frontend.Registration-Tracking.national-approval');
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
//Route::view('supplier_contract', 'frontend.New_forms.supplier_contract');
Route::view('supplier_audit', 'frontend.New_forms.supplier_audit');
//Route::view('correspondence', 'frontend.New_forms.correspondence');
//Route::view('contract_testing_lab_audit', 'frontend.New_forms.contract_testing_lab_audit');
//Route::view('first_product_validation', 'frontend.New_forms.first_product_validation');
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
// ===============OOt form==========================\
Route::view('OOT_form', 'frontend.OOT.OOT_form');

// ===============Additional Testing==========================\
Route::view("additional_testing", 'frontend.additional-testing.additional_testing');

            //! ============================================
            //!                    External Audit
            //! ============================================

        // ========================================By Kuldeep ClinicalSite start===============================

        Route::get('clinicalsiteindex', [ClinicalSiteController::class, 'index'])->name('clinicalsite');
        Route::post('clinicalsitestore', [ClinicalSiteController::class, 'store'])->name('clinicstore');
        Route::get('clinicalsiteshow/{id}', [ClinicalSiteController::class, 'show'])->name('clinicshow');
        Route::put('clinicalsiteupdate/{id}', [ClinicalSiteController::class, 'update'])->name('clinicupdate');
        Route::get('clinicalsiteAuditReport/{id}', [ClinicalSiteController::class, 'clinicalsiteAuditTrial'])->name('clinicalsiteAuditReport');
        Route::post('clinicalsitestagechange/{id}', [ClinicalSiteController::class, 'ClinicalSiteStateChange'])->name('clin_site_stagechange');
        Route::post('clinicalsiteCansilstagechange/{id}', [ClinicalSiteController::class, 'ClinicalSiteCancel'])->name('cansilstagechange');
        // Route::get('clinetauditTrailPdf/{id}', [ClinicalSiteController::class, 'auditTrailPdf'])->name('clinicalsiteTrailPdf');
        Route::post('clinicalsiteChild/{id}', [ClinicalSiteController::class, 'ClinicalChild'])->name('ClinicalsiteChild');

        //! ============================================By Suneel  Validation Form ==================================
        Route::get('/validation', [ValidationController::class, 'validationIndex'])->name('create');
        Route::post('/validation-create', [ValidationController::class, 'store'])->name('validation_store');
        Route::get('/validation/{id}/edit', [ValidationController::class, 'validationEdit'])->name('validation.edit');
        Route::put('/validation/{id}', [ValidationController::class, 'validationUpdate'])->name('validation.update');
        Route::get('validationAuditTrialDetails/{id}', [ValidationController::class, 'ValidationAuditTrialDetails']);
        Route::get('auditValidation/{id}', [ValidationController::class, 'auditValidation']);

        //=============================Equipment ====================
        Route::get('equipmentCreate', [EquipmentController::class, 'equipmentIndex'])->name('create');
        Route::post('/equipmentCreate', [EquipmentController::class, 'equipmentStore'])->name('equipment.store');
        Route::get('/equipment/{id}/edit', [EquipmentController::class, 'equipmentEdit'])->name('equipment.edit');
        Route::put('/equipment/{id}', [EquipmentController::class, 'equipmentUpdate'])->name('equipment.update');
        Route::get('equipmentAuditTrialDetails/{id}', [EquipmentController::class, 'EquipmentAuditTrialDetails']);
        Route::get('audit_trail_equipment/{id}', [EquipmentController::class, 'audit_Equipment']);
        Route::post('equipment_child/{id}', [EquipmentController::class, 'equipment_child_1'])->name('equipment_child_1');

        // =============== New forms - Calibration =================
        Route::get('calibration', [CalibrationController::class, 'calibrationIndex']);
        Route::post('/calibrationCreate', [CalibrationController::class, 'calibrationStore'])->name('calibration.store');
        Route::get('/calibration/{id}/edit', [CalibrationController::class, 'calibrationEdit'])->name('calibration.edit');
        Route::put('/calibration/{id}', [CalibrationController::class, 'calibrationUpdate'])->name('calibration.update');
        Route::get('calibrationAuditTrialDetails/{id}', [CalibrationController::class, 'CalibrationAuditTrialDetails']);
        Route::get('audit_trail_calibration/{id}', [CalibrationController::class, 'auditCalibration']);
        Route::post('calibration_child/{id}', [CalibrationController::class, 'calibration_child_1'])->name('calibration_child_1');

        //=================== National  Approval ====================//
        Route::get('national-approval', [NationalApprovalController::class, 'index']);
        Route::post('/nationalApproval', [NationalApprovalController::class, 'npStore'])->name('national_approval.store');
        Route::get('/national_approval/{id}/edit', [NationalApprovalController::class, 'npEdit'])->name('national_approval.edit');
        Route::put('/np_update/{id}', [NationalApprovalController::class, 'npUpdate'])->name('national_approval.update');
        Route::post('np_child/{id}', [NationalApprovalController::class, 'np_child_1'])->name('np_child_1');
        Route::get('audit_trail_np/{id}', [NationalApprovalController::class, 'audit_NationalApproval']);
        Route::get('npAuditTrialDetails/{id}', [NationalApprovalController::class, 'nationalAuditTrialDetails']);

        //=================== Sanction ====================//
        Route::get('sanction', [SanctionController::class, 'index']);
        Route::post('/sanction', [SanctionController::class, 'sanctionStore'])->name('sanction.store');
        Route::get('/sanction/{id}/edit', [SanctionController::class, 'sanctionEdit'])->name('sanction.edit');
        Route::put('/sanction_update/{id}', [SanctionController::class, 'sanctionUpdate'])->name('sanction.update');
        Route::post('sanction_child/{id}', [SanctionController::class, 'sanction_child_1'])->name('sanction_child_1');
        Route::get('audit_trail_sanction/{id}', [SanctionController::class, 'audit_Sanction']);
        Route::get('sanctionAuditTrialDetails/{id}', [SanctionController::class, 'sanctionAuditTrialDetails']);

        //=================== Monthly Working ====================//
        Route::get('monthly_working', [MonthlyWorkingController::class, 'index']);
        Route::post('/monthly_working', [MonthlyWorkingController::class, 'monthly_workingStore'])->name('monthly_working.store');
        Route::get('/monthly_working/{id}/edit', [MonthlyWorkingController::class, 'monthly_workingEdit'])->name('monthly_working.edit');
        Route::put('/monthly_working_update/{id}', [MonthlyWorkingController::class, 'monthly_workingUpdate'])->name('monthly_working.update');
        Route::post('monthly_working_child/{id}', [MonthlyWorkingController::class, 'monthly_working_child_1'])->name('monthly_working_child_1');
        Route::get('audit_trail_monthly_working/{id}', [MonthlyWorkingController::class, 'audit_monthly_working']);
        Route::get('monthly_workingAuditTrialDetails/{id}', [MonthlyWorkingController::class, 'monthly_workingAuditTrialDetails']);
        // -----------------------By Kshitij Client Inquiry ----------------------
        Route::get('client_inquiry', [ClientInquiryController::class, 'index']);
        Route::post('client_inquiry_store', [ClientInquiryController::class, 'store'])->name('client_inquiry_store');
        Route::put('client_inquiry_update/{id}', [ClientInquiryController::class, 'update'])->name('client_update');
        Route::post('ClientInquirystagechange/{id}', [ClientInquiryController::class, 'StageChange'])->name('CIStage_change');
        Route::post('ClientInquirystage/{id}', [ClientInquiryController::class, 'Stage'])->name('CIStages_change');
        Route::post('ClientInquirycstage/{id}', [ClientInquiryController::class, 'CStage'])->name('CIStages_changes');
        Route::post('RStages_change/{id}', [ClientInquiryController::class, 'RejectStateChanges'])->name('RStages_change');
        Route::post('ClientInquiryrejectstate/{id}', [ClientInquiryController::class, 'RejectState'])->name('RJCStages_change');
        Route::get('client_inquiry_view/{id}',[ClientInquiryController::class,'show'])->name('client_inquiry_view');
        Route::get('ClientInquiry_AuditTrial/{id}',[ClientInquiryController::class,'ClientInquiryAuditTrial'])->name('ClientInquiry_AuditTrial');
        Route::post('Action_item',[ClientInquiryController::class,'Actionchild'])->name('action_item_show');
        Route::get('audit-program/{id}', [AuditProgramController::class, 'auditprogram']);
        Route::post('CNStages_change/{id}', [ClientInquiryController::class, 'ClientCancel'])->name('CNStages_change');

        //----------------------Meeting Management----------------

        // Route::get('meeting-management', [MeetingManagementController::class, 'meetingmanagement']);
        Route::get('meeting_management', [MeetingManagementController::class, 'index']);
        Route::post('meeting_management_store', [MeetingManagementController::class, 'store'])->name('meeting_management_store');
        Route::put('meeting_management_update/{id}', [MeetingManagementController::class, 'update'])->name('meeting_update');
        Route::get('meeting_management_view/{id}',[MeetingManagementController::class,'show'])->name('meeting_management_view');
        Route::post('meetingmanagementstagechange/{id}', [MeetingManagementController::class, 'StageChange'])->name('MMStage_change');
        Route::get('meeting_management_AuditTrial/{id}',[MeetingManagementController::class,'MeetingManagementAuditTrial'])->name('meeting_management_AuditTrial');

        //----------------------Additional Information-------------------
        Route::get('additional_information', [AdditionalInformationController::class, 'index']);
        Route::post('additional_information_create', [AdditionalInformationController::class, 'create'])->name('additional_information_create');
        Route::put('additional_information_update/{id}', [AdditionalInformationController::class, 'update'])->name('additional_update');
        Route::get('additional_information_view/{id}',[AdditionalInformationController::class,'show'])->name('additional_information_view');
        Route::post('additionalinformationstagechange/{id}', [AdditionalInformationController::class, 'StageChange'])->name('AIStage_change');
        Route::post('CancelStages_change/{id}', [AdditionalInformationController::class, 'CancelStateChanges'])->name('CNStages_change');
        Route::post('MoreInfoStages_change/{id}', [AdditionalInformationController::class, 'MoreInfoStateChanges'])->name('MoreInfotages_change');
        Route::get('additional_information_AuditTrial/{id}',[AdditionalInformationController::class,'AdditionalInformationAuditTrial'])->name('additional_information_AuditTrial');

        //---------------------Audit Task-------------------------------------------
        Route::get('audit-task',[AuditTaskController::class,'index']);
        Route::post('store-audit',[AuditTaskController::class,'Store'])->name('audit_store');
        Route::get('show-audit-task/{id}',[AuditTaskController::class,'AuditTaskShow'])->name('show_audit_task');
        Route::post('task-update/{id}',[AuditTaskController::class, 'update'])->name('update');
        // Route::get('auditReport/{id}',[AuditTaskController::class,'AuditTrial'])->name('auditReport');
        // Route::get('singleReport/{id}',[AuditTaskController::class,'AuditSingleReport'])->name('singleReport');
        Route::post('Follow_up',[AuditTaskController::class,'Followupchild'])->name('follow_up_show');
        Route::post('audittaskchangeStage/{id}',[AuditTaskController::class,'auditStage'])->name('ATStage_change');
        Route::post('reject/{id}', [AuditTaskController::class, 'auditReject'])->name('MoreInfostage_change');
        Route::post('cancel/{id}', [AuditTaskController::class, 'auditCancle'])->name('ATCNStages_change');
        Route::get('audit_task_AuditTrial/{id}',[AuditTaskController::class,'AuditTaskAuditTrial'])->name('audit_task_AuditTrial');
        // Route::view('client-inquiry', 'frontend.New_forms.client-inquiry');
        Route::get('audit-program', [AuditProgramController::class, 'auditprogram']);


        // ------------------------------------By Shruti Commitment ------------------------------------
        Route::view('commitment', 'frontend.Registration-Tracking.commitment');
        Route::get('commitment', [CommitmentController::class, 'index'])->name('commitment.index');
        Route::post('commitment_store', [CommitmentController::class,'store'])->name('commitment.store');
        Route::get('commitment_view/{id}', [CommitmentController::class, 'show'])->name('commitment.view');
        Route::put('commitment_Update/{id}', [CommitmentController::class, 'update'])->name('comm_Update');
        Route::post('commitment_stageChange/{id}', [CommitmentController::class, 'stageChange'])->name('commitment.stageChange');
        Route::post('commitment/cancel/{id}', [CommitmentController::class, 'stage_cancel'])->name('commitment.cancel');
        Route::get('commitment_audittrail/{id}', [CommitmentController::class, 'auditTrialshow'])->name('commitment.audittrail');
        Route::get('commitment_auditDetails/{id}', [CommitmentController::class, 'commitmentAuditDetails'])->name('commitment.auditDetails');
        //-------------------------------Medical-device------------------
        Route::get('medical-devices', [medicaldeviceController::class, 'index'])->name('medical-devices.index');
        Route::post('medical-devices_store', [medicaldeviceController::class, 'store'])->name('medical-devices');
        Route::get('medical_Device_view/{id}', [medicaldeviceController::class, 'show'])->name('medical_Device_view');
        Route::post('medicaldeviceUpdate/{id}', [MedicalDeviceController::class, 'Update'])->name('Update');
        Route::post('medicaldevice_stageChange/{id}', [MedicalDeviceController::class, 'stageChange'])->name('medicaldevice_stageChange');
        Route::post('medicalDevice/cancel/{id}', [MedicalDeviceController::class, 'medicalDevice_cancel'])->name('medicalDevice_cancel');
        Route::get('medialdevice_audittrail/{id}', [MedicalDeviceController::class, 'auditTrialshow'])->name('medialdevice_audittrail');
        Route::view('medical_device_view', 'frontend.new_forms.medical_device_view');

        Route::get('psur', [PSURController::class, 'index'])->name('psur.index');
        Route::post('psur_store', [PSURController::class, 'store'])->name('psur.store');
        Route::get('Psur_view/{id}', [PSURController::class, 'show'])->name('psur.view');
        Route::post('Psur_Update/{id}', [PSURController::class, 'Update'])->name('PSUR_Update');
        Route::post('psur_stageChange/{id}', [PSURController::class, 'stageChange'])->name('psur.stageChange');
        Route::post('psur/cancel/{id}', [PSURController::class, 'psur_cancel'])->name('psur_cancel');
        Route::post('psur_stagereject/{id}', [PSURController::class, 'stagereject'])->name('psur.stagereject');
        Route::get('psur_audittrail/{id}', [PSURController::class, 'auditTrialshow'])->name('psur_audittrail');
        Route::get('psur_auditDetails/{id}', [PSURController::class, 'psurAuditDetails'])->name('psur.auditDetails');
        // ==========================  Navneet  monitoring_visit=======================
        Route::get('monitoring_visit', [MonitoringVisitController::class, 'index'])->name('monitoring_visit');
        Route::post('monitoring_visit_store', [MonitoringVisitController::class, 'store'])->name('monitoring_visit_store');
        Route::put('monitoring_visit_update/{id}', [MonitoringVisitController::class, 'update'])->name('monitoring_visit_update');
        Route::get('monitoring_visit_view/{id}', [MonitoringVisitController::class, 'show'])->name('monitoring_visit_view');
        Route::post('monitoring_visit_stage_change/{id}', [MonitoringVisitController::class, 'StageChange'])->name('MVStage_Change');
        Route::post('Violation_item', [MonitoringVisitController::class, 'ViolationChild'])->name('violation_item_show');
        Route::post('MVstages_change/{id}', [MonitoringVisitController::class, 'MonitoringVisitCancel'])->name('MVstages_change');
        Route::get('Monitoring_Visit_AuditTrial/{id}', [MonitoringVisitController::class, 'MonitoringVisitAuditTrial'])->name('Monitoring_Visit_AuditTrial');
        // Route::get('MonitoringVisitSingleReport/{id}', [MonitoringVisitController::class, 'MonitoringVisitSingleReport'])->name('MonitoringVisitSingleReport');
        // ------------------------------ By sheetal --------------------------------        
        Route::get('/renewal',[RenewalController::class,'index'])->name('renewal');
        Route::post('/renewal/store',[RenewalController::class,'store'])->name('renewal.store')->middleware('auth');
        Route::get('renewal/show/{id}',[RenewalController::class,'show'])->name('renewal.show')->middleware('auth');
        Route::post('renewal/update/{id}', [RenewalController::class, 'update'])->name('renewal.update')->middleware('auth');
        
        //--------------------------stage routes------------------------------------------------------------//

        Route::post('renewal/cancel/{id}', [RenewalController::class, 'renewal_cancel_stage'])->name('renewal_cancel_stage')->middleware('auth');
        Route::post('renewal/stage/{id}',[RenewalController::class, 'renewal_send_stage'])->name('renewal_send_stage')->middleware('auth');
        Route::post('renewal/backword/{id}',[RenewalController::class, 'renewal_backword_stage'])->name('renewal_backword_stage')->middleware('auth');
        Route::post('renewal/forword/{id}',[RenewalController::class, 'renewal_forword_close'])->name('renewal_forword_close');
        Route::post('renewal/forword2/{id}',[RenewalController::class, 'renewal_forword2_close'])->name('renewal_forword2_close');
        Route::post('renewal/child/{id}', [RenewalController::class, 'renewal_child_stage'])->name('renewal_child_stage');

        Route::get('renewal/AuditTrial/{id}', [RenewalController::class, 'renewalAuditTrial'])->name('renewalAuditTrial');
        Route::get('renewal/singleReport/{id}', [RenewalController::class, 'singleReport'])->name('singleReport');
        Route::get('renewal/auditReport/{id}', [RenewalController::class, 'auditReport'])->name('auditReport');
        //=========================================================================================================//
        
        //Route::view('hypothesis', 'frontend.newform.hypothesis');
        Route::get('/hypothesis',[HypoController::class,'index']);
        Route::post('/store',[HypoController::class,'store'])->name('hypothesis.store');
        Route::get('hypothesis/show/{id}',[HypoController::class,'show'])->name('hypothesis.show');
        Route::post('hypothesis/update/{id}', [HypoController::class, 'update'])->name('hypothesis.update');

        //====================================stage-hypothesis=====================
       
        Route::post('hypothesis/stage/{id}',[HypoController::class, 'hypothesis_send_stage'])->name('hypothesis_send_stage')->middleware('auth');
        // Route::post('hypothesis/stage/{id}',[HypoController::class, 'hypothesis_send_stage'])->name('hypothesis_send_stage');
        Route::post('hypothesis/backword/{id}', [HypoController::class, 'hypothesis_backword'])->name('hypothesis_backword');
        Route::get('hypothesis/hypothesisAuditTrial/{id}', [HypoController::class, 'hypothesisAuditTrial'])->name('hypothesisAuditTrial');
        Route::get('hypothesis/auditReport/{id}', [HypoController::class, 'auditReport'])->name('auditReport');
        Route::post('hypothesis/cancel/{id}', [HypoController::class, 'hypothesis_Cancel'])->name('hypothesis_Cancel');
        Route::get('hypothesis/singleReport/{id}', [HypoController::class, 'singleReport'])->name('singleReport');
       
        // ====================================root cause analysis=======================
        Route::get('root-cause-analysis', [RootCauseController::class, 'rootcause']);
        Route::post('rootstore', [RootCauseController::class, 'root_store'])->name('root_store');
        Route::post('rootUpdate/{id}', [RootCauseController::class, 'root_update'])->name('root_update');
        Route::get('rootshow/{id}', [RootCauseController::class, 'root_show'])->name('root_show');
        Route::post('root/stage/{id}', [RootCauseController::class, 'root_send_stage'])->name('root_send_stage');
        Route::post('root/cancel/{id}', [RootCauseController::class, 'root_Cancel'])->name('root_Cancel');
        Route::post('root/reject/{id}', [RootCauseController::class, 'root_reject'])->name('root_reject');
        Route::post('root/backword/{id}', [RootCauseController::class, 'root_backword'])->name('root_backword');
        Route::post('root/backword2/{id}', [RootCauseController::class, 'root_backword_2'])->name('root_backword_2');
        Route::post('root/child/{id}', [RootCauseController::class, 'root_child'])->name('root_child');
        Route::get('rootAuditTrial/{id}', [RootCauseController::class, 'rootAuditTrial']);
        Route::get('auditDetailsRoot/{id}', [RootCauseController::class, 'auditDetailsroot'])->name('showrootAuditDetails');
