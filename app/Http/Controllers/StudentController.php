<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
} 