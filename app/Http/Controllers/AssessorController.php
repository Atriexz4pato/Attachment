<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Student;
use Illuminate\Http\Request;

class AssessorController extends Controller
{
    public function my_assessments(Request $request){
        $assessments = Assessment::where('assessor_id',auth()->id())->get;

       if($request->ajax()){
           return response()->json([
               'assessments' => $assessments,
               'message'=>'Assessments List'
           ],200);
       }
       return view('assessments.my_assessments',compact('assessments'));
    }

    public function set_dates(Request $request, $id){
        $assessments = Assessment::find($id);


    }
}
