<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
     public function index(){
        try {
            return view('contact');
        } catch (\Exception $e) {
            return abort(404, "something went wrong");
        }
    }

     public function store(Request $request){
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            Contact::create($validated);

            // Here you can handle the contact form submission, e.g., save to database or send an email
            return response()->json([
                
                'message' => 'Message sent Successfully!'
            ]);
        } catch (\Exception $e) {
             return response()->json([
                
                'message' => 'something went wrong, please try again later.'
            ],500); 
        }
    }
}
