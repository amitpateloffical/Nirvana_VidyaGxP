<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hypothesis extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_oos_no',
        'parent_oot_no',
        'parent_date_opened',
        'parent_short_description',
        'parent_target_closure_date',
        'parent_product_material_name',
        'record_number',
        'division_code',
        'initiator',
        'intiation_date',
        'date_opened',
        'target_closure_date',
        'short_description',
        'description',
        'qc_approver',
        'assignee',
        'qc_comments',
        'aqa_approver',
        'hyp_exp_comments',
        'hypothesis_attachment',
        'aqa_review_comments',
        'aqa_review_attachment',
        'summary_of_hypothesis',
        'delay_justification',
        'hypo_execution_attachment',
        'hypo_exp_qc_review_comments',
        'qc_review_attachment',
        'hypo_exp_aqa_review_comments',
        'hypo_exp_aqa_review_attachment',
        'submit_by',
        'hypo_proposed_by',
        'hypo_proposed_on',
        'hypothesis_proposed_by',
        'hypothesis_proposed_on',
    ];
}
