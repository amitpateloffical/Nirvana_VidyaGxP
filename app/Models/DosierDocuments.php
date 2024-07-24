<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DosierDocumentsgrids;

class DosierDocuments extends Model
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
          'dosier_documents_type',
          'document_language',
          'documents',
          'file_attachments_pli',
          'dossier_parts',
          'root_parent_manufacture',
          'root_parent_product_code',
          'root_parent_trade_name',
          'root_parent_therapeutic_area',
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
