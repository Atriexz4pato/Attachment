<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use Illuminate\Http\Request;
use Psy\Util\Json;

class AssessmentController extends Controller
{


    public function assessment_index(){
        return view('assessment.assessment_view');
    }

    public function assessment_store(Request $request){

        $data = $request->validate([

        ]);

        //add the attachee details
        $data['student_id']=auth()->id();
        Assessment::create($data);

        if ($request->ajax()) {
            return response()->json([
                'data'=>$data,
                'message'=>'Assessment stored successfully',
            ],201);
        }

        return view('assessment.assessment_view');
    }


    public function assessment_view(Request $request){

        $assessments=Assessment::where('student_id',auth()->id())->get();

       if ($request->ajax()) {
           return response()->json([
               'message' => 'Assessments retrieved successfully!',
               'data' => $assessments,
           ], 200); // 200 is the HTTP status code for success
       }

       return view('assessment.assessment_view',compact('assessments'));
    }


    public function assessment_edit($id, Request $request){
       $assessment = Assessment::where('id',$id)->first();

      if($request->ajax()){
          return response()->json([
              'data' => $assessment,
              'message'=>'Assessment retrieved successfully!',
          ]);
      }
      return view('assessment.assessment_edit',compact('assessment'));
    }


    public function assessment_update(Request $request, $id){
        $data = $request->validate([

        ]);

        $assessment= Assessment::find($id);
        if (!$assessment) {
            return response()->json([
                'message' => 'Assessment not found!',
            ], 404); // 404 for "Not Found"
        }
        $assessment->update($data);
        if ($request->ajax()){
            return response()->json([
                'message' => 'Assessment updated successfully!',
                'data' => $assessment,
            ]);
        }
        return view('assessment.assessment_view');


    }
}
