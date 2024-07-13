<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EhsEvent extends Model
{
    use HasFactory;

    public function newchanges(){
        return $this->hasOne(QMSDivision::class);
    }
}
