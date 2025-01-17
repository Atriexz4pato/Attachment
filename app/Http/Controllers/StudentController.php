<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Assessor;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $attachmentStatus = 'Pending';

        return view('student.dashboard', [
            'attachmentStatus' => $attachmentStatus,
            'user' => $user
        ]);
    }

    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document' => 'required|mimes:pdf,doc,docx|max:2048',
            'document_type' => 'required|in:acceptance_letter,recommendation_letter'
        ]);

        try {
            $path = $request->file('document')->store('documents');

            // Here you can save document information to database
            // Example: Document::create(['path' => $path, 'type' => $request->document_type]);

            return back()->with('success', 'Document uploaded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload document. Please try again.');
        }
    }

    public function upcoming_assessment(Request $request){
        //get current dates
        $currentDate = Carbon::now();

        $upcomingAssessment = Assessment::where('assessment_date', '>=',$currentDate)
            ->orderBy('assessment_date', 'ASC')
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'message' => $upcomingAssessment ? 'Record found!' : 'No Upcoming Assessment found!',
                'data' => $upcomingAssessment,
            ]);
        }
        return view('student.upcoming_assessment', compact('upcomingAssessment'));
    }

    public function my_assessors(Request $request){

        $student = Student::where('user_id', Auth::id());
        $assessors = $student->assessors()->get();

       if ($request->ajax()) {
           return response()->json([
               'message' => $assessors ? 'Assessors found!' : 'No assessors found!',
               'data' => $assessors,
           ]);

       }
       return view('student.my_assessors', compact('assessors'));
    }


}
