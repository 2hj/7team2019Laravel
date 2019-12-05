<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function index(\App\Question $question){
      return response()->json(array('content'=>$question), 200);
    }
}
