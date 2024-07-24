<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosierDocumentsgrids extends Model
{
    use HasFactory;
    protected $table = 'dosier_documents_grid';
    protected $fillable = [
        'dosier_documents_id',
        'identifier',
        'data'
    ];
    protected $casts = [
        'data' => 'array'
    ];
}
