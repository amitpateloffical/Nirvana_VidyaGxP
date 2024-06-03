<?php

namespace App\Http\Controllers\newForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function equipmentIndex(){
        return view('frontend.New_forms.equipment');
    }
}
