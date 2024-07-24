<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalSite extends Model
{
    use HasFactory;
    protected $table ='clinical_sites';

    protected $cast = [
        'source_documents'=>  'array' , 
        'attached_files'=> 'array'
    ];
    protected $fillable = [
        'record',
        'division_code',
        'initiator',
        'initiation_date',
        'short_description',
        'due_date',
        'assign_to',
        'type',
        'site_name',
        'source_documents',
        'sponsor',
        'description',
        'attached_files',
        'comments',
        'version_no',
        'admission_criteria',
        'clinical_significance',
        'trade_name',
        'tracking_number',
        'phase_of_study',
        'parent_type',
        'par_oth_type',
        'zone',
        'country',
        'city',
        'state_district',
        'sel_site_name',
        'building',
        'floor',
        'room',
        'site_name_sai',
        'pharmacy',
        'site_no',
        'site_status',
        'acti_date',
        'date_final_report',
        'ini_irb_app_date',
        'imp_site_date',
        'lab_de_name',
        'moni_per_by',
        'drop_withdrawn',
        'enrolled',
        'follow_up',
        'planned',
        'screened',
        'project_annual_mv',
        'schedule_start_date',
        'schedule_end_date',
        'actual_start_date',
        'actual_end_date',
        'lab_name',
        'monitoring_per_by_si',
        'control_group',
        'consent_form',
        'budget',
        'proj_sites_si',
        'proj_subject_si',
        'auto_calculation',
        'currency_si',
        'attached_payments',
        'cra',
        'lead_investigator',
        'reserve_team_associate',
        'additional_investigators',
        'clinical_research_coordinator',
        'pharmacist',
        'comments_si',
        'budget_ut',
        'currency_ut',
    ];
}
