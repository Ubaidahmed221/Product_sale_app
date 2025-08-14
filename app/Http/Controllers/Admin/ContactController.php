<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         try {
            $search = $request->input('search');
           $message = Contact::when($search, function ($query) use ($search) {
                 $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

            return view('admin.contact.index', compact(['message','search']));
        } catch (\Exception $e) {
            return abort(404, "something went wrong");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $message = Contact::findOrFail($id);
               return view('admin.contact.show', compact('message'));

         } catch (\Exception $e) {
            return abort(404, "something went wrong");
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         try {
         $message =   Contact::findOrFail($id);
         $message->update(['status' => $request->status]);
            return back()->with('success', ' status updated successfully.');

           
        } catch (\Exception $e) {
           
            return back()->with('error', $e->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
          try {
             Contact::findOrFail($id)->delete();
            return back()->with('success', ' Message Deleted successfully.');

           
        } catch (\Exception $e) {
           
            return back()->with('error', $e->getMessage());

        }
    }
}
