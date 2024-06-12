<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PreventiveMaintenancesgrids;

class PreventiveMaintenances extends Model
{
    use HasFactory;

    protected $fillable = [
          'id',
          'initiator_id',
          'division_id',
          'record_number',
          'intiation_date',
          'initiator',
          'assign_to',
          'short_description',
          'due_date',
          'additional_information',
          'related_urls',
          'PM_frequency',
          'parent_site_name',
          'parent_building',
          'parent_floor',
          'parent_room',
          'comments',
          'status',
          'stage',
          'date_open',
          'date_close'
      ];

    // public function grids()
    // {
    //   return $this->hasMany(dosier_document_grids::class, 'oos_id');
    // }
    public function record_number()
    {
        return $this->morphOne(QmsRecordNumber::class, 'recordable');
    }
}
