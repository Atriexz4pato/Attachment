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

        return response()->json([
            'data'=>$data,
            'message'=>'Assessment stored successfully',
         ],201);


    }


    public function assessment_view(){
        $assessments=Assessment::where('student_id',auth()->id())->get();

        return response()->json([
            'message' => 'Assessments retrieved successfully!',
            'data' => $assessments,
        ], 200); // 200 is the HTTP status code for success

    }


    public function assessment_edit($id){
       $assessment = Assessment::where('id',$id)->first();

       return response()->json([
           'data' => $assessment,
           'message'=>'Assessment retrieved successfully!',
       ]);
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
        return response()->json([
            'message' => 'Assessment updated successfully!',
            'data' => $assessment,
        ]);


    }
}
